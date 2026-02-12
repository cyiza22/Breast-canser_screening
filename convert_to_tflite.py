import tensorflow as tf

model = tf.keras.models.load_model("breast_risk_model.h5")

converter = tf.lite.TFLiteConverter.from_keras_model(model)
converter.optimizations = [tf.lite.Optimize.DEFAULT]

tflite_model = converter.convert()

open("breast_model.tflite","wb").write(tflite_model)
