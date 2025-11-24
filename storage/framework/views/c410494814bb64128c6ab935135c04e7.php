

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="height: calc(100vh - 60px);">
        <div class="row h-100 g-0 rounded-3 shadow-sm overflow-hidden border bg-white">
            <!-- Sidebar: Conversation List -->
            <div class="col-md-4 col-lg-3 border-end d-flex flex-column h-100 bg-light">
                <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i
                            class="bi bi-chat-dots-fill me-2"></i><?php echo e(__('messages.messages')); ?></h5>
                    <?php
                        $totalUnread = $conversations->sum('unread_count');
                    ?>
                    <span id="total-unread-badge" class="badge bg-danger rounded-pill <?php echo e($totalUnread > 0 ? '' : 'd-none'); ?>">
                        <?php echo e($totalUnread); ?>

                    </span>
                </div> <!-- Search (Optional) -->
                <div class="p-2 bg-light">
                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo e(__('messages.search')); ?>..."
                        id="conversation-search">
                </div>

                <div class="list-group list-group-flush overflow-auto flex-grow-1" id="conversation-list">
                    <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $partner = $conv['partner'];
                            $lastMsg = $conv['latest_message'];
                            $unread = $conv['unread_count'];
                        ?>
                        <a href="#" class="list-group-item list-group-item-action border-0 py-3 conversation-item"
                            data-user-id="<?php echo e($partner->id); ?>"
                            onclick="event.preventDefault(); openChatWith(<?php echo e($partner->id); ?>, '<?php echo e(addslashes($partner->name)); ?>')">
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($partner->name)); ?>&background=random"
                                        class="rounded-circle" width="45" height="45" alt="<?php echo e($partner->name); ?>">
                                    <?php if($unread > 0): ?>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                            <?php echo e($unread); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="ms-3 flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="mb-0 text-truncate text-dark fw-semibold"><?php echo e($partner->name); ?></h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <?php echo e($lastMsg ? $lastMsg->created_at->shortAbsoluteDiffForHumans() : ''); ?>

                                        </small>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate small">
                                        <?php if($lastMsg && $lastMsg->sender_id == auth()->id()): ?>
                                            <span class="text-primary">You:</span>
                                        <?php endif; ?>
                                        <?php echo e($lastMsg ? $lastMsg->content : __('messages.no_messages')); ?>

                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center p-4 text-muted">
                            <i class="bi bi-chat-square text-secondary display-6"></i>
                            <p class="mt-2 small"><?php echo e(__('messages.no_conversations')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="col-md-8 col-lg-9 d-flex flex-column h-100 bg-white position-relative">
                <!-- Empty State -->
                <div id="chat-empty-state"
                    class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                    <div class="bg-light rounded-circle p-4 mb-3">
                        <i class="bi bi-chat-text display-4 text-primary opacity-50"></i>
                    </div>
                    <h4><?php echo e(__('messages.welcome_chat')); ?></h4>
                    <p><?php echo e(__('messages.select_conversation')); ?></p>
                </div>

                <!-- Chat Interface (Hidden by default) -->
                <div id="chat-interface" class="d-none flex-column h-100">
                    <!-- Header -->
                    <div class="p-3 border-bottom bg-white d-flex align-items-center shadow-sm z-1">
                        <button class="btn btn-link d-md-none me-2 text-dark" onclick="toggleSidebar()">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <img id="chat-header-avatar" src="" class="rounded-circle me-3" width="40"
                            height="40">
                        <div>
                            <h6 class="mb-0 fw-bold" id="chat-header-name">User Name</h6>
                            <small class="text-success d-flex align-items-center">
                                <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Online
                            </small>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-telephone"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-camera-video"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle"><i
                                    class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="chat-messages" class="flex-grow-1 p-4 overflow-auto bg-light" style="scroll-behavior: smooth;">
                        <!-- Messages will be injected here -->
                    </div>

                    <!-- Input Area -->
                    <div class="p-3 bg-white border-top">
                        <div class="input-group bg-light rounded-pill border p-1">
                            <button class="btn btn-link text-muted rounded-circle"><i
                                    class="bi bi-emoji-smile"></i></button>
                            <button class="btn btn-link text-muted rounded-circle"><i class="bi bi-paperclip"></i></button>
                            <input type="text" id="chat-input" class="form-control border-0 bg-transparent shadow-none"
                                placeholder="<?php echo e(__('messages.type_message')); ?>...">
                            <button id="chat-send" class="btn btn-primary rounded-circle ms-2"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        .conversation-item:hover,
        .conversation-item.active {
            background-color: #f0f2f5;
        }

        .conversation-item.active {
            border-left: 4px solid #0d6efd !important;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .message-sent {
            background-color: #0084ff;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-received {
            background-color: #e4e6eb;
            color: #050505;
            border-bottom-left-radius: 4px;
        }

        .message-time {
            font-size: 0.7rem;
            margin-top: 4px;
            opacity: 0.7;
        }
    </style>

    <script>
        let currentWithUser = null;
        const userId = <?php echo e(auth()->id()); ?>;

        function csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function toggleSidebar() {
            // Logic for mobile to toggle sidebar visibility
            // For now, simple implementation or leave for future refinement
        }

        async function openChatWith(partnerId, partnerName) {
            currentWithUser = partnerId;

            // Update UI State
            document.getElementById('chat-empty-state').classList.add('d-none');
            document.getElementById('chat-interface').classList.remove('d-none');
            document.getElementById('chat-interface').classList.add('d-flex');

            // Update Header
            document.getElementById('chat-header-name').textContent = partnerName;
            document.getElementById('chat-header-avatar').src =
                `https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=random`;

            // Highlight active conversation
            document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active', 'bg-light'));
            const activeItem = document.querySelector(`.conversation-item[data-user-id="${partnerId}"]`);
            if (activeItem) activeItem.classList.add('active');

            // Load Messages
            await loadHistory(partnerId);
        }

        async function loadHistory(withId) {
            const box = document.getElementById('chat-messages');
            box.innerHTML =
                '<div class="d-flex justify-content-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>';

            try {
                const res = await fetch(`/chat/history/${withId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrf()
                    }
                });

                if (!res.ok) throw new Error('Failed to load');

                const json = await res.json();
                box.innerHTML = '';

                // Group messages by date could be a nice enhancement here

                json.messages.forEach(m => appendMessage(m));
                scrollToBottom();

                // Remove unread badge
                const activeItem = document.querySelector(`.conversation-item[data-user-id="${withId}"]`);
                if (activeItem) {
                    const badge = activeItem.querySelector('.badge');
                    if (badge) {
                        const count = parseInt(badge.innerText);
                        badge.remove();

                        // Update global unread count
                        const globalBadge = document.getElementById('total-unread-badge');
                        if (globalBadge) {
                            let currentTotal = parseInt(globalBadge.innerText);
                            let newTotal = Math.max(0, currentTotal - count);
                            globalBadge.innerText = newTotal;
                            if (newTotal === 0) {
                                globalBadge.classList.add('d-none');
                            }
                        }
                    }
                }

            } catch (err) {
                box.innerHTML = '<div class="text-center text-danger mt-5">Failed to load messages.</div>';
            }
        }

        function appendMessage(m) {
            const box = document.getElementById('chat-messages');
            const isMe = m.sender_id === userId;

            const div = document.createElement('div');
            div.className = `d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}`;

            const time = new Date(m.created_at).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            div.innerHTML = `
            <div class="message-bubble ${isMe ? 'message-sent' : 'message-received'} shadow-sm">
                ${m.content}
                <div class="message-time text-end">${time}</div>
            </div>
        `;
            box.appendChild(div);
        }

        function scrollToBottom() {
            const box = document.getElementById('chat-messages');
            box.scrollTop = box.scrollHeight;
        }

        // Send Message Logic
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');

        async function sendMessage() {
            if (!currentWithUser) return;
            const content = chatInput.value.trim();
            if (!content) return;

            // Optimistic UI update
            const tempMsg = {
                sender_id: userId,
                content: content,
                created_at: new Date().toISOString()
            };
            appendMessage(tempMsg);
            scrollToBottom();
            chatInput.value = '';

            try {
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

                if (!res.ok) throw new Error('Failed to send');
                // Ideally replace temp message with real one or handle ID
            } catch (err) {
                alert('Failed to send message');
            }
        }

        chatSend.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        // Real-time updates (Echo)
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                window.Echo.private('user.' + userId).listen('MessageSent', function(e) {
                    if (currentWithUser && e.sender_id === currentWithUser) {
                        appendMessage(e);
                        scrollToBottom();
                    } else {
                        // Update sidebar preview and unread count
                        // This would require more complex DOM manipulation or reloading the list
                        // For now, we can just play a sound or show a toast
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/chat/inbox.blade.php ENDPATH**/ ?>