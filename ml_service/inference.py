import tensorflow as tf
import numpy as np
from PIL import Image
import io

model = tf.keras.models.load_model("saved_models/breast_cnn_model.h5")

def preprocess(image_bytes):
    img = Image.open(io.BytesIO(image_bytes)).resize((224,224))
    img = np.array(img)/255.0
    return np.expand_dims(img,0)

def predict_image(image_bytes):
    img = preprocess(image_bytes)
    pred = model.predict(img)[0]
    return {
        "class": int(np.argmax(pred)),
        "confidence": float(np.max(pred))
    }
