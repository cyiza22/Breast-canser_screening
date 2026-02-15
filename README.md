# Breast Cancer Screening — AI-Powered Mobile Platform

An AI-powered mobile screening and awareness system that facilitates early breast cancer detection among women in underserved African communities. 
The platform provides accessible preliminary risk assessment, culturally localized health education, and seamless integration with Community Health Worker (CHW) networks.


---

## Table of Contents

- [Description](#description)
- [GitHub Repository](#github-repository)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Environment Setup](#environment-setup)
  - [Prerequisites](#prerequisites)
  - [ML Service (Python)](#1-ml-service-python)
  - [Backend API (Laravel)](#2-backend-api-laravel)

---

## Description

Breast cancer carries a disproportionately high burden in Sub-Saharan Africa, where mortality rates often exceed 50%. In Rwanda, the five-year survival rate is only 46%, 
largely because patients present with advanced-stage disease. Rural screening rates are reported as low as 15%.

This project bridges that gap by combining:

- **AI-Powered Risk Assessment** — A CNN-based deep learning model optimized for on-device image analysis that stratifies risk into low, moderate, and high categories.
- **Health Chatbot** — An AI assistant providing breast cancer education and guidance.
- **CHW Integration** — Connects patients with Community Health Workers for follow-up and referral.

## GitHub Repository

🔗 https://github.com/cyiza22/Breast-canser_screening.git



## Tech Stack

| Layer        | Technology                          |
|--------------|-------------------------------------|      |
| Backend API  | Laravel 10 (PHP) + Sanctum Auth     |
| ML Service   | Python, TensorFlow/Keras, FastAPI   |
| ML Model     | CNN (`.h5`) → TFLite (`.tflite`)    |
| Database     | MySQL                               |

---

## Project Structure

```
BREAST-CANCER-SCREENING/
├── chatbox/                  # AI chatbot module
│   └── chat.py               # health advice bot
├── data/                     # Clinical datasets
│   └── TCIA-Breast-clinical-data-public-7_16_11.xlsx
├── ml_service/               # Machine learning service
│   ├── saved_models/
│   │   ├── breast_cnn_model.h5    # Trained CNN model
│   │   ├── clinical_model.pkl     # Clinical risk model
│   │   └── model.tflite           # Mobile-optimized model
│   ├── inference.py          # Image preprocessing & prediction
│   ├── main.py               # FastAPI prediction endpoint
│   ├── requirements.txt      # Python dependencies
│   └── train_model.ipynb     # Model training notebook
├── screening-api/            # Laravel backend API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php     # Signup & login
│   │   │   ├── AssistController.php   # ML prediction + chat
│   │   │   └── HealthController.php   # Health check endpoint
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   └── Prediction.php
│   │   └── Services/
│   │       └── ChatService.php        # Chat response logic
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
- **MySQL** 8.0+
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

# Run the prediction API
uvicorn main:app --host 0.0.0.0 --port 8001 --reload
```

The ML API will be available at `http://localhost:8001`. Test it:

```bash
curl -X POST http://localhost:8001/predict \
  -F "file=@path/to/test_image.png"
```

**Training the model:** Open `train_model.ipynb` in Jupyter Notebook to retrain or fine-tune the CNN model.

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

Edit `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=breast_screening
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run:

```bash
# Create the database
mysql -u root -p -e "CREATE DATABASE breast_screening;"

# Run migrations
php artisan migrate

# Start the server
php artisan serve
```

The API will be available at `http://localhost:8000/api`.

**API Endpoints:**

| Method | Endpoint       | Auth     | Description                    |
|--------|----------------|----------|--------------------------------|
| POST   | `/api/signup`  | Public   | Register a new user            |
| POST   | `/api/login`   | Public   | Login and receive token        |
| POST   | `/api/assist`  | Sanctum  | Submit image + message for AI  |
| GET    | `/api/health`  | Sanctum  | System health check            |

Kaggledataset:
https://www.kaggle.com/datasets/anaselmasry/datasetbusiwithgt

---

