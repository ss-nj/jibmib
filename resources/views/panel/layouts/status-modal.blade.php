<div class="modal fade" id="edit-status-{{$model->id}}">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__('tickets.edit')}}</h4>
                <button type="button" class="close"
                        data-dismiss="modal">

                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="billing-address">
                            @foreach( $statuses  as $key =>$status)
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <form action="{{route($form_action,$model->id)}}"
                                              enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{$model->id}}" name="id">
                                            <input type="hidden" value="{{$key}}" name="status">
                                            <button type="submit" style="background:{{$status[1]}};width: 100%"
                                                    class="btn btn-rounded "
                                                    >{{$status[0]}}
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button"
                        class="btn btn-rounded btn-danger close-modal"
                        data-dismiss="modal">کنسل
                </button>
            </div>
        </div>
    </div>
</div>
