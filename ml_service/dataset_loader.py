import pandas as pd
from sklearn.preprocessing import LabelEncoder, StandardScaler

def load_clinical_data(path):
    df = pd.read_excel(path)

    df = df.dropna(thresh=len(df.columns) * 0.7)
    df = df.fillna(df.median(numeric_only=True))

    for col in df.select_dtypes("object").columns:
        df[col] = LabelEncoder().fit_transform(df[col].astype(str))

    target = "Overall Survival Status"
    if target not in df.columns:
        raise Exception("Check dataset target column")

    X = df.drop(target, axis=1)
    y = df[target]

    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(X)

    return X_scaled, y
