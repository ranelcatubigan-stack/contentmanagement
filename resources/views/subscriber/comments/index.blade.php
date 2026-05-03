@extends('layouts.app')
@section('title', 'My Comments')
@section('page-title', 'My Comments')

@section('content')

<style>
    :root {
        --navy: #0f172a;
        --navy-soft: #1e293b;
        --blue: #3b82f6;
        --blue-light: #60a5fa;
        --blue-glow: rgba(59,130,246,0.10);
        --slate: #64748b;
        --slate-light: #94a3b8;
        --border: #e2e8f0;
        --white: #ffffff;
        --bg: #f8fafc;
    }

    .comments-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 0 60px;
    }

    /* ── Page Header ── */
    .page-header {
        margin-bottom: 36px;
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
        margin-bottom: 6px;
    }

    .page-sub {
        font-size: 14px;
        color: var(--slate);
    }

    /* ── Section Block ── */
    .comments-section {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 28px;
        transition: box-shadow 0.25s;
    }

    .comments-section:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.07);
    }

    .section-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        position: relative;
    }

    .section-head::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 18px 18px 0 0;
    }

    .section-articles .section-head::before {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
    }

    .section-news .section-head::before {
        background: linear-gradient(90deg, #8b5cf6, #ec4899);
    }

    .section-icon {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .section-articles .section-icon {
        background: #eff6ff;
        color: var(--blue);
    }

    .section-news .section-icon {
        background: #f5f3ff;
        color: #8b5cf6;
    }

    .section-head-text h2 {
        font-size: 16px;
        font-weight: 800;
        color: var(--navy);
        margin: 0 0 2px;
    }

    .section-head-text p {
        font-size: 12px;
        color: var(--slate);
        margin: 0;
    }

    .count-badge {
        margin-left: auto;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 100px;
        background: var(--bg);
        color: var(--slate);
        border: 1px solid var(--border);
    }

    /* ── Comment Row ── */
    .comment-row {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: start;
        gap: 16px;
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .comment-row:last-child { border-bottom: none; }
    .comment-row:hover { background: var(--bg); }

    .comment-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .article-link {
        font-size: 14px;
        font-weight: 700;
        color: var(--navy);
        text-decoration: none;
        line-height: 1.35;
        transition: color 0.15s;
    }

    .article-link:hover { color: var(--blue); }

    .article-link-news {
        color: var(--navy);
    }

    .article-link-news:hover { color: #8b5cf6; }

    .comment-quote {
        font-size: 13px;
        color: var(--slate);
        line-height: 1.55;
        padding: 8px 12px;
        background: var(--bg);
        border-left: 3px solid var(--border);
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }

    .comment-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 2px;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 100px;
        letter-spacing: 0.5px;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef9c3;
        color: #a16207;
    }

    .comment-date {
        font-size: 11px;
        color: var(--slate-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .comment-date i { font-size: 10px; }

    .comment-actions {
        display: flex;
        align-items: center;
        padding-top: 4px;
    }

    .btn-delete {
        width: 34px; height: 34px;
        border: 1px solid var(--border);
        background: white;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--slate-light);
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-delete:hover {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #e11d48;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 52px 24px;
        color: var(--slate-light);
    }

    .empty-icon {
        width: 52px; height: 52px;
        background: var(--bg);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin: 0 auto 14px;
        border: 1px solid var(--border);
    }

    .empty-state p {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--slate);
        margin-bottom: 4px;
    }

    .empty-state span {
        font-size: 12px;
        color: var(--slate-light);
    }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 16px 28px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center;
    }

    .pagination-wrap .pagination .page-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--slate);
        border-color: var(--border);
        border-radius: 8px !important;
        margin: 0 2px;
    }

    .pagination-wrap .pagination .page-item.active .page-link {
        background: var(--navy);
        border-color: var(--navy);
        color: white;
    }

    .pagination-wrap .pagination .page-link:hover {
        background: var(--bg);
        color: var(--navy);
    }
</style>

<div class="comments-page">

    {{-- Page Header --}}
    <div class="page-header">
        <span class="page-label">Your Activity</span>
        <h1 class="page-title">My Comments</h1>
        <p class="page-sub">All comments you've posted across articles and news.</p>
    </div>

    {{-- ARTICLE COMMENTS --}}
    <div class="comments-section section-articles">
        <div class="section-head">
            <div class="section-icon">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <div class="section-head-text">
                <h2>Article Comments</h2>
                <p>Comments you've left on articles</p>
            </div>
            <span class="count-badge">{{ $comments->total() }} total</span>
        </div>

        @forelse($comments as $comment)
        <div class="comment-row">
            <div class="comment-meta">
                @if($comment->post && is_object($comment->post))
                    <a href="{{ route('comments.show', $comment->id) }}" class="article-link">
                        {{ Str::limit($comment->post->title, 60) }}
                    </a>
                @else
                    <span style="font-size:13px; color:var(--slate-light); font-style:italic;">Post no longer available</span>
                @endif

                <div class="comment-quote">
                    "{{ Str::limit($comment->content, 80) }}"
                </div>

                <div class="comment-footer">
                    @php $status = strtolower($comment->status ?? 'pending'); @endphp
                    <span class="status-badge {{ $status === 'approved' ? 'status-approved' : 'status-pending' }}">
                        {{ $status === 'approved' ? '✓ Approved' : '⏳ Pending' }}
                    </span>
                    <span class="comment-date">
                        <i class="bi bi-clock"></i>
                        {{ $comment->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>

            <div class="comment-actions">
                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                      onsubmit="return confirm('Delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" title="Delete comment">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-chat-left-text"></i>
            </div>
            <p>No article comments yet</p>
            <span>Your comments on articles will appear here.</span>
        </div>
        @endforelse

        @if($comments->hasPages())
        <div class="pagination-wrap">
            {{ $comments->links() }}
        </div>
        @endif
    </div>

    {{-- NEWS COMMENTS --}}
    <div class="comments-section section-news">
        <div class="section-head">
            <div class="section-icon">
                <i class="bi bi-broadcast-fill"></i>
            </div>
            <div class="section-head-text">
                <h2>News Comments</h2>
                <p>Comments you've left on news posts</p>
            </div>
            <span class="count-badge">{{ $newsComments->count() }} total</span>
        </div>

        @forelse($newsComments as $comment)
        <div class="comment-row">
            <div class="comment-meta">
                @if($comment->news)
                    <a href="{{ route('news.show', $comment->news->id) }}" class="article-link article-link-news">
                        {{ Str::limit($comment->news->title, 60) }}
                    </a>
                @else
                    <span style="font-size:13px; color:var(--slate-light); font-style:italic;">News post no longer available</span>
                @endif

                <div class="comment-quote">
                    "{{ Str::limit($comment->body, 80) }}"
                </div>

                <div class="comment-footer">
                    <span class="comment-date">
                        <i class="bi bi-clock"></i>
                        {{ $comment->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>

            <div class="comment-actions">
                <form action="{{ route('news.comment.delete', $comment) }}" method="POST"
                      onsubmit="return confirm('Delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" title="Delete comment">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-broadcast"></i>
            </div>
            <p>No news comments yet</p>
            <span>Your comments on news posts will appear here.</span>
        </div>
        @endforelse
    </div>

</div>

@endsection