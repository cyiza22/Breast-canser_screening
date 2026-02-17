"""
Clinical Risk Assessment for Breast Cancer Screening
Questionnaire-based risk stratification using standard epidemiological factors.
"""

import os
import joblib
import numpy as np

# --- Risk factor weights (based on Gail Model / WHO guidelines) ---
# Used as fallback when clinical_model.pkl is not available

WEIGHTS = {
    "age":              0.15,
    "family_history":   0.20,
    "age_first_period": 0.05,
    "age_first_birth":  0.08,
    "previous_biopsy":  0.12,
    "lump_detected":    0.18,
    "skin_changes":     0.10,
    "nipple_discharge": 0.07,
    "breast_pain":      0.05,
}

# --- Try to load the trained clinical model ---
MODEL_PATH = os.path.join("saved_models", "clinical_model.pkl")
trained_model = None

try:
    trained_model = joblib.load(MODEL_PATH)
    print(f"[INFO] Loaded trained clinical model from {MODEL_PATH}")
except Exception as e:
    print(f"[INFO] No trained model found ({e}). Using rule-based scoring.")


def encode_responses(data: dict) -> dict:
    """
    Convert questionnaire answers into numeric features.
    Input: raw form data (strings from the mobile app).
    Output: dict of float features ready for scoring.
    """

    features = {}

    # Age → normalized score (higher risk with age)
    age = int(data.get("age", 30))
    if age < 30:
        features["age"] = 0.1
    elif age < 40:
        features["age"] = 0.3
    elif age < 50:
        features["age"] = 0.6
    elif age < 60:
        features["age"] = 0.8
    else:
        features["age"] = 1.0

    # Family history of breast cancer
    family = data.get("family_history", "none")
    family_map = {"none": 0.0, "distant": 0.3, "mother_sister": 0.7, "multiple": 1.0}
    features["family_history"] = family_map.get(family, 0.0)

    # Age at first menstrual period
    period_age = int(data.get("age_first_period", 13))
    features["age_first_period"] = 0.7 if period_age < 12 else 0.3

    # Age at first live birth (or nulliparous)
    birth = data.get("age_first_birth", "before_30")
    birth_map = {"before_20": 0.1, "20_to_29": 0.3, "after_30": 0.6, "no_children": 0.7}
    features["age_first_birth"] = birth_map.get(birth, 0.3)

    # Previous breast biopsy
    biopsy = data.get("previous_biopsy", "no")
    features["previous_biopsy"] = 1.0 if biopsy == "yes" else 0.0

    # Current symptoms — self-reported
    features["lump_detected"] = 1.0 if data.get("lump_detected") == "yes" else 0.0
    features["skin_changes"] = 1.0 if data.get("skin_changes") == "yes" else 0.0
    features["nipple_discharge"] = 1.0 if data.get("nipple_discharge") == "yes" else 0.0
    features["breast_pain"] = 1.0 if data.get("breast_pain") == "yes" else 0.0

    return features


def score_with_weights(features: dict) -> float:
    """Rule-based weighted scoring (0.0 - 1.0)."""
    total = 0.0
    for key, weight in WEIGHTS.items():
        total += features.get(key, 0.0) * weight
    return round(min(total, 1.0), 3)


def classify_risk(score: float) -> str:
    """Map a 0-1 score to a risk category."""
    if score < 0.3:
        return "low"
    elif score < 0.6:
        return "moderate"
    else:
        return "high"


def get_recommendations(risk_level: str, features: dict) -> list[str]:
    """Return actionable next steps based on risk level and symptoms."""

    recs = []

    if risk_level == "high":
        recs.append("Please visit a health facility for clinical examination as soon as possible.")
        recs.append("Ask your Community Health Worker to help arrange a referral.")
    elif risk_level == "moderate":
        recs.append("Schedule a clinical breast examination within the next month.")
        recs.append("Continue monthly self-examinations and track any changes.")
    else:
        recs.append("Continue regular monthly self-examinations.")
        recs.append("Schedule routine screening as recommended for your age group.")

    # Symptom-specific advice
    if features.get("lump_detected") == 1.0:
        recs.insert(0, "A lump was reported — clinical examination is strongly recommended.")

    if features.get("skin_changes") == 1.0:
        recs.append("Skin changes on the breast should be evaluated by a professional.")

    if features.get("nipple_discharge") == 1.0:
        recs.append("Nipple discharge should be assessed by a healthcare provider.")

    return recs


def assess_risk(data: dict) -> dict:
    """
    Main entry point. Takes raw questionnaire data, returns full risk report.
    Uses the trained .pkl model if available, otherwise falls back to weights.
    """

    features = encode_responses(data)
    feature_names = list(WEIGHTS.keys())
    feature_values = [features[k] for k in feature_names]

    # Try trained model first
    if trained_model is not None:
        try:
            X = np.array(feature_values).reshape(1, -1)
            prediction = trained_model.predict_proba(X)[0]
            # Assume binary classifier: [prob_benign, prob_malignant]
            risk_score = float(prediction[1]) if len(prediction) > 1 else float(prediction[0])
        except Exception as e:
            print(f"[WARN] Trained model failed ({e}), falling back to weights.")
            risk_score = score_with_weights(features)
    else:
        risk_score = score_with_weights(features)

    risk_level = classify_risk(risk_score)
    recommendations = get_recommendations(risk_level, features)

    return {
        "risk_score": round(risk_score, 3),
        "risk_level": risk_level,
        "recommendations": recommendations,
        "features_used": features,
        "model_type": "trained_pkl" if trained_model else "rule_based",
    }