<div id="chat-ui" class="card fixed-bottom m-3" style="width:350px;display:none;right:0;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong><?php echo e(__('messages.chat')); ?></strong>
        <button id="chat-close" class="btn btn-sm btn-secondary"><?php echo e(__('messages.close')); ?></button>
    </div>
    <div class="card-body" style="height:300px;overflow:auto;" id="chat-messages">
        <div class="text-muted">No conversation selected.</div>
    </div>
    <div class="card-footer">
        <div class="input-group">
            <button class="btn btn-outline-secondary" type="button" id="chat-attach-btn">
                <i class="bi bi-paperclip"></i>
            </button>
            <input type="file" id="chat-file-input" style="display: none;">
            <input id="chat-input" class="form-control" placeholder="<?php echo e(__('messages.type_message')); ?>">
            <button id="chat-send" class="btn btn-primary"><?php echo e(__('messages.send')); ?></button>
        </div>
        <div id="chat-file-preview" class="small text-muted mt-1" style="display:none;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatToggle = document.getElementById('chat-toggle');
        const chatUi = document.getElementById('chat-ui');
        const chatClose = document.getElementById('chat-close');
        const chatSend = document.getElementById('chat-send');
        const chatInput = document.getElementById('chat-input');
        const chatAttachBtn = document.getElementById('chat-attach-btn');
        const chatFileInput = document.getElementById('chat-file-input');
        const chatFilePreview = document.getElementById('chat-file-preview');

        let currentWithUser = null;
        let selectedFile = null;

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
                appendMessage(m);
            });
            box.scrollTop = box.scrollHeight;
            // Remove unread badge from conversation list (if present)
            try {
                const convSelector = document.querySelector(
                    `.list-group-item[onclick*="openChatWith(${withId})"]`);
                if (convSelector) {
                    const badge = convSelector.querySelector('.badge');
                    if (badge) badge.remove();
                }
            } catch (err) {
                // ignore DOM errors
            }
        }

        function appendMessage(m) {
            const box = document.getElementById('chat-messages');
            const div = document.createElement('div');
            const isMe = m.sender_id === (window.LAWLITE_USER_ID || 0);
            div.className = 'mb-2 d-flex ' + (isMe ? 'justify-content-end' : 'justify-content-start');

            let contentHtml = '';
            if (m.content) {
                contentHtml += `<div>${m.content}</div>`;
            }

            if (m.attachment_path) {
                const url = `/storage/${m.attachment_path}`;
                if (m.attachment_type === 'image') {
                    contentHtml +=
                        `<div class="mt-1"><a href="${url}" target="_blank"><img src="${url}" style="max-width: 150px; max-height: 150px; border-radius: 4px;"></a></div>`;
                } else {
                    contentHtml +=
                        `<div class="mt-1"><a href="${url}" target="_blank" class="text-decoration-none"><i class="bi bi-file-earmark"></i> Attachment</a></div>`;
                }
            }

            div.innerHTML = `
                <div class="p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'}" style="max-width:70%;">
                    ${contentHtml}
                </div>
            `;
            box.appendChild(div);
        }

        if (chatToggle) chatToggle.addEventListener('click', () => {
            chatUi.style.display = (chatUi.style.display === 'none') ? 'block' : 'none';
        });
        if (chatClose) chatClose.addEventListener('click', () => chatUi.style.display = 'none');

        // File attachment handling
        if (chatAttachBtn) {
            chatAttachBtn.addEventListener('click', () => chatFileInput.click());
        }

        if (chatFileInput) {
            chatFileInput.addEventListener('change', () => {
                if (chatFileInput.files.length > 0) {
                    selectedFile = chatFileInput.files[0];
                    chatFilePreview.style.display = 'block';
                    chatFilePreview.textContent = `Selected: ${selectedFile.name}`;
                } else {
                    selectedFile = null;
                    chatFilePreview.style.display = 'none';
                }
            });
        }

        chatSend?.addEventListener('click', async () => {
            if (!currentWithUser) {
                alert('Select a conversation first');
                return;
            }
            const content = chatInput.value.trim();

            if (!content && !selectedFile) return;

            const formData = new FormData();
            formData.append('receiver_id', currentWithUser);
            if (content) formData.append('content', content);
            if (selectedFile) formData.append('attachment', selectedFile);

            const res = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf()
                },
                body: formData
            });

            if (res.ok) {
                chatInput.value = '';
                selectedFile = null;
                chatFileInput.value = '';
                chatFilePreview.style.display = 'none';
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
                        // The event might not have the full structure we need if we just use e.message
                        // But let's assume e contains the message fields
                        appendMessage(e);
                        const box = document.getElementById('chat-messages');
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