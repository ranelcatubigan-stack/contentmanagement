@extends('layouts.app')
@section('title', 'My Comments')
@section('page-title', 'My Comments')

@section('content')

{{-- ARTICLE COMMENTS --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
        <i class="bi bi-file-earmark-text-fill text-primary"></i>
        <h5 class="mb-0 fw-bold text-dark">Article Comments</h5>
        <span class="badge bg-primary rounded-pill ms-auto">{{ $comments->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Article Title</th>
                        <th>Your Comment</th>
                        <th>Status</th>
                        <th>Date Posted</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td class="ps-4">
                                @if($comment->post && is_object($comment->post))
                                    <a href="{{ route('comments.show', $comment->id) }}"
                                    class="text-decoration-none fw-bold text-primary">
                                        {{ Str::limit($comment->post->title, 40) }}
                                    </a>
                                @else
                                    <span class="text-muted small">Post deleted</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-secondary">
                                    "{{ Str::limit($comment->content, 60) }}"
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary">
                                    "{{ Str::limit($comment->content, 60) }}"
                                </span>
                            </td>
                            <td>
                                @php $status = strtolower($comment->status); @endphp
                                <span class="badge rounded-pill px-3 
                                    {{ $status === 'approved' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                    {{ $status === 'approved' ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $comment->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                      onsubmit="return confirm('Delete this comment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-left-text" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                                No article comments yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if($comments->hasPages())
        <div class="d-flex justify-content-center py-3">
            {{ $comments->links() }}
        </div>
        @endif
    </div>
</div>

{{-- NEWS COMMENTS --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
        <i class="bi bi-broadcast-fill text-info"></i>
        <h5 class="mb-0 fw-bold text-dark">News Comments</h5>
        <span class="badge bg-info rounded-pill ms-auto">{{ $newsComments->count() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">News Title</th>
                        <th>Your Comment</th>
                        <th>Date Posted</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($newsComments as $comment)
                        <tr>
                            <td class="ps-4">
                                @if($comment->news)
                                    <a href="{{ route('news.show', $comment->news->id) }}"
                                       class="text-decoration-none fw-bold text-info">
                                        {{ Str::limit($comment->news->title, 40) }}
                                    </a>
                                @else
                                    <span class="text-muted small">News deleted</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-secondary">
                                    "{{ Str::limit($comment->body, 60) }}"
                                </span>
                            </td>
                            <td class="text-muted small">{{ $comment->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('news.comment.delete', $comment) }}" method="POST"
                                      onsubmit="return confirm('Delete this comment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-broadcast" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                                No news comments yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection