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

        document.addEventListener("scroll", trackScrolling);
        // document.addEventListener("scroll", trackScrollingFooter);

        function trackScrolling() {
            const el = document.querySelector(".cat-fixed-container");
            const header = document.querySelector(".primary-header");
            let sticky = el.getBoundingClientRect();
            // offsetHeight
// console.log(header.offsetHeight,sticky)
            if (window.pageYOffset >= (sticky.top + header.offsetHeight)) {
                el.classList.remove("a");
                el.classList.add("b");
            } else {
                el.classList.add("a");
                el.classList.remove("b")
            }
        }

        // theme-footer w-100
        function trackScrollingFooter() {
            const el = document.querySelector(".cat-fixed-container");
            const footer = document.querySelector(".theme-footer");
            let sticky = el.getBoundingClientRect();

            console.log(document.body.clientHeight, window.pageYOffset, footer.offsetHeight)
            if (document.body.clientHeight <= (window.pageYOffset + footer.offsetHeight)) {
                console.log(1)
                // el.classList.remove("b");
                // el.classList.add("a");
            } else {
                console.log(2)
                // el.classList.add("b");
                // el.classList.remove("a")
            }
        }

    </script>
@endpush

