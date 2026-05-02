@extends('layouts.app')
@section('title', 'Analytics')
@section('page-title', 'System Analytics')

@section('styles')
<style>
    .analytics-wrap { max-width: 1200px; margin: 0 auto; }

    /* ── Gradient Stat Cards ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        border-radius: 16px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .stat-card .bg-icon {
        position: absolute;
        right: 20px; bottom: 10px;
        font-size: 56px;
        opacity: 0.15;
    }

    .stat-card.blue  { background: linear-gradient(135deg, #1e6fdb, #38b6ff); }
    .stat-card.teal  { background: linear-gradient(135deg, #0d9488, #2dd4bf); }
    .stat-card.rose  { background: linear-gradient(135deg, #be123c, #fb7185); }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        opacity: 0.85;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1;
    }

    /* ── Quick Actions ── */
    .quick-actions-card {
        background: white;
        border-radius: 16px;
        padding: 16px 24px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .quick-label {
        font-weight: 700;
        font-size: 13px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .quick-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        background: white;
        transition: all 0.2s;
    }

    .quick-btn:hover {
        border-color: #0ea5e9;
        color: #0ea5e9;
        background: #f0f9ff;
    }

    /* ── Panel Cards ── */
    .panel-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        height: 100%;
    }

    .panel-header {
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

    /* ── Status Rows ── */
    .status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
    }

    .status-row:last-child { border-bottom: none; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .pill-published { background: #dcfce7; color: #16a34a; }
    .pill-draft     { background: #fef9c3; color: #ca8a04; }
    .pill-hidden    { background: #f1f5f9; color: #64748b; }
    .pill-approved  { background: #dcfce7; color: #16a34a; }
    .pill-pending   { background: #fef9c3; color: #ca8a04; }
    .pill-spam      { background: #fee2e2; color: #dc2626; }

    .status-count {
        font-weight: 700;
        font-size: 15px;
        color: #0f172a;
        background: #f1f5f9;
        padding: 3px 12px;
        border-radius: 20px;
    }

    /* ── Author Rows ── */
    .author-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    .author-row:hover { background: #f8fafc; }
    .author-row:last-child { border-bottom: none; }

    .author-avatar {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        color: white;
        flex-shrink: 0;
    }

    .av-blue   { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
    .av-violet { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
    .av-rose   { background: linear-gradient(135deg, #f43f5e, #e11d48); }
    .av-teal   { background: linear-gradient(135deg, #14b8a6, #0d9488); }
    .av-amber  { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .author-info { flex: 1; min-width: 0; }

    .author-name {
        font-weight: 600;
        font-size: 13px;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .author-role-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .role-admin  { background: #fef3c7; color: #92400e; }
    .role-author { background: #e0f2fe; color: #0284c7; }

    .author-count      { font-weight: 800; font-size: 16px; color: #0f172a; text-align: right; }
    .author-count-sub  { font-size: 10px; color: #94a3b8; text-align: right; }

    @media (max-width: 768px) {
        .stat-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="analytics-wrap">

    {{-- ── STAT CARDS ── --}}
    @php
    $totalPosts    = $contentStats->sum('total');
    $totalComments = $commentStats->sum('total');
    $totalUsers    = \App\Models\User::count();
    $totalNews     = \App\Models\News::count();
    @endphp
    <div class="stat-grid">
        <div class="stat-card blue">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <i class="bi bi-people-fill bg-icon"></i>
        </div>
        <div class="stat-card teal">
            <div class="stat-label">Total Posts</div>
            <div class="stat-value">{{ $totalPosts }}</div>
            <i class="bi bi-file-earmark-text-fill bg-icon"></i>
        </div>
        <div class="stat-card rose">
            <div class="stat-label">Total Comments</div>
            <div class="stat-value">{{ $totalComments }}</div>
            <i class="bi bi-chat-dots-fill bg-icon"></i>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #7c3aed, #a78bfa);">
            <div class="stat-label">Total News</div>
            <div class="stat-value">{{ $totalNews }}</div>
            <i class="bi bi-newspaper bg-icon"></i>
        </div>
    </div>


    {{-- ── TWO COLUMN LAYOUT ── --}}
    <div class="row g-4">

        {{-- LEFT: Content Status + Comment Status --}}
        <div class="col-lg-6 d-flex flex-column gap-4">

            {{-- Content by Status --}}
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title">
                        <i class="bi bi-bar-chart-fill text-primary"></i>
                        Content by Status
                    </h6>
                </div>
                @foreach($contentStats as $stat)
                <div class="status-row">
                    <span class="status-pill
                        @if($stat->status === 'published') pill-published
                        @elseif($stat->status === 'draft') pill-draft
                        @else pill-hidden @endif">
                        <i class="bi
                            @if($stat->status === 'published') bi-check-circle-fill
                            @elseif($stat->status === 'draft') bi-pencil-fill
                            @else bi-eye-slash-fill @endif"></i>
                        {{ ucfirst($stat->status) }}
                    </span>
                    <span class="status-count">{{ $stat->total }}</span>
                </div>
                @endforeach
            </div>

            {{-- Comments by Status --}}
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title">
                        <i class="bi bi-chat-dots-fill text-success"></i>
                        Comments by Status
                    </h6>
                </div>
                @forelse($commentStats as $stat)
                <div class="status-row">
                    <span class="status-pill
                        @if($stat->status === 'approved') pill-approved
                        @elseif($stat->status === 'pending') pill-pending
                        @elseif($stat->status === 'spam') pill-spam
                        @else pill-hidden @endif">
                        <i class="bi
                            @if($stat->status === 'approved') bi-check-circle-fill
                            @elseif($stat->status === 'pending') bi-clock-fill
                            @elseif($stat->status === 'spam') bi-shield-x-fill
                            @else bi-dash-circle @endif"></i>
                        {{ ucfirst($stat->status) }}
                    </span>
                    <span class="status-count">{{ $stat->total }}</span>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No comments yet</div>
                @endforelse
            </div>

        </div>

        {{-- RIGHT: Top Authors --}}
        <div class="col-lg-6">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title">
                        <i class="bi bi-trophy-fill text-warning"></i>
                        Top Authors
                    </h6>
                    <span style="background:#f1f5f9; color:#64748b; font-size:11px;
                                 font-weight:600; padding:3px 10px; border-radius:20px;">
                        Admin & Author only
                    </span>
                </div>
                @php
                    $avatarClasses   = ['av-blue','av-violet','av-rose','av-teal','av-amber'];
                    $filteredAuthors = $topAuthors->whereIn('role', ['admin','author']);
                    $i = 0;
                @endphp
                @forelse($filteredAuthors as $author)
                <div class="author-row">
                    <div class="author-avatar {{ $avatarClasses[$i % count($avatarClasses)] }}">
                        {{ strtoupper(substr($author->name, 0, 1)) }}
                    </div>
                    <div class="author-info">
                        <div class="author-name">{{ $author->name }}</div>
                        <span class="author-role-badge {{ $author->role === 'admin' ? 'role-admin' : 'role-author' }}">
                            {{ ucfirst($author->role) }}
                        </span>
                    </div>
                    <div>
                        <div class="author-count">{{ $author->contents_count }}</div>
                        <div class="author-count-sub">posts</div>
                    </div>
                </div>
                @php $i++; @endphp
                @empty
                <div class="p-4 text-center text-muted">No authors found</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection