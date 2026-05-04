// ── Estado ────────────────────────────────────────────────────────────────────
let sessionId = null;
let docs = []; // [{name: string, chunks: number}]

// ── Init ──────────────────────────────────────────────────────────────────────
document.getElementById('file-input').addEventListener('change', function () {
    if (this.files[0]) handleFileUpload(this.files[0]);
});

// ── Atualiza a UI com base no estado atual ────────────────────────────────────
function updateUI() {
    const hasDocs = docs.length > 0;

    // Badge de estado
    const badge = document.getElementById('status-badge');
    if (hasDocs) {
        badge.className = 'badge-active px-3 py-1 rounded-pill fw-semibold';
        badge.textContent = `● ${docs.length} ${docs.length === 1 ? 'fonte attiva' : 'fonti attive'}`;
    } else {
        badge.className = 'badge-no-doc px-3 py-1 rounded-pill fw-semibold';
        badge.textContent = '● Nessun documento';
    }

    // Lista de documentos
    const listSection = document.getElementById('doc-list-section');
    const listEl = document.getElementById('doc-list');
    if (hasDocs) {
        listSection.style.display = '';
        listEl.innerHTML = docs.map(d => `
            <div class="doc-item">
                <div class="fw-semibold text-truncate doc-item-name">
                    <i class="fa-regular fa-file fa-xs me-1"></i>${escapeHtml(d.name)}
                </div>
                <div class="doc-item-chunks">${d.chunks} chunk</div>
            </div>
        `).join('');
    } else {
        listSection.style.display = 'none';
    }

    // Label e estado da zona de upload
    document.getElementById('upload-label').textContent = hasDocs ? 'Aggiungi fonte' : 'Carica documento';
    const zone = document.getElementById('upload-zone');
    if (docs.length >= 5) {
        zone.style.opacity = '0.4';
        zone.style.pointerEvents = 'none';
    } else {
        zone.style.opacity = '1';
        zone.style.pointerEvents = '';
    }

    // Botão Ricomincia
    document.getElementById('btn-ricomincia').style.display = hasDocs ? '' : 'none';

    // Input bar
    const input = document.getElementById('chat-input');
    const btnSend = document.getElementById('btn-send');
    input.disabled = !hasDocs;
    btnSend.disabled = !hasDocs;
    input.placeholder = hasDocs ? 'Inizia a digitare…' : 'Carica un documento per iniziare…';

    // Contador de fontes
    document.getElementById('fonti-counter').textContent = `${docs.length} fonti`;

    // Empty state do chat
    const emptyEl = document.getElementById('chat-empty');
    if (emptyEl) emptyEl.style.display = hasDocs ? 'none' : '';
}

// ── Upload de documento ───────────────────────────────────────────────────────
function handleFileUpload(file) {
    if (docs.length >= 5) {
        showToast('Limite di 5 documenti per sessione raggiunto');
        document.getElementById('file-input').value = '';
        return;
    }

    // Mostrar estado de indexação
    document.getElementById('status-badge').className = 'badge-indexing px-3 py-1 rounded-pill fw-semibold';
    document.getElementById('status-badge').textContent = '⏳ Indicizzazione…';
    document.getElementById('indexing-steps').style.display = '';
    document.getElementById('upload-zone').style.display = 'none';
    document.getElementById('filename-progress').textContent = file.name;

    // Reset visual dos steps
    ['step-read', 'step-chunk', 'step-embed', 'step-faiss'].forEach(id => {
        const el = document.getElementById(id);
        el.className = 'step-item';
        el.querySelector('i').className = 'fa-solid fa-circle-dot fa-xs';
    });

    // Animação client-side dos steps (simulada com timers)
    setTimeout(() => markStepDone('step-read'), 300);
    setTimeout(() => markStepDone('step-chunk'), 900);
    setTimeout(() => markStepDone('step-embed'), 1800);
    // step-faiss é marcado quando a resposta HTTP chegar

    // Enviar ficheiro ao Laravel
    const formData = new FormData();
    formData.append('file', file);
    if (sessionId) formData.append('session_id', sessionId);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    fetch('/upload', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            if (data.error || data.errors || !data.session_id) {
                const msg = data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Servizio non disponibile. Avvia api.py.');
                showToast(msg);
                resetAfterError();
                return;
            }
            markStepDone('step-faiss');
            setTimeout(() => {
                sessionId = data.session_id;
                docs.push({ name: data.filename, chunks: data.chunks });
                document.getElementById('indexing-steps').style.display = 'none';
                document.getElementById('upload-zone').style.display = '';
                document.getElementById('file-input').value = '';
                updateUI();
            }, 500);
        })
        .catch(() => {
            showToast('Servizio non disponibile. Avvia api.py.');
            resetAfterError();
        });
}

