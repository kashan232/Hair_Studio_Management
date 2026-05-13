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
                <h1 class="page-title">Zone Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Zones</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Zone List</h3>
                            <div class="ms-auto">
                                <a href="{{route('zones.create')}}" class="btn btn-primary btn-sm">Create Zone</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zones-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Region/Zone Name</th>
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
<script src="{{asset('')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(function () {
    var table = $('#zones-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('zones.index') }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'full_name', name: 'full_name' },
            { data: 'job_title', name: 'job_title' },
            { data: 'cell_no', name: 'cell_no' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#zones-table').on('click', '.delete-btn', function() {
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
                    url: '{{ url('zones') }}/' + id,
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
