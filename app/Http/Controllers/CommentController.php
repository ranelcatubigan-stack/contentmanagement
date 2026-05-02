<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Pinapakita ang listahan ng comments
    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', compact('comments'));
        
    }

    // PAG-POST NG COMMENT
   public function store(Request $request, $slug = null) 
{
    $request->validate([
        'content_id' => 'required|exists:contents,id',
        'body'       => 'required|string|max:1000',
    ]);

    try {
        Comment::create([
            'user_id'      => Auth::id(),
            'post_id'      => $request->content_id,
            'content'      => $request->body, // ← key fix
            'status'       => 'approved',
            'author_name'  => Auth::user()->name,
            'author_email' => Auth::user()->email,
        ]);
        

        return back()->with('success', 'Comment posted successfully!');

    } catch (\Exception $e) {
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}

    public function show(Comment $comment)
    {
        // I-load din ang post relationship para maipakita kung saan galing ang comment
        $comment->load('post', 'user');

        return view('comments.show', compact('comment'));
    }

    public function spam(Comment $comment)
{
    try {
        $comment->update(['status' => 'spam']);

        return back()->with('success', 'Comment marked as spam.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

public function approve(Comment $comment)
{
    try {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Comment has been approved!');
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

public function subscriberIndex() 
{
    // Article comments
    $comments = Comment::where('user_id', Auth::id())
                ->with(['post' => function($query) {
                    $query->select('id', 'title', 'slug');
                }])
                ->latest()
                ->paginate(10);

    // News comments
    $newsComments = \App\Models\NewsComment::where('user_id', Auth::id())
                ->with('news')
                ->latest()
                ->get();

    return view('subscriber.comments.index', compact('comments', 'newsComments'));
}
/**
 * Reject the specified comment.
 */
public function reject(Comment $comment)
{
    try {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Comment has been rejected.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
    // PAG-DELETE NG COMMENT
    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'editor' || $user->id === $comment->user_id) {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

        abort(403, 'Unauthorized action.');
    }
}