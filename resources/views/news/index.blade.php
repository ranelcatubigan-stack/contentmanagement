@extends('layouts.app')
@section('title', 'News Feed')
@section('page-title', 'News')

@section('styles')
<style>
    .news-feed { max-width: 860px; margin: 0 auto; }

    .news-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        margin-bottom: 32px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .news-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,0.10); }

    .news-card-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
    }

    .news-card-img-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38bdf8;
        font-size: 4rem;
    }

    .news-card-body { padding: 28px 32px; }

    .news-category {
        display: inline-block;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 14px;
    }

    .news-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .news-title a { text-decoration: none; color: inherit; }
    .news-title a:hover { color: #0284c7; }

    .news-excerpt {
        color: #64748b;
        font-size: 0.97rem;
        line-height: 1.75;
        margin-bottom: 24px;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #94a3b8;
        flex-wrap: wrap;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .author-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    .like-btn {
        background: none;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        margin-left: auto;
    }

    .like-btn:hover { border-color: #f43f5e; color: #f43f5e; }
    .like-btn.liked { border-color: #f43f5e; color: #f43f5e; background: #fff1f2; }
    .like-btn.liked i { color: #f43f5e; }

    .read-more-btn {
        color: #0284c7;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.2s;
    }

    .read-more-btn:hover { gap: 10px; }
</style>
@endsection

@section('content')
<div class="news-feed">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Latest News</h4>
            <p class="text-muted mb-0" style="font-size:14px;">Stay updated with the latest stories</p>
        </div>
    </div>

    @forelse($news as $post)
    <div class="news-card" id="news-{{ $post->id }}">

        {{-- Cover Photo --}}
        @if($post->photo)
            <a href="{{ route('news.show', $post) }}">
                <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="news-card-img">
            </a>
        @else
            <div class="news-card-img-placeholder">
                <i class="bi bi-broadcast"></i>
            </div>
        @endif

        <div class="news-card-body">
            <span class="news-category">{{ $post->category }}</span>

            <h2 class="news-title">
                <a href="{{ route('news.show', $post) }}">{{ $post->title }}</a>
            </h2>

            <p class="news-excerpt">{{ Str::limit($post->body, 220) }}</p>

            <a href="{{ route('news.show', $post) }}" class="read-more-btn mb-4 d-inline-flex">
                Read full story <i class="bi bi-arrow-right"></i>
            </a>

            <div class="news-meta">
                <div class="author-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                <div>
                    <span class="fw-semibold text-dark">{{ $post->user->name }}</span>
                    <span class="d-block" style="font-size:11px;">{{ $post->created_at->format('M d, Y · g:i A') }}</span>
                </div>

                <span class="ms-2">
                    <i class="bi bi-chat-fill text-info"></i>
                    {{ $post->comments->count() }} comment(s)
                </span>

                {{-- Like Button --}}
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
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-broadcast" style="font-size:3rem; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
        <h5 style="color:#475569;">No news posts yet</h5>
        <p>Check back later for updates!</p>
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $news->links() }}
    </div>

</div>
@endsection

@section('scripts')
<script>
function toggleLike(newsId, btn) {
    fetch(`/news/${newsId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                         || '{{ csrf_token() }}',
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