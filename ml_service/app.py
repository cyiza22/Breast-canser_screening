from fastapi import FastAPI, File, UploadFile
import tensorflow as tf
import numpy as np
from PIL import Image
from transformers import pipeline

app = FastAPI()

model = tf.keras.models.load_model("breast_risk_model.h5")

chatbot = pipeline("text-generation",
                   model="microsoft/DialoGPT-medium")

IMG_SIZE = 224
classes = ["low","moderate","high"]

def preprocess(image):
    image = image.resize((IMG_SIZE,IMG_SIZE))
    image = np.array(image)/255.0
    return np.expand_dims(image,0)

@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    img = Image.open(file.file)
    x = preprocess(img)

    pred = model.predict(x)
    risk = classes[np.argmax(pred)]

    return {"risk":risk}

@app.post("/chat")
async def chat(message:str):
    response = chatbot(message, max_length=80)
    return {"reply":response[0]["generated_text"]}
