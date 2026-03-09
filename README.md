# MamaCare — AI-Powered Breast Cancer Screening Platform

An AI-powered mobile screening and awareness system for early breast cancer detection among women in underserved African communities. 

---

## Video Demo

🎥 **5-minute demo:** https://www.loom.com/share/132829e835454f27907d26ef962464fa

## Live Deployment

**ML Service:** https://breast-canserscreening-production-950a.up.railway.app/health
**Backend API:** https://courageous-illumination-production-1258.up.railway.app
**APK Download:** https://expo.dev/artifacts/eas/8bwyVvKDjvPL9oi53beNCV.apk
**iOS app:**https://expo.dev/artifacts/eas/e7XxDHqcwewYfdHiuTLhBv.tar.gz

## GitHub Repository

🔗 https://github.com/cyiza22/Breast-canser_screening.git
🔗 https://github.com/cyiza22/MamaCare.git(Mobile app)

---

## Table of Contents

1. [Description](#description)
2. [Tech Stack](#tech-stack)
3. [System Architecture](#system-architecture)
4. [Installation & Setup](#installation--setup)
5. [API Endpoints](#api-endpoints)
6. [Core Features](#core-features)
7. [Testing Results](#testing-results)
8. [Analysis](#analysis)
9. [Discussion](#discussion)
10. [Deployment](#deployment)
11. [Recommendations & Future Work](#recommendations--future-work)

---

## Description

Breast cancer carries a disproportionately high burden in Sub-Saharan Africa, where mortality rates often exceed 50%. In Rwanda, the five-year survival rate is only 46%, largely because patients present with advanced-stage disease. Rural screening rates are as low as 15%.

MamaCare bridges that gap by combining:

- **Questionnaire-Based Risk Assessment** — A clinical risk scoring engine inspired by the Gail Model that evaluates 9 factors (age, family history, reproductive history, symptoms) and returns low/moderate/high risk with personalized recommendations.
- **AI Image Analysis** — A CNN model (EfficientNetB0) trained on the BUSI ultrasound dataset for classifying breast images as benign, malignant, or normal. Supports both server-side and on-device (TFLite/TFJS) inference.
- **Offline Capability** — TensorFlow.js model bundled in the app allows image prediction without internet, with AsyncStorage caching for screening history.
- **Health Chat Assistant** — Keyword-based assistant covering self-exams, symptoms, risk factors, screening guidelines, and treatment with fallback responses when offline.
- **Backend Caching** — Laravel caches ML results (same inputs = instant response) reducing server load.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Mobile App | React Native (Expo SDK 54) |
| Backend API | Laravel 10 (PHP 8.2) + Sanctum Auth |
| ML Service | Python 3.11, TensorFlow 2.20, FastAPI |
| Risk Model | Scikit-learn RandomForest (clinical_model.pkl) |
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
       │                 │  /api/assist     │
       │ offline         └────────┬─────────┘
       ▼                          │ HTTP
┌──────────────────┐     ┌────────▼─────────┐
│  TFJS Model      │     │  FastAPI ML Svc  │
│  (On-Device)     │     │  (Railway)       │
│  + AsyncStorage  │     │  /assess         │
│  Cache           │     │  /predict        │
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
| POST | `/api/screen` | Token | Submit questionnaire for risk assessment |
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
| POST | `/assess` | Questionnaire risk scoring |
| POST | `/predict` | Image classification |

---

## Core Features

### 1. Risk Assessment Questionnaire

Evaluates 9 clinical risk factors inspired by the Gail Model:

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

| Level | Score | Action |
|-------|-------|--------|
| Low | 0.0 - 0.29 | Continue routine self-exams |
| Moderate | 0.3 - 0.59 | Schedule clinical exam within one month |
| High | 0.6 - 1.0 | Visit health facility immediately |

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

### Strategy 2: Functional Testing — Different Data Values

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
| Risk Assessment (first call) | ~1.5s | ML service inference |
| Risk Assessment (cached) | ~50ms | Laravel cache hit |
| Image Upload (server) | ~3s | Depends on image size |
| Image Upload (on-device) | ~2s | TFJS inference, no network |
| Screening History | ~100ms | Cached after first load |

---

## Analysis

### Objectives vs Results

| Objective | Status | Details |
|-----------|--------|---------|
| Clinical risk assessment questionnaire | Achieved | 9-factor scoring engine with 3 risk levels |
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

**Clinical Model (Random Forest):** 100% accuracy on TCIA dataset (41 patients). Expected given the small, well-separated dataset.

---

## Discussion

### Key Milestones

1. **End-to-end ML Pipeline:** From raw ultrasound images to mobile prediction, including model training, conversion (H5 → TFLite → TFJS), and cloud deployment.

2. **Offline-First Architecture:** Critical for rural Rwanda where internet connectivity is unreliable. The TFJS model runs entirely on-device, and AsyncStorage caches results for later sync.

3. **3-Tier Microservices:** Mobile app, Laravel API, and FastAPI ML service are independently deployable. The ML model can be retrained and redeployed without updating the app.

4. **Smart Caching:** Backend caches ML results by input hash. Same questionnaire answers or same image = instant cached response. Reduces server costs and improves UX.

5. **Culturally Appropriate Design:** Pink-themed UI designed for women in Kigali. Risk levels include actionable next steps relevant to the Rwandan healthcare system (e.g., "Visit your nearest health facility").

### Impact

- **Accessibility:** Preliminary screening available to women who cannot easily access a clinic
- **Early Detection:** Risk stratification identifies high-risk individuals for immediate referral
- **CHW Support:** Screening history enables Community Health Workers to prioritize follow-ups
- **Cost Reduction:** On-device inference eliminates per-prediction cloud costs

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

# Screening test (use token from above)
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

1. **Partner with local clinics** in Gasabo and Kicukiro to validate risk assessment accuracy against clinical outcomes
2. **Train CHWs** to use the app as a triage tool during community health drives
3. **Collect more local ultrasound data** to improve model accuracy for the Rwandan population

### Future Technical Work

1. **Improve CNN accuracy to 95%+** using 3-model ensemble with TTA and more training data
2. **Multi-language support** — Add Kinyarwanda translations for all screens
3. **Push notifications** — Monthly self-exam reminders
4. **CHW web dashboard** — Web portal for Community Health Workers
5. **DICOM integration** — Accept standard medical imaging formats
6. **Federated learning** — Train models on local data without uploading sensitive images

---

## Project Structure

```
Breast-canser_screening/
├── ml_service/                    # FastAPI ML service
│   ├── saved_models/
│   │   ├── breast_cnn_model.h5    # Trained CNN model
│   │   ├── clinical_model.pkl     # Risk assessment model
│   │   └── model.tflite           # Mobile-optimized model
│   ├── inference.py               # Image preprocessing
│   ├── risk_assessment.py         # Questionnaire scoring
│   ├── main.py                    # FastAPI endpoints
│   ├── Dockerfile                 # Railway deployment
│   └── train_model.ipynb          # Training notebook
├── screening-api/                 # Laravel backend API
│   ├── app/Http/Controllers/
│   │   ├── AuthController.php     # Auth (signup/login/logout)
│   │   ├── ScreeningController.php # Risk assessment + history
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

## Datasets

- **BUSI Ultrasound Dataset:** https://www.kaggle.com/datasets/anaselmasry/datasetbusiwithgt (780 images, 3 classes)
- **TCIA Breast Clinical Data:** Public clinical dataset (51 patients, 15 features)

---

## Emojis
Emojisense vscode Extension


