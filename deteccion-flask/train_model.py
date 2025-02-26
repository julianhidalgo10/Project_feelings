import pickle
import numpy as np
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.naive_bayes import MultinomialNB

# Datos de entrenamiento (Ejemplo)
textos = [
    "El producto es excelente, me encantó",
    "No me gustó para nada, muy malo",
    "Es un buen producto, estoy satisfecho",
    "Horrible, nunca volveré a comprar",
    "Es aceptable, podría mejorar"
]
etiquetas = ["positivo", "negativo", "positivo", "negativo", "neutral"]

# Vectorización de texto
vectorizador = CountVectorizer()
X = vectorizador.fit_transform(textos)

# Entrenamiento del modelo
modelo = MultinomialNB()
modelo.fit(X, etiquetas)

# Guardar el modelo entrenado
with open("model/modelo_sentimientos.pkl", "wb") as archivo:
    pickle.dump(modelo, archivo)

with open("model/vectorizador.pkl", "wb") as archivo:
    pickle.dump(vectorizador, archivo)

print("✅ Modelo entrenado y guardado correctamente en la carpeta 'model'.")