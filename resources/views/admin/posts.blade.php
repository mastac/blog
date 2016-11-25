@extends('admin.home')

@section('content')

    <div class="box">
        <div class="box-body">
            {!! $dataTable->table(['class' => "table table-bordered table-striped"]) !!}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you want delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts-footer')

{!! $dataTable->scripts() !!}

<script type="text/javascript">
    $(function(){
        $('#confirmDelete').on('show.bs.modal', function (event) {
            var form_delete = $(event.relatedTarget).find('form');
            var modal = $(this);
            modal.find('.modal-footer button.btn-primary').off();
            modal.find('.modal-footer button.btn-primary').on('click', function(e) {
                form_delete.submit();
            });
        });
    });
</script>
@endpush
