@extends('panel.layouts.master')

@section('title')
    {{__('tickets.tickets')}}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            @include('panel.layouts.status-modal',['form_action'=>'panel.tickets.status.update','model'=>$ticket,'statuses'=>\App\Http\Core\Models\Ticket::STATUS])

            <div class="col-xl-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">{{__('tickets.tickets')}} </h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{route('panel.store.message')}}" method="post">
                                @csrf
                                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mb-0">
                                            <table class="table table-bordered margin-btm-0">
                                                <thead class="cart-table-head">
                                                <tr>
                                                    <td class="text-center"> #</td>
                                                    <td class="text-center"> {{__('tickets.title')}}</td>
                                                    <td class="text-center"> {{__('tickets.created at')}}</td>
                                                    <td class="text-center"> {{__('tickets.answered at')}}</td>
                                                    <td class="text-center"> {{__('tickets.actions')}}</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="custom-cart">{{$ticket->id}}</div>
                                                    </td>
                                                    <td class="text-left shopping-cart-breif">
                                                        <h5><a href=""
                                                               class="text-uppercase">     {{$ticket->title}}</a></h5>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="custom-cart">{{Verta::instance($ticket->created_at)->timezone('Asia/Tehran')->format('%B %d، %Y H:i')}}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="custom-cart">{{Verta::instance($ticket->updated_at)->timezone('Asia/Tehran')->format('%B %d، %Y H:i')}}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="" data-toggle="modal"
                                                           style="background:{{\App\Http\Core\Models\Ticket::STATUS[$ticket->status][1]}};
                                                               width: 100%;
                                                               display: inline-block;
                                                               padding: 5px;
                                                               border-radius: 4px;"
                                                           data-target="#edit-status-{{$ticket->id}}"
                                                           class="cart-add-cart-o ">{{\App\Http\Core\Models\Ticket::STATUS[$ticket->status][0]}}</a>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12 mt-2">
                                        <div class="table-responsive mb-0">
                                            <table class="table table-bordered margin-btm-0">
                                                <thead class="cart-table-head">
                                                <tr>
                                                    <td class="text-center"> #</td>
                                                    <td class="text-center"> {{__('tickets.sender')}}</td>
                                                    <td class="text-center"> {{__('tickets.message')}}</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($messages as $message)
                                                    <tr style="background :{{$message->from_admin?'#c6c6c6':''}}">
                                                        <td class="text-center">
                                                            <div class="custom-cart">{{$loop->index}}</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="custom-cart">{{$message->user?$message->user->name:''}}</div>
                                                        </td>
                                                        <td class="shopping-cart-breif">
                                                            <h5>
                                                                {{$message->body}}
                                                            </h5>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                       <textarea class="form-control" id="ticket-description" rows="8" name="body" required
                                                 onkeyup="textCounter(this,10,1000);" onpaste="textCounter(this,10,1000);"
                                                 maxlength="1000"
                                                 oninvalid="setCustomValidity('معرفی مختصر حداقل 10 کاراکتر می باشد')"
                                                 onchange="try{setCustomValidity('')}catch(e){}"
                                                 placeholder="معرفی مختصر " minlength="10" cols="30"
                                                 title="معرفی مختصر "
                                       ></textarea>
                                        <div class="count_hint_field"></div>
                                        <div class="error_field text-danger">
                                            @error('body')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <button type="submit"
                                                class="btn btn-rounded btn-success">
                                            {{__('tickets.answer')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

@endsection

