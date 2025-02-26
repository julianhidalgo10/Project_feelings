from flask import Flask, request, jsonify
import pickle
import numpy as np
import firebase_admin
from firebase_admin import credentials, firestore
import os

# 📌 Cargar credenciales de Firebase usando la ruta absoluta
firebase_config_path = os.path.join(os.getcwd(), "firebase-config.json")
cred = credentials.Certificate(firebase_config_path)
firebase_admin.initialize_app(cred)

# Conectar con Firestore
db = firestore.client()

# Crear la aplicación Flask
app = Flask(__name__)

# 📌 Cargar el modelo y el vectorizador con rutas absolutas
modelo_path = os.path.join(os.getcwd(), "model", "modelo_sentimientos.pkl")
vectorizador_path = os.path.join(os.getcwd(), "model", "vectorizador.pkl")

try:
    with open(modelo_path, "rb") as archivo:
        modelo = pickle.load(archivo)
    with open(vectorizador_path, "rb") as archivo:
        vectorizador = pickle.load(archivo)
    print("✅ Modelo y vectorizador cargados correctamente.")
except Exception as e:
    print(f"❌ Error al cargar el modelo o vectorizador: {e}")
    exit(1)

# 📌 Ruta para probar que Flask está corriendo correctamente
@app.route('/', methods=['GET'])
def home():
    return "<h1>API de Clasificación de Sentimientos</h1><p>Flask está funcionando correctamente.</p>"

# 📌 Ruta para clasificar un texto
@app.route('/clasificar', methods=['POST'])
def clasificar():
    try:
        datos = request.get_json()
        print("📌 Datos recibidos en Flask desde Postman:", datos)  # Debug

        if not datos or "texto" not in datos:
            return jsonify({"error": "Debe proporcionar un texto"}), 400

        texto = datos["texto"]
        print("📌 Texto recibido:", texto)  # Debug

        # Convertir el texto a la representación numérica
        texto_vectorizado = vectorizador.transform([texto])
        resultado = modelo.predict(texto_vectorizado)[0]

        # Guardar en Firebase
        db.collection("clasificaciones").add({
            "texto": texto,
            "clasificacion": resultado
        })

        return jsonify({"texto": texto, "clasificacion": resultado})

    except Exception as e:
        print(f"❌ Error en la clasificación: {e}")
        return jsonify({"error": "Ocurrió un error interno"}), 500

# 📌 Ejecutar la aplicación Flask
if __name__ == "__main__":
    print("📌 Rutas registradas en Flask:")
    print(app.url_map)  # Debug para ver qué rutas carga Flask
    app.run(debug=True, host='0.0.0.0', port=5000)