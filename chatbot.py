from flask import Flask
from flask_cors import CORS
import os
import gradio as gr

from langchain_groq import ChatGroq
from langchain_community.embeddings import HuggingFaceEmbeddings
from langchain_community.document_loaders import PyPDFLoader, DirectoryLoader
from langchain_community.vectorstores import Chroma
from langchain.chains import RetrievalQA
from langchain.prompts import PromptTemplate
from langchain.text_splitter import RecursiveCharacterTextSplitter

app = Flask(__name__)
CORS(app)
print("Initializing Chatbot...")

# Initialize LLM using ChatGroq
def initialize_llm():
    llm = ChatGroq(
        temperature=0,
        groq_api_key="api",
        model_name="llama-3.3-70b-versatile"
    )
    return llm

# Create or load the vector database (assumes PDFs and DB folder are inside the 'chatbot' folder)
def create_vector_db():
    # PDFs are stored in the "chatbot" folder
    loader = DirectoryLoader("chatbot", glob="*.pdf", loader_cls=PyPDFLoader)
    documents = loader.load()
    text_splitter = RecursiveCharacterTextSplitter(chunk_size=500, chunk_overlap=50)
    texts = text_splitter.split_documents(documents)
    embeddings = HuggingFaceEmbeddings(model_name="sentence-transformers/all-MiniLM-L6-v2")
    # Save Chroma DB inside "chatbot/chroma_db"
    vector_db = Chroma.from_documents(texts, embeddings, persist_directory="chatbot/chroma_db")
    vector_db.persist()
    print("ChromaDB created and data saved")
    return vector_db

# Set up the QA chain using the vector DB and LLM
def setup_qa_chain(vector_db, llm):
    retriever = vector_db.as_retriever()
    
    # Corrected Prompt Template
    prompt_template = """
    You are MindCare, a compassionate and understanding mental health chatbot here to support users in their well-being journey. Your responses are warm, friendly, and to the point, offering clear and thoughtful guidance based on general mental health knowledge. You listen attentively, respond with empathy, and create a safe space where users feel heard and valued. If a question is unrelated to mental health, acknowledge it briefly and gently steer the conversation back to well-being. Your goal is to provide support, reassurance, and practical advice in a way that feels natural and human. Keep responses concise yet meaningful—comforting but never overly wordy.

    Context: {context}
    User: {question}
    Chatbot:
    """
    PROMPT = PromptTemplate(template=prompt_template, input_variables=["context", "question"])
    
    qa_chain = RetrievalQA.from_chain_type(
        llm=llm,
        chain_type="stuff",
        retriever=retriever,
        chain_type_kwargs={"prompt": PROMPT}
    )
    return qa_chain

llm = initialize_llm()
db_path = "chatbot/chroma_db"
if not os.path.exists(db_path):
    vector_db = create_vector_db()
else:
    embeddings = HuggingFaceEmbeddings(model_name="sentence-transformers/all-MiniLM-L6-v2")
    vector_db = Chroma(persist_directory=db_path, embedding_function=embeddings)
qa_chain = setup_qa_chain(vector_db, llm)

def chatbot_response(user_input, history=[]):
    if not user_input.strip():
        return "Please provide a valid input", history
    
    response_dict = qa_chain.invoke({"context": "", "query": user_input})  # Ensure the input format matches
    response = response_dict.get("result", "I couldn't generate a response.")  # Extracts only the text
    
    return response


# Custom CSS for Pink Theme
custom_css = """
    body {
        background-color: #ffe6f2;
    }
    .gradio-container {
        background-color: #ffccdd;
        border-radius: 10px;
        padding: 10px;
    }
    .gradio-container h1 {
        color: #ff4d94;
    }
    .message-container {
        background-color: #ff99c8;
        color: white;
        border-radius: 10px;
        padding: 10px;
    }
    .message-container.user {
        background-color: #ff66a3;
    }
"""
# JavaScript for Back button
redirect_js = """
<button onclick="window.location.href='http://localhost/Mindcare/index.php'" style="padding:10px 15px; background-color:#ff69b4; color:white; border:none; cursor:pointer; font-size:16px; margin-top:10px;">
    🔙 Back to Home
</button>
"""
# Create Gradio interface inside Blocks
with gr.Blocks(css=custom_css) as chatbot_app:
    gr.Markdown("<h1 style='text-align: center;'> 🧠 MindCare Mental Health Chatbot 🤖</h1>")
    gr.Markdown("<p style='text-align: center;'>A compassionate chatbot designed to assist with mental well-being. Note: For serious concerns, contact a professional.</p>")
    
    chatbot = gr.ChatInterface(fn=chatbot_response, title="MindCare Chatbot")
    gr.HTML(redirect_js)
chatbot_app.launch(server_name="0.0.0.0", server_port=5002, share=False)
