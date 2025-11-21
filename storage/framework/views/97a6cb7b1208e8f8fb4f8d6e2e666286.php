<div id="chat-ui" class="card fixed-bottom m-3" style="width:350px;display:none;right:0;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Chat</strong>
        <button id="chat-close" class="btn btn-sm btn-secondary">X</button>
    </div>
    <div class="card-body" style="height:300px;overflow:auto;" id="chat-messages">
        <div class="text-muted">No conversation selected.</div>
    </div>
    <div class="card-footer">
        <div class="input-group">
            <input id="chat-input" class="form-control" placeholder="Type a message...">
            <button id="chat-send" class="btn btn-primary">Send</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatToggle = document.getElementById('chat-toggle');
        const chatUi = document.getElementById('chat-ui');
        const chatClose = document.getElementById('chat-close');
        const chatSend = document.getElementById('chat-send');
        const chatInput = document.getElementById('chat-input');

        let currentWithUser = null;

        function csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        async function loadHistory(withId) {
            const res = await fetch(`/chat/history/${withId}`, {
                headers: {
                    'X-CSRF-TOKEN': csrf()
                }
            });
            if (!res.ok) return;
            const json = await res.json();
            const box = document.getElementById('chat-messages');
            box.innerHTML = '';
            json.messages.forEach(m => {
                const div = document.createElement('div');
                const isMe = m.sender_id === (window.LAWLITE_USER_ID || 0);
                div.className = 'mb-2 d-flex ' + (isMe ? 'justify-content-end' :
                    'justify-content-start');
                div.innerHTML = `
                    <div class="p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'}" style="max-width:70%;">
                        ${m.content}
                    </div>
                `;
                box.appendChild(div);
            });
            box.scrollTop = box.scrollHeight;
        }

        if (chatToggle) chatToggle.addEventListener('click', () => {
            chatUi.style.display = (chatUi.style.display === 'none') ? 'block' : 'none';
        });
        if (chatClose) chatClose.addEventListener('click', () => chatUi.style.display = 'none');

        chatSend?.addEventListener('click', async () => {
            if (!currentWithUser) {
                alert('Select a conversation first (placeholder)');
                return;
            }
            const content = chatInput.value.trim();
            if (!content) return;
            const res = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf()
                },
                body: JSON.stringify({
                    receiver_id: currentWithUser,
                    content
                })
            });
            if (res.ok) {
                chatInput.value = '';
                await loadHistory(currentWithUser);
            }
        });

        // Expose helper to open chat with a user id
        window.openChatWith = function(userId) {
            currentWithUser = userId;
            chatUi.style.display = 'block';
            loadHistory(userId);
        }

        // Listen for incoming broadcast messages via Echo
        try {
            if (window.Echo && window.LAWLITE_USER_ID) {
                window.Echo.private('user.' + window.LAWLITE_USER_ID).listen('MessageSent', function(e) {
                    // if chat open with sender, append
                    if (currentWithUser && e.sender_id === currentWithUser) {
                        const box = document.getElementById('chat-messages');
                        const div = document.createElement('div');
                        div.className = 'mb-2 d-flex justify-content-start';
                        div.innerHTML = `
                            <div class="p-2 rounded bg-light" style="max-width:70%;">
                                ${e.content || ''}
                            </div>
                        `;
                        box.appendChild(div);
                        box.scrollTop = box.scrollHeight;
                    }
                });
            }
        } catch (err) {
            // ignore
        }
    });
</script>
<?php /**PATH F:\Defence\LawLite\resources\views/components/chat_ui.blade.php ENDPATH**/ ?>