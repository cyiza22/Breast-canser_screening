from fastapi import FastAPI, UploadFile
from inference import predict_image

app = FastAPI()

@app.post("/predict")
async def predict(file: UploadFile):
    return predict_image(await file.read())
