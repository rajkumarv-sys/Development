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
            <a target="_blank" href="http://www.brandidea.ai" class="noble-ui-logo d-block mb-2"><img src="{{ url('/storage/brandideaAnalytics_logo.png') }}" width="200" height="50" alt="" title=""></a></span>
            </a>
              <h5 class="text-muted font-weight-normal mb-4">Set Password</h5>

                <form class="forms-sample" action="{{url('/user/setpasswd')}}" method="POST">
                  {{ csrf_field() }}
                 
                  <div class="form-group">
                      <label for="password">Enter Password
                          <span class="text-danger">*</span>
                          <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Password Rule : Should be 8 characters combination of atleast 1 alphabet, 1 numeral and 1 special characters from @!#$%"></i></span>
                      </label>
                      <input type="password" id="password1" name="password1" class="form-control" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                      <label for="password">Re-Enter Password
                          <span class="text-danger">*</span>
                          <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Password"></i></span>
                      </label>
                      <input type="password" id="password2" name="password2" class="form-control" placeholder="Enter Password">
                  </div>

                  <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary submit" type="submit">Set Password</button>
                  </div>

                  <input type="hidden" name="mytoken" value="{{$_GET['mytoken']}}">
                  <input type="hidden" name="userid" value="{{$_GET['userid']}}">
                  <input type="hidden" name="emailid" value="{{$_GET['emailid']}}">
                
              </form>

              <a href="{{ url('/auth/login') }}" class="d-block mt-3 text-muted">Already Signed! login</a>

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


    });
</script>
@endpush