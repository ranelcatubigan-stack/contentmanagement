@extends('layouts.app')
@section('title', 'My News')
@section('page-title', 'My News')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">My News Posts</h4>
            <p class="text-muted mb-0" style="font-size:14px;">{{ $news->total() }} post(s) total</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Write News
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Likes</th>
                        <th>Comments</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $post)
                    <tr>
                        <td>
                            <span class="fw-semibold text-dark">
                                {{ Str::limit($post->title, 50) }}
                            </span>
                        </td>
                        <td>
                            <span style="background:#e0f2fe; color:#0284c7; font-size:11px; font-weight:700; letter-spacing:.5px; padding:3px 10px; border-radius:20px;">
                                {{ $post->category }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size:13px;">
                                <i class="bi bi-heart-fill text-danger me-1"></i>{{ $post->likes_count }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size:13px;">
                                <i class="bi bi-chat-fill text-info me-1"></i>{{ $post->comments->count() }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:13px;">
                            {{ $post->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('news.show', $post) }}"
                                   class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                                <a href="{{ route('news.edit', $post) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('news.destroy', $post) }}" method="POST"
                                      onsubmit="return confirm('Delete this news post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-2">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-broadcast" style="font-size:2.5rem; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
                            No news posts yet. <a href="{{ route('news.create') }}">Write your first one!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($news->hasPages())
        <div class="d-flex justify-content-center py-4 border-top">
            {{ $news->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.table thead th {
    background: #f8fafc;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #64748b;
    padding: 14px 16px;
    border: none;
}
.table tbody td {
    padding: 14px 16px;
    border-color: #f1f5f9;
}
</style>
@endsection