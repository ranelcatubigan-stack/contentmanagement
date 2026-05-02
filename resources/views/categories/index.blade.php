@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Manage Categories')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Categories</h4>
            <p class="text-muted mb-0" style="font-size:14px;">{{ $categories->total() }} categories total</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><code style="color:#e11d48; background:#fff1f2; padding:2px 8px; border-radius:6px; font-size:12px;">{{ $category->slug }}</code></td>
                        <td>
                            <span class="badge bg-primary rounded-pill">{{ $category->contents_count }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                {{-- VIEW button — shows published posts in this category --}}
                                <a href="{{ route('categories.show', $category) }}"
                                   class="btn btn-sm btn-outline-info rounded-pill px-3"
                                   title="View posts in this category">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                                {{-- EDIT button --}}
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                   title="Edit category">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                {{-- DELETE button --}}
                                <form action="{{ route('categories.destroy', $category) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger rounded-pill px-2"
                                            title="Delete"
                                            {{ $category->contents_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-folder-x" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                            No categories found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="d-flex justify-content-center py-4 border-top">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.table thead th {
    background: #f8fafc;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #64748b;
    padding: 14px 16px;
    border: none;
}
.table tbody td {
    padding: 14px 16px;
    border-color: #f1f5f9;
}
</style>
@endsection