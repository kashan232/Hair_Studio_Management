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


  <!-- App body starts -->
    <div class="row gx-3">
        <div class="col-xl-12 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="col-12 p-3">

                    <table class="table">
                       <thead>
                            <th>Model</th>
                            <th>Permissions</th>
                       </thead>
                       <tbody>
                            <form action="{{route('role.applyPermissions')}}" class="ajaxForm">
                            <input type="hidden" name="role_id" value="{{$role_id}}">
                            @foreach ($groupedPermissions as $model => $permissions)
                               <tr>
                                    <td>
                                        <span style="height: 30px; padding: 3px 15px 0px 15px; line-height: 23px;" class="badge bg-primary-subtle text-primary text-uppercase ">
                                            {{ $model }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach ($permissions as $permission)
                                        <div class="form-check form-check-inline" style="width:20%">
                                            <input {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}  class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" >
                                            <label class="form-check-label" for="flexCheckDefault">{{$permission->name}}</label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="right">
                        <input type="submit" class="btn btn-primary" name="" id="">
                    </div>
                    </form>


                </div>
            </div>
          </div>
    </div>
  </div>
@endsection
@section('JScript')

@endsection
