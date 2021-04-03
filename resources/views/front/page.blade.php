@extends('front.layouts.master')

@section('title'){{$title}}@endsection

@section('content')
    <article class="w-100 position-relative">
        <section class="content-container mt-5 mb-5">
            <nav aria-label="breadcrumb p-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">خانه</a></li>
                    <li class="breadcrumb-item"><a href="#">اطلاعات شرکت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">قوانین</li>
                </ol>
            </nav>
            <hr>
            <div class="single-page w-100 p-5">
                <h1>{{$title}}</h1>
                {!! $content !!}

            </div>

        </section>
    </article>
@endsection
