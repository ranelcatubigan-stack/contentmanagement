@extends('layouts.app')
@section('title', 'Analytics')
@section('page-title', 'System Analytics')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');

    .analytics-wrap {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* ── Section Label ── */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* ── Panel ── */
    .panel {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .panel-count {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #64748b;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* ── Big Metric Cards ── */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .metric-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .metric-card .m-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
    }

    .metric-card .m-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .metric-card .m-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }

    .metric-card .m-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 6px;
    }

    .mc-blue  .m-icon { background: #eff6ff; color: #2563eb; }
    .mc-teal  .m-icon { background: #f0fdfa; color: #0d9488; }
    .mc-rose  .m-icon { background: #fff1f2; color: #e11d48; }
    .mc-violet .m-icon { background: #f5f3ff; color: #7c3aed; }

    .mc-blue  { border-top: 3px solid #2563eb; }
    .mc-teal  { border-top: 3px solid #0d9488; }
    .mc-rose  { border-top: 3px solid #e11d48; }
    .mc-violet { border-top: 3px solid #7c3aed; }

    /* ── Rank Rows ── */
    .rank-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    .rank-row:hover { background: #f8fafc; }
    .rank-row:last-child { border-bottom: none; }

    .rank-num {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        font-weight: 700;
        color: #cbd5e1;
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .rank-num.top { color: #f59e0b; }

    .rank-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        color: white;
        flex-shrink: 0;
    }

    .av-1 { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
    .av-2 { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
    .av-3 { background: linear-gradient(135deg, #f43f5e, #e11d48); }
    .av-4 { background: linear-gradient(135deg, #14b8a6, #0d9488); }
    .av-5 { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .rank-info { flex: 1; min-width: 0; }

    .rank-name {
        font-weight: 600;
        font-size: 13px;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rank-meta {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 1px;
    }

    .rank-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .badge-admin  { background: #fef3c7; color: #92400e; }
    .badge-author { background: #e0f2fe; color: #0284c7; }

    .rank-stat {
        text-align: right;
        flex-shrink: 0;
    }

    .rank-stat-val {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 15px;
        color: #0f172a;
    }

    .rank-stat-label {
        font-size: 10px;
        color: #94a3b8;
    }

    /* ── Progress Bar ── */
    .progress-row {
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
    }

    .progress-row:last-child { border-bottom: none; }

    .progress-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .progress-label {
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .progress-val {
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .progress-bar-wrap {
        height: 6px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.8s ease;
    }

    /* ── News Engagement Row ── */
    .news-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    .news-row:hover { background: #f8fafc; }
    .news-row:last-child { border-bottom: none; }

    .news-cat {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        background: #e0f2fe;
        color: #0284c7;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .news-title {
        flex: 1;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-stats {
        display: flex;
        gap: 16px;
        flex-shrink: 0;
    }

    .news-stat {
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    /* ── Comment Health ── */
    .health-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
    }

    .health-item {
        padding: 20px;
        text-align: center;
        border-right: 1px solid #f1f5f9;
    }

    .health-item:last-child { border-right: none; }

    .health-val {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 4px;
    }

    .health-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .metric-grid { grid-template-columns: repeat(2, 1fr); }
        .health-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="analytics-wrap">

    @php
        $totalPosts    = $contentStats->sum('total');
        $totalComments = $commentStats->sum('total');
        $totalUsers    = \App\Models\User::count();
        $totalNews     = \App\Models\News::count();

        $approvedComments = $commentStats->where('status', 'approved')->first()->total ?? 0;
        $pendingComments  = $commentStats->where('status', 'pending')->first()->total ?? 0;
        $spamComments     = $commentStats->where('status', 'spam')->first()->total ?? 0;
        $approvalRate     = $totalComments > 0 ? round(($approvedComments / $totalComments) * 100) : 0;

        $topNewsItems = \App\Models\News::with(['user', 'comments'])
            ->withCount('comments')
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();

        $topCommentedArticles = \App\Models\Content::withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(5)
            ->get();

        $filteredAuthors = $topAuthors->whereIn('role', ['admin','author']);
        $maxPosts = $filteredAuthors->max('contents_count') ?: 1;

        $avatarClasses = ['av-1','av-2','av-3','av-4','av-5'];
    @endphp

    {{-- ── METRIC CARDS ── --}}
    <div class="section-label"><span>Overview</span></div>
    <div class="metric-grid mb-4">
        <div class="metric-card mc-blue">
            <div class="m-icon"><i class="bi bi-people-fill"></i></div>
            <div class="m-label">Total Users</div>
            <div class="m-value">{{ $totalUsers }}</div>
            <div class="m-sub">Across all roles</div>
        </div>
        <div class="metric-card mc-teal">
            <div class="m-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="m-label">Total Articles</div>
            <div class="m-value">{{ $totalPosts }}</div>
            <div class="m-sub">{{ $contentStats->where('status','published')->first()->total ?? 0 }} published</div>
        </div>
        <div class="metric-card mc-rose">
            <div class="m-icon"><i class="bi bi-chat-dots-fill"></i></div>
            <div class="m-label">Total Comments</div>
            <div class="m-value">{{ $totalComments }}</div>
            <div class="m-sub">{{ $approvalRate }}% approval rate</div>
        </div>
        <div class="metric-card mc-violet">
            <div class="m-icon"><i class="bi bi-newspaper"></i></div>
            <div class="m-label">Total News</div>
            <div class="m-value">{{ $totalNews }}</div>
            <div class="m-sub">{{ $topNewsItems->sum('likes_count') }} total likes</div>
        </div>
    </div>

    {{-- ── ROW 1: Authors Leaderboard + Comment Health ── --}}
    <div class="section-label"><span>Performance</span></div>
    <div class="row g-3 mb-3">

        {{-- Authors Leaderboard --}}
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-head">
                    <h6 class="panel-title">
                        <i class="bi bi-trophy-fill text-warning"></i>
                        Authors Leaderboard
                    </h6>
                    <span class="panel-count">Top {{ $filteredAuthors->count() }}</span>
                </div>
                @forelse($filteredAuthors as $i => $author)
                <div class="rank-row">
                    <span class="rank-num {{ $i === 0 ? 'top' : '' }}">#{{ $i + 1 }}</span>
                    <div class="rank-avatar {{ $avatarClasses[$i % 5] }}">
                        {{ strtoupper(substr($author->name, 0, 1)) }}
                    </div>
                    <div class="rank-info">
                        <div class="rank-name">{{ $author->name }}</div>
                        <span class="rank-badge {{ $author->role === 'admin' ? 'badge-admin' : 'badge-author' }}">
                            {{ ucfirst($author->role) }}
                        </span>
                    </div>
                    <div class="rank-stat">
                        <div class="rank-stat-val">{{ $author->contents_count }}</div>
                        <div class="rank-stat-label">articles</div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No authors yet</div>
                @endforelse
            </div>
        </div>

        {{-- Comment Health + Content Breakdown --}}
        <div class="col-lg-6 d-flex flex-column gap-3">

            {{-- Comment Health --}}
            <div class="panel">
                <div class="panel-head">
                    <h6 class="panel-title">
                        <i class="bi bi-heart-pulse-fill text-danger"></i>
                        Comment Health
                    </h6>
                    <span class="panel-count">{{ $approvalRate }}% healthy</span>
                </div>
                <div class="health-grid">
                    <div class="health-item">
                        <div class="health-val" style="color:#16a34a;">{{ $approvedComments }}</div>
                        <div class="health-label">Approved</div>
                    </div>
                    <div class="health-item">
                        <div class="health-val" style="color:#ca8a04;">{{ $pendingComments }}</div>
                        <div class="health-label">Pending</div>
                    </div>
                    <div class="health-item">
                        <div class="health-val" style="color:#dc2626;">{{ $spamComments }}</div>
                        <div class="health-label">Spam</div>
                    </div>
                </div>
            </div>

            {{-- Content Breakdown --}}
            <div class="panel">
                <div class="panel-head">
                    <h6 class="panel-title">
                        <i class="bi bi-bar-chart-fill text-primary"></i>
                        Content Breakdown
                    </h6>
                </div>
                @foreach($contentStats as $stat)
                @php
                    $pct = $totalPosts > 0 ? round(($stat->total / $totalPosts) * 100) : 0;
                    $colors = ['published' => '#16a34a', 'draft' => '#ca8a04', 'hidden' => '#94a3b8'];
                    $color = $colors[$stat->status] ?? '#94a3b8';
                @endphp
                <div class="progress-row">
                    <div class="progress-top">
                        <span class="progress-label">
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $color }};display:inline-block;"></span>
                            {{ ucfirst($stat->status) }}
                        </span>
                        <span class="progress-val">{{ $stat->total }} <span style="color:#94a3b8;font-size:11px;">({{ $pct }}%)</span></span>
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill" style="width:{{ $pct }}%; background:{{ $color }};"></div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- ── ROW 2: Most Commented Articles + News Engagement ── --}}
    <div class="section-label"><span>Engagement</span></div>
    <div class="row g-3 mb-3">

        {{-- Most Commented Articles --}}
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-head">
                    <h6 class="panel-title">
                        <i class="bi bi-chat-square-dots-fill text-info"></i>
                        Most Commented Articles
                    </h6>
                </div>
                @forelse($topCommentedArticles as $i => $article)
                <div class="rank-row">
                    <span class="rank-num {{ $i === 0 ? 'top' : '' }}">#{{ $i + 1 }}</span>
                    <div class="rank-info">
                        <div class="rank-name">{{ Str::limit($article->title, 45) }}</div>
                        <div class="rank-meta">{{ $article->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="rank-stat">
                        <div class="rank-stat-val" style="color:#0ea5e9;">{{ $article->comments_count }}</div>
                        <div class="rank-stat-label">comments</div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No articles yet</div>
                @endforelse
            </div>
        </div>

        {{-- News Engagement --}}
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-head">
                    <h6 class="panel-title">
                        <i class="bi bi-fire text-danger"></i>
                        Top News by Engagement
                    </h6>
                </div>
                @forelse($topNewsItems as $i => $news)
                <div class="rank-row">
                    <span class="rank-num {{ $i === 0 ? 'top' : '' }}">#{{ $i + 1 }}</span>
                    <div class="rank-info">
                        <div class="rank-name">{{ Str::limit($news->title, 35) }}</div>
                        <div class="rank-meta">by {{ $news->user->name }}</div>
                    </div>
                    <div class="news-stats">
                        <div class="news-stat">
                            <i class="bi bi-heart-fill text-danger"></i>
                            {{ $news->likes_count }}
                        </div>
                        <div class="news-stat">
                            <i class="bi bi-chat-fill text-info"></i>
                            {{ $news->comments_count }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No news yet</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── ROW 3: Users by Role ── --}}
    <div class="section-label"><span>Users</span></div>
    <div class="panel mb-4">
        <div class="panel-head">
            <h6 class="panel-title">
                <i class="bi bi-people-fill text-primary"></i>
                Users by Role
            </h6>
            <span class="panel-count">{{ $totalUsers }} total</span>
        </div>
        <div class="row g-0">
            @php
                $roleColors = [
                    'admin'      => ['bg' => '#fef3c7', 'color' => '#92400e', 'bar' => '#f59e0b'],
                    'author'     => ['bg' => '#e0f2fe', 'color' => '#0284c7', 'bar' => '#0ea5e9'],
                    'editor'     => ['bg' => '#f0fdf4', 'color' => '#166534', 'bar' => '#22c55e'],
                    'subscriber' => ['bg' => '#f5f3ff', 'color' => '#6d28d9', 'bar' => '#8b5cf6'],
                    'creator'    => ['bg' => '#fff7ed', 'color' => '#9a3412', 'bar' => '#f97316'],
                ];
            @endphp
            @foreach($userStats as $stat)
            @php
                $pct = $totalUsers > 0 ? round(($stat->total / $totalUsers) * 100) : 0;
                $rc = $roleColors[$stat->role] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','bar'=>'#94a3b8'];
            @endphp
            <div class="col-md-6">
                <div class="progress-row">
                    <div class="progress-top">
                        <span class="progress-label">
                            <span style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};
                                         padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;">
                                {{ ucfirst($stat->role) }}
                            </span>
                        </span>
                        <span class="progress-val">{{ $stat->total }} <span style="color:#94a3b8;font-size:11px;">({{ $pct }}%)</span></span>
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill" style="width:{{ $pct }}%;background:{{ $rc['bar'] }};"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection