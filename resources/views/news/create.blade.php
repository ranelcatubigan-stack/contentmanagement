@extends('layouts.app')
@section('title', 'Write News')
@section('page-title', 'Write News')

@section('styles')
<style>
    .news-form-wrap { max-width: 820px; margin: 0 auto; }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .form-label {
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 15px;
        color: #0f172a;
        transition: border-color 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.1);
    }

    textarea.form-control { min-height: 200px; resize: vertical; }

    .photo-upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
        position: relative;
    }

    .photo-upload-area:hover { border-color: #38bdf8; background: #f0f9ff; }
    .photo-upload-area i { font-size: 2.5rem; color: #94a3b8; margin-bottom: 12px; display: block; }
    .photo-upload-area p { color: #64748b; margin: 0; font-size: 14px; }
    .photo-upload-area input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }

    #photo-preview {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 12px;
        display: none;
        margin-top: 12px;
    }

    .btn-publish {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 40px;
        font-weight: 700;
        font-size: 15px;
        transition: opacity 0.2s;
    }

    .btn-publish:hover { opacity: 0.9; color: white; }
</style>
@endsection

@section('content')
<div class="news-form-wrap">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('news.my') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h4 class="fw-bold text-dark mb-0">Write a News Post</h4>
    </div>

    <div class="form-card">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="form-label">Headline / Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       placeholder="Write a compelling headline..." value="{{ old('title') }}">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                    <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Politics" {{ old('category') == 'Politics' ? 'selected' : '' }}>Politics</option>
                    <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health</option>
                    <option value="Science" {{ old('category') == 'Science' ? 'selected' : '' }}>Science</option>
                    <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                    <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                    <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="Lifestyle" {{ old('category') == 'Lifestyle' ? 'selected' : '' }}>Lifestyle</option>
                </select>
            </div>

            {{-- Photo Upload --}}
            <div class="mb-4">
                <label class="form-label">Cover Photo</label>
                <div class="photo-upload-area" id="upload-area">
                    <input type="file" name="photo" id="photo-input" accept="image/*">
                    <i class="bi bi-image"></i>
                    <p><strong>Click to upload</strong> or drag & drop</p>
                    <p class="mt-1" style="font-size:12px; color:#94a3b8;">PNG, JPG, WEBP up to 5MB</p>
                </div>
                <img id="photo-preview" src="" alt="Preview">
                @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            {{-- Body --}}
            <div class="mb-4">
                <label class="form-label">News Content</label>
                <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                          placeholder="Write your full news story here...">{{ old('body') }}</textarea>
                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn-publish">
                    <i class="bi bi-send-fill me-2"></i> Publish News
                </button>
                <a href="{{ route('news.my') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    const input = document.getElementById('photo-input');
    const preview = document.getElementById('photo-preview');
    const uploadArea = document.getElementById('upload-area');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadArea.style.borderColor = '#38bdf8';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection