@extends('layouts.app')
@section('title', 'Content Moderation')
@section('page-title', 'Content Moderation')

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

    .moderation-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 0 60px;
    }

    .page-header {
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

    /* ── Section Cards ── */
    .section-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 24px;
        position: relative;
    }

    .section-card.articles::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        border-radius: 18px 18px 0 0;
    }

    .section-card.news-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #8b5cf6, #0ea5e9);
        border-radius: 18px 18px 0 0;
    }

    .section-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--bg);
    }

    .section-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
    }

    .section-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        background: white;
        border: 1px solid var(--border);
        color: var(--slate);
    }

    /* ── Table ── */
    .table { margin: 0; }

    .table thead th {
        background: var(--white);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--slate);
        padding: 12px 20px;
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

    .title-cell {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--navy);
    }

    .author-cell {
        font-size: 13px;
        color: var(--slate);
        font-weight: 500;
    }

    .status-select {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
        color: var(--navy);
        background: var(--white);
        cursor: pointer;
        transition: border-color 0.2s;
        outline: none;
    }

    .status-select:focus { border-color: var(--blue); }

    .cat-pill {
        display: inline-block;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }

    .stat-cell {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: var(--slate);
    }

    .date-cell {
        font-size: 12.5px;
        color: var(--slate-light);
        white-space: nowrap;
    }

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
        background: #e0f2fe;
        color: #0284c7;
    }

    .action-btn:hover {
        background: #bae6fd;
        color: #0369a1;
        transform: translateY(-2px);
    }

    /* ── Comments clickable ── */
    .comments-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: #0ea5e9;
        text-decoration: none;
        transition: color 0.15s;
    }

    .comments-link:hover { color: #0284c7; }

    /* ── Likes ── */
    .likes-cell {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: #e11d48;
    }

    /* ── Empty ── */
    .empty-state {
        text-align: center;
        padding: 50px 24px;
    }

    .empty-icon-wrap {
        width: 52px; height: 52px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--slate-light);
        margin: 0 auto 14px;
    }

    .empty-state p { font-size: 13px; color: var(--slate); margin: 0; font-weight: 500; }

    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="moderation-page">

    <div class="page-header">
        <span class="page-label">Administration</span>
        <h1 class="page-title">Content Moderation</h1>
    </div>

    {{-- ── ARTICLES TABLE ── --}}
    <div class="section-card articles">
        <div class="section-header">
            <h6 class="section-title">
                <i class="bi bi-file-earmark-text-fill text-primary"></i>
                Articles
            </h6>
            <span class="section-badge">{{ $contents->total() }} total</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                    <tr>
                        <td><span class="title-cell">{{ Str::limit($content->title, 50) }}</span></td>
                        <td><span class="author-cell">{{ $content->user->name }}</span></td>
                        <td>
                            <form action="{{ route('contents.updateStatus', $content) }}"
                                  method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <select name="status" class="status-select"
                                        onchange="this.form.submit()">
                                    <option value="draft"     @selected($content->status === 'draft')>✎ Draft</option>
                                    <option value="published" @selected($content->status === 'published')>✓ Published</option>
                                    <option value="hidden"    @selected($content->status === 'hidden')>⊘ Hidden</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('comments.index', ['content_id' => $content->id]) }}"
                               class="comments-link">
                                <i class="bi bi-chat-dots-fill"></i>
                                {{ $content->comments()->count() }}
                            </a>
                        </td>
                        <td><span class="date-cell">{{ $content->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <a href="{{ route('contents.show', $content) }}"
                               class="action-btn" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <p>No articles found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contents->hasPages())
        <div class="pagination-wrap">{{ $contents->links() }}</div>
        @endif
    </div>

    {{-- ── NEWS TABLE ── --}}
    <div class="section-card news-section">
        <div class="section-header">
            <h6 class="section-title">
                <i class="bi bi-newspaper text-primary"></i>
                News
            </h6>
            <span class="section-badge">{{ $news->total() }} total</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Likes</th>
                        <th>Comments</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $article)
                    <tr>
                        <td><span class="title-cell">{{ Str::limit($article->title, 50) }}</span></td>
                        <td><span class="author-cell">{{ $article->user->name }}</span></td>
                        <td><span class="cat-pill">{{ $article->category }}</span></td>
                        <td>
                            <span class="likes-cell">
                                <i class="bi bi-heart-fill"></i>
                                {{ $article->likes_count }}
                            </span>
                        </td>
                        <td>
                            <span class="stat-cell">
                                <i class="bi bi-chat-dots-fill text-info"></i>
                                {{ $article->comments->count() }}
                            </span>
                        </td>
                        <td><span class="date-cell">{{ $article->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <a href="{{ route('news.show', $article) }}"
                               class="action-btn" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <p>No news found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($news->hasPages())
        <div class="pagination-wrap">{{ $news->links() }}</div>
        @endif
    </div>

</div>
@endsection