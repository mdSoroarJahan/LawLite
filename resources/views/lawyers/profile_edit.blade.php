@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3>Edit Lawyer Profile</h3>
                    <form method="POST" action="{{ route('lawyer.profile.edit') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo -->
                        <div class="mb-3 text-center">
                            @if ($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo"
                                    class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            </div>
                        </div>

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
                            <label>Bar Council ID</label>
                            <input name="bar_council_id" value="{{ old('bar_council_id', $lawyer->bar_council_id ?? '') }}"
                                class="form-control" />
                        </div>

                        <!-- Education -->
                        <div class="mb-3">
                            <label>Education</label>
                            <div id="education-wrapper">
                                @if (isset($lawyer->education) && is_array($lawyer->education))
                                    @foreach ($lawyer->education as $edu)
                                        <div class="input-group mb-2">
                                            <input name="education[]" value="{{ $edu }}" class="form-control"
                                                placeholder="Degree, University, Year" />
                                            <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="input-group mb-2">
                                    <input name="education[]" class="form-control" placeholder="Degree, University, Year" />
                                    <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="add-education">Add
                                Education</button>
                        </div>

                        <!-- Experience -->
                        <div class="mb-3">
                            <label>Experience</label>
                            <div id="experience-wrapper">
                                @if (isset($lawyer->experience) && is_array($lawyer->experience))
                                    @foreach ($lawyer->experience as $exp)
                                        <div class="input-group mb-2">
                                            <input name="experience[]" value="{{ $exp }}" class="form-control"
                                                placeholder="Role, Firm, Years" />
                                            <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="input-group mb-2">
                                    <input name="experience[]" class="form-control" placeholder="Role, Firm, Years" />
                                    <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="add-experience">Add
                                Experience</button>
                        </div>

                        <!-- Languages -->
                        <div class="mb-3">
                            <label>Languages</label>
                            <div id="languages-wrapper">
                                @if (isset($lawyer->languages) && is_array($lawyer->languages))
                                    @foreach ($lawyer->languages as $lang)
                                        <div class="input-group mb-2">
                                            <input name="languages[]" value="{{ $lang }}" class="form-control"
                                                placeholder="Language" />
                                            <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="input-group mb-2">
                                    <input name="languages[]" class="form-control" placeholder="Language" />
                                    <button type="button" class="btn btn-outline-danger remove-field">X</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="add-language">Add Language</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function addField(wrapperId, placeholder) {
                const wrapper = document.getElementById(wrapperId);
                const div = document.createElement('div');
                div.className = 'input-group mb-2';
                div.innerHTML = `
                    <input name="${wrapperId.replace('-wrapper', '[]')}" class="form-control" placeholder="${placeholder}" />
                    <button type="button" class="btn btn-outline-danger remove-field">X</button>
                `;
                wrapper.appendChild(div);
            }

            document.getElementById('add-education').addEventListener('click', () => addField('education-wrapper',
                'Degree, University, Year'));
            document.getElementById('add-experience').addEventListener('click', () => addField('experience-wrapper',
                'Role, Firm, Years'));
            document.getElementById('add-language').addEventListener('click', () => addField('languages-wrapper',
                'Language'));

            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-field')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
@endsection
