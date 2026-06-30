@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/user') }}">Users</a></li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/user', $posts['id'])}}" method="POST" role="search">
                @method('PUT')
                @csrf
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit User Info</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Edit User Info
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="User Name or Email ID"></i></span>
                            </label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter User Name or Email ID" value="{{$posts['email']}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="firstname">First Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="First Name"></i></span>
                            </label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" value="{{$posts['firstname']}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Last Name"></i></span>
                            </label>
                            <input type="text" id="designation" name="lastname" class="form-control" placeholder="Enter Last Name" value="{{$posts['lastname']}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Designation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Designation"></i></span>
                            </label>
                            <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation" value="{{$posts['designation']}}">
                        </div>

                         <div class="form-group col-md-6">
                            <label for="phone">Phone
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Phone"></i></span>
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone" value="{{$posts['phone']}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country">Country
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Country"></i></span>
                            </label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="Enter Country" value="{{$posts['country']}}">
                        </div>


                        <div class="form-group col-md-6">
                            <label for="country">Organization
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Organization"></i></span>
                            </label>
                            <input type="text" id="Organization" name="Organization" class="form-control" placeholder="Enter Organization" value="{{$posts['Organization']}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country">About Organization
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="About Organization"></i></span>
                            </label>
                            <input type="text" id="about_orgn" name="about_orgn" class="form-control" placeholder="About Organization" value="{{$posts['about_orgn']}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="user_type">Select User Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Access Type"></i></span>
                            </label>
                            <select id="user_type" name="user_type" class="js-example-basic-single">
                                <option value="">User Type</option>
                                <option value="Angel" @if ($posts['user_type'] == "Angel") {{'selected="selected"'}} @endif>Angel</option>
                                <option value="FamilyOffice" @if ($posts['user_type'] == "FamilyOffice") {{'selected="selected"'}} @endif>Family Office</option>
                                <option value="VentureCapitalFirm" @if ($posts['user_type'] == "VentureCapitalFirm") {{'selected="selected"'}} @endif>Venture Capital Firm</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country_id">Select Access Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Access Type"></i></span>
                            </label>
                            <select id="access_type" name="access_type" class="js-example-basic-single">
                                <option value="">Access Type</option>
                                <option value="ADMIN" @if ($posts['access_type'] == "ADMIN") {{'selected="selected"'}} @endif>Admin</option>
                                <option value="SUMMARY" @if ($posts['access_type'] == "SUMMARY") {{'selected="selected"'}} @endif>Summary</option>
                                <option value="DETAILED" @if ($posts['access_type'] == "DETAILED") {{'selected="selected"'}} @endif>Detailed</option>
                                <option value="INVESTOR" @if ($posts['access_type'] == "INVESTOR") {{'selected="selected"'}} @endif>Investor</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country_id">Status
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Status"></i></span>
                            </label>
                            <select id="status" name="status" class="js-example-basic-single">
                                <option value="InActive" @if ($posts['status'] == "InActive") {{'selected="selected"'}} @endif>InActive</option>
                                <option value="Active" @if ($posts['status'] == "Active") {{'selected="selected"'}} @endif>Active</option>
                            </select>
                        </div>

                        
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" data-request="ajax-submit" data-target='[role="energy"]' class="btn btn-sm btn-primary submit">Submit</button>
                        <a href="{{ url('/user') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });

        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush