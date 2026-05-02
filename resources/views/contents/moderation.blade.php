@extends('layouts.app')
@section('title', 'Content Moderation')
@section('page-title', 'Content Moderation')

@section('content')
<div class="container-fluid">

    {{-- ================================ --}}
    {{-- TABLE 1: ARTICLES               --}}
    {{-- ================================ --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-file-earmark-text me-2"></i> Articles
            </h5>
            <span class="badge bg-white text-primary">{{ $contents->total() }} total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                            <td>{{ Str::limit($content->title, 50) }}</td>
                            <td>{{ $content->user->name }}</td>
                            <td>
                                <form action="{{ route('contents.updateStatus', $content) }}"
                                      method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <select name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                        <option value="draft"
                                            @selected($content->status === 'draft')>Draft</option>
                                        <option value="published"
                                            @selected($content->status === 'published')>Published</option>
                                        <option value="hidden"
                                            @selected($content->status === 'hidden')>Hidden</option>
                                    </select>
                                </form>
                            </td>
                            {{-- Comments count --}}
                            <td>
                                <a href="{{ route('comments.index', ['content_id' => $content->id]) }}"
                                   class="d-flex align-items-center gap-1 text-decoration-none text-info">
                                    <i class="bi bi-chat-dots-fill"></i>
                                    <strong>{{ $content->comments()->count() }}</strong>
                                </a>
                            </td>
                            <td>{{ $content->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('contents.show', $content) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-file-earmark-text d-block fs-2 mb-2 opacity-25"></i>
                                No articles found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $contents->links() }}
        </div>
    </div>

    {{-- ================================ --}}
    {{-- TABLE 2: NEWS                   --}}
    {{-- ================================ --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #0ea5e9, #2563eb);">
            <h5 class="mb-0 text-white">
                <i class="bi bi-newspaper me-2"></i> News
            </h5>
            <span class="badge bg-white text-primary">{{ $news->total() }} total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                            <td>{{ Str::limit($article->title, 50) }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <span class="badge"
                                      style="background:#e0f2fe; color:#0284c7;">
                                    {{ $article->category }}
                                </span>
                            </td>
                            {{-- Likes --}}
                            <td>
                                <span class="d-flex align-items-center gap-1 text-danger">
                                    <i class="bi bi-heart-fill"></i>
                                    <strong>{{ $article->likes_count }}</strong>
                                </span>
                            </td>
                            {{-- Comments --}}
                            <td>
                                <span class="d-flex align-items-center gap-1 text-info">
                                    <i class="bi bi-chat-dots-fill"></i>
                                    <strong>{{ $article->comments->count() }}</strong>
                                </span>
                            </td>
                            <td>{{ $article->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('news.show', $article) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-newspaper d-block fs-2 mb-2 opacity-25"></i>
                                No news found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $news->links() }}
        </div>
    </div>

</div>
@endsection