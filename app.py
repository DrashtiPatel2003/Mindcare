from flask import Flask, jsonify, send_file, request
import requests
import pandas as pd
import joblib
import matplotlib.pyplot as plt
import io
import seaborn as sns
from flask_cors import CORS

app = Flask(__name__)
CORS(app)
print("Flask app is starting...")

# Load trained Random Forest model
model = joblib.load("ranfor.joblib")

# Fetch latest response from PHP
FETCH_URL = "http://localhost/Mindcare/fetch_latest.php"

# Load dataset for analysis
df = pd.read_csv("database/enc_ds.csv")

# Feature columns in order expected by model
FEATURE_COLUMNS = [
    "Age", "Gender", "self_employed", "family_history", "work_interfere",
    "no_employees", "remote_work", "tech_company", "benefits",
    "care_options", "wellness_program", "seek_help", "anonymity",
    "leave", "mental_health_consequence", "phys_health_consequence",
    "coworkers", "supervisor", "mental_health_interview",
    "phys_health_interview", "mental_vs_physical", "obs_consequence"
]

# Gender Encoding Mapping
GENDER_MAP = {"female": 0, "male": 1, "others": 2}

@app.route('/predict', methods=['GET'])
def predict():
    try:
        response = requests.get(FETCH_URL)
        user_data = response.json()
        
        if "error" in user_data:
            return jsonify({"error": user_data["error"]}), 404

        processed_data = {
            "Age": int(user_data["age"]),
            "Gender": int(user_data["gender"]),
            "self_employed": int(user_data["self_employed"]),
            "family_history": int(user_data["family_history"]),
            "work_interfere": int(user_data["work_interfere"]),
            "no_employees": int(user_data["no_employees"]),
            "remote_work": int(user_data["remote_work"]),
            "tech_company": int(user_data["tech_company"]),
            "benefits": int(user_data["benefits"]),
            "care_options": int(user_data["care_options"]),
            "wellness_program": int(user_data["wellness_program"]),
            "seek_help": int(user_data["seek_help"]),
            "anonymity": int(user_data["anonymity"]),
            "leave": int(user_data["leave_policy"]),  # Fixed key mismatch
            "mental_health_consequence": int(user_data["mental_health_consequence"]),
            "phys_health_consequence": int(user_data["phys_health_consequence"]),
            "coworkers": int(user_data["coworkers"]),
            "supervisor": int(user_data["supervisor"]),
            "mental_health_interview": int(user_data["mental_health_interview"]),
            "phys_health_interview": int(user_data["phys_health_interview"]),
            "mental_vs_physical": int(user_data["mental_vs_physical"]),
            "obs_consequence": int(user_data["obs_consequence"]),
        }

        feature_values = [processed_data[col] for col in FEATURE_COLUMNS]
        input_df = pd.DataFrame([processed_data], columns=FEATURE_COLUMNS)

        prediction = model.predict(input_df)[0]
        probability = model.predict_proba(input_df)[0][1] * 100

        return jsonify({
            "prediction": "Treatment Recommended" if prediction == 1 else "No Treatment Needed",
            "probability": round(probability, 2)
        })
    
    except Exception as e:
        return jsonify({"error": "Prediction error: " + str(e)}), 500

