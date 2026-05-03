@extends('layouts.app')
@section('title', 'My News')
@section('page-title', 'My News')

@section('styles')
<style>
    :root {
        --navy: #0f172a;
        --navy-soft: #1e293b;
        --blue: #3b82f6;
        --blue-light: #60a5fa;
        --slate: #64748b;
        --slate-light: #94a3b8;
        --border: #e2e8f0;
        --white: #ffffff;
        --bg: #f8fafc;
    }

    .news-page {
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

    .page-sub {
        font-size: 13px;
        color: var(--slate);
        margin: 0;
    }

    .btn-create {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 11px 22px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-create:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }

    .alert-success-custom {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #15803d;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .news-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        position: relative;
    }

    .news-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0ea5e9, #06b6d4);
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
        padding: 16px 20px;
        vertical-align: middle;
        border-color: var(--border);
        font-size: 13.5px;
    }

    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: var(--bg); }

    .news-title-cell {
        font-weight: 700;
        color: var(--navy);
        font-size: 14px;
        line-height: 1.3;
    }

    .category-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 700;
        color: #0284c7;
        background: #e0f2fe;
        border-radius: 20px;
        padding: 3px 10px;
        letter-spacing: 0.3px;
    }

    .stat-cell {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: var(--slate);
        font-weight: 600;
    }

    .date-cell {
        font-size: 12.5px;
        color: var(--slate-light);
        white-space: nowrap;
    }

    .action-group { display: flex; gap: 6px; align-items: center; }

    .action-btn {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        flex-shrink: 0;
    }

    .action-btn:hover { transform: translateY(-2px); }
    .btn-view   { background: #e0f2fe; color: #0284c7; }
    .btn-edit   { background: #fef9c3; color: #ca8a04; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-view:hover   { background: #bae6fd; color: #0369a1; }
    .btn-edit:hover   { background: #fde68a; color: #92400e; }
    .btn-delete:hover { background: #fecaca; color: #b91c1c; }

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

    .empty-state h5 {
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: var(--slate);
        margin-bottom: 20px;
    }

    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="news-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <span class="page-label">News Management</span>
            <h1 class="page-title">My News</h1>
            <p class="page-sub">{{ $news->total() }} post{{ $news->total() !== 1 ? 's' : '' }} total</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn-create">
            <i class="bi bi-plus-lg"></i> Write News
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert-success-custom">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- News Table --}}
    <div class="news-card">
        <div class="table-responsive">
            <table class="table mb-0">
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
                            <span class="news-title-cell">
                                {{ Str::limit($post->title, 55) }}
                            </span>
                        </td>
                        <td>
                            <span class="category-pill">
                                <i class="bi bi-broadcast" style="font-size:9px;"></i>
                                {{ $post->category }}
                            </span>
                        </td>
                        <td>
                            <span class="stat-cell">
                                <i class="bi bi-heart-fill text-danger" style="font-size:12px;"></i>
                                {{ $post->likes_count }}
                            </span>
                        </td>
                        <td>
                            <span class="stat-cell">
                                <i class="bi bi-chat-dots-fill text-info" style="font-size:12px;"></i>
                                {{ $post->comments->count() }}
                            </span>
                        </td>
                        <td>
                            <span class="date-cell">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('news.show', $post) }}"
                                   class="action-btn btn-view" title="View post">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('news.edit', $post) }}"
                                   class="action-btn btn-edit" title="Edit post">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('news.destroy', $post) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Delete this news post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete post">
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
                                    <i class="bi bi-broadcast"></i>
                                </div>
                                <h5>No news posts yet</h5>
                                <p>Start writing and publish your first news post.</p>
                                <a href="{{ route('news.create') }}" class="btn-create">
                                    <i class="bi bi-plus-lg"></i> Write First News
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($news->hasPages())
        <div class="pagination-wrap">
            {{ $news->links() }}
        </div>
        @endif
    </div>

</div>
@endsection