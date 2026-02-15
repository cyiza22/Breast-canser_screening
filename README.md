# Breast Cancer Screening — AI-Powered Mobile Platform

An AI-powered mobile screening and awareness system that facilitates early breast cancer detection among women in underserved African communities. The platform provides accessible preliminary risk assessment through a clinical questionnaire, culturally localized health education via a chat assistant, and seamless integration with Community Health Worker (CHW) networks.


## video links
video link part1: https://www.loom.com/share/479ca405c7224ecfab56dc2ac121e7e6
video link part2: https://www.loom.com/share/c6129dd03c9443069ec7c627174fdd17

## Table of Contents

- [Description](#description)
- [GitHub Repository](#github-repository)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Environment Setup](#environment-setup)
  - [Prerequisites](#prerequisites)
  - [ML Service (Python)](#1-ml-service-python)
  - [Backend API (Laravel)](#2-backend-api-laravel)
- [API Endpoints](#api-endpoints)
- [Risk Assessment](#risk-assessment)
- [Chat Assistant](#chat-assistant)
- [Testing](#testing)

---

## Description

Breast cancer carries a disproportionately high burden in Sub-Saharan Africa, where mortality rates often exceed 50%. In Rwanda, the five-year survival rate is only 46%, largely because patients present with advanced-stage disease. Rural screening rates are reported as low as 15%.

This project bridges that gap by combining:

- **Questionnaire-Based Risk Assessment** — A clinical risk scoring engine that evaluates nine factors (age, family history, reproductive history, symptoms) and stratifies risk into low, moderate, and high categories with personalized recommendations.
- **AI Image Analysis** — A CNN-based deep learning model for histopathology image classification, with a TFLite version for on-device inference.
- **Health Chat Assistant** — A knowledge-based assistant covering breast self-exams, symptoms, risk factors, screening guidelines, and treatment information.
- **CHW Integration** — Screening history dashboard allowing Community Health Workers to prioritize follow-ups and coordinate referrals.



---

## GitHub Repository

🔗 https://github.com/cyiza22/Breast-canser_screening.git

---

## Tech Stack

| Layer           | Technology                          |
|-----------------|-------------------------------------|
| Backend API     | Laravel 10 (PHP) + Sanctum Auth     |
| ML Service      | Python, TensorFlow/Keras, FastAPI   |
| Risk Assessment | Scikit-learn (clinical_model.pkl) + rule-based fallback |
| ML Model        | CNN (`.h5`) → TFLite (`.tflite`)    |
| Database        | MySQL (or SQLite for development)   |

---

## Project Structure

```
BREAST-CANCER-SCREENING/
├── chatbox/                  # Standalone chatbot module
│   └── chat.py
├── data/                     # Clinical datasets
│   └── TCIA-Breast-clinical-data-public-7_16_11.xlsx
├── ml_service/               # FastAPI machine learning service
│   ├── saved_models/
│   │   ├── breast_cnn_model.h5    # Trained CNN model
│   │   ├── clinical_model.pkl     # Clinical risk classifier
│   │   └── model.tflite           # Mobile-optimized model
│   ├── inference.py          # Image preprocessing & prediction
│   ├── risk_assessment.py    # Questionnaire risk scoring engine
│   ├── main.py               # FastAPI endpoints (/predict, /assess)
│   ├── requirements.txt      # Python dependencies
│   └── train_model.ipynb     # Model training notebook
├── screening-api/            # Laravel backend API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php        # Signup & login
│   │   │   ├── AssistController.php      # Image prediction + chat
│   │   │   ├── ScreeningController.php   # Questionnaire risk assessment
│   │   │   └── HealthController.php      # Health check
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   └── Prediction.php            # Stores screenings (image + questionnaire)
│   │   └── Services/
│   │       ├── MLService.php             # HTTP client for FastAPI /predict
│   │       └── ChatService.php           # Knowledge-based chat responses
│   ├── routes/api.php        # API route definitions
│   ├── database/migrations/  # DB schema
│   └── ...
└── .gitignore
```

---

## Environment Setup

### Prerequisites

- **PHP** ≥ 8.1 & **Composer**
- **Python** ≥ 3.9
- **Node.js** ≥ 18 & **npm**
- **MySQL** 8.0+ (or SQLite for quick setup)
- **React Native CLI** (or Expo)

---

### 1. ML Service (Python)

```bash
cd ml_service

# Create and activate virtual environment
python -m venv .venv
source .venv/bin/activate        # Linux/Mac
# .venv\Scripts\activate         # Windows

# Install dependencies
pip install -r requirements.txt
pip install python-multipart     # Required for file uploads

# Run the ML API
uvicorn main:app --host 0.0.0.0 --port 8001 --reload
```

The ML service will be available at `http://localhost:8001`.

**Verify it's running:**
```bash
curl http://localhost:8001/health
# → {"status":"ok","service":"ml"}
```

---

### 2. Backend API (Laravel)

```bash
cd screening-api

# Install PHP dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials and ML service URL:

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
# Create the database (MySQL only)
mysql -u root -p -e "CREATE DATABASE breast_screening;"

# Run migrations
php artisan migrate

# Start the server
php artisan serve
```

The API will be available at `http://localhost:8000/api`.

---



## API Endpoints

| Method | Endpoint          | Auth     | Description                              |
|--------|-------------------|----------|------------------------------------------|
| POST   | `/api/signup`     | Public   | Register a new user                      |
| POST   | `/api/login`      | Public   | Login and receive Sanctum token          |
| POST   | `/api/screen`     | Sanctum  | Submit questionnaire for risk assessment |
| GET    | `/api/screenings` | Sanctum  | Get user's screening history             |
| POST   | `/api/assist`     | Sanctum  | Submit image + message for AI chat       |
| GET    | `/api/health`     | Sanctum  | System health check                      |

**ML Service (direct):**

| Method | Endpoint   | Description                         |
|--------|------------|-------------------------------------|
| POST   | `/assess`  | Questionnaire risk scoring          |
| POST   | `/predict` | Histopathology image classification |
| GET    | `/health`  | ML service health check             |

---

## Risk Assessment

The primary screening tool is a **clinical questionnaire** that evaluates nine risk factors:

| Factor | Options |
|--------|---------|
| Age | 18–100 |
| Family history | `none`, `distant`, `mother_sister`, `multiple` |
| Age at first period | 8–20 |
| Age at first birth | `before_20`, `20_to_29`, `after_30`, `no_children` |
| Previous biopsy | `yes`, `no` |
| Lump detected | `yes`, `no` |
| Skin changes | `yes`, `no` |
| Nipple discharge | `yes`, `no` |
| Breast pain | `yes`, `no` |

**Risk Levels:**

| Level | Score Range | Action |
|-------|-------------|--------|
| Low | 0.0 – 0.29 | Continue routine self-exams |
| Moderate | 0.3 – 0.59 | Schedule clinical exam within one month |
| High | 0.6 – 1.0 | Visit health facility immediately, CHW referral |



---

## Chat Assistant

The chat assistant responds to breast health queries across five topics:

| Topic | Example Questions |
|-------|-------------------|
| Self-examination | "How do I do a self-exam?" |
| Symptoms | "What are the early signs of breast cancer?" |
| Risk factors | "What are the risk factors?" |
| Screening | "When should I get a mammogram?" |
| Treatment | "Is breast cancer treatable?" |

The assistant also contextualizes screening results — after a risk assessment, users can ask what their result means and get personalized guidance.

---

## Testing

### Quick Verification

```bash
# 1. Check ML service
curl http://localhost:8001/health

# 2. Register a user
curl -X POST http://localhost:8000/api/signup \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123"}'

# 3. Run a screening (use the token from step 2)
curl -X POST http://localhost:8000/api/screen \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"age":45,"family_history":"mother_sister","age_first_period":11,"age_first_birth":"after_30","previous_biopsy":"no","lump_detected":"yes","skin_changes":"no","nipple_discharge":"no","breast_pain":"yes"}'
```

### Test Personas

| Persona | Age | Family History | Key Symptoms | Expected Risk |
|---------|-----|----------------|--------------|---------------|
| Marie — Young, healthy | 25 | None | None | Low |
| Claudine — Middle-aged | 42 | Distant relative | Breast pain | Moderate |
| Jeanne — Multiple flags | 55 | Mother had BC | Lump + skin changes | High |




### System Architecture

```
┌──────────────┐     ┌──────────────────┐     ┌──────────────────┐
│  React Native│────▶│  Laravel API     │────▶│  MySQL Database  │
│  Mobile App  │     │  (Port 8000)     │     │                  │
└──────┬───────┘     └────────┬─────────┘     └──────────────────┘
       │                      │
       │ (offline)            │ HTTP
       ▼                      ▼
┌──────────────┐     ┌──────────────────┐
│  TFLite Model│     │  FastAPI ML Svc  │
│  (On-Device) │     │  (Port 8001)     │
└──────────────┘     │  /assess         │
                     │  /predict        │
                     └──────────────────┘


## Datasets

- TCIA public breast clinical dataset
-https://www.kaggle.com/datasets/anaselmasry/datasetbusiwithgt

---

