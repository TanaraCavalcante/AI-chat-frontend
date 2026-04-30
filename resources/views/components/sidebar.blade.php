<div id="sidebar">

    {{-- Badge stato --}}
    <div class="mb-3">
        <div class="text-uppercase fw-semibold mb-3 section-label">Stato</div>
        <span id="status-badge" class="badge-no-doc px-3 py-1 rounded-pill fw-semibold">● Nessun documento</span>
    </div>

    {{-- Steps di indicizzazione (nascosto per impostazione predefinita) --}}
    <div id="indexing-steps" style="display:none;">
        <div class="text-uppercase fw-semibold mb-1 section-label">Indicizzazione</div>
        <div id="filename-progress" class="fw-semibold text-primary mb-2"></div>
        <div class="progress mb-2 progress-tiny">
            <div class="progress-bar progress-bar-striped progress-bar-animated progress-indexing"></div>
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
        <div class="text-uppercase fw-semibold mb-1 section-label">Documenti</div>
        <div id="doc-list"></div>
    </div>

    {{-- Zona upload --}}
    <div id="upload-zone" class="upload-zone" onclick="document.getElementById('file-input').click()">
        <input type="file" id="file-input" style="display:none;" accept=".pdf,.txt,.docx,.xlsx">
        <i class="fa-solid fa-paperclip mb-1 d-block upload-icon"></i>
        <div class="fw-semibold mb-2" id="upload-label">Carica documento</div>
        <div class="upload-hint">PDF · TXT · DOCX · XLSX · max 20 MB</div>
    </div>

    {{-- Ricomincia (nascosto per impostazione predefinita) --}}
    <button id="btn-ricomincia" style="display:none;" onclick="ricomincia()">
        <i class="fa-solid fa-rotate-left fa-xs"></i> Ricomincia
    </button>

</div>
