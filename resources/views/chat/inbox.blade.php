@extends('layouts.landing')

@section('content')
<div class="container-fluid px-2 px-md-4 py-3">
    <div class="row g-0 rounded-3 shadow overflow-hidden border" style="height: calc(100vh - 100px); min-height: 500px;">
        <!-- Sidebar: Conversation List -->
        <div class="col-md-4 col-lg-3 border-end d-flex flex-column bg-light h-100" id="conversation-sidebar">
            <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center flex-shrink-0 shadow-sm">
                <h5 class="mb-0 fw-bold text-primary"><i
                        class="bi bi-chat-dots-fill me-2"></i>{{ __('messages.messages') }}</h5>
                @php
                $totalUnread = $conversations->sum('unread_count');
                @endphp
                <span id="total-unread-badge" class="badge bg-danger rounded-pill {{ $totalUnread > 0 ? '' : 'd-none' }}" style="min-width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                    {{ $totalUnread }}
                </span>
            </div>
            <!-- Search -->
            <div class="p-3 bg-light flex-shrink-0">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; z-index: 1;"></i>
                    <input type="text" class="form-control form-control-sm ps-5" placeholder="{{ __('messages.search') }}..."
                        id="conversation-search" style="border-radius: 20px; border: 1px solid #e5e7eb;">
                </div>
            </div>

            <div id="conversation-search-empty" class="text-center text-muted small py-2 d-none">
                {{ __('messages.no_conversations') }}
            </div>

            <div class="list-group list-group-flush overflow-auto flex-grow-1" id="conversation-list">
                @forelse($conversations as $conv)
                @php
                $partner = $conv['partner'];
                $lastMsg = $conv['latest_message'];
                $unread = $conv['unread_count'];
                @endphp
                @if($partner)
                <a href="#" class="list-group-item list-group-item-action border-0 py-3 conversation-item conversation-link"
                    data-user-id="{{ $partner->id }}"
                    data-user-name="{{ $partner->name }}">
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=10b981&color=ffffff&bold=true"
                                class="rounded-circle avatar-professional" width="45" height="45" alt="{{ $partner->name }}">
                            @if ($unread > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                {{ $unread }}
                            </span>
                            @endif
                        </div>
                        <div class="ms-3 flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 text-truncate fw-semibold">{{ $partner->name }}</h6>
                                <small class="text-muted conversation-updated-at" style="font-size: 0.75rem;">
                                    {{ $lastMsg ? $lastMsg->created_at->shortAbsoluteDiffForHumans() : '' }}
                                </small>
                            </div>
                            <p class="mb-0 text-muted text-truncate small conversation-preview">
                                @if ($lastMsg && $lastMsg->sender_id == auth()->id())
                                <span class="text-primary">You:</span>
                                @endif
                                {{ $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->content, 40) : __('messages.no_messages') }}
                            </p>
                        </div>
                    </div>
                </a>
                @endif
                @empty
                <div class="text-center p-4 text-muted">
                    <i class="bi bi-chat-square text-secondary display-6"></i>
                    <p class="mt-2 small">{{ __('messages.no_conversations') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="col-md-8 col-lg-9 d-flex flex-column bg-white h-100" id="chat-area">
            <!-- Empty State -->
            <div id="chat-empty-state"
                class="d-flex flex-column justify-content-center align-items-center flex-grow-1 text-muted">
                <div class="bg-light rounded-circle p-4 mb-3">
                    <i class="bi bi-chat-text display-4 text-primary opacity-50"></i>
                </div>
                <h4>{{ __('messages.welcome_chat') }}</h4>
                <p>{{ __('messages.select_conversation') }}</p>
            </div>

            <!-- Chat Interface (Hidden by default) -->
            <div id="chat-interface" class="d-none flex-column h-100">
                <!-- Header -->
                <div class="p-3 border-bottom bg-white d-flex align-items-center shadow-sm flex-shrink-0" style="z-index: 1;">
                    <button class="btn btn-link d-md-none me-2" onclick="toggleSidebar()" style="color: inherit;">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <img id="chat-header-avatar" src="" class="rounded-circle me-3 shadow-sm" width="44"
                        height="44" style="border: 2px solid #e5e7eb; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold" id="chat-header-name">User Name</h6>
                        <small id="chat-header-status" class="text-muted d-flex align-items-center">
                            <!-- Status will be injected here -->
                        </small>
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" title="{{ __('messages.audio_call') }}"
                            onclick="startCall()" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-telephone"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 chat-dropdown" style="min-width: 200px;">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="viewUserProfile()">
                                        <i class="bi bi-person-circle text-primary"></i>
                                        <span>View Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="searchInChat()">
                                        <i class="bi bi-search text-info"></i>
                                        <span>Search in Chat</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="toggleMuteNotifications()">
                                        <i class="bi bi-bell-slash text-warning" id="mute-icon"></i>
                                        <span id="mute-text">Mute Notifications</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="clearChatDisplay()">
                                        <i class="bi bi-eraser text-secondary"></i>
                                        <span>Clear Chat Display</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="exportChat()">
                                        <i class="bi bi-download text-success"></i>
                                        <span>Export Chat</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="blockUser()">
                                        <i class="bi bi-slash-circle"></i>
                                        <span>Block User</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="chat-messages" class="flex-grow-1 p-4 overflow-auto bg-light" style="scroll-behavior: smooth; background-image: url('data:image/svg+xml,%3Csvg width=\" 60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239C92AC\" fill-opacity=\"0.02\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    <!-- Messages will be injected here -->
                </div>

                <!-- Input Area -->
                <div class="p-3 bg-white border-top flex-shrink-0 shadow-lg">
                    <div class="input-group" style="background: transparent; border: none; padding: 0;">
                        <div class="d-flex align-items-center w-100" style="gap: 8px;">
                            <button class="btn btn-link text-muted rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-emoji-smile fs-5"></i>
                            </button>
                            <button class="btn btn-link text-muted rounded-circle p-2"
                                onclick="document.getElementById('file-input').click()" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-paperclip fs-5"></i>
                            </button>
                            <input type="file" id="file-input" class="d-none" onchange="handleFileSelect(this)">
                            <div class="flex-grow-1" style="position: relative;">
                                <input type="text" id="chat-input" class="form-control border-0 shadow-none text-body chat-input-modern"
                                    placeholder="{{ __('messages.type_message') }}..." style="border-radius: 24px; padding: 12px 20px; background: #f8f9fa; border: 2px solid #e5e7eb !important; transition: all 0.3s ease;">
                            </div>
                            <button id="chat-send" class="btn btn-primary rounded-circle"
                                style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </div>
                    <div id="file-preview" class="mt-2 d-none">
                        <div class="d-inline-flex align-items-center position-relative border rounded-pill px-3 py-2 shadow-sm" style="background: #f8f9fa;">
                            <i class="bi bi-file-earmark me-2 text-primary"></i>
                            <span id="file-name" class="small"></span>
                            <button type="button" class="btn-close btn-close-sm ms-2" style="font-size: 0.7rem;"
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
    /* ============================================
           MODERN MESSAGING UI - INDUSTRY LEVEL DESIGN
           ============================================ */

    /* Custom Scrollbar - Professional Design */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #059669 0%, #047857 100%);
    }

    [data-theme="dark"] ::-webkit-scrollbar-track {
        background: #1e293b;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #34d399 0%, #10b981 100%);
    }

    /* Main Container - Glass Morphism Effect */
    #conversation-sidebar,
    #chat-area {
        backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Conversation List - Professional Clean Design */
    .conversation-item {
        transition: all 0.25s ease;
        border-radius: 12px !important;
        margin: 4px 8px;
        padding: 12px 16px !important;
        border: none !important;
        position: relative;
        overflow: hidden;
        background: #ffffff;
    }

    .conversation-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 0;
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
        transition: width 0.25s ease;
        border-radius: 0 4px 4px 0;
    }

    .conversation-item:hover {
        background: #f8fafb !important;
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .conversation-item.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.04) 100%) !important;
        box-shadow: 0 2px 12px rgba(16, 185, 129, 0.12);
    }

    .conversation-item.active::before {
        width: 4px;
    }

    .conversation-item h6 {
        color: #1f2937 !important;
        font-weight: 600;
    }

    .conversation-item .text-muted {
        color: #6b7280 !important;
    }

    .conversation-item .text-primary {
        color: #10b981 !important;
    }

    /* Professional Avatar Styling */
    .avatar-professional {
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
        border: 2px solid #ffffff;
    }

    [data-theme="dark"] .conversation-item {
        background: rgba(15, 23, 42, 0.6);
    }

    [data-theme="dark"] .conversation-item:hover {
        background: rgba(52, 211, 153, 0.08) !important;
    }

    [data-theme="dark"] .conversation-item.active {
        background: rgba(52, 211, 153, 0.12) !important;
        box-shadow: 0 2px 12px rgba(52, 211, 153, 0.15);
    }

    [data-theme="dark"] .conversation-item h6 {
        color: #f1f5f9 !important;
    }

    [data-theme="dark"] .conversation-item .text-muted {
        color: #94a3b8 !important;
    }

    [data-theme="dark"] .avatar-professional {
        border-color: rgba(255, 255, 255, 0.1);
    }

    /* Modern Message Bubbles */
    .message-bubble {
        max-width: 70%;
        padding: 14px 18px;
        border-radius: 20px;
        position: relative;
        font-size: 0.95rem;
        line-height: 1.6;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        animation: messageSlideIn 0.3s ease-out;
        transition: transform 0.2s ease;
    }

    .message-bubble:hover {
        transform: scale(1.02);
    }

    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-sent {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        border-bottom-right-radius: 6px;
        margin-left: auto;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }

    .message-received {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #1a1a1a !important;
        border-bottom-left-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    [data-theme="dark"] .message-received {
        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        color: #e2e8f0 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .message-time {
        font-size: 0.7rem;
        margin-top: 6px;
        opacity: 0.75;
        font-weight: 500;
    }

    .message-sent .message-time {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .message-received .message-time {
        color: #6b7280 !important;
    }

    [data-theme="dark"] .message-received .message-time {
        color: #94a3b8 !important;
    }

    /* Modern Input Area */
    #chat-interface .input-group {
        background: #ffffff !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 24px !important;
        padding: 4px !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    #chat-interface .input-group:focus-within {
        border-color: #10b981 !important;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.15);
    }

    #chat-input {
        font-size: 0.95rem;
        padding: 10px 16px !important;
    }

    #chat-send {
        width: 44px !important;
        height: 44px !important;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        transition: all 0.3s ease;
    }

    #chat-send:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
    }

    #chat-send:active {
        transform: scale(0.95);
    }

    [data-theme="dark"] #chat-interface .input-group {
        background: #1a202c !important;
        border-color: #374151 !important;
    }

    [data-theme="dark"] #chat-interface .input-group:focus-within {
        border-color: #34d399 !important;
        box-shadow: 0 4px 16px rgba(52, 211, 153, 0.2);
    }

    [data-theme="dark"] #chat-send {
        background: linear-gradient(135deg, #34d399 0%, #059669 100%) !important;
        box-shadow: 0 4px 12px rgba(52, 211, 153, 0.3);
    }

    /* Dark Mode - Complete Color Override (chat specific enhancements) */
    [data-theme="dark"] .bg-white {
        background-color: #0f172a !important;
    }

    [data-theme="dark"] .bg-light {
        background-color: #0b1220 !important;
    }

    [data-theme="dark"] .border,
    [data-theme="dark"] .border-end,
    [data-theme="dark"] .border-bottom,
    [data-theme="dark"] .border-top {
        border-color: #22303f !important;
    }

    /* global text colors for dark theme inside chat */
    [data-theme="dark"] .text-body,
    [data-theme="dark"] .text-muted,
    [data-theme="dark"] h5,
    [data-theme="dark"] h6,
    [data-theme="dark"] p,
    [data-theme="dark"] small,
    [data-theme="dark"] span,
    [data-theme="dark"] a {
        color: #e6eef8 !important;
    }

    /* conversation list specifics */
    [data-theme="dark"] .list-group-item,
    [data-theme="dark"] .conversation-item,
    [data-theme="dark"] .conversation-preview,
    [data-theme="dark"] .conversation-updated-at {
        color: #cbd5e1 !important;
    }

    [data-theme="dark"] .conversation-item h6 {
        color: #f1f5f9 !important;
    }

    [data-theme="dark"] .badge {
        background-color: #ef4444 !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    /* buttons & links */
    [data-theme="dark"] .btn-link,
    [data-theme="dark"] .btn-link.text-muted,
    [data-theme="dark"] .text-primary {
        color: #7ee7b8 !important;
    }

    /* icons */
    [data-theme="dark"] .bi {
        color: #bcd2e6 !important;
    }

    /* form controls */
    [data-theme="dark"] .form-control {
        background-color: #0e1724 !important;
        color: #e6eef8 !important;
        border-color: #22303f !important;
    }

    [data-theme="dark"] .form-control::placeholder {
        color: #94a3b8 !important;
    }

    [data-theme="dark"] .form-control:focus {
        background-color: #0e1724 !important;
        color: #e6eef8 !important;
        border-color: #34d399 !important;
        box-shadow: 0 0 0 0.2rem rgba(52, 211, 153, 0.08);
    }

    /* ensure message bubbles are readable */
    [data-theme="dark"] .message-bubble {
        color: #e6eef8 !important;
    }

    [data-theme="dark"] .list-group-item {
        background-color: transparent !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .list-group-item h6 {
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] #chat-messages {
        background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
        background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%2334d399\" fill-opacity=\"0.02\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E') !important;
    }

    [data-theme="dark"] .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4) !important;
    }

    [data-theme="dark"] .modal-content {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }

    [data-theme="dark"] .modal-content h5,
    [data-theme="dark"] .modal-content p {
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .btn-light {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .btn-light:hover {
        background-color: #475569 !important;
        color: #ffffff !important;
    }

    [data-theme="dark"] .btn-link {
        color: #94a3b8 !important;
    }

    [data-theme="dark"] .btn-link:hover {
        color: #34d399 !important;
    }

    /* Empty State */
    [data-theme="dark"] #chat-empty-state {
        color: #94a3b8 !important;
    }

    [data-theme="dark"] #chat-empty-state h4,
    [data-theme="dark"] #chat-empty-state p {
        color: #cbd5e1 !important;
    }

    /* Conversation Preview Text */
    [data-theme="dark"] .conversation-preview {
        color: #94a3b8 !important;
    }

    [data-theme="dark"] .conversation-updated-at {
        color: #64748b !important;
    }

    /* Call Log Badge */
    [data-theme="dark"] .badge.bg-light {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    /* Avatar Pulse Animation */
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
        border: 3px solid #667eea;
        animation: pulse 1.5s infinite;
    }

    [data-theme="dark"] .avatar-pulse::after {
        border-color: #34d399;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.3);
            opacity: 0;
        }
    }

    /* Header Styling */
    [data-theme="dark"] #chat-interface .border-bottom {
        border-color: #334155 !important;
        background: #0f172a !important;
    }

    /* File Preview */
    [data-theme="dark"] #file-preview {
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] #file-preview .border {
        border-color: #334155 !important;
        background: #1e293b !important;
    }

    /* Search Input */
    [data-theme="dark"] #conversation-search {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }

    [data-theme="dark"] #conversation-search::placeholder {
        color: #94a3b8 !important;
    }

    /* Modern Input Styling */
    .chat-input-modern:focus {
        background: #ffffff !important;
        border-color: #667eea !important;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1) !important;
        outline: none !important;
    }

    [data-theme="dark"] .chat-input-modern {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .chat-input-modern:focus {
        background: #1e293b !important;
        border-color: #34d399 !important;
        box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.1) !important;
    }

    [data-theme="dark"] .chat-input-modern::placeholder {
        color: #94a3b8 !important;
    }

    /* File Preview Dark Mode */
    [data-theme="dark"] #file-preview .border {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    [data-theme="dark"] #file-preview span {
        color: #e2e8f0 !important;
    }

    /* Smooth Transitions */
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    /* Empty State Improvements */
    #chat-empty-state {
        opacity: 0.7;
    }

    #chat-empty-state i {
        font-size: 4rem;
        opacity: 0.3;
    }

    [data-theme="dark"] #chat-empty-state i {
        opacity: 0.2;
    }

    /* Chat Dropdown Menu Styling */
    .chat-dropdown {
        border-radius: 12px !important;
        padding: 8px !important;
        background: #ffffff;
    }

    .chat-dropdown .dropdown-item {
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .chat-dropdown .dropdown-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }

    .chat-dropdown .dropdown-item.text-danger:hover {
        background: rgba(239, 68, 68, 0.1);
    }

    .chat-dropdown .dropdown-divider {
        border-color: #e5e7eb;
    }

    .chat-dropdown .dropdown-item i {
        font-size: 1rem;
        width: 20px;
    }

    [data-theme="dark"] .chat-dropdown {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    [data-theme="dark"] .chat-dropdown .dropdown-item {
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .chat-dropdown .dropdown-item:hover {
        background: rgba(52, 211, 153, 0.1) !important;
    }

    [data-theme="dark"] .chat-dropdown .dropdown-item.text-danger {
        color: #f87171 !important;
    }

    [data-theme="dark"] .chat-dropdown .dropdown-item.text-danger:hover {
        background: rgba(248, 113, 113, 0.1) !important;
    }

    [data-theme="dark"] .chat-dropdown .dropdown-divider {
        border-color: #334155;
    }

    /* Search in Chat Modal */
    .search-chat-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }

    [data-theme="dark"] .search-chat-container {
        background: #0f172a;
    }
</style>

<script>
    // Debug: Script loaded
    console.log('Chat script loaded');

    let currentWithUser = null;
    let isLoadingHistory = false;
    let isSendingMessage = false;
    const currentUserId = "{{ auth()->id() }}";
    const initialWithUserId = "{{ $openUser?->id }}";
    const initialWithUserName = "{{ addslashes($openUser?->name) }}";

    console.log('Current user ID:', currentUserId);

    const conversationList = document.getElementById('conversation-list');
    const conversationSearch = document.getElementById('conversation-search');
    const conversationSearchEmpty = document.getElementById('conversation-search-empty');

    function ensureConversationItem(partnerId, partnerName) {
        if (!conversationList || !partnerId) return;
        let item = conversationList.querySelector(`.conversation-item[data-user-id="${partnerId}"]`);
        if (!item) {
            item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action border-0 py-3 conversation-item conversation-link';
            item.dataset.userId = partnerId;
            item.dataset.userName = partnerName || 'User';
            item.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName || 'User')}&background=10b981&color=ffffff&bold=true"
                                class="rounded-circle avatar-professional" width="45" height="45" alt="${partnerName || 'User'}">
                        </div>
                        <div class="ms-3 flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 text-truncate fw-semibold">${partnerName || 'User'}</h6>
                            </div>
                            <p class="mb-0 text-muted text-truncate small conversation-preview">{{ __('messages.no_messages') }}</p>
                        </div>
                    </div>`;
            conversationList.prepend(item);
        }
    }

    // Debug elements existence
    const uiElements = {
        conversationList: !!conversationList,
        conversationSearch: !!conversationSearch,
        chatEmptyState: !!document.getElementById('chat-empty-state'),
        chatInterface: !!document.getElementById('chat-interface'),
        chatMessages: !!document.getElementById('chat-messages')
    };
    console.log('UI Elements found:', uiElements);

    if (conversationSearch) {
        conversationSearch.addEventListener('input', function() {
            filterConversations(this.value.trim().toLowerCase());
        });
    }

    document.addEventListener('click', function(e) {
        const link = e.target.closest('.conversation-link');
        if (link) {
            e.preventDefault();
            e.stopPropagation();
            const partnerId = link.dataset.userId;
            const partnerName = link.dataset.userName;

            console.log('Click detected on conversation:', partnerId, partnerName);

            // Allow clicking even if loading (to switch users or retry)
            // if (isLoadingHistory) { ... } 

            openChatWith(partnerId, partnerName);
        }
    });

    function filterConversations(term) {
        if (!conversationList) return;
        let visibleCount = 0;
        conversationList.querySelectorAll('.conversation-item').forEach(item => {
            const name = (item.dataset.userName || '').toLowerCase();
            const previewText = (item.querySelector('.conversation-preview')?.textContent || '').toLowerCase();
            const matches = !term || name.includes(term) || previewText.includes(term);
            item.classList.toggle('d-none', !matches);
            if (matches) visibleCount++;
        });
        if (conversationSearchEmpty) {
            conversationSearchEmpty.classList.toggle('d-none', visibleCount !== 0 || !term);
        }
    }

    function csrf() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('conversation-sidebar');
        const chatArea = document.getElementById('chat-area');
        if (sidebar && chatArea) {
            sidebar.classList.toggle('d-none');
            chatArea.classList.toggle('d-none');
        }
    }

    async function openChatWith(partnerId, partnerName) {
        console.log('openChatWith initiated for:', partnerId);
        currentWithUser = partnerId;

        // Update UI State
        const emptyState = document.getElementById('chat-empty-state');
        const chatInterface = document.getElementById('chat-interface');

        if (emptyState) {
            emptyState.style.display = 'none';
            emptyState.classList.add('d-none');
        }

        if (chatInterface) {
            chatInterface.style.display = 'flex';
            chatInterface.classList.remove('d-none');
            chatInterface.classList.add('d-flex');
            console.log('Chat interface shown');
        } else {
            console.error('Chat interface element not found!');
            return;
        }

        // Update Header
        const headerName = document.getElementById('chat-header-name');
        const headerAvatar = document.getElementById('chat-header-avatar');
        const headerStatus = document.getElementById('chat-header-status');

        if (headerName) headerName.textContent = partnerName;
        if (headerAvatar) headerAvatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=10b981&color=ffffff&bold=true`;
        if (headerStatus) headerStatus.innerHTML = '<span class="text-muted">Checking status...</span>';

        // Highlight active conversation
        document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active', 'bg-light'));
        const activeItem = document.querySelector(`.conversation-item[data-user-id="${partnerId}"]`);
        if (activeItem) activeItem.classList.add('active');

        // Load Messages
        await loadHistory(partnerId);
    }

    async function loadHistory(withId) {
        console.log('loadHistory called for:', withId);

        isLoadingHistory = true;
        const box = document.getElementById('chat-messages');
        if (!box) {
            console.error('Chat messages container not found');
            return;
        }

        box.innerHTML = '<div class="d-flex justify-content-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>';

        try {
            const url = `/chat/history/${withId}`;
            console.log('Fetching history from:', url);

            const res = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': csrf(),
                    'Accept': 'application/json'
                }
            });

            console.log('API response status:', res.status);

            if (!res.ok) {
                const errorText = await res.text();
                console.error('API error response:', errorText);
                throw new Error(`Failed to load: ${res.status}`);
            }

            const json = await res.json();
            console.log('Chat history data:', json);

            if (!json.ok) {
                throw new Error(json.message || 'Failed to load messages');
            }

            box.innerHTML = '';

            // Check if messages exist
            if (!json.messages || json.messages.length === 0) {
                box.innerHTML = '<div class="text-center text-muted mt-5"><i class="bi bi-chat-dots display-4"></i><p class="mt-2">No messages yet. Start the conversation!</p></div>';
            } else {
                json.messages.forEach(m => {
                    appendMessage(m);
                });
                scrollToBottom();
            }

            // Update Online Status
            const statusEl = document.getElementById('chat-header-status');
            if (statusEl) {
                if (json.partner_status && json.partner_status.is_online) {
                    statusEl.innerHTML = '<span class="text-success"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Online</span>';
                } else {
                    let lastSeenText = 'Offline';
                    if (json.partner_status && json.partner_status.last_seen) {
                        const date = new Date(json.partner_status.last_seen);
                        const now = new Date();
                        const diff = Math.floor((now - date) / 1000); // seconds

                        if (diff < 60) lastSeenText = 'Last seen just now';
                        else if (diff < 3600) lastSeenText = `Last seen ${Math.floor(diff / 60)}m ago`;
                        else if (diff < 86400) lastSeenText = `Last seen ${Math.floor(diff / 3600)}h ago`;
                        else lastSeenText = `Last seen ${date.toLocaleDateString()}`;
                    }
                    statusEl.innerHTML = `<span class="text-muted">${lastSeenText}</span>`;
                }
            }

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
            console.error('Error loading messages:', err);
            box.innerHTML = `<div class="text-center text-danger mt-5">
                    <i class="bi bi-exclamation-circle display-4"></i>
                    <p class="mt-2">Failed to load messages.</p>
                    <small class="text-muted">${err.message}</small>
                </div>`;
        } finally {
            isLoadingHistory = false;
        }
    }

    // Sanitization helpers
    function sanitizeMessage(text = '') {
        const temp = document.createElement('div');
        temp.textContent = text;
        return temp.innerHTML.replace(/\n/g, '<br>');
    }

    function sanitizePlainText(text = '') {
        const temp = document.createElement('div');
        temp.textContent = text;
        return temp.innerHTML;
    }

    // Update conversation preview
    function updateConversationPreview(userId, message) {
        if (!conversationList || !message) return;
        const item = conversationList.querySelector(`.conversation-item[data-user-id="${userId}"]`);
        if (!item) return;
        const previewEl = item.querySelector('.conversation-preview');
        if (previewEl && typeof message.content === 'string') {
            const prefix = parseInt(message.sender_id) === parseInt(currentUserId) ? '<span class="text-primary">You:</span> ' : '';
            previewEl.innerHTML = prefix + sanitizePlainText(message.content);
        }
        const timeEl = item.querySelector('.conversation-updated-at');
        if (timeEl && message.created_at) {
            const date = new Date(message.created_at);
            timeEl.textContent = date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    // Update global unread badge
    function updateGlobalUnreadCount(delta) {
        const globalBadge = document.getElementById('total-unread-badge');
        if (!globalBadge) return;
        const current = parseInt(globalBadge.innerText) || 0;
        const next = Math.max(0, current + delta);
        globalBadge.innerText = next;
        globalBadge.classList.toggle('d-none', next === 0);
    }

    // Increment unread badge on a conversation
    function incrementUnreadBadge(userId) {
        if (!conversationList) return;
        const item = conversationList.querySelector(`.conversation-item[data-user-id="${userId}"]`);
        if (!item) return;
        let badge = item.querySelector('.badge');
        if (!badge) {
            const avatarWrapper = item.querySelector('.position-relative');
            if (!avatarWrapper) return;
            badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light';
            badge.innerText = '0';
            avatarWrapper.appendChild(badge);
        }
        const current = parseInt(badge.innerText) || 0;
        badge.innerText = current + 1;
        updateGlobalUnreadCount(1);
    }

    function appendMessage(m) {
        const box = document.getElementById('chat-messages');
        if (!box) return;
        const isMe = parseInt(m.sender_id) === parseInt(currentUserId);

        const div = document.createElement('div');

        const time = new Date(m.created_at).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        // Handle Call Logs
        if (m.attachment_type === 'call_log') {
            div.className = 'd-flex justify-content-center mb-3';
            div.innerHTML = `
                    <div class="badge bg-light text-body border p-2 rounded-pill shadow-sm d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i> 
                        <span>${sanitizeMessage(m.content)}</span>
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

        const messageBody = sanitizeMessage(m.content || '');
        const hasBody = messageBody.length > 0;

        div.innerHTML = `
            <div class="message-bubble ${isMe ? 'message-sent' : 'message-received'} shadow-sm">
                ${attachmentHtml}
                ${hasBody ? `<div>${messageBody}</div>` : ''}
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

    // Toggle send button state
    function toggleSendState(isBusy) {
        if (!chatSend) return;
        chatSend.disabled = isBusy;
        chatSend.innerHTML = isBusy ?
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' :
            '<i class="bi bi-send-fill"></i>';
    }

    async function sendMessage() {
        if (!currentWithUser) return;
        if (isSendingMessage) return;
        const content = chatInput.value.trim();
        const file = fileInput.files[0];

        if (!content && !file) return;

        isSendingMessage = true;
        toggleSendState(true);

        // Optimistic UI update (text only for now, file needs upload)
        if (content && !file) {
            const tempMsg = {
                sender_id: currentUserId,
                content: content,
                created_at: new Date().toISOString()
            };
            appendMessage(tempMsg);
            scrollToBottom();
            chatInput.value = '';
            updateConversationPreview(currentWithUser, tempMsg);
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
                updateConversationPreview(currentWithUser, data.message);
            }
        } catch (err) {
            console.error(err);
            alert('Failed to send message');
        } finally {
            isSendingMessage = false;
            toggleSendState(false);
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
                `https://ui-avatars.com/api/?name=${encodeURIComponent(senderName)}&background=10b981&color=ffffff&bold=true`;
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

    // ============================================
    // THREE-DOT MENU FUNCTIONS
    // ============================================

    let isMuted = false;

    function viewUserProfile() {
        event.preventDefault();
        if (!currentWithUser) return;

        // Get lawyer profile URL or user profile
        const userName = document.getElementById('chat-header-name').textContent;

        // Try to find if user is a lawyer
        fetch(`/api/user/${currentWithUser}/profile-url`)
            .then(res => res.json())
            .then(data => {
                if (data.url) {
                    window.open(data.url, '_blank');
                } else {
                    // Show user info in a toast/alert
                    showToast(`User: ${userName}`, 'info');
                }
            })
            .catch(() => {
                showToast(`User: ${userName}`, 'info');
            });
    }

    function searchInChat() {
        event.preventDefault();
        const box = document.getElementById('chat-messages');
        if (!box) return;

        const searchTerm = prompt('Search for messages containing:');
        if (!searchTerm || !searchTerm.trim()) return;

        const messages = box.querySelectorAll('.message-bubble');
        let found = false;

        // Remove previous highlights
        messages.forEach(msg => {
            msg.style.outline = '';
            msg.style.boxShadow = '';
        });

        // Find and highlight matching messages
        messages.forEach(msg => {
            const text = msg.textContent.toLowerCase();
            if (text.includes(searchTerm.toLowerCase())) {
                msg.style.outline = '2px solid #10b981';
                msg.style.boxShadow = '0 0 10px rgba(16, 185, 129, 0.3)';
                if (!found) {
                    msg.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    found = true;
                }
            }
        });

        if (!found) {
            showToast('No messages found matching: ' + searchTerm, 'warning');
        } else {
            showToast('Found matching messages (highlighted in green)', 'success');
        }
    }

    function toggleMuteNotifications() {
        event.preventDefault();
        isMuted = !isMuted;

        const icon = document.getElementById('mute-icon');
        const text = document.getElementById('mute-text');

        if (isMuted) {
            icon.className = 'bi bi-bell-fill text-success';
            text.textContent = 'Unmute Notifications';
            showToast('Notifications muted for this chat', 'success');
        } else {
            icon.className = 'bi bi-bell-slash text-warning';
            text.textContent = 'Mute Notifications';
            showToast('Notifications unmuted', 'success');
        }
    }

    function clearChatDisplay() {
        event.preventDefault();
        if (!confirm('Clear chat display? (Messages will still be saved)')) return;

        const box = document.getElementById('chat-messages');
        if (box) {
            box.innerHTML = '<div class="text-center text-muted mt-5"><i class="bi bi-chat-dots display-4"></i><p class="mt-2">Chat display cleared. Refresh to reload messages.</p></div>';
            showToast('Chat display cleared', 'success');
        }
    }

    function exportChat() {
        event.preventDefault();
        const box = document.getElementById('chat-messages');
        if (!box) return;

        const userName = document.getElementById('chat-header-name').textContent;
        const messages = box.querySelectorAll('.message-bubble');

        if (messages.length === 0) {
            showToast('No messages to export', 'warning');
            return;
        }

        let exportText = `Chat with ${userName}\nExported on: ${new Date().toLocaleString()}\n${'='.repeat(50)}\n\n`;

        messages.forEach(msg => {
            const isSent = msg.classList.contains('message-sent');
            const time = msg.querySelector('.message-time')?.textContent || '';
            const content = msg.textContent.replace(time, '').trim();
            const sender = isSent ? 'You' : userName;
            exportText += `[${time}] ${sender}: ${content}\n`;
        });

        // Download as text file
        const blob = new Blob([exportText], {
            type: 'text/plain'
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `chat_${userName.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.txt`;
        a.click();
        URL.revokeObjectURL(url);

        showToast('Chat exported successfully', 'success');
    }

    function blockUser() {
        event.preventDefault();
        const userName = document.getElementById('chat-header-name').textContent;

        if (!confirm(`Are you sure you want to block ${userName}? You won't receive messages from them.`)) return;

        // API call to block user (implement backend endpoint)
        fetch('/chat/block', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf()
                },
                body: JSON.stringify({
                    user_id: currentWithUser
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    showToast(`${userName} has been blocked`, 'success');
                    // Remove from conversation list
                    const item = document.querySelector(`.conversation-item[data-user-id="${currentWithUser}"]`);
                    if (item) item.remove();
                    // Clear chat
                    document.getElementById('chat-interface').classList.add('d-none');
                    document.getElementById('chat-empty-state').classList.remove('d-none');
                } else {
                    showToast(data.message || 'Could not block user', 'error');
                }
            })
            .catch(() => {
                showToast('Feature coming soon', 'info');
            });
    }

    // Toast notification helper
    function showToast(message, type = 'info') {
        // Remove existing toasts
        const existingToast = document.querySelector('.chat-toast');
        if (existingToast) existingToast.remove();

        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };

        const icons = {
            success: 'bi-check-circle-fill',
            error: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };

        const toast = document.createElement('div');
        toast.className = 'chat-toast';
        toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: #1e293b;
                color: white;
                padding: 12px 20px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                border-left: 4px solid ${colors[type]};
            `;
        toast.innerHTML = `<i class="bi ${icons[type]}" style="color: ${colors[type]}"></i> ${message}`;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add toast animation styles
    const toastStyle = document.createElement('style');
    toastStyle.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
    document.head.appendChild(toastStyle);

    // If the page was opened with ?with=<user_id>, pre-open that conversation
    if (initialWithUserId) {
        ensureConversationItem(initialWithUserId, initialWithUserName || 'User');
        openChatWith(initialWithUserId, initialWithUserName || 'User');
    }

    // Real-time updates (Echo)
    document.addEventListener('DOMContentLoaded', function() {
        if (window.Echo) {
            // Listen for messages
            window.Echo.private('user.' + currentUserId).listen('MessageSent', function(e) {
                if (currentWithUser && parseInt(e.sender_id) === parseInt(currentWithUser)) {
                    appendMessage(e);
                    scrollToBottom();
                } else {
                    // Message from someone else - increment unread badge
                    incrementUnreadBadge(e.sender_id);
                }
                // Update conversation preview for the sender
                updateConversationPreview(e.sender_id, e);
            });

            // Listen for calls
            window.Echo.private('user.' + currentUserId).listen('AudioCallSignal', function(e) {
                console.log('Signal received:', e);
                handleSignal(e);
            });
        }
    });
</script>
@endsection