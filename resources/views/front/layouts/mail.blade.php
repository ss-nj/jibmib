<div class="w-100 p-sm-5 p-1 mb-5">
    <div class="news-form-container bg-white">
        <form action="{{route('newsletter.join')}}" class="ajax_validate" method="post">
            @csrf
            <span class="col-4 news-form-title">اشتراک در خبرنامه</span>
            <span class="col-6"><input type="text" name="email_address" class="email_address" placeholder="ایمیل">
                      <span class="col-12 error_field text-danger"></span>
  </span>
            <span class="col-2 "><input type="submit" value="ثبت"></span>
        </form>
    </div>
</div>

