# MindCare

MindCare is an AI-powered mental health analysis and support system that helps users track their moods, book therapy sessions, and access mental health resources. It includes an admin panel for managing users, therapists, and questionnaires.

## Features
- **User Dashboard**: Tracks moods and displays graphical analysis.
- **Therapist Booking**: Users can book therapy sessions (online/offline).
- **Questionnaire Analysis**: AI-based prediction for mental health insights.
- **Admin Panel**: Manage therapists, appointments, and user queries.
- **Chatbot Support**: Provides mental health assistance.
- **Motivational Resources**: Includes yoga, breathing exercises, and fun videos.
- **Secure Authentication**: OTP-based signup and password reset.
- **Newsletter Subscription**: Users can subscribe for mental health updates.

## Tech Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, Python (Flask for ML)
- **Database**: MySQL
- **Machine Learning**: Random Forest Model (Joblib)
- **Libraries**: PHPMailer, Composer, ChromaDB

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/mindcare.git
   cd mindcare
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up the database:
   - Import `database/init.sql` into MySQL.
4. Configure `.env` file with database credentials.
5. Start the PHP server:
   ```bash
   php -S localhost:8000
   ```
6. Run the AI model (optional):
   ```bash
   python app.py
   ```

## Usage
- Open `http://localhost:8000` in your browser.
- Sign up and explore the dashboard.
- Admins can log in at `/admin/index2.php`.

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m "Added new feature"`).
4. Push to your branch (`git push origin feature-name`).
5. Open a Pull Request.
