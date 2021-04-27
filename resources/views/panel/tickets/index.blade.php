@extends('panel.layouts.master')

@section('title')
    {{__('tickets.tickets list')}}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">

            <div class="col-xl-12 box-margin">
{{--                @include('error-validation')--}}

                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title mb-2">{{__('tickets.tickets list')}}</h4>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('tickets.title')}}</th>
                                    <th>{{__('tickets.sender')}}</th>
                                    <th>{{__('tickets.created at')}}</th>
                                    <th>{{__('tickets.last change')}}</th>
                                    <th>{{__('tickets.last massage')}}</th>
                                    <th>{{__('tickets.status')}}</th>
                                    <th style="width: 120px;">{{__('tickets.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
{{--                                @dd($tickets)--}}
                                @foreach($tickets as $index => $ticket)
                                    <tr>
                                        <td>{{ ++$index }}</td>

                                        <td><a href="{{route('panel.tickets.show',$ticket->id)}}">{{ $ticket->title }}</a></td>
                                        <td>{{ $ticket->user->name }}</td>

                                        <td>{{verta($ticket->created_at)->timezone('Asia/Tehran')->format('%B %d، %Y H:i')}}</td>
                                        <td>{{verta($ticket->updated_at)->timezone('Asia/Tehran')->format('%B %d، %Y H:i')}}</td>
                                        <td>{{\Illuminate\Support\Str::limit($ticket->latestMessage->body,50)}}</td>
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

                                        <td>

                                            <form action="{{ route('panel.tickets.destroy', $ticket->id) }}"
                                                  style="display: inline;" id="frm-delete-tickets{{ $ticket->id }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <a href="#"
                                                   onclick="deleteWithModal('frm-delete-tickets', '{{ $ticket->id }}', event)"><i
                                                        class="fa fa-trash btn btn-danger btn-circle"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('panel.layouts.status-modal',['form_action'=>'panel.tickets.status.update','model'=>$ticket,'statuses'=>\App\Http\Core\Models\Ticket::STATUS])

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

@endsection

