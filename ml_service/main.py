from fastapi import FastAPI, File, UploadFile, HTTPException
from pydantic import BaseModel

from inference import predict_image
from risk_assessment import assess_risk

app = FastAPI(title="Breast Cancer Screening ML Service")


# ── Request schema (matches Laravel ScreeningController validation) ──────────
class QuestionnaireInput(BaseModel):
    age: int
    family_history: str           # none | distant | mother_sister | multiple
    age_first_period: int
    age_first_birth: str          # before_20 | 20_to_29 | after_30 | no_children
    previous_biopsy: str          # yes | no
    lump_detected: str            # yes | no
    skin_changes: str             # yes | no
    nipple_discharge: str         # yes | no
    breast_pain: str              # yes | no


# ── Health check ─────────────────────────────────────────────────────────────
@app.get("/health")
def health():
    return {"status": "ok", "service": "ml_service"}


# ── Questionnaire risk assessment (called by Laravel /api/screen) ─────────────
@app.post("/assess")
def assess(data: QuestionnaireInput):
    try:
        result = assess_risk(data.model_dump())
        return result  # must contain: risk_level, risk_score, recommendations
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))


# ── Image prediction (called by Laravel /api/assist) ──────────────────────────
@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    try:
        image_bytes = await file.read()
        result = predict_image(image_bytes)
        return result
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))