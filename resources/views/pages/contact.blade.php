@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">{{ __('messages.footer_contact') }}</h1>

                <p class="lead text-muted mb-5">
                    Have questions or need assistance? We're here to help. Reach out to us using the information below.
                </p>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-envelope text-primary fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Email Us</h5>
                            </div>
                            <p class="text-muted mb-0">
                                For general inquiries:<br>
                                <a href="mailto:support@lawlite.com" class="text-decoration-none">support@lawlite.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-geo-alt text-primary fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Visit Us</h5>
                            </div>
                            <p class="text-muted mb-0">
                                LawLite HQ<br>
                                Dhaka, Bangladesh
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Send us a Message</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Your Name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" placeholder="How can we help?">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Your message..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary px-4 py-2">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
