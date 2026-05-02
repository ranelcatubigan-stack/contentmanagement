@extends('layouts.app')
@section('title', 'My Articles')
@section('page-title', 'My Articles')

@section('styles')
<style>
    .content-wrap { max-width: 1100px; margin: 0 auto; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .btn-create {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.2s;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-create:hover { opacity: 0.9; color: white; }

    .articles-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .table thead th {
        background: #f8fafc;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 14px 16px;
        border: none;
    }

    .table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .table tbody tr:hover { background: #f8fafc; }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .status-published { background: #dcfce7; color: #16a34a; }
    .status-draft { background: #fef9c3; color: #ca8a04; }
    .status-hidden { background: #f1f5f9; color: #64748b; }

    .action-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
    }

    .action-btn:hover { transform: translateY(-1px); }
    .btn-view { background: #e0f2fe; color: #0284c7; }
    .btn-edit { background: #fef9c3; color: #ca8a04; }
    .btn-delete { background: #fee2e2; color: #dc2626; }

    /* Modal */
    .modal-card {
        border-radius: 20px;
        overflow: hidden;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        border: none;
        padding: 20px 28px;
    }

    .modal-title { font-weight: 700; font-size: 18px; }
    .modal-body { padding: 28px; }
    .modal-footer { padding: 16px 28px; border-top: 1px solid #f1f5f9; }

    .form-label {
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.1);
    }

    textarea.form-control { min-height: 150px; resize: vertical; }
</style>
@endsection

@section('content')
<div class="content-wrap">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h4 class="fw-bold text-dark mb-1">My Articles</h4>
            <p class="text-muted mb-0" style="font-size:14px;">
                {{ $contents->total() }} article(s) total
            </p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'author')
        <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <i class="bi bi-plus-lg"></i> Create New Post
        </button>
        @endif
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Articles Table --}}
    <div class="articles-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                    <tr>
                        <td>
                            <span class="fw-semibold text-dark">
                                {{ Str::limit($content->title, 50) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted">
                                {{ $content->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td>
                            @if($content->status === 'published')
                                <span class="status-badge status-published">Published</span>
                            @elseif($content->status === 'draft')
                                <span class="status-badge status-draft">Draft</span>
                            @else
                                <span class="status-badge status-hidden">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">
                                <i class="bi bi-eye me-1"></i>{{ \Cache::get('content_views_total_' . $content->id, 0) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $content->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('contents.show', $content) }}"
                                   class="action-btn btn-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(Auth::user()->can('update', $content))
                                <a href="{{ route('contents.edit', $content) }}"
                                   class="action-btn btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                @if(Auth::user()->can('delete', $content))
                                <form action="{{ route('contents.destroy', $content) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Delete this article?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-file-earmark-text"
                               style="font-size:2.5rem; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
                            No articles yet. Create your first one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($contents->hasPages())
        <div class="d-flex justify-content-center py-4">
            {{ $contents->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ================================ --}}
{{-- CREATE POST MODAL               --}}
{{-- ================================ --}}
@if(auth()->user()->role === 'admin' || auth()->user()->role === 'author')
<div class="modal fade" id="createPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-card">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i> Create New Article
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('contents.store') }}" method="POST">
                @csrf
                <div class="modal-body">
    <div class="row g-3">

        {{-- Title --}}
        <div class="col-12">
            <label class="form-label">Title</label>
            <input type="text" name="title" 
                   class="form-control @error('title') is-invalid @enderror"
                   placeholder="Enter a catchy title..." 
                   value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Category --}}
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" 
                    class="form-select @error('category_id') is-invalid @enderror">
                <option value="" disabled selected>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Status --}}
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" 
                    class="form-select @error('status') is-invalid @enderror">
                <option value="draft" @selected(old('status') === 'draft')>
                    Draft (For Approval)
                </option>
                <option value="published" @selected(old('status') === 'published')>
                    Published
                </option>
                <option value="hidden" @selected(old('status') === 'hidden')>
                    Hidden
                </option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Content --}}
        <div class="col-12">
            <label class="form-label">Content</label>
            <textarea name="body" rows="8"
                      class="form-control @error('body') is-invalid @enderror"
                      placeholder="Write your story here..." 
                      required>{{ old('body') }}</textarea>
            @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Tags --}}
        <div class="col-12">
            <label class="form-label">Tags</label>
            <select name="tags[]" 
                    class="form-select @error('tags') is-invalid @enderror"
                    multiple style="height: 120px;">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                        @selected(is_array(old('tags')) && in_array($tag->id, old('tags')))>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl / Cmd to select multiple tags</small>
            @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

    </div>
</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-create">
                        <i class="bi bi-send-fill me-1"></i> Publish Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection