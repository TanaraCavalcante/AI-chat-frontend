<x-master title="Tanas'AI">

    {{-- LAYOUT PRINCIPAL --}}
    <div class="chat-layout">

        {{-- SIDEBAR --}}
        @include('components.sidebar')

        {{-- CHAT AREA --}}
        <div class="chat-area">

            {{-- Mensagens --}}
            <div id="chat-messages" class="flex-fill overflow-y-auto d-flex flex-column gap-3 p-3">
                <div id="chat-empty" class="m-auto text-center text-muted fs-7">
                    <i class="fa-regular fa-file-lines d-block mb-2 empty-icon"></i>
                    <div class="fw-semibold mb-1 text-secondary">Nessun documento caricato</div>
                    Carica un documento nella barra laterale<br>per iniziare a fare domande.
                </div>
            </div>

            {{-- Input bar --}}
            <div id="input-bar">
                <div class="input-pill">
                    <input type="text" id="chat-input"
                           placeholder="Carica un documento per iniziare…"
                           disabled
                           onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMessage();}">
                    <span id="fonti-counter">0 fonti</span>
                    <button id="btn-send" class="btn-send" onclick="sendMessage()" disabled>
                        <i class="fa-solid fa-paper-plane fa-sm"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Toast container --}}
    <div id="toast-container"></div>

    @push('scripts')
        <script src="{{ asset('js/chat.js') }}?v={{ filemtime(public_path('js/chat.js')) }}"></script>
    @endpush

</x-master>
