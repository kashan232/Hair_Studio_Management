@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Circle Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Circles</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Circle List</h3>
                            <div class="ms-auto">
                                <a href="{{route('circles.create')}}" class="btn btn-primary btn-sm">Create Circle</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="circles-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Circle Name</th>
                                            <th>Region / Zone</th>
                                            <th>Code</th>
                                            <th>Full Name</th>
                                            <th>Job Title</th>
                                            <th>Cell No</th>
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
<script>
$(function () {
    var table = $('#circles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('circles.index') }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'zone_name', name: 'zone.name' },
            { data: 'code', name: 'code' },
            { data: 'full_name', name: 'full_name' },
            { data: 'job_title', name: 'job_title' },
            { data: 'cell_no', name: 'cell_no' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#circles-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url('circles') }}/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire("Deleted!", response.success, "success");
                    }
                });
            }
        });
    });
});
</script>
@endsection
