## [2026-09-08] - Restyle dell'aside e rimozione del brand W-Tech

### Aggiunto
- Endpoint `/api/remove-doc` nel backend Python (repo `ai-chat`): rimuove un singolo documento dalla sessione e ricostruisce l'indice FAISS senza di esso
- Route e metodo `ChatController::removeDoc()` per esporre la rimozione al frontend
- Rimozione di un documento dalla UI senza reload di pagina, con icona colorata per tipo file (PDF/DOCX/XLSX/TXT), dimensione e stato
- Drag & drop nella zona di upload dell'aside
- Sezione "Come funziona?" statica nell'aside
- Favicon del progetto

### Modificato
- Rebranding completo da "AI W-TECH" a "Tanas'AI" (title, meta, aside)
- Rimosso il navbar in cima alla pagina: il layout ora è solo aside + area chat
- Aside ridisegnato con tema scuro viola/indigo, riscritto con classi utility Bootstrap e poche classi generiche riutilizzabili per colori (`.text-purple`, `.bg-purple`, `.bg-card`, `.border-faint`) invece di una classe dedicata per componente
- CSS del foglio principale con cache-busting (`?v=filemtime`) per evitare problemi di cache del browser sulle modifiche di stile