@app.route('/graph')
def graph():
    try:
        fig, axs = plt.subplots(2, 2, figsize=(12, 10))

        # Graph 1: Treatment Distribution
        treatment_counts = df['treatment'].value_counts()
        axs[0, 0].bar(['No Treatment', 'Treatment'], treatment_counts, color=['red', 'green'])
        axs[0, 0].set_title("Overall Treatment Distribution")
        axs[0, 0].set_xlabel("Treatment Status")
        axs[0, 0].set_ylabel("Count")

        # Graph 2: Work Interference vs. Treatment
        pd.crosstab(df['work_interfere'], df['treatment']).plot(kind='bar', stacked=True, colormap='viridis', ax=axs[0, 1])
        axs[0, 1].set_title("Work Interference vs. Treatment")
        axs[0, 1].set_xlabel("Work Interference")
        axs[0, 1].set_ylabel("Count")

        # Graph 3: Age Distribution
        df['Age'].hist(bins=10, color='skyblue', ax=axs[1, 0])
        axs[1, 0].set_title("Age Distribution")
        axs[1, 0].set_xlabel("Age")
        axs[1, 0].set_ylabel("Frequency")

        # Graph 4: Gender Distribution
        gender_counts = df['Gender'].map({0: "Female", 1: "Male", 2: "Others"}).value_counts()
        axs[1, 1].pie(gender_counts, labels=gender_counts.index, autopct='%1.1f%%', colors=['blue', 'pink', 'gray'])
        axs[1, 1].set_title("Gender Distribution")

        plt.tight_layout()
        buf = io.BytesIO()
        plt.savefig(buf, format="png")
        buf.seek(0)

        return send_file(buf, mimetype="image/png")

    except Exception as e:
        return jsonify({"error": "Graph generation error: " + str(e)}), 500

@app.route('/api/age-trend/<int:age>')
def age_trend(age):
    try:
        age_filtered = df[(df['Age'] >= age - 5) & (df['Age'] <= age + 5)]
        data = age_filtered.groupby("Age")["treatment"].count().to_dict()
        return jsonify(data)
    except Exception as e:
        return jsonify({"error": "Age trend error: " + str(e)}), 500

@app.route('/api/gender-trend/<string:gender>')
def gender_trend(gender):
    try:
        gender_encoded = GENDER_MAP.get(gender.lower())
        
        if gender_encoded is None:
            return jsonify({"error": "Invalid gender"}), 400

        gender_filtered = df[df['Gender'] == gender_encoded]
        data = gender_filtered["treatment"].value_counts().to_dict()
        return jsonify(data)

    except Exception as e:
        return jsonify({"error": "Gender trend error: " + str(e)}), 500

@app.route('/api/workplace_trends', methods=['GET'])
def workplace_trends():
    try:
        no_employees = request.args.getlist('no_employees')
        remote_work = request.args.get('remote_work')

        df_filtered = df.copy()

        if no_employees:
            no_employees = [int(size) for size in no_employees]
            df_filtered = df_filtered[df_filtered['no_employees'].isin(no_employees)]

        if remote_work is not None:
            remote_work = int(remote_work)
            df_filtered = df_filtered[df_filtered['remote_work'] == remote_work]

        trend_data = df_filtered.groupby('no_employees')['treatment'].value_counts().unstack().fillna(0)

        result = {
            "categories": trend_data.index.tolist(),
            "yes_treatment": trend_data[1].tolist() if 1 in trend_data else [],
            "no_treatment": trend_data[0].tolist() if 0 in trend_data else []
        }
        return jsonify(result)

    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/workplace_trends_graph', methods=['GET'])
def workplace_trends_graph():
    try:
        company_size = request.args.getlist('no_employees')
        remote_work = request.args.get('remote_work')

        df_filtered = df.copy()

        if company_size:
            company_size = [int(size) for size in company_size]
            df_filtered = df_filtered[df_filtered['no_employees'].isin(company_size)]

        if remote_work is not None:
            remote_work = int(remote_work)
            df_filtered = df_filtered[df_filtered['remote_work'] == remote_work]

        trend_data = df_filtered.groupby('no_employees')['treatment'].value_counts().unstack().fillna(0)

        plt.figure(figsize=(10, 6))
        trend_data.plot(kind='bar', stacked=True, colormap='coolwarm')

        plt.title("Workplace Mental Health Trends")
        plt.xlabel("Company Size (Number of Employees)")
        plt.ylabel("Number of Employees")
        plt.xticks(rotation=45)
        plt.legend(["No Treatment", "Treatment"], title="Mental Health Treatment")

        buf = io.BytesIO()
        plt.savefig(buf, format="png")
        buf.seek(0)

        return send_file(buf, mimetype="image/png")

    except Exception as e:
        return jsonify({"error": "Graph generation error: " + str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