function markStepDone(id) {
    const el = document.getElementById(id);
    el.className = 'step-item done';
    el.querySelector('i').className = 'fa-solid fa-check fa-xs';
}

function resetAfterError() {
    document.getElementById('indexing-steps').style.display = 'none';
    document.getElementById('upload-zone').style.display = '';
    document.getElementById('file-input').value = '';
    updateUI();
}

// ── Enviar mensagem ───────────────────────────────────────────────────────────
function sendMessage() {
    const input = document.getElementById('chat-input');
    const pergunta = input.value.trim();
    if (!pergunta || !sessionId) return;

    input.value = '';

    const emptyEl = document.getElementById('chat-empty');
    if (emptyEl) emptyEl.remove();

    appendUserBubble(pergunta);
    const spinnerId = appendSpinnerBubble();
    scrollToBottom();

    fetch('/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ pergunta }),
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById(spinnerId)?.remove();
        if (data.error) {
            if (data.error.includes('Sessione non trovata')) {
                showToast('Sessione scaduta. Ricarica un documento.', 'warning');
                sessionId = null;
                docs = [];
                updateUI();
            } else {
                appendBotBubble(`<em style="color:#ef4444;">${escapeHtml(data.error)}</em>`);
            }
        } else {
            appendBotBubble(escapeHtml(data.resposta).replace(/\n/g, '<br>'));
        }
        scrollToBottom();
    })
    .catch(() => {
        document.getElementById(spinnerId)?.remove();
        appendBotBubble('<em style="color:#ef4444;">Servizio non disponibile.</em>');
        scrollToBottom();
    });
}

function avatarHtml() {
    return `<div class="bot-avatar">
        <img src="/images/atomic.png" alt="Chat-bot avatar"
             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span class="fallback">WT</span>
    </div>`;
}

function appendUserBubble(text) {
    document.getElementById('chat-messages').insertAdjacentHTML('beforeend', `
        <div class="bubble-user-wrapper">
            <div class="bubble-user">${escapeHtml(text)}</div>
        </div>
    `);
}

function appendBotBubble(html) {
    document.getElementById('chat-messages').insertAdjacentHTML('beforeend', `
        <div class="bubble-bot-wrapper">
            ${avatarHtml()}
            <div class="bubble-bot">${html}</div>
        </div>
    `);
}

function appendSpinnerBubble() {
    const id = 'spinner-' + Date.now();
    document.getElementById('chat-messages').insertAdjacentHTML('beforeend', `
        <div id="${id}" class="bubble-bot-wrapper">
            ${avatarHtml()}
            <div class="bubble-bot bubble-spinner">
                <span class="me-1">● ●</span> elaborazione in corso…
            </div>
        </div>
    `);
    return id;
}

function scrollToBottom() {
    const el = document.getElementById('chat-messages');
    el.scrollTop = el.scrollHeight;
}

// ── Ricomincia ────────────────────────────────────────────────────────────────
function ricomincia() {
    Swal.fire({
        title: 'Ricominciare?',
        text: 'La sessione e la cronologia verranno eliminate.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sì, ricomincia',
        cancelButtonText: 'Annulla',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        reverseButtons: true,
    }).then(result => {
        if (!result.isConfirmed) return;
        _doRicomincia();
    });
}

function _doRicomincia() {
    fetch('/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ session_id: sessionId }),
    }).finally(() => {
        sessionId = null;
        docs = [];
        document.getElementById('chat-messages').innerHTML = `
            <div id="chat-empty">
                <i class="fa-regular fa-file-lines d-block mb-2 empty-icon"></i>
                <div class="fw-semibold mb-1 empty-title">Nessun documento caricato</div>
                Carica un documento nella barra laterale<br>per iniziare a fare domande.
            </div>
        `;
        updateUI();
    });
}

// ── Toasts ────────────────────────────────────────────────────────────────────
function showToast(message, type = 'danger') {
    const id = 'toast-' + Date.now();
    document.getElementById('toast-container').insertAdjacentHTML('beforeend', `
        <div id="${id}" style="background:${type==='danger'?'#ef4444':'#f59e0b'}; color:#fff; padding:10px 14px; border-radius:8px; font-size:13px; display:flex; gap:8px; align-items:center; box-shadow:0 2px 8px rgba(0,0,0,.15);">
            <span style="flex:1;">${escapeHtml(message)}</span>
            <button onclick="document.getElementById('${id}').remove()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:16px;">×</button>
        </div>
    `);
    setTimeout(() => document.getElementById(id)?.remove(), 5000);
}

// ── Utils ─────────────────────────────────────────────────────────────────────
function escapeHtml(text) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(text));
    return d.innerHTML;
}

// ── Boot ──────────────────────────────────────────────────────────────────────
updateUI();
