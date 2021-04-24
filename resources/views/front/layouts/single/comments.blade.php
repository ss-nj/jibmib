<div class="w-100 d-flex">
    <div class="align-self-center">
        <img class="circle-usr-img" src="{{asset($comment->commenter->image->path)}}"
             alt="" width="40" height='40'>
    </div>
    <div class="comment-content-container p-4 m-2">
        <div class="w-100 row">
            <div class="col-8">
                {!! $comment->comment !!}
            </div>
            <div class="col-4 comment-content-status">
                <div><span class="pr-3"><i class="fa-solid fa-clock"></i></span><span class="pr-3">تاریخ</span><span>
                        {{verta($comment->created_at)->timezone('Asia/Tehran')->format('%d، %B %Y')}}</span>
                </div>
                <div><a class="font-weight-bold text-dark" href="#">پاسخ دهید</a></div>
            </div>
        </div>
    </div>
</div>

<?php //____________ Comment Reply  _______________?>
@if($comment->answer!=null)
    <div class="comment-reply-item ml-md-5">
        <div class="w-100 d-flex">
            <div class="align-self-center">
                <img class="circle-usr-img" src="{{asset($comment->commenter->image->path)}}"
                     alt="" width="40" height='40'>
            </div>
            <div class="comment-content-container p-4 m-2">
                <div class="w-100 row">
                    <div class="col-8">
                        {!! $comment->answer !!}
                    </div>
                    <div class="col-4 comment-content-status">
                        <div><span class="pr-3"><i class="fa-solid fa-clock"></i></span><span
                                class="pr-3">تاریخ</span><span>{{verta($comment->answer_time)->timezone('Asia/Tehran')->format('%d، %B %Y')}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
