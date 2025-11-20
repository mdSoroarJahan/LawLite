@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3>Edit Lawyer Profile</h3>
                    <form method="POST" action="{{ route('lawyer.profile.edit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <input name="name" value="{{ old('name', $user->name) }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>City</label>
                            <input name="city" value="{{ old('city', $lawyer->city ?? '') }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Expertise</label>
                            <input name="expertise" value="{{ old('expertise', $lawyer->expertise ?? '') }}"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Documents (license, ID) — PDF or images</label>
                            <input name="documents[]" type="file" class="form-control" multiple accept=".pdf,image/*" />
                            <div class="form-text">Upload scanned license, NID, or other supporting docs. Files are private
                                but accessible to admins for verification.</div>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
