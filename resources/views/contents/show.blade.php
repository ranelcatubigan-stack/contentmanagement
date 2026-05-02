@extends('layouts.app')

@section('title', $content->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            {{-- 1. POST HEADER & CONTENT --}}
            <article class="mb-5">
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1">{{ $content->title }}</h1>
                    <div class="text-muted fst-italic mb-2 d-flex align-items-center gap-3 flex-wrap">
                        <span>Posted on {{ $content->created_at->format('M d, Y') }} by {{ $content->user->name ?? 'Author' }}</span>
                        <span class="d-flex align-items-center gap-1" style="font-style:normal;">
                            <i class="bi bi-eye-fill text-primary"></i>
                            <strong>{{ number_format($viewCount) }}</strong>
                            {{ $viewCount == 1 ? 'view' : 'views' }}
                        </span>
                    </div>
                    
                    {{-- Category & Tags --}}
                    @if($content->category)
                        <span class="badge bg-primary text-decoration-none link-light">
                            {{ $content->category->name }}
                        </span>
                    @endif
                    
                    @foreach($content->tags as $tag)
                        <span class="badge bg-secondary text-decoration-none link-light">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </header>

                {{-- Featured Image --}}
                @if($content->featured_image)
                    <figure class="mb-4">
                        <img class="img-fluid rounded shadow-sm w-100" src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" />
                    </figure>
                @endif

                {{-- Main Article Body --}}
                <section class="mb-5 leading-relaxed" style="font-size: 1.1rem; line-height: 1.8;">
                    {!! $content->body !!}
                </section>
            </article>

            <hr class="my-5">

            {{-- 2. COMMENT FORM SECTION --}}
            <section class="mb-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Post a Comment</h4>
                
                @auth
                    <div class="card border-0 shadow-sm bg-light rounded-4">
                        <div class="card-body p-4">
                            {{-- Validation & Success Alerts --}}
                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success border-0 shadow-sm mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="/posts/{{ $content->slug }}/comments" method="POST">
                                @csrf
                                {{-- Link to Content --}}
                                <input type="hidden" name="content_id" value="{{ $content->id }}">

                                <div class="form-group mb-3">
                                    <textarea name="body" class="form-control" rows="3" placeholder="Add a comment..." required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Post Comment</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info border-0 shadow-sm rounded-4 p-4 text-center">
                        <i class="bi bi-lock-fill fs-3 mb-2 d-block"></i>
                        Please <a href="{{ route('login') }}" class="fw-bold text-decoration-none">login</a> to join the conversation.
                    </div>
                @endauth
            </section>

            {{-- 3. COMMENTS DISPLAY LIST --}}
            <section>
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Comments ({{ $content->comments()->where('status', 'approved')->count() }})
                </h4>

                @forelse($content->comments()->where('status', 'approved')->get() as $comment)
    <div class="d-flex mb-4 p-3 bg-white border rounded-3 shadow-sm">
        <div class="flex-shrink-0">
            <img class="rounded-circle border" 
                 src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'User') }}&background=random" 
                 alt="..." width="50">
        </div>
        <div class="ms-3 w-100">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">{{ $comment->user->name ?? 'Anonymous' }}</h6>
                <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="mt-2 text-dark">
                {{ $comment->content }}
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-chat-square-dots fs-1 mb-3 d-block opacity-25"></i>
        No comments yet. Be the first to share your thoughts!
    </div>
@endforelse
            </section>

            {{-- 4. THE BACK BUTTON FIX --}}
            <div class="mt-5 text-center">
                {{-- Kung hindi ka sure sa route name, gamitin ang url('/') o itama ang route name --}}
              <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill px-4">
    <i class="bi bi-arrow-left me-1"></i> Back to List
</a>


            </div>

        </div>
    </div>
</div>

<style>
    .leading-relaxed img { max-width: 100%; height: auto; border-radius: 8px; }
    .badge { padding: 0.5em 0.8em; margin-right: 5px; }
    .card-body textarea:focus { border: 1px solid #0d6efd !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important; }
</style>
@endsection