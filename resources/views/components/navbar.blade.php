<nav class="navbar navbar-expand-lg navy">
    <div class="container">
        <a class="navbar-brand text-white" href="/">LawLite</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="#">@lang('nav.browse_lawyers')</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">@lang('nav.articles')</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">@lang('nav.faqs')</a></li>
                <li class="nav-item d-flex align-items-center me-2">
                    @include('components.notifications')
                </li>
                <li class="nav-item me-2"><button id="chat-toggle" class="btn btn-outline-light">Chat</button></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">EN|BN</a></li>
            </ul>
        </div>
    </div>
</nav>
