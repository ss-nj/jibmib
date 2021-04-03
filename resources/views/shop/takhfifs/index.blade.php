@extends('shop.layouts.master')

@section('title')ایجاد تخفیف@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست تخفیف</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.takhfifs.index')}}">لیست تخفیف</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <h4 class="mb-4">ویژگی ها</h4>

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>قیمت</th>
                            <th>قیمت با تخفیف</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                            <th>دسته بندی ها</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($takhfifs as $takhfif)
                            <tr>
                                <td>{{$takhfif->id}}</td>

                                <td>{{$takhfif->name}}</td>

                                <td>
                                    {{verta($takhfif->display_start_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}
                                </td>
                                <td>
                                    {{verta($takhfif->display_end_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}
                                </td>

                                <td>{{$takhfif->price}}</td>
                                <td>{{$takhfif->discount_price}}</td>
                                <td>
                                    {{verta($takhfif->created_at)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}
                                </td>
                                <td>
                                    <a href="{{route('shop.takhfifs.edit',$takhfif->id)}}"
                                       class="btn btn-circle btn-icon-only"><i
                                            class="fa fa-pen "></i></a>

                                    <form action="{{ route('shop.takhfifs.destroy', $takhfif->id) }}"
                                          style="display: inline;"
                                          id="frm-delete-takhfif-value{{ $takhfif->id }}"
                                          method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <a href="#" class="btn btn-circle btn-icon-only"
                                           onclick="deleteWithModal('frm-delete-takhfif-value', '{{ $takhfif->id }}', event)"><i
                                                class="fa fa-trash alert-danger"></i></a>
                                    </form>
                                </td>
                                <td>{!! implode('-', $takhfif->categories->pluck('name')->toArray()) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



@endsection


