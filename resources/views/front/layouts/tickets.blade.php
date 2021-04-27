<div class="ticket-section card-section mt-5 p-2">

    <div class="cart-item">
        <div class="d-sm-flex">

            {{--            <a > <div class="align-self-center theme-btn green-btn ml-auto"><span><i--}}
            {{--                            class="fa-regular fa-print"></i> </span>درخواست پشتیبانی جدید--}}
            {{--                </div></a>--}}

            {{--            <a href="" data-toggle="modal" class="align-self-center theme-btn green-btn ml-auto"--}}
            {{--               data-target="#role-permissions">--}}
            {{--                    <span><i class="fa-regular "></i></span>درخواست پشتیبانی جدید--}}
            {{--            </a>--}}

            <button class="align-self-center theme-btn green-btn ml-auto " data-toggle="modal"
                    data-target="#open-ticket">
                تیکت جدید
            </button>
        </div>
        <hr>
    </div><!-- .cart-item -->

    @foreach($tickets as $ticket)
        <div class=" ticket-section card-section mt-5 p-2">
            <div class="cart-item">
                <div class="d-sm-flex">
                    <div class="off-item-title d-flex flex-column">
                        <div class="p-2">

                            تاریخ ثیت
                            {{verta($ticket->created_at)->timezone('Asia/Tehran')->format('Y/m/d')}}
                        </div>
                        <div class="d-flex p-2 mt-auto">
                            <div>
                                <span>عنوان تیکت: </span>
                                <span>{{$ticket->title}}</span>
                            </div>

                        </div>
                    </div>

                </div>
                <hr>
                <div class="off-item-title d-flex flex-column">
                    <div class="off-item-title d-flex flex-column">
                        <div>
                            <span>متن پیام: </span>
                            <blockquote>{!! $ticket->messages[0]->body!!}</blockquote>
                        </div>
                    </div>
                    <div class="off-item-title d-flex flex-column">
                        <div>
                                <span>آخرین پیام: </span>
                                @if($ticket->messages->count()>1)

                                <blockquote>{!!$ticket->messages->last()->body!!}</blockquote>
                            @endif
                        </div>
                    </div>
                    <a href="{{route('user.tickets.show',$ticket->id)}}" class="align-self-center theme-btn green-btn ml-auto " >
                        مشاهده ی تیکت
                    </a>
                </div>
            </div>
        </div><!-- .ticket-section -->
    @endforeach
</div><!-- .ticket-section -->


<form class="needs-validation modal fade ajax_validate" action="{{route('user.tickets.store')}}" method="post"
      id="open-ticket" tabindex="-1">
    {{ csrf_field() }}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ثبت یک تیکت جدید</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">ما بطور معمول تیکت ها را ظرف 2 روز کاری پاسخ می دهیم.</p>
                <div class="form-group">
                    <label for="ticket-subject">موضوع</label>
                    <input class="form-control title" name="title" type="text">
                    <div class="error_field text-danger"></div>

                </div>
                <div class="form-group">
                    <label for="ticket-description">توضیحات</label>
                    <textarea class="form-control body" name="body" id="" rows="5"></textarea>
                    <div class="error_field text-danger"></div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
            </div>
        </div>
    </div>
</form>



