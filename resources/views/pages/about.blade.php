@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">{{ __('messages.footer_about') }}</h1>

                <div class="mb-5">
                    <p class="lead text-muted">
                        LawLite is a pioneering legal technology platform dedicated to making legal assistance accessible,
                        transparent, and efficient for everyone.
                    </p>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-3">Our Mission</h3>
                    <p>
                        Our mission is to bridge the gap between legal professionals and individuals seeking legal help. We
                        believe that quality legal advice should be just a click away. By leveraging advanced technology and
                        AI, we empower users to understand their rights and connect with the right experts.
                    </p>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-3">What We Do</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-primary me-3 mt-1"></i>
                            <span><strong>Verified Lawyers:</strong> We maintain a rigorous verification process to ensure
                                you connect with qualified and trustworthy legal professionals.</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-primary me-3 mt-1"></i>
                            <span><strong>AI Assistance:</strong> Our AI-powered tools provide instant answers to common
                                legal queries, helping you navigate complex legal jargon.</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-primary me-3 mt-1"></i>
                            <span><strong>Secure Platform:</strong> We prioritize your privacy and security, ensuring that
                                your sensitive legal matters remain confidential.</span>
                        </li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-3">Our Team</h3>
                    <p>
                        LawLite is built by a passionate team of legal experts, software engineers, and designers working
                        together to transform the legal industry. We are committed to innovation and excellence in
                        everything we do.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
