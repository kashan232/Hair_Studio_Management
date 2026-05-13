@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Roles</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Role List</h3>
                            <div class="ms-auto">
                                <button class="btn btn-primary btn-sm" id="create_role_btn" data-bs-toggle="modal" data-bs-target="#model">Create Role</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>S#</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                        <tr class="{{ $role->deleted_at ? 'table-danger' : '' }}">
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$role->name}}</td>
                                            <td>
                                                <a href="{{route('role.permissions',$role->id)}}" class="btn btn-info btn-sm">
                                                    Assign Permissions
                                                </a>
                                                <button data-data="{{$role}}" id="edit_role" class="btn btn-primary btn-sm">
                                                    <i class="ri-edit-box-line"></i>
                                                </button>
                                                <button data-url="{{route('role.destroy',$role->id)}}" data-msg="" onclick="ajaxRequest(this)" class="btn btn-danger btn-sm">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$roles->links()}}
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
                <h5 class="modal-title" id="modelLabel">Create Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajaxForm" action="{{route('role.store')}}" method="post">
                @csrf
                <input type="hidden" name="edit_id" value="" id="edit_id">
                <div class="modal-body">
                    <div class="col-12 mt-2">
                        <label class="form-label">Role Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
$(document).ready(function() {
    $(document).on('click','#edit_role',function(){
        var data = $(this).data('data');
        $('#modelLabel').html('Edit Role');
        $('#edit_id').val(data.id);
        $('#name').val(data.name);
        $('#model').modal('show');
    });

    $(document).on('click','#create_role_btn',function(){
        $('.ajaxForm')[0].reset();
        $('#edit_id').val(null);
        $('#modelLabel').html('Create Role');
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
