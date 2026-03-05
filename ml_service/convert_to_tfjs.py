"""
Custom Keras → TensorFlow.js converter
Bypasses the broken tensorflowjs pip package on Windows.
Only needs tensorflow + numpy (already installed).
"""

import tensorflow as tf
import numpy as np
import json
import os

print("Loading model...")
model = tf.keras.models.load_model("saved_models/breast_cnn_model.h5")
print(f"Model loaded: {len(model.weights)} weight tensors")

# Output directory
out_dir = "saved_models/tfjs_model"
os.makedirs(out_dir, exist_ok=True)

# Get model topology as JSON (Keras format — TFJS understands this)
topology = json.loads(model.to_json())

# Collect weights and write to binary shard file
print("Converting weights...")
weight_data = b""
weight_entries = []

for w in model.weights:
    arr = w.numpy().astype(np.float32)
    weight_entries.append({
        "name": w.name,
        "shape": list(arr.shape),
        "dtype": "float32",
    })
    weight_data += arr.tobytes()

# Write the binary weights file
shard_name = "group1-shard1of1.bin"
shard_path = os.path.join(out_dir, shard_name)
with open(shard_path, "wb") as f:
    f.write(weight_data)

# Build model.json
model_json = {
    "modelTopology": topology,
    "format": "layers-model",
    "generatedBy": "custom_converter",
    "convertedBy": "MamaCare",
    "weightsManifest": [
        {
            "paths": [shard_name],
            "weights": weight_entries,
        }
    ],
}

model_path = os.path.join(out_dir, "model.json")
with open(model_path, "w") as f:
    json.dump(model_json, f)

weight_mb = len(weight_data) / (1024 * 1024)
print(f"\nDone! TFJS model saved to {out_dir}/")
print(f"  model.json        — topology + weight manifest")
print(f"  {shard_name} — {weight_mb:.1f} MB weights")
print(f"\nCopy these 2 files into your MamaCare app assets folder.")
