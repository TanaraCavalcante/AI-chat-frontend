<aside id="sidebar">
<div id="sidebar-inner">

    {{-- Header del brand --}}
    <div class="aside-header d-flex align-items-center gap-2">
        <img src="{{ asset('images/bot-icon.png') }}" alt="Tanas'AI" class="aside-brand-icon flex-shrink-0" onerror="this.style.display='none'">
        <div class="aside-full flex-grow-1 text-truncate">
            <div class="fw-bold text-white lh-sm fs-5" >Tanas'<span class="text-purple">AI</span></div>
            <div class="text-white-50 lh-sm fs-8">Documenti &rarr; Risposte intelligenti</div>
        </div>
        <button type="button" class="aside-full sidebar-pin-toggle flex-shrink-0" onclick="toggleSidebarPin()" title="Blocca/comprimi la sidebar">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <div id="sidebar-scroll">

    {{-- Zona upload --}}
    <div id="upload-zone" class="aside-full upload-zone" onclick="document.getElementById('file-input').click()">
        <input type="file" id="file-input" style="display:none;" accept=".pdf,.txt,.docx,.xlsx">
        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
        <div class="fw-semibold" id="upload-label">Carica un documento</div>
        <div class="upload-hint-main">Trascina un file qui o clicca per selezionare</div>
        <div class="upload-hint">PDF &middot; TXT &middot; DOCX &middot; XLSX &middot; Max 20 MB</div>
    </div>

    {{-- Stato di indicizzazione (nascosto per impostazione predefinita) --}}
    <div id="indexing-steps" class="aside-full bg-card border border-faint rounded-3 p-3" style="display:none;">
        <div class="fw-semibold text-white fs-7 mb-2 text-truncate" id="filename-progress"></div>
        <div class="progress mb-2 progress-tiny">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-purple"></div>
        </div>
        <div class="step-list">
            <div id="step-read"  class="step-item"><i class="fa-solid fa-circle-dot fa-xs"></i> Lettura file</div>
            <div id="step-chunk" class="step-item"><i class="fa-solid fa-circle-dot fa-xs"></i> Divisione in chunk</div>
            <div id="step-embed" class="step-item"><i class="fa-solid fa-circle-dot fa-xs"></i> Generazione embeddings</div>
            <div id="step-faiss" class="step-item"><i class="fa-solid fa-circle-dot fa-xs"></i> Indicizzazione FAISS</div>
        </div>
    </div>

    {{-- Lista documenti (nascosta per impostazione predefinita) --}}
    <div id="doc-list-section" class="aside-full" style="display:none;">
        <div class="section-label-row">
            <span class="section-label">Documenti caricati</span>
            <span class="doc-count-badge" id="doc-count-badge">0</span>
        </div>
        <div id="doc-list"></div>
    </div>

    {{-- Come funziona --}}
    <div class="aside-full bg-card border border-faint rounded-3 p-3">
        <button type="button" class="how-toggle d-flex align-items-center justify-content-between gap-2 fw-bold text-white fs-6 w-100 bg-transparent border-0 p-0"
                data-bs-toggle="collapse" data-bs-target="#how-it-works-body" aria-expanded="false" aria-controls="how-it-works-body">
            <span class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-purple how-toggle-icon"></i> Come funziona?
            </span>
            <i class="fa-solid fa-chevron-down fs-8 text-white-50 how-toggle-chevron"></i>
        </button>

        <div class="collapse" id="how-it-works-body">
            <div class="d-flex align-items-start gap-2 mt-3 mb-2">
                <span class="how-step-num bg-purple text-white fw-bold fs-8">1</span>
                <div>
                    <div class="text-white fw-semibold fs-7">Carica il tuo documento</div>
                    <div class="text-white-50 fs-8">Aggiungi il file che vuoi analizzare</div>
                </div>
            </div>

            <div class="d-flex align-items-start gap-2 mb-2">
                <span class="how-step-num bg-purple text-white fw-bold fs-8">2</span>
                <div>
                    <div class="text-white fw-semibold fs-7">L'IA lo legge e lo elabora</div>
                    <div class="text-white-50 fs-8">Ricerca semantica nel contenuto (RAG)</div>
                </div>
            </div>

            <div class="d-flex align-items-start gap-2">
                <span class="how-step-num bg-purple text-white fw-bold fs-8">3</span>
                <div>
                    <div class="text-white fw-semibold fs-7">Ricevi la risposta</div>
                    <div class="text-white-50 fs-8">Con risposte precise e contestualizzate</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ricomincia (nascosto per impostazione predefinita) --}}
    <button id="btn-ricomincia" class="aside-full" style="display:none;" onclick="ricomincia()">
        <i class="fa-solid fa-trash-can fa-xs"></i> Rimuovi tutti i documenti
    </button>

    </div>

</div>
</aside>
