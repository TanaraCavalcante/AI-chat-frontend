# Changelog

## [2026-09-08] - Restyle completo: rebranding Tanas'AI, aside retrattile e miglioramenti chat

### Aggiunto
- Endpoint `/api/remove-doc` nel backend Python (repo `ai-chat`) e route/metodo corrispondenti in `ChatController`: rimozione di un singolo documento dalla sessione senza reload di pagina, con ricostruzione dell'indice FAISS
- Sidebar retrattile: chiusa mostra solo l'icona del bot, anteprima al passaggio del mouse, resta fissa (docked) al click
- Sezione "Come funziona?" collassabile, header dell'aside fisso e scrollbar personalizzata (anche nell'area messaggi)
- Footer dell'aside con crediti ("Powered by Groq" e link al GitHub della sviluppatrice)
- Drag & drop nella zona di upload, animazione a 4 fasi durante l'indicizzazione del documento
- Orario sui messaggi della chat e pulsante per copiare la risposta del bot, con fallback per contesti non sicuri dove la Clipboard API non e' disponibile
- Nuova favicon del progetto
- Classi CSS generiche riutilizzabili per colori (`.text-purple`, `.bg-card`, `.text-muted-2`, ecc.) e scala di font-size (`.fs-7`, `.fs-8`)

### Modificato
- Rebranding completo da "AI W-TECH" a "Tanas'AI": rimosso il navbar, layout ora solo aside + area chat, tema scuro viola/indigo
- CSS di aside e fumetti della chat semplificato con utility Bootstrap al posto di classi dedicate per ogni componente
- Pulsante "Ricomincia" rinominato in "Reset", icona di invio della chat da freccia ad aeroplanino
- `ChatController`: URL dell'API Python spostato da `env()` diretto a `config('services.python_api.url')`; aggiunti i tipi di ritorno espliciti a tutti i metodi pubblici
- `chat.js`: toggle di stato via `classList` invece di sostituire l'intero `className`, per non perdere le classi utility statiche applicate nel markup

### Corretto
- Diversi bug di layout introdotti durante la semplificazione CSS (fumetti senza `display:flex`, footer dell'aside che non si nascondeva insieme al resto quando compressa, hover del chevron che coinvolgeva anche l'icona)
- Cache-busting aggiunto anche a `chat.js` (gia' presente su `app.css`) per evitare che il browser servisse versioni in cache dopo una modifica

### Rimosso
- Asset immagine residui del brand W-Tech non piu' referenziati (`atomic.png`, `logo.png`)
- CSS morto (`.step-item.active`, mai applicato dal JS)

## [2026-09-07] - Pulizia .env.example

### Rimosso
- Rimosse da `.env.example` le variabili non utilizzate dal progetto (`BROADCAST_CONNECTION`, `MEMCACHED_*`, `REDIS_*`, `MAIL_*`, `AWS_*`) e le righe commentate relative a driver/config alternativi non in uso (MySQL/Postgres, `APP_MAINTENANCE_STORE`, `PHP_CLI_SERVER_WORKERS`, `CACHE_PREFIX`)

### Aggiunto
- Aggiunta `PYTHON_API_URL` a `.env.example`, richiesta da `ChatController` ma finora assente dal file di esempio

## [2026-05-11] - Rinominato brand in "AI W-TECH"

### Modificato
- Titolo pagina e label navbar aggiornati da "W-Tech AI Chat" / "AI Chat" a "AI W-TECH"

## [2026-05-07] - Corretto fallback porta API Python

### Corretto
- `ChatController`: fallback `PYTHON_API_URL` corretto da porta `5000` a `5001`

## [2026-04-30] - 1.0.1

### Aggiunto
- Aggiunta logo `public/images/logo.png`

### Corretto
- Corretto border-radius del logo wrapper nel navbar: aggiunta classe `.logo-wrapper` con `border-radius`, `overflow: hidden` e padding dedicati nel CSS
- Aggiunto `.playwright-mcp/` e `.claude/settings.json` al `.gitignore`
