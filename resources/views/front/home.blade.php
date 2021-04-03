@extends('front.layouts.master')

@section('content')
    @include('front.layouts.content')
@endsection

@push('style')
    <style>
        .carousel-item img {
            height: 339px !important;
        }
    </style>
@endpush
