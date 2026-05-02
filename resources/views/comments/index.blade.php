@extends('layouts.app')
@section('title', 'Comments')
@section('page-title', 'Manage Comments')
 
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Comments</h5>
                </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                 <tbody>
    @forelse($comments as $comment)
        <tr>
            {{-- 1. AUTHOR --}}
            <td>{{ $comment->author_name ?? $comment->user->name }}</td>

            {{-- 2. POST --}}
            <td>
                @if($comment->post)
                    <a href="{{ route('comments.show', $comment->id) }}" class="text-decoration-none fw-bold text-primary">
                        {{ Str::limit($comment->post->title, 40) }}
                    </a>
                @else
                    <span class="text-muted small italic">Post deleted</span>
                @endif
            </td>

            {{-- 3. COMMENT --}}
            <td>{{ Str::limit($comment->content ?? $comment->body, 50) }}</td>

            {{-- 4. STATUS --}}
            <td>
                @if($comment->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @elseif($comment->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($comment->status) }}</span>
                @endif
            </td>

            {{-- 5. DATE --}}
            <td>{{ $comment->created_at->format('M d, Y') }}</td>

            {{-- 6. ACTIONS --}}
           <td>
    <div class="d-flex gap-1">
        {{-- View Button --}}
        <a href="{{ route('comments.show', $comment->id) }}" class="btn btn-info btn-sm text-white" title="View Details">
            <i class="bi bi-eye"></i>
        </a>

        {{-- SPAM BUTTON (The Update) --}}
        @if($comment->status !== 'spam')
            <form action="{{ route('comments.spam', $comment->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm text-dark" title="Mark as Spam" onclick="return confirm('Mark this comment as spam?')">
                    <i class="bi bi-exclamation-triangle"></i>
                </button>
            </form>
        @endif

        {{-- APPROVE BUTTON --}}
@if($comment->status !== 'approved')
    <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-success btn-sm" title="Approve">
            <i class="bi bi-check-lg"></i>
        </button>
    </form>
@endif

{{-- SPAM BUTTON (keep only this one, remove the duplicate) --}}
@if($comment->status !== 'spam')
    <form action="{{ route('comments.spam', $comment->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-warning btn-sm text-dark" title="Mark as Spam" onclick="return confirm('Mark this comment as spam?')">
            <i class="bi bi-exclamation-triangle"></i>
        </button>
    </form>
@endif

{{-- Delete Button --}}
<form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
        <i class="bi bi-trash"></i>
    </button>
</form>
    </div>
</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No comments found.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            <div class="d-flex justify-content-center mt-4">
    {{ $comments->links() }}
</div>
    </div>
</div>
@endsection
 