@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="small-content-container cart-container mb-5">

            <!-- _______________________ Profile Title Section ___________________ -->

            <div class=" ticket-section card-section mt-5 p-2">
                <main class="main-content dt-sl mt-4 mb-3">
                    <div class="container main-container">
                        <div class="row">
                            <!-- Start Sidebar -->
                        <!-- End Sidebar -->


                            <!-- Start Content -->
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

                                <div class="row">
                                    <div class="col-12">
                                        <div
                                            class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                                            <h2>تیکت ها</h2>
                                        </div>
                                        @if(count($tickets)>0)
                                            <div class="dt-sl">
                                                <div class="text-left" style="margin-bottom: 1%">
                                                    <button class="btn " style="background-color: #00BFD6; color: white;" data-toggle="modal" data-target="#open-ticket">ثبت
                                                        تیکت جدید
                                                    </button>
                                                </div>
                                                <div class="table-responsive" >
                                                    <table class="table table-order">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>موضوع تیکت</th>
                                                            <th>تاریخ ارسال شده</th>
                                                            <th>تاریخ پاسخ</th>
                                                            <th>وضعیت</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($tickets as $index=>$ticket)
                                                            <tr style="background-color: {{$ticket->user_seen==0?($ticket->answer_time!=null?'lightgrey':''):''}}">
                                                                <td>{{$index+1}}</td>
                                                                <td><a class="navi-link"
                                                                       href="#"
                                                                       {{--                                                               href="{{ route('tickets.show', ['tickets' => $ticket->id]) }}" style="text-decoration: underline !important;"--}}
                                                                       onclick="user_seen({{$ticket->id}})"
                                                                       data-toggle="modal"
                                                                       data-target="#ticket-{{ $ticket->id }}"
                                                                       data-ui-toggle-class="flip-x" data-ui-target="#animate"
                                                                    >
                                                                        {{ $ticket->title }}</a>
                                                                </td>
                                                                <td>{{ verta($ticket->created_at)->format('H:i Y/m/d') }}</td>
                                                                <td>{{ $ticket->answer_time != null ? verta($ticket->answer_time)->format('H:i Y/m/d') : 'در انتظار پاسخ' }}</td>
                                                                <td>
                                                             <span
                                                                 class="badge badge-{{ $ticket->answer_time != null ? 'success' : 'danger' }} m-0">
                                                            {{ $ticket->answer_time != null ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}
                                                            </span>
                                                                </td>
                                                            </tr>
                                                            <div id="ticket-{{ $ticket->id }}" style="margin-top: -30px" class="modal modal-dialog table-responsive  fade animate">
                                                                <div class="modal-dialog" id="animate">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">تیکت</h4>
                                                                            <button class="close" type="button" data-dismiss="modal"
                                                                                    aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container mb-3">
                                                                                <div class="row">
                                                                                    <!-- Ticket-->
                                                                                    <div class="col-lg-12 pb-5">
                                                                                        <h2 class="h5 text-center text-sm-right">{{ $ticket->title }}</h2>
                                                                                        <div
                                                                                            class="d-sm-flex justify-content-between bg-secondary py-3 mb-3">
                                                                                            <div class="p-2 w-100 text-center"><strong
                                                                                                    class="d-block mb-1">تاریخ ارسال
                                                                                                    شده</strong><span>{{ verta($ticket->created_at)->format('Y/m/d') }}</span>
                                                                                            </div>
                                                                                            <div class="py-2 w-100 text-center"><strong
                                                                                                    class="d-block mb-1">تاریخ
                                                                                                    پاسخ</strong><span>{{ $ticket->answer ? verta($ticket->answer_time)->format('Y/m/d') : 'در انتظار پاسخ' }}</span>
                                                                                            </div>
                                                                                            <div class="py-2 w-100 text-center"><strong
                                                                                                    class="d-block mb-1">وضعیت</strong>
                                                                                                <span
                                                                                                    class="badge badge-{{ $ticket->answer_time != null ? 'success' : 'danger' }}">
                                                                                     {{ $ticket->answer_time != null ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}
                                                                                    </span>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="blockquote comment mb-4">
                                                                                            <div
                                                                                                class="d-sm-flex justify-content-between align-items-center">
                                                                                                <div class="testimonial-footer">
                                                                                                    <div class="testimonial-avatar"><img
                                                                                                            src="{{ asset( $ticket->user->image->path) }}"
                                                                                                            style="width: 50px;height: 50px"
                                                                                                            alt="Comment Author Avatar"/>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="d-table-cell align-middle pl-2">
                                                                                                        <div
                                                                                                            class="blockquote-footer">{{ $ticket->user->name }}
                                                                                                            @if($ticket->ticket != null)
                                                                                                                <cite>{{ verta($ticket->created_at)->format('H:i') }} {{ verta($ticket->created_at)->format('%A, %d %B %y') }}</cite>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="blockquote comment">
                                                                                                <h5>{{ $ticket->ticket }}</h5>
                                                                                                @if($ticket->answer)
                                                                                                    <div class="testimonial-footer">
                                                                                                        <div class="testimonial-avatar">
                                                                                                            <img
                                                                                                                style="height: 100px; width: 100px"
                                                                                                                src="{{ asset('images/users_pic/user.png') }}"
                                                                                                                alt="Comment Author Avatar"/>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="d-table-cell align-middle pl-2">
                                                                                                            <div
                                                                                                                class="blockquote-footer">
                                                                                                                پشتیبانی
                                                                                                                <cite>{{ verta($ticket->answer_time)->format('H:i') }} {{ verta($ticket->answer_time)->format('%A, %d %B %y') }}</cite>
                                                                                                            </div>
                                                                                                            <h5>{{ $ticket->answer }}</h5>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <!-- Off-Canvas Menu-->
                                                        </tbody>
                                                    </table>
                                                    {{ $tickets->links() }}
                                                </div>
                                            </div>
                                        @else
                                            <p>هیچ تیکتی برای نمایش وجود ندارد!</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                    <!-- Open Ticket Modal-->
                    <form class="needs-validation" action="{{route('user.tickets.store')}}" method="post" id="open-ticket" tabindex="-1" novalidate>
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
                                        <input class="form-control" name="title" type="text" id="ticket-subject" required>
                                        <div class="invalid-tooltip">لطفا قسمت موضوع را پر کنید</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ticket-description">توضیحات</label>
                                        <textarea class="form-control" name="ticket" id="ticket-description" rows="8" required></textarea>
                                        <div class="invalid-tooltip">لطفا توضیحات تیکت را ارائه دهید</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Off-Canvas Menu-->
                </main>
            </div><!-- .ticket-section -->


        </section>
    </article>
@endsection
