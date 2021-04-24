<?php

namespace App\Http;


use App\Http\Controllers\Controller;
use App\Http\Core\Models\Comment;
use App\Http\Core\Models\Ticket;
use App\OrderItem;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $comments = Comment::where('commenter_id', Auth::id())->get();
        return view('user.profile.profile-comments', compact('comments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'takhfif_id' => 'required|numeric|exists:takhfifs,id',
            'comment' => 'required|nullable|max:500',
            'name' => 'required|max:50',
            'title' => 'required|max:50',
        ]);


        if (!auth()->user())
            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'برای ثبت دیدگاه وارد شوید!');


//        $order = OrderItem::where('user_id', auth()->id())->where('takhfif_id', $request->takhfif_id)->first();
//        if ($order == null)
//            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'ثبت نظر و امتیاز فقط برای کالاهای خریداری شده امکان پذیر است!');


        $comment = Comment::where([['commenter_id', auth()->id()], ['commentable_id', $request->takhfif_id]])->get();
        if (count($comment) > 0)
            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'شما قبلا برای این محصول نظر ثبت کرده اید!');


       $comment= Comment::create([
            'commentable_id' => $request->takhfif_id,
            'commenter_id' => auth()->id(),
            'commentable_type' => 'App\Http\Shop\Models\Takhfif',
            'commenter_type' => 'App\Http\Core\Models\User',
            'comment' => $request->comment,
            'title' => $request->title,
            'name' => $request->name,

        ]);


        return JsonResponse::sendJsonResponse(1, 'موفق',
            'از ثبت دیدگاه شما سپاسگزاریم.نظر شما پس از تایید نمایش داده خواهد شد');
    }
    public function update(Request $request,Comment $comment)
    {
        $request->validate([
            'answer' => 'required|nullable|max:500',
        ]);


        if (!auth()->user())
            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'برای ثبت دیدگاه وارد شوید!');


        $comment->update([
            'answer'=>$request->answer,
            'operator_id'=>auth()->id,
            'approved'=>true,
            'answer_time'=>now(),
        ]);


        return JsonResponse::sendJsonResponse(1, 'موفق',
            'از ثبت دیدگاه شما سپاسگزاریم.نظر شما پس از تایید نمایش داده خواهد شد');
    }
}
