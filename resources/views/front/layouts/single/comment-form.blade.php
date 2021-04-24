<div class="comment-form-container w-100 mt-4 mb-4 p-4 position-relative">
    <form action="{{route('comment.store')}}" method="post" class="ajax_validate">
        @csrf
        <div class="row">
            <div class="col-md-1 usr-icon text-right"><i class="fas fa-user"></i></div>
            <input type="hidden" autocomplete="false" name="takhfif_id" value="{{$takhfif->id}}">
            <div class="col-md-5"><input class="name" type="text" name="name" placeholder="نام">
                <div class="error_field text-danger"></div></div>
            <div class="col-md-6"><input class="title" type="text" name="title" placeholder="موضوع"> <div class="error_field text-danger"></div></div>
            <textarea autocomplete="false" class="form-control comment" name="comment" id="" cols="30" rows="5" placeholder="متن پیام"></textarea> <div class="error_field text-danger"></div>
            <div class="col-12">
                <input type="submit" class="theme-btn orange-btn float-right mt-5" value="ارسال">
            </div>
        </div>
    </form>
    <img class="footer-side footer-side-right"
         src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}" alt="">
    <img class="footer-side footer-side-left" src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}"
         alt="">
</div>
