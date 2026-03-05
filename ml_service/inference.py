import tensorflow as tf
import numpy as np
from PIL import Image
import io

model = tf.keras.models.load_model("saved_models/breast_cnn_model.h5")

# Must match train_data.class_indices from training
CLASS_NAMES = {
    0: "benign",
    1: "malignant",
    2: "normal",
}


def preprocess(image_bytes):
    """Resize image for EfficientNetB0.
    
    IMPORTANT: Do NOT normalize to [0,1].
    EfficientNetB0 has its own internal preprocessing layer
    and expects raw [0, 255] pixel values.
    """
    img = Image.open(io.BytesIO(image_bytes)).convert("RGB").resize((224, 224))
    img = np.array(img, dtype=np.float32)  # keep [0, 255] range
    return np.expand_dims(img, 0)


def predict_image(image_bytes):
    """Run prediction and return class, label, and confidence."""
    img = preprocess(image_bytes)
    pred = model.predict(img)[0]  # [prob_benign, prob_malignant, prob_normal]

    class_index = int(np.argmax(pred))
    confidence = float(np.max(pred))
    label = CLASS_NAMES[class_index]

    return {
        "class": class_index,
        "label": label,
        "confidence": round(confidence, 4),
        "probabilities": {
            "benign": round(float(pred[0]), 4),
            "malignant": round(float(pred[1]), 4),
            "normal": round(float(pred[2]), 4),
        }
    }