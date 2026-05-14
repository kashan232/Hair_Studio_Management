@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Region Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Regions</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Region List</h3>
                            <div class="ms-auto">
                                <a href="{{route('regions.create')}}" class="btn btn-primary btn-sm">Create Region</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="regions-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Unit Name</th>
                                            <th>Region Name</th>
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
    var table = $('#regions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('regions.index') }}',
        columns: [
            { data: 'unit_name', name: 'unit.name' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#regions-table').on('click', '.delete-btn', function() {
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
                    url: '{{ url('regions') }}/' + id,
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
