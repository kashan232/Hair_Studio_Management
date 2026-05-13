@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Permissions</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Permission List</h3>
                            <div class="ms-auto">
                                <button class="btn btn-primary btn-sm" id="create_btn" data-bs-toggle="modal" data-bs-target="#model">Create Permission</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>S#</th>
                                            <th>Model</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                        <tr class="{{ $permission->deleted_at ? 'table-danger' : '' }}">
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$permission->model}}</td>
                                            <td>{{$permission->name}}</td>
                                            <td>
                                                <button data-data="{{$permission}}" id="edit_permission" class="btn btn-primary btn-sm">
                                                    <i class="ri-edit-box-line"></i>
                                                </button>
                                                <button data-url="{{route('permission.destroy',$permission->id)}}" data-msg="" onclick="ajaxRequest(this)" class="btn btn-danger btn-sm">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$permissions->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="model" tabindex="-1" aria-labelledby="modelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelLabel">Create Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajaxForm" action="{{route('permission.store')}}" method="post">
                @csrf
                <input type="hidden" name="edit_id" value="" id="edit_id">
                <div class="modal-body">
                    <div class="col-12 mt-2">
                        <label class="form-label">Table Name</label>
                        <input type="text" class="form-control" name="model" id="model_input" required>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="form-label">Permission Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
$(document).ready(function() {
    $(document).on('click','#edit_permission',function(){
        var data = $(this).data('data');
        $('#modelLabel').html('Edit Permission');
        $('#edit_id').val(data.id);
        $('#name').val(data.name);
        $('#model_input').val(data.model);
        $('#model').modal('show');
    });

    $(document).on('click','#create_btn',function(){
        $('.ajaxForm')[0].reset();
        $('#edit_id').val(null);
        $('#modelLabel').html('Create Permission');
    });

    $('.ajaxForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#global-loader").fadeIn();
            },
            complete: function() {
                $("#global-loader").fadeOut();
            },
            success: function(response) {
                Swal.fire("Success!", response.success || "Saved Successfully", "success").then(() => {
                    window.location.reload();
                });
            },
            error: function() {
                Swal.fire("Error!", "Something went wrong", "error");
            }
        });
    });
});
</script>
@endsection
