# laww
 ⚖️ Smart Legal Assistance System
> *Describe the crime. Know the law.*

A web-based AI-powered legal tool that maps any crime description — in English, Hindi, or Marathi — to the relevant Indian Penal Code (IPC) sections, complete with punishments, bailable status, and steps to file an FIR.

---

 🧠 What It Does

Most people in India don't know which law applies when a crime happens to them. This system bridges that gap — just describe what happened in plain language, and the AI instantly finds the applicable IPC sections. No legal knowledge required.

---

✨ Key Features

- **AI-Powered Law Matching** — Google Gemini understands your description and returns the most relevant IPC sections
- **Multilingual Input** — Type in Hindi, Marathi, or English — auto-translated before processing
- **Voice Input** — Speak your problem aloud using the built-in mic
- **Bailable / Cognizable Detection** — Automatically determined from punishment text
- **Browse by Category** — Explore 14 crime categories with severity ratings, fine amounts, and FIR guidance
- **Nyaya Chatbot** — In-page legal assistant for quick IPC queries
- **Recent Searches** — Last 5 searches saved locally for quick access



 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, Bootstrap 5, JavaScript |
| Backend | PHP |
| AI Engine | Google Gemini 1.5 Flash API |
| Translation | Google Translate API |
| Voice | Web Speech API |
| Database | MySQL + JSON |



 📂 Project Structure


laww/
├── index.php              # Home page — search form, voice input, chatbot
├── search.php             # AI pipeline — translate → extract → match laws
├── result.php             # Results page — IPC cards, badges, severity
├── categories.php         # Browse all 14 crime categories
├── import.php             # One-time JSON to MySQL importer
├── includes/
│   └── db_connection.php  # Database connection
└── database json/
    └── laws.json          # 16 laws across 14 IPC categories

*Built at **Hack Days Nagpur** Hackathon*
