@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'User Management')

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

    .users-page {
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
        white-space: nowrap;
    }

    .btn-create:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }

    .users-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        position: relative;
    }

    .users-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #8b5cf6, #3b82f6);
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

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-av {
        width: 36px; height: 36px;
        border-radius: 10px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }

    .av-admin      { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .av-author     { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
    .av-editor     { background: linear-gradient(135deg, #10b981, #059669); }
    .av-subscriber { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .av-default    { background: linear-gradient(135deg, #64748b, #475569); }

    .user-username {
        font-weight: 700;
        font-size: 13px;
        color: var(--navy);
        line-height: 1.2;
    }

    .user-email-sm {
        font-size: 11px;
        color: var(--slate-light);
    }

    .name-cell {
        font-size: 13.5px;
        color: var(--navy);
        font-weight: 500;
    }

    .role-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 11px;
        border-radius: 20px;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .role-admin      { background: #fef3c7; color: #92400e; }
    .role-author     { background: #e0f2fe; color: #0284c7; }
    .role-editor     { background: #dcfce7; color: #15803d; }
    .role-subscriber { background: #f5f3ff; color: #6d28d9; }
    .role-default    { background: #f1f5f9; color: #64748b; }

    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 11px;
        border-radius: 20px;
        letter-spacing: 0.4px;
    }

    .status-active   { background: #dcfce7; color: #15803d; }
    .status-inactive { background: #fee2e2; color: #dc2626; }

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
    .btn-view     { background: #e0f2fe; color: #0284c7; }
    .btn-edit     { background: #fef9c3; color: #ca8a04; }
    .btn-lock     { background: #fef3c7; color: #92400e; }
    .btn-unlock   { background: #dcfce7; color: #15803d; }
    .btn-delete   { background: #fee2e2; color: #dc2626; }
    .btn-view:hover   { background: #bae6fd; color: #0369a1; }
    .btn-edit:hover   { background: #fde68a; color: #92400e; }
    .btn-lock:hover   { background: #fde68a; color: #78350f; }
    .btn-unlock:hover { background: #bbf7d0; color: #166534; }
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

    .empty-state h5 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: var(--slate); }

    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center;
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
</style>
@endsection

@section('content')
<div class="users-page">

    <div class="page-header">
        <div>
            <span class="page-label">Administration</span>
            <h1 class="page-title">Manage Users</h1>
            <p class="page-sub">{{ $users->total() }} user{{ $users->total() !== 1 ? 's' : '' }} total</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-create">
            <i class="bi bi-person-plus-fill"></i> Add User
        </a>
    </div>

    @if(session('success'))
    <div class="alert-success-custom">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    <div class="users-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                        $avClass = match($user->role) {
                            'admin'      => 'av-admin',
                            'author'     => 'av-author',
                            'editor'     => 'av-editor',
                            'subscriber' => 'av-subscriber',
                            default      => 'av-default',
                        };
                        $roleClass = match($user->role) {
                            'admin'      => 'role-admin',
                            'author'     => 'role-author',
                            'editor'     => 'role-editor',
                            'subscriber' => 'role-subscriber',
                            default      => 'role-default',
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-av {{ $avClass }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="user-username">{{ $user->username }}</div>
                                    <div class="user-email-sm">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="name-cell">{{ $user->name }}</span></td>
                        <td>
                            <span class="role-badge {{ $roleClass }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $user->is_active ? '● Active' : '● Inactive' }}
                            </span>
                        </td>
                        <td><span class="date-cell">{{ $user->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('users.show', $user) }}"
                                   class="action-btn btn-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}"
                                   class="action-btn btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                    @if($user->is_active)
                                    <form action="{{ route('users.deactivate', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="action-btn btn-lock" title="Deactivate"
                                                onclick="return confirm('Deactivate this user?')">
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('users.activate', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="action-btn btn-unlock" title="Activate">
                                            <i class="bi bi-unlock-fill"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                          onsubmit="return confirm('Delete this user permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h5>No users found</h5>
                                <p>Add your first user to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection