@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/user') }}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add User</li>
    </ol>
</nav>

<div class="text-center dimback">
    <div id="psdatasourcSpinner" class="spinner-border text-primary" style="width: 5rem; height: 5rem; display: none; margin-top:25px;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/user')}}" method="POST" role="search">
            {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add User</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Enter First Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter First Name"></i></span>
                            </label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Enter Last Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Last Name"></i></span>
                            </label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keyword_1">Enter Eamil or Login ID
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Email ID"></i></span>
                            </label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email ID">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_site">Select User Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select User Type"></i></span>
                            </label>
                            <select id="type" name="user_type" class="js-example-basic-single">
                                <option value="">Select User Type</option>
                                <option value="Regular">Regular</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Enter Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Password Rule : Should be 8 characters combination of atleast 1 alphabet, 1 numeral and 1 special characters from @!#$%"></i></span>
                            </label>
                            <input type="password" id="password1" name="password1" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Re-Enter Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Password"></i></span>
                            </label>
                            <input type="password" id="password2" name="password2" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="organization">Enter Organization Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Organization Name"></i></span>
                            </label>
                            <input type="text" id="organization" name="organization" class="form-control" placeholder="Enter Organization Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="about_orgn">Enter About Organization
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter About Organization"></i></span>
                            </label>
                            <input type="text" id="about_orgn" name="about_orgn" class="form-control" placeholder="Enter About Organization">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="designation">Enter Designation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Designation"></i></span>
                            </label>
                            <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Enter Phone Contact info
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Phone Contact Info"></i></span>
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Contact Info">
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
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Tags
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 20,
            'placeholderColor': '#666666'
        });

        $.ajaxSetup({
            animation: "spinner"
        });

        $('.submit').click(function() {

            if($('#email').val()=="" || $('#name').val()=="" || $('#type').val()=="") {
                alert("User Name or Email ID or Type should not blank !!!");
                 return false;
            }

            if($('#password1').val() === $('#password2').val()) {

                    var regExp = /[_\-!@#$%;,.:]/;
                    if(!regExp.test($('#password1').val())){
                        alert("Need atleast 1 special character !!!");
                        return false;
                    } else {
                        //alert("Yes OKKKK !!!");
                        var regExp = /^.*(?=.{8,20})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&!-_]).*$/;
                            if(!regExp.test($('#password1').val())){
                                alert("Need atleast 1 Albhabet and 1 Number !!!");
                                return false;
                            } else {
                                //alert("Yes OKKKK !!!");
                                return true;
                            }
                        return true;
                    }

            } else if(document.getElementById('password1').value.length < 8 || document.getElementById('password1').value.length > 20) {
                alert("Password length should between 8 to 30 characters !!!");
                return false;
            }
            else {
                alert("Password and Re-Enter password does not matches");
                return false;
            }
           
            $('.dimback').show();
            $('#psdatasourcSpinner').show();
        });

        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }


        function validatePassword() {
                var p = document.getElementById('newPassword').value,
                    errors = [];
                if (p.length < 8) {
                    errors.push("Your password must be at least 8 characters");
                }
                if (p.search(/[a-z]/i) < 0) {
                    errors.push("Your password must contain at least one letter."); 
                }
                if (p.search(/[0-9]/) < 0) {
                    errors.push("Your password must contain at least one digit.");
                }
                if (errors.length > 0) {
                    alert(errors.join("\n"));
                    return false;
                }
                return true;
            }
    });
</script>
@endpush