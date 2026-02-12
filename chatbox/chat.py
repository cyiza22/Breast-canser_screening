from transformers import pipeline

chatbot = pipeline(
    "text-generation",
    model="microsoft/DialoGPT-medium"
)

def ask_bot(message):
    prompt = f"Breast cancer health advice: {message}"
    response = chatbot(prompt, max_length=100)
    return response[0]["generated_text"]
