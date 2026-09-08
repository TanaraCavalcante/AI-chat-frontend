<aside id="sidebar">

    {{-- Header del brand --}}
    <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('images/bot-icon.png') }}" alt="Tanas'AI" class="aside-brand-icon flex-shrink-0" onerror="this.style.display='none'">
        <div>
            <div class="fw-bold text-white lh-sm fs-5" >Tanas'<span class="text-purple">AI</span></div>
            <div class="text-white-50 lh-sm fs-8">Documenti &rarr; Risposte intelligenti</div>
        </div>
    </div>

    {{-- Zona upload --}}
    <div id="upload-zone" class="upload-zone" onclick="document.getElementById('file-input').click()">
        <input type="file" id="file-input" style="display:none;" accept=".pdf,.txt,.docx,.xlsx">
        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
        <div class="fw-semibold" id="upload-label">Carica un documento</div>
        <div class="upload-hint-main">Trascina un file qui o clicca per selezionare</div>
        <div class="upload-hint">PDF &middot; TXT &middot; DOCX &middot; XLSX &middot; Max 20 MB</div>
    </div>

    {{-- Stato di indicizzazione (nascosto per impostazione predefinita) --}}
    <div id="indexing-steps" class="bg-card border border-faint rounded-3 p-3" style="display:none;">
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
    <div id="doc-list-section" style="display:none;">
        <div class="section-label-row">
            <span class="section-label">Documenti caricati</span>
            <span class="doc-count-badge" id="doc-count-badge">0</span>
        </div>
        <div id="doc-list"></div>
    </div>

    {{-- Come funziona --}}
    <div class="bg-card border border-faint rounded-3 p-3">
        <div class="d-flex align-items-center gap-2 fw-bold text-white fs-6 mb-2">
            <i class="fa-solid fa-wand-magic-sparkles text-purple"></i> Come funziona?
        </div>

        <div class="d-flex align-items-start gap-2 mb-2">
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

    {{-- Ricomincia (nascosto per impostazione predefinita) --}}
    <button id="btn-ricomincia" style="display:none;" onclick="ricomincia()">
        <i class="fa-solid fa-rotate-left fa-xs"></i> Ricomincia
    </button>

</aside>
