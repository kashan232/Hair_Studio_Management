@extends('layouts.main')
@section('css')
<link rel="stylesheet" href="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Users</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User List</h3>
                            <div class="ms-auto">
                                <a href="{{route('user.create')}}" class="btn btn-primary btn-sm">Create User</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Code</th>
                                            <th>Cnic</th>
                                            <th>Mobile</th>
                                            <th>Joining Date</th>
                                            <th>Role</th>
                                            <th>Areas</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script src="{{asset('')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(function () {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users') }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'code', name: 'code' },
            { data: 'cnic', name: 'cnic' },
            { data: 'mobile', name: 'mobile' },
            { data: 'joining_date', name: 'joining_date' },
            { data: 'role', name: 'role', orderable: false, searchable: false },
            { data: 'areas', name: 'areas', orderable: false, searchable: false },
            { data: 'status',
                render: function(data, type, full, meta) {
                    return '<div class="form-check form-switch" style="margin: 0;min-height: 0;">' +
                        '<input class="form-check-input" type="checkbox" role="switch" id="' + full.id + '"' + (data == 1 ? ' checked' : '') + '>' +
                    '</div>';
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});

$('#users-table').on('click', '.form-check-input', function(e) {
    e.preventDefault();
    var checkbox = $(this);
    var id = $(this).attr('id');
    Swal.fire({
        title: "Are you sure?",
        text: "You want change user active status!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Confirm it!"
    }).then(function (t) {
        if (t.isConfirmed){
            $.ajax({
                url: '{{route("user.status.update")}}',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                dataType: "json",
                beforeSend: function() {
                    $("#global-loader").fadeIn();
                },
                complete: function () {
                    $("#global-loader").fadeOut();
                },
                success: function (data) {
                    checkbox.prop('checked', data == 1);
                }
            });
        }
    });
});
</script>
@endsection
