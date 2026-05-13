@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Division Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Divisions</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Division List</h3>
                            <div class="ms-auto">
                                <a href="{{route('divisions.create')}}" class="btn btn-primary btn-sm">Create Division</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="divisions-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Division Name</th>
                                            <th>Circle</th>
                                            <th>Zone</th>
                                            <th>Code</th>
                                            <th>Full Name</th>
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
    var table = $('#divisions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('divisions.index') }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'circle_name', name: 'circle.name' },
            { data: 'zone_name', name: 'circle.zone.name' },
            { data: 'code', name: 'code' },
            { data: 'full_name', name: 'full_name' },
            { data: 'cell_no', name: 'cell_no' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#divisions-table').on('click', '.delete-btn', function() {
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
                    url: '{{ url('divisions') }}/' + id,
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
