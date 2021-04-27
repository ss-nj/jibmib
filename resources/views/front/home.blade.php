@extends('front.layouts.master')

@section('content')
    @include('front.layouts.content')
@endsection

@push('style')
    <style>
        .carousel-item img {
            height: 339px !important;
        }
        .b {
            position: fixed;
            top: 20px;
        }

        .a {
            position: absolute;
            top: 230px;
        }
    </style>
@endpush

@push('internal_js')
    <script>
        // document.addEventListener("scroll", trackScrolling);
        //
        // function trackScrolling() {
        //     const el = document.querySelector(".cat-fixed-container");
        //
        //     if (el.getBoundingClientRect().top < 20) {
        //         el.classList.remove("a");
        //         el.classList.add("b")
        //     } else {
        //         el.classList.add("a");
        //         el.classList.remove("b")
        //     }
        // }
    </script>
@endpush

