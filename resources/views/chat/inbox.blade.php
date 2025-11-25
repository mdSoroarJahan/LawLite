@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4" style="height: calc(100vh - 60px);">
        <div class="row h-100 g-0 rounded-3 shadow-sm overflow-hidden border bg-white">
            <!-- Sidebar: Conversation List -->
            <div class="col-md-4 col-lg-3 border-end d-flex flex-column h-100 bg-light">
                <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i
                            class="bi bi-chat-dots-fill me-2"></i>{{ __('messages.messages') }}</h5>
                    @php
                        $totalUnread = $conversations->sum('unread_count');
                    @endphp
                    <span id="total-unread-badge" class="badge bg-danger rounded-pill {{ $totalUnread > 0 ? '' : 'd-none' }}">
                        {{ $totalUnread }}
                    </span>
                </div> <!-- Search (Optional) -->
                <div class="p-2 bg-light">
                    <input type="text" class="form-control form-control-sm" placeholder="{{ __('messages.search') }}..."
                        id="conversation-search">
                </div>

                <div class="list-group list-group-flush overflow-auto flex-grow-1" id="conversation-list">
                    @forelse($conversations as $conv)
                        @php
                            $partner = $conv['partner'];
                            $lastMsg = $conv['latest_message'];
                            $unread = $conv['unread_count'];
                        @endphp
                        <a href="#" class="list-group-item list-group-item-action border-0 py-3 conversation-item"
                            data-user-id="{{ $partner->id }}"
                            onclick="event.preventDefault(); openChatWith({{ $partner->id }}, '{{ addslashes($partner->name) }}')">
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=random"
                                        class="rounded-circle" width="45" height="45" alt="{{ $partner->name }}">
                                    @if ($unread > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                            {{ $unread }}
                                        </span>
                                    @endif
                                </div>
                                <div class="ms-3 flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="mb-0 text-truncate text-dark fw-semibold">{{ $partner->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            {{ $lastMsg ? $lastMsg->created_at->shortAbsoluteDiffForHumans() : '' }}
                                        </small>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate small">
                                        @if ($lastMsg && $lastMsg->sender_id == auth()->id())
                                            <span class="text-primary">You:</span>
                                        @endif
                                        {{ $lastMsg ? $lastMsg->content : __('messages.no_messages') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center p-4 text-muted">
                            <i class="bi bi-chat-square text-secondary display-6"></i>
                            <p class="mt-2 small">{{ __('messages.no_conversations') }}</p>
                        </div>
                    @endforelse
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
                    <h4>{{ __('messages.welcome_chat') }}</h4>
                    <p>{{ __('messages.select_conversation') }}</p>
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
                            <small id="chat-header-status" class="text-muted d-flex align-items-center">
                                <!-- Status will be injected here -->
                            </small>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-light btn-sm rounded-circle" title="{{ __('messages.audio_call') }}"
                                onclick="startCall()">
                                <i class="bi bi-telephone"></i>
                            </button>
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
                            <button class="btn btn-link text-muted rounded-circle"
                                onclick="document.getElementById('file-input').click()">
                                <i class="bi bi-paperclip"></i>
                            </button>
                            <input type="file" id="file-input" class="d-none" onchange="handleFileSelect(this)">
                            <input type="text" id="chat-input" class="form-control border-0 bg-transparent shadow-none"
                                placeholder="{{ __('messages.type_message') }}...">
                            <button id="chat-send" class="btn btn-primary rounded-circle ms-2"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                        <div id="file-preview" class="mt-2 d-none">
                            <div class="d-inline-block position-relative border rounded p-2">
                                <span id="file-name" class="small text-muted"></span>
                                <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle"
                                    aria-label="Close" onclick="clearFile()"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incoming Call Modal -->
    <div class="modal fade" id="incoming-call-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4">
                <div class="mb-3">
                    <div class="avatar-pulse d-inline-block">
                        <img id="incoming-call-avatar" src="" class="rounded-circle" width="80"
                            height="80">
                    </div>
                </div>
                <h5 class="mb-1" id="incoming-call-name">User</h5>
                <p class="text-muted small">Incoming Audio Call...</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn btn-danger rounded-circle p-3" onclick="rejectCall()">
                        <i class="bi bi-telephone-x-fill h4 mb-0"></i>
                    </button>
                    <button class="btn btn-success rounded-circle p-3" onclick="acceptCall()">
                        <i class="bi bi-telephone-fill h4 mb-0"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Call Modal -->
    <div class="modal fade" id="active-call-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4">
                <div class="mb-3">
                    <img id="active-call-avatar" src="" class="rounded-circle" width="80" height="80">
                </div>
                <h5 class="mb-1" id="active-call-name">User</h5>
                <p class="text-success small" id="call-status">Connected</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn btn-secondary rounded-circle p-3" onclick="toggleMute()" id="mute-btn">
                        <i class="bi bi-mic-fill h4 mb-0"></i>
                    </button>
                    <button class="btn btn-danger rounded-circle p-3" onclick="endCall()">
                        <i class="bi bi-telephone-x-fill h4 mb-0"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <audio id="remote-audio" autoplay></audio>

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

        .avatar-pulse {
            position: relative;
        }

        .avatar-pulse::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            border: 2px solid #0d6efd;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
    </style>

    <script>
        let currentWithUser = null;
        const userId = {{ auth()->id() }};

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
            document.getElementById('chat-header-status').innerHTML =
                '<span class="text-muted">Checking status...</span>';

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

                // Update Online Status
                const statusEl = document.getElementById('chat-header-status');
                if (json.partner_status && json.partner_status.is_online) {
                    statusEl.innerHTML =
                        '<span class="text-success"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Online</span>';
                } else {
                    let lastSeenText = 'Offline';
                    if (json.partner_status && json.partner_status.last_seen) {
                        const date = new Date(json.partner_status.last_seen);
                        // Simple formatting, can be improved with a library like moment.js or date-fns
                        const now = new Date();
                        const diff = Math.floor((now - date) / 1000); // seconds

                        if (diff < 60) lastSeenText = 'Last seen just now';
                        else if (diff < 3600) lastSeenText = `Last seen ${Math.floor(diff / 60)}m ago`;
                        else if (diff < 86400) lastSeenText = `Last seen ${Math.floor(diff / 3600)}h ago`;
                        else lastSeenText = `Last seen ${date.toLocaleDateString()}`;
                    }
                    statusEl.innerHTML = `<span class="text-muted">${lastSeenText}</span>`;
                }

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

            const time = new Date(m.created_at).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            // Handle Call Logs
            if (m.attachment_type === 'call_log') {
                div.className = 'd-flex justify-content-center mb-3';
                div.innerHTML = `
                    <div class="badge bg-light text-dark border p-2 rounded-pill shadow-sm d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i> 
                        <span>${m.content}</span>
                        <span class="text-muted ms-2 small" style="font-size: 0.75em;">${time}</span>
                    </div>
                `;
                box.appendChild(div);
                return;
            }

            div.className = `d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}`;

            let attachmentHtml = '';
            if (m.attachment_path) {
                const url = `/storage/${m.attachment_path}`;
                if (m.attachment_type === 'image') {
                    attachmentHtml =
                        `<div class="mb-2"><a href="${url}" target="_blank"><img src="${url}" class="img-fluid rounded" style="max-width: 200px; max-height: 200px;"></a></div>`;
                } else {
                    attachmentHtml =
                        `<div class="mb-2"><a href="${url}" target="_blank" class="btn btn-sm btn-light border"><i class="bi bi-file-earmark me-1"></i> Download File</a></div>`;
                }
            }

            div.innerHTML = `
            <div class="message-bubble ${isMe ? 'message-sent' : 'message-received'} shadow-sm">
                ${attachmentHtml}
                ${m.content || ''}
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
        const fileInput = document.getElementById('file-input');

        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                document.getElementById('file-preview').classList.remove('d-none');
                document.getElementById('file-name').textContent = input.files[0].name;
            }
        }

        function clearFile() {
            fileInput.value = '';
            document.getElementById('file-preview').classList.add('d-none');
        }

        async function sendMessage() {
            if (!currentWithUser) return;
            const content = chatInput.value.trim();
            const file = fileInput.files[0];

            if (!content && !file) return;

            // Optimistic UI update (text only for now, file needs upload)
            if (content && !file) {
                const tempMsg = {
                    sender_id: userId,
                    content: content,
                    created_at: new Date().toISOString()
                };
                appendMessage(tempMsg);
                scrollToBottom();
                chatInput.value = '';
            }

            const formData = new FormData();
            formData.append('receiver_id', currentWithUser);
            if (content) formData.append('content', content);
            if (file) formData.append('attachment', file);

            // Clear inputs immediately
            chatInput.value = '';
            clearFile();

            try {
                const res = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf()
                    },
                    body: formData
                });

                if (!res.ok) throw new Error('Failed to send');

                const data = await res.json();
                if (data.ok && data.message) {
                    // If we sent a file, the optimistic update didn't happen, so append now
                    // Or if we sent text, we might want to replace the temp message (not implemented here)
                    // For simplicity, if there was a file, we append the returned message
                    if (file) {
                        appendMessage(data.message);
                        scrollToBottom();
                    }
                }
            } catch (err) {
                alert('Failed to send message');
            }
        }

        chatSend.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        // WebRTC & Calling Logic
        let peerConnection;
        let localStream;
        let incomingCallSignal = null;
        let incomingCallSender = null;
        let callStartTime = null;

        const rtcConfig = {
            iceServers: [{
                urls: 'stun:stun.l.google.com:19302'
            }]
        };

        async function startCall() {
            if (!currentWithUser) return;

            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                createPeerConnection();
                localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);

                sendSignal({
                    type: 'offer',
                    sdp: offer
                });

                // Show active call modal (calling state)
                document.getElementById('active-call-name').textContent = document.getElementById('chat-header-name')
                    .textContent;
                document.getElementById('active-call-avatar').src = document.getElementById('chat-header-avatar').src;
                document.getElementById('call-status').textContent = 'Calling...';
                document.getElementById('call-status').className = 'text-muted small';
                new bootstrap.Modal(document.getElementById('active-call-modal')).show();

            } catch (err) {
                console.error('Error starting call:', err);
                alert('Could not access microphone');
            }
        }

        function createPeerConnection() {
            peerConnection = new RTCPeerConnection(rtcConfig);

            peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    sendSignal({
                        type: 'candidate',
                        candidate: event.candidate
                    });
                }
            };

            peerConnection.ontrack = (event) => {
                const remoteAudio = document.getElementById('remote-audio');
                if (remoteAudio.srcObject !== event.streams[0]) {
                    remoteAudio.srcObject = event.streams[0];
                    document.getElementById('call-status').textContent = 'Connected';
                    document.getElementById('call-status').className = 'text-success small';
                    callStartTime = new Date();
                }
            };

            peerConnection.onconnectionstatechange = () => {
                if (peerConnection.connectionState === 'disconnected' || peerConnection.connectionState === 'failed') {
                    endCallUI();
                }
            };
        }

        async function sendSignal(signal) {
            const res = await fetch('/chat/signal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf()
                },
                body: JSON.stringify({
                    receiver_id: currentWithUser,
                    signal: signal
                })
            });

            if (res.ok) {
                const data = await res.json();
                if (data.message) {
                    appendMessage(data.message);
                    scrollToBottom();
                }
            }
        }

        async function handleSignal(data) {
            const signal = data.signal;
            const senderId = data.senderId;
            const senderName = data.senderName;

            if (signal.type === 'offer') {
                // Incoming call
                incomingCallSignal = signal;
                incomingCallSender = senderId;
                currentWithUser = senderId; // Switch context to caller (optional, or handle differently)

                document.getElementById('incoming-call-name').textContent = senderName;
                document.getElementById('incoming-call-avatar').src =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(senderName)}&background=random`;
                new bootstrap.Modal(document.getElementById('incoming-call-modal')).show();
            } else if (signal.type === 'answer') {
                if (peerConnection) {
                    await peerConnection.setRemoteDescription(new RTCSessionDescription(signal.sdp));
                }
            } else if (signal.type === 'candidate') {
                if (peerConnection) {
                    await peerConnection.addIceCandidate(new RTCIceCandidate(signal.candidate));
                }
            } else if (signal.type === 'reject' || signal.type === 'end') {
                endCallUI();
                bootstrap.Modal.getInstance(document.getElementById('incoming-call-modal'))?.hide();
            }
        }

        async function acceptCall() {
            bootstrap.Modal.getInstance(document.getElementById('incoming-call-modal')).hide();

            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                createPeerConnection();
                localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

                await peerConnection.setRemoteDescription(new RTCSessionDescription(incomingCallSignal.sdp));
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);

                sendSignal({
                    type: 'answer',
                    sdp: answer
                });

                // Show active call modal
                document.getElementById('active-call-name').textContent = document.getElementById('incoming-call-name')
                    .textContent;
                document.getElementById('active-call-avatar').src = document.getElementById('incoming-call-avatar').src;
                document.getElementById('call-status').textContent = 'Connected';
                document.getElementById('call-status').className = 'text-success small';
                new bootstrap.Modal(document.getElementById('active-call-modal')).show();

            } catch (err) {
                console.error('Error accepting call:', err);
            }
        }

        function rejectCall() {
            sendSignal({
                type: 'reject'
            });
            bootstrap.Modal.getInstance(document.getElementById('incoming-call-modal')).hide();
        }

        function endCall() {
            let duration = '';
            if (callStartTime) {
                const diff = Math.floor((new Date() - callStartTime) / 1000);
                const mins = Math.floor(diff / 60);
                const secs = diff % 60;
                duration = `${mins}:${secs.toString().padStart(2, '0')}`;
            }
            sendSignal({
                type: 'end',
                duration: duration
            });
            endCallUI();
        }

        function endCallUI() {
            if (peerConnection) {
                peerConnection.close();
                peerConnection = null;
            }
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localStream = null;
            }
            bootstrap.Modal.getInstance(document.getElementById('active-call-modal'))?.hide();
        }

        function toggleMute() {
            if (localStream) {
                const audioTrack = localStream.getAudioTracks()[0];
                audioTrack.enabled = !audioTrack.enabled;
                const btn = document.getElementById('mute-btn');
                if (audioTrack.enabled) {
                    btn.classList.replace('btn-danger', 'btn-secondary');
                    btn.innerHTML = '<i class="bi bi-mic-fill h4 mb-0"></i>';
                } else {
                    btn.classList.replace('btn-secondary', 'btn-danger');
                    btn.innerHTML = '<i class="bi bi-mic-mute-fill h4 mb-0"></i>';
                }
            }
        }

        // Real-time updates (Echo)
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                // Listen for messages
                window.Echo.private('user.' + userId).listen('MessageSent', function(e) {
                    if (currentWithUser && e.sender_id === currentWithUser) {
                        appendMessage(e);
                        scrollToBottom();
                    }
                });

                // Listen for calls
                window.Echo.private('user.' + userId).listen('AudioCallSignal', function(e) {
                    console.log('Signal received:', e);
                    handleSignal(e);
                });
            }
        });
    </script>
@endsection
