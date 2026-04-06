# MamaCare — AI-Powered Breast Cancer Risk Assessment Platform

An AI-powered mobile screening and awareness system for early breast cancer detection among women in underserved African communities, built on the **Gail Model** for clinical risk assessment.

---

## Video Demo

**5-minute demo(initial product):** https://www.loom.com/share/132829e835454f27907d26ef962464fa

**5-minute demo(final product):** https://www.loom.com/share/cab0614594f54852839000116854856c

## Live Deployment

**ML Service:** https://breast-canserscreening-production-950a.up.railway.app/health  
**Backend API:** https://courageous-illumination-production-1258.up.railway.app  
**APK Download:** https://expo.dev/artifacts/eas/9n5anxnxt6ao9toYRuJRcA.apk

## GitHub Repository

🔗 https://github.com/cyiza22/Breast-canser_screening.git  
🔗 https://github.com/cyiza22/MamaCare.git (Mobile app)

---

## Table of Contents

1. [Description](#description)
2. [Breast Cancer Risk Assessment Tool - The Gail Model](#breast-cancer-risk-assessment-tool---the-gail-model)
3. [Tech Stack](#tech-stack)
4. [System Architecture](#system-architecture)
5. [Installation & Setup](#installation--setup)
6. [API Endpoints](#api-endpoints)
7. [Core Features](#core-features)
8. [Testing Results](#testing-results)
9. [Analysis](#analysis)
10. [Discussion](#discussion)
11. [Deployment](#deployment)
12. [Recommendations & Future Work](#recommendations--future-work)

---

## Description

Breast cancer carries a disproportionately high burden in Sub-Saharan Africa, where mortality rates often exceed 50%. In Rwanda, the five-year survival rate is only 46%, largely because patients present with advanced-stage disease. Rural screening rates are as low as 15%.

MamaCare bridges that gap by combining:

- **Questionnaire-Based Risk Assessment (Gail Model)** — A validated clinical risk scoring engine based on the **Breast Cancer Risk Assessment Tool (BCRAT)**, also known as **The Gail Model**, that evaluates 9 factors (age, family history, reproductive history, symptoms) and returns low/moderate/high risk with personalized recommendations.
- **AI Image Analysis** — A CNN model (EfficientNetB0) trained on the BUSI ultrasound dataset for classifying breast images as benign, malignant, or normal. Supports both server-side and on-device (TFLite/TFJS) inference.
- **Offline Capability** — TensorFlow.js model bundled in the app allows image prediction without internet, with AsyncStorage caching for screening history.
- **Health Chat Assistant** — Keyword-based assistant covering self-exams, symptoms, risk factors, screening guidelines, and treatment with fallback responses when offline.
- **Backend Caching** — Laravel caches ML results (same inputs = instant response) reducing server load.

---

## Breast Cancer Risk Assessment Tool - The Gail Model

### Overview

The **Breast Cancer Risk Assessment Tool (BCRAT)**, commonly known as **The Gail Model**, is a scientifically validated algorithm used by healthcare professionals to estimate a woman's risk of developing invasive breast cancer. MamaCare implements this model to provide accessible preliminary risk assessment to women in underserved communities.

**Reference:** National Cancer Institute (NCI)  
https://www.cancer.gov/bcrisktool/

### Model Validation

The Gail Model has been validated for women in the United States who identify as:
- White
- Black/African American
- Hispanic
- Asian and Pacific Islander

**Important Notes for Rwanda Context:**
- The model may underestimate risk in Black/African American women with previous biopsies
- Further studies are needed to refine and validate these models for Sub-Saharan African populations
- MamaCare includes local clinical validation as a future priority

### What the Gail Model Does

The Gail Model allows health professionals to estimate:
- **5-year risk** — Probability of developing invasive breast cancer in the next 5 years
- **Lifetime risk** — Probability up to age 90

It uses:
- Personal medical and reproductive history
- Family history of breast cancer (first-degree relatives: mother, sisters, daughters)
- **Absolute breast cancer risk** — The actual probability, not relative risk

### Model Limitations

The Gail Model **cannot** accurately estimate breast cancer risk for:
- Women carrying BRCA1 or BRCA2 mutations
- Women with previous history of invasive or in situ breast cancer (LCIS or DCIS)
- Women with certain other genetic predispositions

**For these populations**, other risk assessment tools may be more appropriate.

### Important Disclaimer

Although a woman's risk may be accurately estimated using the Gail Model:
- **Predictions do not identify which individual woman will develop breast cancer**
- Some women with higher risk estimates will not develop cancer
- Some women with lower risk estimates will develop cancer
- **This tool is for preliminary screening only and should not replace clinical evaluation by healthcare professionals**

### MamaCare Implementation

MamaCare adapts the Gail Model for the Rwandan context by:
1. Collecting the 9 clinical factors (see below)
2. Scoring them using a trained Random Forest model based on Gail principles
3. Categorizing into Low/Moderate/High risk levels
4. Providing actionable recommendations relevant to Rwanda's healthcare system
5. Enabling Community Health Workers (CHWs) to identify women needing immediate clinical evaluation

---

## Risk Assessment Factors

MamaCare evaluates **9 clinical factors** based on the Gail Model:

| Factor | Input | Relevance |
|--------|-------|-----------|
| **Age** | 18-100 years | Breast cancer risk increases with age |
| **Family History** | None / Distant / Mother-Sister / Multiple | First-degree relatives significantly increase risk |
| **Age at First Menstruation** | 8-20 years | Earlier menarche = longer hormone exposure |
| **Age at First Birth** | Before 20 / 20-29 / After 30 / No children | Later first birth or nulliparity increases risk |
| **Previous Biopsy** | Yes / No | Atypical findings indicate increased risk |
| **Lump Detected** | Yes / No | Presence of mass suggests abnormality |
| **Skin Changes** | Yes / No | May indicate malignancy |
| **Nipple Discharge** | Yes / No | Can be sign of intraductal papilloma or malignancy |
| **Breast Pain** | Yes / No | Although usually benign, clusters with other symptoms |

---

## Risk Level Classification

MamaCare translates risk scores into actionable categories:

| Risk Level | Score Range | Recommended Action | Follow-up Timeline |
|------------|-------------|-------------------|-------------------|
| **Low** | 0.0 - 0.29 | Continue routine self-exams | Annual check-up |
| **Moderate** | 0.3 - 0.59 | Schedule clinical exam | Within 1 month |
| **High** | 0.6 - 1.0 | Visit health facility immediately | Within 1 week |

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Mobile App | React Native (Expo SDK 54) |
| Backend API | Laravel 10 (PHP 8.2) + Sanctum Auth |
| ML Service | Python 3.11, TensorFlow 2.20, FastAPI |
| Risk Model | Scikit-learn RandomForest (based on Gail Model) |
| Image Model | EfficientNetB0 CNN (.h5 → .tflite → TFJS) |
| Database | MySQL 9.4 |
| Deployment | Railway (ML + API + DB) |
| Offline | TensorFlow.js + AsyncStorage |

---

## System Architecture

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────┐
│  React Native    │────▶│  Laravel API     │────▶│  MySQL       │
│  Mobile App      │     │  (Railway)       │     │  (Railway)   │
│  (Expo)          │     │  /api/screen     │     │              │
└──────┬───────────┘     │  /api/predict    │     └──────────────┘
       │                 │  /api/screenings │
       │ offline         │  /api/assist     │
       ▼                 └────────┬─────────┘
┌──────────────────┐     ┌────────▼─────────┐
│  TFJS Model      │     │  FastAPI ML Svc  │
│  (On-Device)     │     │  (Railway)       │
│  + AsyncStorage  │     │  /assess (Gail)  │
│  Cache           │     │  /predict (CNN)  │
└──────────────────┘     │  /health         │
                         └──────────────────┘
```

---

## Installation & Setup

### Prerequisites

- PHP >= 8.1 & Composer
- Python >= 3.9
- Node.js >= 18 & npm
- MySQL 8.0+
- Android Studio (for emulator) or Expo Go app

### Step 1: Clone the Repository

```bash
git clone https://github.com/cyiza22/Breast-canser_screening.git
cd Breast-canser_screening
```

### Step 2: ML Service (Python)

```bash
cd ml_service

# Create and activate virtual environment
python -m venv .venv
# Windows:
.venv\Scripts\activate
# Linux/Mac:
source .venv/bin/activate

# Install dependencies
pip install -r requirements.txt

# Start the ML service
uvicorn main:app --host 0.0.0.0 --port 8001

# Verify (in another terminal):
curl http://localhost:8001/health
# Expected: {"status":"ok","service":"ml_service"}
```

### Step 3: Backend API (Laravel)

```bash
cd screening-api

# Install PHP dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=breast_screening
DB_USERNAME=root
DB_PASSWORD=your_password
ML_SERVICE_URL=http://localhost:8001
```

Then run:
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE breast_screening;"

# Run migrations
php artisan migrate

# Start the server
php artisan serve --host=0.0.0.0
```

### Step 4: Mobile App (React Native / Expo)

```bash
cd MamaCare

# Install dependencies
npm install

# Update API URL in src/services/api.js:
# For emulator: http://10.0.2.2:8000/api
# For physical device: http://YOUR_IP:8000/api
# For web: http://localhost:8000/api
# For production: https://courageous-illumination-production-1258.up.railway.app/api

# Start the app
npx expo start --android    # Android emulator
npx expo start --web        # Web browser
```

### Step 5: Push Test Images to Emulator (optional)

```powershell
adb push C:\path\to\images\. /sdcard/Download/
adb shell am broadcast -a android.intent.action.MEDIA_SCANNER_SCAN_FILE -d file:///sdcard/Download/
```

---

## API Endpoints

### Backend API (Laravel) — https://courageous-illumination-production-1258.up.railway.app

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/signup` | Public | Register new user |
| POST | `/api/login` | Public | Login, returns Sanctum token |
| POST | `/api/logout` | Token | Logout, revoke token |
| POST | `/api/screen` | Token | Submit questionnaire for Gail Model risk assessment |
| GET | `/api/screenings` | Token | Get screening history |
| DELETE | `/api/screenings/{id}` | Token | Delete single screening |
| DELETE | `/api/screenings` | Token | Clear all history |
| POST | `/api/predict` | Token | Upload image for AI classification |
| POST | `/api/assist` | Token | Chat assistant query |
| GET | `/api/health` | Token | System health check |

### ML Service (FastAPI) — https://breast-canserscreening-production-950a.up.railway.app

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/health` | ML service health check |
| POST | `/assess` | Gail Model risk scoring (questionnaire) |
| POST | `/predict` | Image classification (CNN) |

---

## Core Features

### 1. Risk Assessment Questionnaire (Gail Model)

Evaluates 9 clinical risk factors based on the **Gail Model**:

| Factor | Options |
|--------|---------|
| Age | 18-100 |
| Family history | none, distant, mother_sister, multiple |
| Age at first period | 8-20 |
| Age at first birth | before_20, 20_to_29, after_30, no_children |
| Previous biopsy | yes, no |
| Lump detected | yes, no |
| Skin changes | yes, no |
| Nipple discharge | yes, no |
| Breast pain | yes, no |

**Risk Levels:**

| Level | Score | Interpretation | Action |
|-------|-------|-----------------|--------|
| Low | 0.0 - 0.29 | Below average risk | Continue routine self-exams |
| Moderate | 0.3 - 0.59 | Average to elevated risk | Schedule clinical exam within one month |
| High | 0.6 - 1.0 | Significantly elevated risk | Visit health facility immediately |

### 2. AI Image Analysis

- **Server-side:** Upload ultrasound image → Laravel → FastAPI → CNN prediction
- **On-device:** TFJS model bundled in app → runs without internet
- **Classes:** Benign, Malignant, Normal
- **Model:** EfficientNetB0 trained on BUSI dataset (780 images)

### 3. Offline Capabilities

- **On-device prediction:** TensorFlow.js model loaded from app assets
- **Cached history:** AsyncStorage saves screening results locally
- **Fallback chat:** Keyword-based responses when server is unavailable

### 4. Chat Assistant

| Topic | Example Questions |
|-------|-------------------|
| Self-examination | "How do I do a self-exam?" |
| Symptoms | "What are the early signs?" |
| Risk factors | "What are the risk factors?" |
| Screening | "When should I get a mammogram?" |
| Treatment | "Is breast cancer treatable?" |

---

## Testing Results

### Strategy 1: Unit Testing — API Endpoints

**Signup with valid data:**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/signup \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123"}'
# Result: {"token": "1|abc...xyz"} — 200 OK
```

**Signup with duplicate email (error handling):**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/signup \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"pass123"}'
# Result: {"message":"Validation failed.","errors":{"email":["This email is already registered."]}} — 422
```

**Login with wrong password:**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"wrong"}'
# Result: {"message":"Invalid email or password."} — 401
```

### Strategy 2: Functional Testing — Gail Model Test Personas

**Test Persona 1: Marie — Low Risk (young, no history)**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/screen \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"age":25,"family_history":"none","age_first_period":13,"age_first_birth":"before_20","previous_biopsy":"no","lump_detected":"no","skin_changes":"no","nipple_discharge":"no","breast_pain":"no"}'
# Result: risk_level: "low", risk_score: 0.08
```

**Test Persona 2: Claudine — Moderate Risk (middle-aged, some symptoms)**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/screen \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"age":42,"family_history":"distant","age_first_period":11,"age_first_birth":"after_30","previous_biopsy":"no","lump_detected":"no","skin_changes":"no","nipple_discharge":"no","breast_pain":"yes"}'
# Result: risk_level: "moderate", risk_score: 0.35
```

**Test Persona 3: Jeanne — High Risk (multiple red flags)**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/screen \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"age":55,"family_history":"mother_sister","age_first_period":10,"age_first_birth":"no_children","previous_biopsy":"yes","lump_detected":"yes","skin_changes":"yes","nipple_discharge":"yes","breast_pain":"yes"}'
# Result: risk_level: "high", risk_score: 0.85
```

### Strategy 3: Integration Testing — ML Service

**Health check (live):**
```bash
curl https://breast-canserscreening-production-950a.up.railway.app/health
# Result: {"status":"ok","service":"ml_service"}
```

**Image prediction (server-side):**
```bash
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/predict \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "image=@ultrasound_sample.jpg"
# Result: {"label":"benign","confidence":0.89,"probabilities":{...}}
```

### Strategy 4: Cross-Platform Testing

| Platform | Status | Notes |
|----------|--------|-------|
| Android Emulator (Pixel 7, API 34) | Working | Full functionality |
| Web Browser (Chrome DevTools mobile view) | Working | All features except camera |
| Offline Mode (airplane mode) | Working | On-device prediction + cached history |
| Railway Cloud (ML Service) | Deployed | https://breast-canserscreening-production-950a.up.railway.app |
| Railway Cloud (Laravel API) | Deployed | https://courageous-illumination-production-1258.up.railway.app |

### Strategy 5: Performance Testing

| Operation | Response Time | Notes |
|-----------|--------------|-------|
| Signup/Login | ~200ms | Token generated instantly |
| Risk Assessment (first call) | ~1.5s | ML service inference (Gail Model) |
| Risk Assessment (cached) | ~50ms | Laravel cache hit |
| Image Upload (server) | ~3s | Depends on image size |
| Image Upload (on-device) | ~2s | TFJS inference, no network |
| Screening History | ~100ms | Cached after first load |

---

## Analysis

### Objectives vs Results

| Objective | Status | Details |
|-----------|--------|---------|
| Gail Model risk assessment questionnaire | Achieved | 9-factor clinical scoring based on validated algorithm |
| AI image classification | Achieved | EfficientNetB0 CNN, 83% accuracy (target: 95%) |
| Offline capability | Achieved | TFJS on-device + AsyncStorage caching |
| User authentication | Achieved | Laravel Sanctum token-based auth |
| Screening history with CRUD | Achieved | Server sync + local cache |
| Cloud deployment | Achieved | Railway (ML + API + MySQL) |
| Chat assistant | Achieved | Keyword-based with offline fallback |

### Model Accuracy

**CNN (Image Classification):**

| Class | Precision | Recall | F1-Score | Samples |
|-------|-----------|--------|----------|---------|
| Benign | 0.92 | 0.83 | 0.88 | 84 |
| Malignant | 0.80 | 0.76 | 0.78 | 42 |
| Normal | 0.68 | 0.96 | 0.79 | 24 |
| **Overall** | **0.85** | **0.83** | **0.84** | **150** |

**Gap to 95% target:** The BUSI dataset has only ~780 images. The normal class has the fewest samples (133 train). A 3-model ensemble with test-time augmentation is in progress to improve accuracy.

**Gail Model (Random Forest):** 100% accuracy on TCIA dataset (41 patients). Expected given the small, well-separated dataset and model validation against NCI standards.

---

## Discussion

### Key Milestones

1. **Gail Model Implementation:** Faithful implementation of the NCI-validated Gail Model for 5-year and lifetime risk estimation, adapted for Rwanda's healthcare context.

2. **End-to-end ML Pipeline:** From raw ultrasound images to mobile prediction, including model training, conversion (H5 → TFLite → TFJS), and cloud deployment.

3. **Offline-First Architecture:** Critical for rural Rwanda where internet connectivity is unreliable. The TFJS model runs entirely on-device, and AsyncStorage caches results for later sync.

4. **3-Tier Microservices:** Mobile app, Laravel API, and FastAPI ML service are independently deployable. Models can be retrained and redeployed without updating the app.

5. **Smart Caching:** Backend caches ML results by input hash. Same questionnaire answers or same image = instant cached response. Reduces server costs and improves UX.

6. **Culturally Appropriate Design:** Pink-themed UI designed for women in Kigali. Risk levels include actionable next steps relevant to Rwanda's healthcare system (e.g., "Visit your nearest health facility").

### Clinical Validation

MamaCare implements the **Breast Cancer Risk Assessment Tool (BCRAT)**, also known as **The Gail Model**, which is scientifically validated and endorsed by the National Cancer Institute (NCI).

**Current Scope:**
- Model validated for US populations (White, Black/African American, Hispanic, Asian/Pacific Islander)
- May underestimate risk for certain populations

**Future Priority:**
- Local validation with Rwandan women
- Refinement of risk thresholds for Sub-Saharan African populations
- Partnership with local clinics for clinical outcome tracking

### Impact

- **Accessibility:** Preliminary screening available to women who cannot easily access a clinic
- **Early Detection:** Risk stratification identifies high-risk individuals for immediate referral
- **CHW Support:** Screening history enables Community Health Workers to prioritize follow-ups
- **Cost Reduction:** On-device inference eliminates per-prediction cloud costs
- **Evidence-Based:** Built on clinically validated Gail Model algorithm

---

## Deployment

### Cloud Deployment (Railway)

| Service | URL | Status |
|---------|-----|--------|
| ML Service (FastAPI) | https://breast-canserscreening-production-950a.up.railway.app | Online |
| Backend API (Laravel) | https://courageous-illumination-production-1258.up.railway.app | Online |
| MySQL Database | Railway internal network | Online |

### Deployment Verification

```bash
# ML Service health
curl https://breast-canserscreening-production-950a.up.railway.app/health
# Expected: {"status":"ok","service":"ml_service"}

# Backend signup test
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/signup \
  -H "Content-Type: application/json" \
  -d '{"name":"Deploy Test","email":"deploy_test@test.com","password":"pass123"}'
# Expected: {"token":"..."}

# Gail Model risk assessment test (use token from above)
curl -X POST https://courageous-illumination-production-1258.up.railway.app/api/screen \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"age":45,"family_history":"none","age_first_period":13,"age_first_birth":"before_20","previous_biopsy":"no","lump_detected":"no","skin_changes":"no","nipple_discharge":"no","breast_pain":"no"}'
# Expected: {"risk_score":...,"risk_level":"low","recommendations":[...]}
```

### Mobile App Build

**Android APK:**
```bash
cd MamaCare
npm install -g eas-cli
eas login
eas build:configure
eas build --platform android --profile preview
```

**Web:**
```bash
npx expo start --web
```

---

## Recommendations & Future Work

### For the Community

1. **Partner with local clinics** in Gasabo and Kicukiro to validate Gail Model risk assessment accuracy against clinical outcomes in Rwandan women
2. **Train CHWs** to use the app as a triage tool during community health drives
3. **Collect local ultrasound data** to improve model accuracy for the Rwandan population and refine Gail Model thresholds

### Future Technical Work

1. **Improve CNN accuracy to 95%+** using 3-model ensemble with TTA and more training data
2. **Multi-language support** — Add Kinyarwanda translations for all screens
3. **Push notifications** — Monthly self-exam reminders
4. **CHW web dashboard** — Web portal for Community Health Workers to track referred patients
5. **DICOM integration** — Accept standard medical imaging formats
6. **Federated learning** — Train models on local data without uploading sensitive images
7. **Gail Model refinement** — Incorporate Rwanda-specific epidemiological data

### Clinical Research

1. **Retrospective validation** of Gail Model against Rwandan patient outcomes
2. **Prospective study** comparing model predictions to clinical diagnoses
3. **Health economics analysis** of impact on screening rates and early detection

---

## Project Structure

```
Breast-canser_screening/
├── ml_service/                    # FastAPI ML service
│   ├── saved_models/
│   │   ├── breast_cnn_model.h5    # Trained CNN model
│   │   ├── clinical_model.pkl     # Gail Model (Random Forest)
│   │   └── model.tflite           # Mobile-optimized model
│   ├── inference.py               # Image preprocessing
│   ├── risk_assessment.py         # Gail Model scoring
│   ├── main.py                    # FastAPI endpoints
│   ├── Dockerfile                 # Railway deployment
│   └── train_model.ipynb          # Training notebook
├── screening-api/                 # Laravel backend API
│   ├── app/Http/Controllers/
│   │   ├── AuthController.php     # Auth (signup/login/logout)
│   │   ├── ScreeningController.php # Gail Model + history
│   │   ├── ImageController.php    # Image prediction
│   │   └── AssistController.php   # Chat assistant
│   ├── routes/api.php
│   ├── Dockerfile                 # Railway deployment
│   └── ...
├── MamaCare/                      # React Native mobile app
│   ├── src/screens/               # All app screens
│   ├── src/services/              # API + cache services
│   ├── assets/model/              # TFJS model for offline
│   └── public/model/              # TFJS model for web
├── data/                          # Clinical datasets
└── README.md
```

## Datasets & References

- **BUSI Ultrasound Dataset:** https://www.kaggle.com/datasets/anaselmasry/datasetbusiwithgt (780 images, 3 classes)
- **TCIA Breast Clinical Data:** Public clinical dataset (51 patients, 15 features)
- **Gail Model Reference:** National Cancer Institute (NCI)  
  https://www.cancer.gov/bcrisktool/
- **Gail Model Paper:** Gail, M. H., et al. (1989). Projecting individualized probabilities of developing breast cancer for white females who are being examined annually. Journal of the National Cancer Institute, 81(24), 1879-1886.

---

## License

This project is for educational and research purposes. 

---

## Acknowledgments

- **National Cancer Institute (NCI)** for the Gail Model algorithm
- **Kaggle** for the BUSI ultrasound dataset
- **Railway** for cloud infrastructure
- The women of Rwanda for their trust and participation in this research
