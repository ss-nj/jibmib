@extends('front.layouts.master')

@section('title')مشاهده تیکت@endsection

@section('content')


    <!-- Page Content-->
    <div class="container mb-3">
        <div class="row">
        @include('user/profile-info')
        <!-- Ticket-->
            <div class="col-lg-8 pb-5">
                <h2 class="h5 text-center text-sm-right">{{ $ticket->title }}</h2>
                <div class="d-sm-flex justify-content-between bg-secondary py-3 mb-3">
                    <div class="p-2 w-100 text-center"><strong class="d-block mb-1">تاریخ ارسال شده</strong><span>{{ verta($ticket->created_at)->format('Y/m/d') }}</span></div>
                    <div class="py-2 w-100 text-center"><strong class="d-block mb-1">تاریخ پاسخ</strong><span>{{ $ticket->answer ? verta($ticket->answer_time)->format('Y/m/d') : 'در انتظار پاسخ' }}</span></div>
                    <div class="py-2 w-100 text-center"><strong class="d-block mb-1">وضعیت</strong>
                        <span class="badge badge-{{ $ticket->answer_time != null ? 'success' : 'danger' }}">
                            {{ $ticket->answer_time != null ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}
                        </span>
                    </div>
                </div>

                <div class="blockquote comment mb-4">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="testimonial-footer">
                            <div class="testimonial-avatar"><img src="{{ url('images/users_pic/' . $ticket->user->pic) }}" alt="Comment Author Avatar"/>
                            </div>
                            <div class="d-table-cell align-middle pl-2">
                                <div class="blockquote-footer">{{ $ticket->user->name }}
                                    @if($ticket->ticket != null)
                                        <cite>{{ verta($ticket->created_at)->format('H:i') }} {{ verta($ticket->created_at)->format('%A, %d %B %y') }}</cite>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blockquote comment">
                        <p>{{ $ticket->ticket }}</p>
                        @if($ticket->answer)
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar"><img src="{{ url('images/users_pic/user.png') }}" alt="Comment Author Avatar"/>
                                </div>
                                <div class="d-table-cell align-middle pl-2">
                                    <div class="blockquote-footer">پشتیبانی
                                        <cite>{{ verta($ticket->answer_time)->format('H:i') }} {{ verta($ticket->answer_time)->format('%A, %d %B %y') }}</cite>
                                    </div>
                                    <p>{{ $ticket->answer }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer-->
@endsection

