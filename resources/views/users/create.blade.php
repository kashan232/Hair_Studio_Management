@extends('layouts.main')
@section('css')
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($user)) Create User @else Update User @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users')}}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($user)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('user.store')}}" class="ajaxForm row">
                                @csrf
                                <input type="hidden" name="edit_id" value="{{$user->id ?? ''}}">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{$user->code ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cnic</label>
                                    <input type="text" class="form-control" name="cnic" value="{{$user->cnic ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{$user->mobile ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" name="joining_date" value="{{$user->joining_date ?? ''}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation</label>
                                    <select name="designation" id="designation" class="form-control form-select">
                                        <option value="supervisor" {{ isset($user) && $user->designation == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="recovery-officer" {{ isset($user) && $user->designation == 'recovery-officer' ? 'selected' : '' }}>Recovery Officer</option>
                                        <option value="lineman" {{ isset($user) && $user->designation == 'lineman' ? 'selected' : '' }}>Lineman</option>
                                        <option value="karkun" {{ isset($user) && $user->designation == 'karkun' ? 'selected' : '' }}>Karkun</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" value="12345678">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="c_password" value="12345678" >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">IBC</label>
                                    <select class="form-control select2" name="area_id[]" id="area_id" multiple>
                                        @php
                                            $selectedAreas = old('area_id', isset($user) ? $user->areas->pluck('id')->toArray() : []);
                                        @endphp
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" {{ in_array($area->id, $selectedAreas) ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role" id="role" class="form-control form-select">
                                        <option value="">Please Select Role</option>
                                        @php
                                            $selectedRole = old('role', isset($user) && $user->roles->isNotEmpty() ? $user->roles->first()->name : '');
                                        @endphp
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $selectedRole == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save User</button>
                                    <a href="{{ route('users') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </form>
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
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Options",
            width: '100%'
        });

        $('.ajaxForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("#global-loader").fadeIn();
                },
                complete: function() {
                    $("#global-loader").fadeOut();
                },
                success: function(response) {
                    if (response.errors) {
                        Swal.fire("Error!", "Please check your inputs", "error");
                    } else {
                        Swal.fire("Success!", response.success, "success").then(() => {
                            if(response.reload) window.location.reload();
                            if(response.redirect) window.location.href = response.redirect;
                        });
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Something went wrong", "error");
                }
            });
        });
    });
</script>
@endsection
