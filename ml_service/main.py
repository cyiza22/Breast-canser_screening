from fastapi import FastAPI, UploadFile
from pydantic import BaseModel
from inference import predict_image
from risk_assessment import assess_risk

app = FastAPI(title="Breast Cancer Screening ML Service")


# --- Image prediction (existing) ---

@app.post("/predict")
async def predict(file: UploadFile):
    """Predict from histopathology image."""
    return predict_image(await file.read())


# --- Clinical questionnaire risk assessment (new) ---

class QuestionnaireInput(BaseModel):
    age: int = 30
    family_history: str = "none"            # none | distant | mother_sister | multiple
    age_first_period: int = 13
    age_first_birth: str = "before_30"      # before_20 | 20_to_29 | after_30 | no_children
    previous_biopsy: str = "no"             # yes | no
    lump_detected: str = "no"               # yes | no
    skin_changes: str = "no"                # yes | no
    nipple_discharge: str = "no"            # yes | no
    breast_pain: str = "no"                 # yes | no

    class Config:
        json_schema_extra = {
            "example": {
                "age": 45,
                "family_history": "mother_sister",
                "age_first_period": 11,
                "age_first_birth": "after_30",
                "previous_biopsy": "no",
                "lump_detected": "yes",
                "skin_changes": "no",
                "nipple_discharge": "no",
                "breast_pain": "yes",
            }
        }


@app.post("/assess")
async def assess(data: QuestionnaireInput):
    """Run clinical risk assessment from questionnaire answers."""
    return assess_risk(data.model_dump())


# --- Health check ---

@app.get("/health")
async def health():
    return {"status": "ok", "service": "ml"}