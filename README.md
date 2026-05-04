# AI Chat — Frontend

Interfaccia web per un assistente documentale basato su RAG (Retrieval-Augmented Generation). Permette di caricare documenti (PDF, DOCX, TXT, XLSX) e fare domande sul loro contenuto in linguaggio naturale.

---

## Architettura

Questo repository è il **frontend Laravel**. Funziona come intermediario tra il browser e il backend Python:

```
Browser → Laravel (questo repo) → Python API (ai-chat) → Claude AI
```

| Layer | Tecnologia | Ruolo |
|---|---|---|
| Frontend | Laravel 13 + Blade + Bootstrap 5 | UI, sessioni, proxy HTTP |
| Backend | Python + Flask + FAISS + LangChain | Indicizzazione, embeddings, RAG |
| AI | Claude (Anthropic API) | Generazione delle risposte |

Il Laravel **non elabora i documenti direttamente** — fa da proxy: riceve i file dal browser e li inoltra all'API Python tramite `Http::post()`. La sessione Python (`session_id`) viene conservata nella sessione Laravel.

### Endpoint esposti da Laravel

| Metodo | Route | Descrizione |
|---|---|---|
| `GET` | `/` | Carica la view principale |
| `POST` | `/upload` | Invia il file all'API Python |
| `POST` | `/chat` | Inoltra la domanda e restituisce la risposta |
| `POST` | `/clear` | Termina la sessione e libera la memoria FAISS |

---

## Tecnologie

- **Laravel 13** — routing, sessioni, proxy HTTP
- **Blade** — template engine con componenti (`x-navbar`, `x-sidebar`)
- **Bootstrap 5** — layout e componenti UI
- **SweetAlert2** — dialoghi di conferma
- **Vite** — bundler assets
- **Tailwind CSS 4** — utility classes (opzionale, configurato)

---

## Setup su una nuova macchina

### Prerequisiti

- PHP 8.3+
- Composer
- Node.js + npm
- Laravel Valet (opzionale, consigliato per sviluppo locale)

### 1. Clona e installa dipendenze

```bash
git clone <repo-url> ai-chat-frontend
cd ai-chat-frontend

composer install
npm install
```

### 2. Configura l'ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Apri `.env` e imposta l'URL dell'API Python:

```env
PYTHON_API_URL=http://127.0.0.1:5000
```

### 3. Avvia con Valet

```bash
valet link ai-chat-frontend
valet secure ai-chat-frontend   # opzionale, abilita HTTPS
```

L'app sarà disponibile su `https://ai-chat-frontend.test`.

### 4. Build assets (sviluppo)

```bash
npm run dev
```

---

## Backend Python

Il backend si trova nel repository separato `AI-chat`. Va avviato prima di usare il frontend:

```bash
cd ../AI-chat
source venv/bin/activate
python api.py
```

Deve essere in ascolto sull'URL configurato in `PYTHON_API_URL` (default: `http://127.0.0.1:5001`).

---

## Struttura principale

```
app/Http/Controllers/ChatController.php   — proxy verso l'API Python
resources/views/
    chat.blade.php                        — view principale
    components/
        master.blade.php                  — layout HTML base
        navbar.blade.php                  — barra di navigazione
        sidebar.blade.php                 — upload, lista documenti, stato
public/
    css/app.css                           — stili custom
    js/chat.js                            — logica UI e chiamate API
    images/                               — logo e avatar
```
