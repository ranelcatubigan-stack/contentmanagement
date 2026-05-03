@extends('layouts.app')
@section('title', 'News Feed')
@section('page-title', 'News')

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

    .news-feed {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 860px;
        margin: 0 auto;
        padding-bottom: 60px;
    }

    /* ── Page Header ── */
    .feed-header {
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

    .page-sub {
        font-size: 13px;
        color: var(--slate-light);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-write {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-write:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }

    /* ── News Card ── */
    .news-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 24px;
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        position: relative;
    }

    .news-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        opacity: 0;
        transition: opacity 0.22s;
        z-index: 1;
    }

    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(15,23,42,0.10);
        border-color: #bfdbfe;
    }

    .news-card:hover::before { opacity: 1; }

    /* ── Cover Image ── */
    .news-card-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        display: block;
    }

    .news-card-img-placeholder {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .placeholder-icon {
        width: 56px; height: 56px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--blue);
    }

    /* ── Card Body ── */
    .news-card-body { padding: 26px 30px 22px; }

    .news-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .news-category {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: var(--blue);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 5px 13px;
        border-radius: 20px;
        border: 1px solid #dbeafe;
    }

    .news-date-top {
        font-size: 12px;
        color: var(--slate-light);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .news-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .news-title a {
        text-decoration: none;
        color: inherit;
        transition: color 0.15s;
    }

    .news-title a:hover { color: var(--blue); }

    .news-excerpt {
        color: var(--slate);
        font-size: 0.92rem;
        line-height: 1.75;
        margin-bottom: 18px;
    }

    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 700;
        color: var(--blue);
        text-decoration: none;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        padding: 8px 16px;
        margin-bottom: 18px;
        transition: all 0.18s;
    }

    .read-more-btn:hover {
        background: var(--blue);
        color: white;
        border-color: var(--blue);
        gap: 10px;
    }

    /* ── Meta Row ── */
    .news-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .author-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #0f172a, #334155);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }

    .author-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.2;
    }

    .author-label {
        font-size: 11px;
        color: var(--slate-light);
    }

    .meta-stats {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        flex-wrap: wrap;
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: var(--slate);
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 5px 12px;
    }

    .meta-chip.comment i { color: #06b6d4; }

    .like-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        color: var(--slate);
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 5px 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .like-btn:hover {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #e11d48;
    }

    .like-btn.liked {
        background: #fff1f2;
        border-color: #fda4af;
        color: #e11d48;
    }

    .like-btn i { font-size: 12px; transition: transform 0.15s; }
    .like-btn:hover i, .like-btn.liked i { color: #e11d48; }
    .like-btn:hover i { transform: scale(1.2); }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
    }

    .empty-icon-wrap {
        width: 68px; height: 68px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: var(--slate-light);
        margin: 0 auto 20px;
    }

    .empty-state h5 { font-size: 17px; font-weight: 800; color: var(--navy); margin-bottom: 6px; }
    .empty-state p  { font-size: 13.5px; color: var(--slate); margin: 0; }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 8px;
    }

    .pagination-wrap .pagination .page-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--slate);
        border-color: var(--border);
        border-radius: 9px !important;
        margin: 0 2px;
        padding: 7px 13px;
        background: var(--white);
        transition: all 0.15s;
    }

    .pagination-wrap .pagination .page-item.active .page-link {
        background: var(--navy);
        border-color: var(--navy);
        color: white;
    }

    .pagination-wrap .pagination .page-link:hover {
        background: var(--bg);
        color: var(--navy);
        border-color: var(--border);
    }
</style>
@endsection

@section('content')
<div class="news-feed">

    {{-- Page Header --}}
    <div class="feed-header">
        <div>
            <span class="page-label">Latest Updates</span>
            <h1 class="page-title">News Feed</h1>
            <p class="page-sub">
                <i class="bi bi-broadcast"></i>
                Stay updated with the latest stories
            </p>
        </div>
        @if(Auth::user()->isAuthor() || Auth::user()->isAdmin())
        <a href="{{ route('news.create') }}" class="btn-write">
            <i class="bi bi-plus-lg"></i> Write News
        </a>
        @endif
    </div>

    @forelse($news as $post)
    <div class="news-card" id="news-{{ $post->id }}">

        {{-- Cover Photo --}}
        @if($post->photo)
            <a href="{{ route('news.show', $post) }}">
                <img src="{{ asset('storage/' . $post->photo) }}"
                     alt="{{ $post->title }}"
                     class="news-card-img">
            </a>
        @else
            <div class="news-card-img-placeholder">
                <div class="placeholder-icon">
                    <i class="bi bi-broadcast"></i>
                </div>
            </div>
        @endif

        <div class="news-card-body">

            {{-- Category + Date --}}
            <div class="news-card-top">
                <span class="news-category">
                    <i class="bi bi-tag" style="font-size:10px;"></i>
                    {{ $post->category }}
                </span>
                <span class="news-date-top">
                    <i class="bi bi-clock"></i>
                    {{ $post->created_at->format('M d, Y · g:i A') }}
                </span>
            </div>

            {{-- Title --}}
            <h2 class="news-title">
                <a href="{{ route('news.show', $post) }}">{{ $post->title }}</a>
            </h2>

            {{-- Excerpt --}}
            <p class="news-excerpt">{{ Str::limit($post->body, 200) }}</p>

            {{-- Read More --}}
            <a href="{{ route('news.show', $post) }}" class="read-more-btn">
                Read full story <i class="bi bi-arrow-right"></i>
            </a>

            {{-- Meta Row --}}
            <div class="news-meta">
                <div class="author-avatar">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="author-name">{{ $post->user->name }}</div>
                    <div class="author-label">Author</div>
                </div>

                <div class="meta-stats">
                    <span class="meta-chip comment">
                        <i class="bi bi-chat-dots-fill"></i>
                        {{ $post->comments->count() }}
                    </span>

                    @auth
                    <button class="like-btn {{ $post->isLikedBy(Auth::id()) ? 'liked' : '' }}"
                            onclick="toggleLike({{ $post->id }}, this)"
                            data-news-id="{{ $post->id }}">
                        <i class="bi {{ $post->isLikedBy(Auth::id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        <span class="like-count">{{ $post->likes_count }}</span>
                    </button>
                    @endauth
                </div>
            </div>

        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon-wrap">
            <i class="bi bi-broadcast"></i>
        </div>
        <h5>No news yet</h5>
        <p>Check back later for the latest stories and updates.</p>
    </div>
    @endforelse

    @if($news->hasPages())
    <div class="pagination-wrap">
        {{ $news->links() }}
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
function toggleLike(newsId, btn) {
    fetch(`/news/${newsId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        btn.querySelector('.like-count').textContent = data.likes_count;
        const icon = btn.querySelector('i');
        if (data.liked) {
            btn.classList.add('liked');
            icon.className = 'bi bi-heart-fill';
        } else {
            btn.classList.remove('liked');
            icon.className = 'bi bi-heart';
        }
    });
}
</script>
@endsection