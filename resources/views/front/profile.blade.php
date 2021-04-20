@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="small-content-container cart-container mb-5">

            <!-- _______________________ Profile Title Section ___________________ -->

            <div class=" ticket-section card-section mt-5 p-2">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="text-center usr-profile-title pr-3">
                            <img class="big-circle-usr-img output" id="output2" src="{{asset(\Illuminate\Support\Facades\Auth::user()->image->path)}}" alt="">
                            <div class="text-center font-weight-bold text-success">{{auth()->user()->full_name}}</div>
                        </div>
                    </div>
                    <div class="col-sm-9 align-self-center">
                        <ul class="nav nav-tabs profile-tab-title justify-content-around" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">تخفیف های من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">اطلاعات شخصی</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .ticket-section -->

            <div class="tab-content" id="myTabContent">

                <!-- _______________________ Off Items Section ___________________ -->
                <!-- <div id="offs-list" class="fade show active" role="tabpanel" aria-labelledby="off-list-tab"> -->
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                   @include('front.layouts.profile-takhfif-list')
                </div>

                <!-- _______________________ Personal Information Section ___________________ -->
                <!-- <div id="personal-info" class="fade" role="tabpanel" aria-labelledby="personal-info-tab"> -->
                <div class="tab-pane fade  show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @include('front.layouts.profile-user-info')<!-- .ticket-section -->
                </div><!-- .tab-pane -->

            </div><!-- #myTabContent -->

        </section>
    </article>
@endsection
