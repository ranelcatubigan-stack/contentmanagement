@extends('layouts.app')
@section('title', 'Comments')
@section('page-title', 'Manage Comments')

@section('styles')
<style>
    :root {
        --navy: #0f172a;
        --blue: #3b82f6;
        --slate: #64748b;
        --slate-light: #94a3b8;
        --border: #e2e8f0;
        --white: #ffffff;
        --bg: #f8fafc;
    }

    .comments-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 0 60px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 28px;
    }

    .page-label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--blue);
        margin-bottom: 6px;
        display: block;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--navy);
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .page-sub { font-size: 13px; color: var(--slate); margin: 0; }

    .comments-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        position: relative;
    }

    .comments-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #f59e0b, #ef4444);
        border-radius: 18px 18px 0 0;
    }

    .table { margin: 0; }

    .table thead th {
        background: var(--bg);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--slate);
        padding: 14px 20px;
        border: none;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .table tbody td {
        padding: 14px 20px;
        vertical-align: middle;
        border-color: var(--border);
        font-size: 13.5px;
    }

    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: var(--bg); }

    .author-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .author-av {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .author-av-name {
        font-weight: 700;
        font-size: 13px;
        color: var(--navy);
    }

    .post-link {
        font-weight: 600;
        font-size: 13px;
        color: var(--blue);
        text-decoration: none;
        transition: color 0.15s;
    }

    .post-link:hover { color: #1d4ed8; text-decoration: underline; }

    .comment-text {
        font-size: 13px;
        color: var(--slate);
        max-width: 260px;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 11px;
        border-radius: 20px;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .status-approved { background: #dcfce7; color: #15803d; }
    .status-pending  { background: #fef9c3; color: #a16207; }
    .status-spam     { background: #fee2e2; color: #dc2626; }
    .status-default  { background: #f1f5f9; color: #64748b; }

    .date-cell {
        font-size: 12.5px;
        color: var(--slate-light);
        white-space: nowrap;
    }

    .action-group { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }

    .action-btn {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        flex-shrink: 0;
    }

    .action-btn:hover { transform: translateY(-2px); }
    .btn-view    { background: #e0f2fe; color: #0284c7; }
    .btn-approve { background: #dcfce7; color: #15803d; }
    .btn-spam    { background: #fef9c3; color: #ca8a04; }
    .btn-delete  { background: #fee2e2; color: #dc2626; }
    .btn-view:hover    { background: #bae6fd; color: #0369a1; }
    .btn-approve:hover { background: #bbf7d0; color: #166534; }
    .btn-spam:hover    { background: #fde68a; color: #92400e; }
    .btn-delete:hover  { background: #fecaca; color: #b91c1c; }

    .empty-state {
        text-align: center;
        padding: 60px 24px;
    }

    .empty-icon-wrap {
        width: 60px; height: 60px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: var(--slate-light);
        margin: 0 auto 16px;
    }

    .empty-state h5 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: var(--slate); margin-bottom: 0; }

    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="comments-page">

    <div class="page-header">
        <div>
            <span class="page-label">Moderation</span>
            <h1 class="page-title">All Comments</h1>
            <p class="page-sub">{{ $comments->total() }} comment{{ $comments->total() !== 1 ? 's' : '' }} total</p>
        </div>
    </div>

    <div class="comments-card">
        <div class="table-responsive">
            <table class="table mb-0">
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
                        <td>
                            <div class="author-cell">
                                <div class="author-av">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="author-av-name">
                                    {{ $comment->author_name ?? $comment->user->name }}
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($comment->post)
                                <a href="{{ route('comments.show', $comment->id) }}" class="post-link">
                                    {{ Str::limit($comment->post->title, 35) }}
                                </a>
                            @else
                                <span class="text-muted" style="font-size:12px; font-style:italic;">Post deleted</span>
                            @endif
                        </td>
                        <td>
                            <span class="comment-text">
                                {{ Str::limit($comment->content ?? $comment->body, 60) }}
                            </span>
                        </td>
                        <td>
                            @php $st = $comment->status; @endphp
                            <span class="status-badge status-{{ in_array($st,['approved','pending','spam']) ? $st : 'default' }}">
                                @if($st === 'approved') ✓ Approved
                                @elseif($st === 'pending') ⏳ Pending
                                @elseif($st === 'spam') ⚠ Spam
                                @else {{ ucfirst($st) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="date-cell">{{ $comment->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                {{-- View --}}
                                <a href="{{ route('comments.show', $comment->id) }}"
                                   class="action-btn btn-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- Approve --}}
                                @if($comment->status !== 'approved')
                                <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-approve" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Spam --}}
                                @if($comment->status !== 'spam')
                                <form action="{{ route('comments.spam', $comment->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-spam" title="Mark as Spam"
                                            onclick="return confirm('Mark as spam?')">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this comment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="bi bi-chat-square-dots"></i>
                                </div>
                                <h5>No comments yet</h5>
                                <p>Comments will appear here once users start engaging.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($comments->hasPages())
        <div class="pagination-wrap">
            {{ $comments->links() }}
        </div>
        @endif
    </div>

</div>
@endsection