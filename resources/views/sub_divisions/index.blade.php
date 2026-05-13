@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Sub-Division Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sub-Divisions</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub-Division List</h3>
                            <div class="ms-auto">
                                <a href="{{route('sub_divisions.create')}}" class="btn btn-primary btn-sm">Create Sub-Division</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="sub-divisions-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Sub-Division Name</th>
                                            <th>Division</th>
                                            <th>Circle</th>
                                            <th>Zone</th>
                                            <th>Code</th>
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
    var table = $('#sub-divisions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('sub_divisions.index') }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'division_name', name: 'division.name' },
            { data: 'circle_name', name: 'division.circle.name' },
            { data: 'zone_name', name: 'division.circle.zone.name' },
            { data: 'code', name: 'code' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#sub-divisions-table').on('click', '.delete-btn', function() {
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
                    url: '{{ url('sub_divisions') }}/' + id,
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
