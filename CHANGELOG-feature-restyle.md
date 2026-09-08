## [2026-09-08] - Semplificazione del CSS dell'aside con utility Bootstrap

### Aggiunto
- Nuove classi generiche per colori riutilizzati nell'aside: `.text-purple-light`, `.text-green-light`, `.text-red-light`, `.text-muted-2`, `.text-muted-3`

### Modificato
- Zona di upload, stato di indicizzazione, lista documenti e pulsante di reset riscritti con utility Bootstrap (`d-flex`, `gap-*`, `rounded-3`, `fs-7`/`fs-8`, ecc.) al posto di classi CSS dedicate, mantenendo solo cio' che non ha un equivalente diretto (dimensioni fisse, pulsanti circolari, hover)
- `chat.js`: il toggle degli step di indicizzazione ora usa `classList.add/remove` invece di sostituire l'intero `className`, cosi' non cancella piu' le classi utility statiche applicate nel markup
- Pulsante "Rimuovi tutti i documenti" rinominato in "Reset" (icona e testo del modale di conferma aggiornati di conseguenza), piu' coerente con l'azione

### Rimosso
- CSS morto: `.step-item.active`, mai applicato dal JS

## [2026-09-08] - Header dell'aside fisso e scrollbar personalizzata

### Aggiunto
- Scrollbar sottile e personalizzata (colore viola translucido, thumb arrotondato) per l'area scorrevole dell'aside, a filo del bordo destro

### Modificato
- L'header del brand (icona, titolo, chevron) resta fisso in cima all'aside: solo la sezione sottostante (upload, documenti, come funziona, rimuovi tutto) scorre
- Corretto lo stato hover del chevron di "Come funziona?": ora cambia colore solo il chevron, non piu' anche l'icona della bacchetta

## [2026-09-08] - Sidebar retrattile con anteprima al passaggio del mouse

### Aggiunto
- Sidebar collassabile: chiusa mostra solo l'icona del bot (rail stretta), passando il mouse sopra si apre come overlay temporaneo (senza spostare l'area chat), e cliccando sul chevron mentre e' aperta resta fissa (docked) finche' non viene richiuso
- Aggiornata la favicon del progetto

## [2026-09-08] - Sezione "Come funziona?" a scomparsa e chiarezza sul pulsante di reset

### Modificato
- La sezione "Come funziona?" nell'aside ora è collassabile (Bootstrap collapse): chiusa di default, si apre cliccando sul titolo, con chevron che ruota in base allo stato
- Rinominato il pulsante "Ricomincia" in "Rimuovi tutti i documenti" (con icona cestino), e aggiornato il testo di conferma, per chiarire che l'azione elimina tutti i file caricati e la cronologia della chat

## [2026-09-08] - Ripristino animazione di indicizzazione e affinamenti aside

### Aggiunto
- Scala di font-size generica (`.fs-7` = 0.75rem, `.fs-8` = 0.5rem) accanto a quella nativa di Bootstrap (`.fs-6` = 1rem)

### Modificato
- Ripristinata l'animazione a 4 fasi durante l'upload (Lettura file → Divisione in chunk → Generazione embeddings → Indicizzazione FAISS), rimossa per errore durante il restyle iniziale
- Timing dell'animazione ricalibrato sulla durata tipica di ogni fase (embeddings è la più lenta) e corretto un bug per cui, con risposte rapide del backend, l'ultimo step risultava completato mentre quelli precedenti restavano bloccati in attesa
- Header dell'aside riscritto con classi utility Bootstrap; icona del bot ingrandita e senza più il contenitore con sfondo/bordo

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
