<?php

namespace Modules\Blog\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Modules\Blog\app\Models\BlogComment;

class BlogCommentController extends Controller
{

    use RedirectHelperTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        checkAdminHasPermissionAndThrowException('blog.comment.view');
        Paginator::useBootstrap();

        $comments = BlogComment::with('parent')->latest()->paginate(15);
        return view('blog::Comment.index', compact('comments'));
    }

    public function show($id)
    {
        checkAdminHasPermissionAndThrowException('blog.comment.view');
        $comments = BlogComment::where('blog_id', $id)->paginate(20);
        return view('blog::Comment.show', compact('comments'));
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('blog.comment.delete');
        BlogComment::findOrFail($id)?->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.blog-comment.index');
    }

    public function statusUpdate($id)
    {
        checkAdminHasPermissionAndThrowException('blog.comment.update');
        $blogCategory = BlogComment::find($id);
        if ($blogCategory) {
            $status = $blogCategory->status == 1 ? 0 : 1;
            $blogCategory->update(['status' => $status]);

            $notification = __('Updated Successfully');

            return response()->json([
                'success' => true,
                'message' => $notification,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Failed!'),
        ]);
    }

    public function reply(Request $request)
    {

        $comment = BlogComment::find($request->comment_id);

        $blog_id = $comment->blog_id;
        $comment->status = 1;
        checkAdminHasPermissionAndThrowException('blog.comment.reply');
        $data = request()->all();
        $data['status'] = 1;
        $data['parent_id'] = $request->comment_id;
        $data['blog_id'] = $blog_id;
        $data['comment'] = $request->reply;
        $data['name'] = auth('admin')->user()->name;
        $data['email'] = auth('admin')->user()->email;

        BlogComment::create($data);

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.blog-comment.show', ['blog_comment' => $blog_id], [
            'message' => 'Reply Successfully!',
            'alert-type' => 'success'
        ]);
    }
}
