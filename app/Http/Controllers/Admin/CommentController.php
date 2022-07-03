<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:approve-comment')->only(['update']);
        $this->middleware('can:delete-comment')->only(['destroy']);
        $this->middleware('can:show-comments')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query();

        $comments = $comments->orderBy('approved')->paginate(20);
        return view('admin.comments.all', compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->approved = true;
        $comment->update();
        return redirect()->back()->with('message', 'نظر با موفقیت تایید شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('message', 'نظر با موفقیت حذف شد');
    }
}
