@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/search_list">Menu Setting</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Menu</li>
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
            <form action="{{url('/user/updatepwd')}}" method="POST" role="search">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add New Password</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Enter Original Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Password Rule : Should be 8 characters combination of atleast 1 alphabet, 1 numeral and 1 special characters from @!#$%"></i></span>
                            </label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" id="id" name="id" value="{{$id}}" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Enter New Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Password Rule : Should be 8 characters combination of atleast 1 alphabet, 1 numeral and 1 special characters from @!#$%"></i></span>
                            </label>
                            <input type="password" id="password1" name="password1" class="form-control" placeholder="Enter New Password">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" id="dummy" name="dummy" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Re-Enter New Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Password"></i></span>
                            </label>
                            <input type="password" id="password2" name="password2" class="form-control" placeholder="Re Enter New Password">
                        </div>                        

                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" data-request="ajax-submit" data-target='[role="energy"]' class="btn btn-sm btn-primary submit">Submit</button>
                        <a href="{{url('/user')}}" class="btn btn-sm btn-danger">Cancel</a>
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
            // if($('#password1').val() === $('#password2').val()) {
                
            //     return true;
            // } else {
            //     alert("New Password and Re-Enter password does not matches");
            //     return false;
            // }
           
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