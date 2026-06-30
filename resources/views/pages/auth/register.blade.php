@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">
            <div class="auth-left-wrapper" style="background-image: url({{ url('https://via.placeholder.com/219x452') }})">

            </div>
          </div>
          <div class="col-md-8 pl-md-0">
            <div class="auth-form-wrapper px-4 py-5">
            <a href="#" class="noble-ui-logo d-block mb-2"><img src="{{ url('/storage/brandideaAnalytics_logo.png') }}" width="200" height="50" alt="" title=""></a>
              <h5 class="text-muted font-weight-normal mb-4">New User Registration Form</h5>

                <form class="forms-sample" action="{{url('/user/register')}}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="username">Username / Email ID</label> <span class="text-danger">*</span>
                    <input type="email" class="form-control" id="username" name="username" placeholder="User Name">
                  </div>
                  <div class="form-group">
                    <label for="firstname">First Name</label>  <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                  </div>
                  <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                  </div>
                  <div class="form-group">
                    <label for="user_type">Select User Type
                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select User Type"></i></span>
                    </label>
                    <select id="user_type" name="user_type" class="js-example-basic-single">
                        <option value="">Select User Type</option>
                        <option value="admin">Admin</option>
                        <option value="type-1">Type 1</option>
                        <option value="type-2">Type 2</option>
                        <option value="type-3">Type 3</option>
                    </select>
                </div>
                  <div class="form-group">
                    <label for="organization">Organization</label>  <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization">
                  </div>
                  <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">
                  </div>
                  <div class="form-group">
                    <label for="phone">Mobile/Phone</label>  <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile / Phone (ISD and STD Code)">
                  </div>

                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button class="btn btn-primary submit" type="submit">Signup</button>
                </div>

                <a href="{{ url('/auth/login') }}" class="d-block mt-3 text-muted">Already Signed! login</a>
                
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('custom-scripts')
<script>
    $(function() {
        

        $.ajaxSetup({
            animation: "spinner"
        });

        $('.submit').click(function() {

            if($('#phone').val()=="" || $('#username').val()=="" || $('#firstname').val()=="" || $('#organization').val()=="") {
                alert("User Name/Email ID, First Name, Organization, Phone fields should not be blank !!!");
                 return false;
            }

            // if($('#password1').val() === $('#password2').val()) {

            //         var regExp = /[_\-!@#$%;,.:]/;
            //         if(!regExp.test($('#password1').val())){
            //             alert("Need atleast 1 special character !!!");
            //             return false;
            //         } else {
            //             //alert("Yes OKKKK !!!");
            //             var regExp = /^.*(?=.{8,20})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&!-_]).*$/;
            //                 if(!regExp.test($('#password1').val())){
            //                     alert("Need atleast 1 Albhabet and 1 Number !!!");
            //                     return false;
            //                 } else {
            //                     //alert("Yes OKKKK !!!");
            //                     return true;
            //                 }
            //             return true;
            //         }

            // } else if(document.getElementById('password1').value.length < 8 || document.getElementById('password1').value.length > 20) {
            //     alert("Password length should between 8 to 30 characters !!!");
            //     return false;
            // }
            // else {
            //     alert("Password and Re-Enter password does not matches");
            //     return false;
            // }
           
            $('.dimback').show();
            $('#psdatasourcSpinner').show();
        });


    });
</script>
@endpush