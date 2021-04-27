@extends('front.layouts.master')

@section('title')مشاهده تیکت@endsection

@section('content')



    <article class="w-100 position-relative">
        <section class="small-content-container cart-container mb-5">

            <!-- _______________________ Profile Title Section ___________________ -->

            <div class=" ticket-section  mt-5 p-2">
                <div class="row">
                    <!-- Ticket-->
                    <div class="col-lg-12 pb-5">
                        <h2 class="h5 text-center text-right">{{ $ticket->title }}</h2>
                        <div class="d-sm-flex justify-content-between bg-secondary py-3 mb-3 text-white">
                            <div class="p-2 w-100 text-center"><strong class="d-block mb-1">تاریخ ارسال شده</strong><span>{{ verta($ticket->created_at)->format('Y/m/d') }}</span></div>
                            <div class="py-2 w-100 text-center"><strong class="d-block mb-1">تاریخ پاسخ</strong><span>{{ $ticket->status!==0 ?  : 'در انتظار پاسخ' }}</span></div>
                            <div class="py-2 w-100 text-center"><strong class="d-block mb-1">وضعیت</strong>
                                <span class="badge badge-{{ $ticket->answer_time != null ? 'success' : 'danger' }}">
                            {{ $ticket->answer_time != null ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}
                        </span>
                            </div>
                        </div>

                        <div class="blockquote comment mb-4">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <div class="testimonial-footer">
                                    </div>
                                    <div class="d-table-cell align-middle pl-2">
                                        <div class="blockquote-footer">{{ $ticket->user->full_name }}
                                                <cite>{{ verta($ticket->created_at)->format('%A, %d %B %Y ساعت H:i') }}</cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blockquote comment">
                                <p>{{ $ticket->title }}</p>
                                @foreach($ticket->messages as $message)
                                    <div class="testimonial-footer">
                                        </div>
                                        <div class="d-table-cell align-middle pl-2">
                                            <div class="blockquote-footer"> {{$ticket->from_admin?'پشتیبانی': $ticket->user->full_name}}
                                                <cite> {{ verta($message->created_at)->format('%A, %d %B %Y ساعت H:i' ) }}</cite>
                                            </div>
                                            <blockquote>{{ $message->body }}</blockquote>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    <form class="needs-validation col-sm-12  ajax_validate" action="{{route('user.messages.store',$ticket->id)}}" method="post"
                          id="open-ticket" tabindex="-1">
                        {{ csrf_field() }}
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">پاسخ به تیکت</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true"></span></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">ما بطور معمول تیکت ها را ظرف 2 روز کاری پاسخ می دهیم.</p>
                                    <div class="form-group">
                                        <label for="ticket-description">متن پیام</label>
                                        <textarea class="form-control body" name="body" id="" rows="5"></textarea>
                                        <div class="error_field text-danger"></div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                    </div>
                </div>
            </div><!-- .ticket-section -->


        </section>
    </article>

@endsection

