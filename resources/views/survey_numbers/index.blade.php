@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Survey Number Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Survey Numbers</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Survey Number List</h3>
                            <div class="ms-auto">
                                <a href="{{route('survey_numbers.create')}}" class="btn btn-primary btn-sm">Create Survey Number</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="survey-numbers-table" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Taluka</th>
                                            <th>Circle</th>
                                            <th>Tappa</th>
                                            <th>Deh</th>
                                            <th>Number</th>
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
    var table = $('#survey-numbers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('survey_numbers.index') }}',
        columns: [
            { data: 'division_name', name: 'deh.tappa.revenueCircle.taluka.district.revenueDivision.name' },
            { data: 'district_name', name: 'deh.tappa.revenueCircle.taluka.district.name' },
            { data: 'taluka_name', name: 'deh.tappa.revenueCircle.taluka.name' },
            { data: 'circle_name', name: 'deh.tappa.revenueCircle.name' },
            { data: 'tappa_name', name: 'deh.tappa.name' },
            { data: 'deh_name', name: 'deh.name' },
            { data: 'number', name: 'number' },
            { data: 'code', name: 'code' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#survey-numbers-table').on('click', '.delete-btn', function() {
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
                    url: '{{ url('survey_numbers') }}/' + id,
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
