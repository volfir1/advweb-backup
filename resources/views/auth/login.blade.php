<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bake to go Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="Dashboard/vendors/feather/feather.css">
  <link rel="stylesheet" href="Dashboard/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="Dashboard/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="/customer/css/login-signup.css">
  <link rel="shortcut icon" href="Dashboard/images/favicon.png" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <div class="container-scroller">
 
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="customer/images/logos/baketogo.svg" alt="logo">
              </div>
              <h4>Hello! Let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form action="{{route('authenticate')}}" id="loginForm" class="pt-3" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="Name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="Password" name="password" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>   
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="/signup" class="text-primary">Create</a>
                </div>
                <div id="message" class="alert" style="display:none;"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="Dashboard/vendors/js/vendor.bundle.base.js"></script>
  <script src="Dashboard/js/off-canvas.js"></script>
  <script src="Dashboard/js/hoverable-collapse.js"></script>
  <script src="Dashboard/js/template.js"></script>
  <script src="Dashboard/js/settings.js"></script>
  <script src="Dashboard/js/todolist.js"></script>

  <script>
$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $("#loginForm").submit(function(event) {
    event.preventDefault();
    $(".error").remove();
    var name = $("#Name").val();
    var password = $("#Password").val();
    var isValid = true;

    if (name === "") {
      $("#Name").after('<span class="error">This field is required</span>');
      isValid = false;
    }

    if (password === "") {
      $("#Password").after('<span class="error">This field is required</span>');
      isValid = false;
    }

    if (isValid) {
      $.ajax({
        url: "{{ route('authenticate') }}",
        type: "POST",
        data: {
          name: name,
          password: password
        },
        success: function(response) {
          if (response.success) {
            $("#message").removeClass('alert-danger').addClass('alert-success').text('Login successful').show();
            window.location.href = response.redirect;
          } else {
            $("#message").removeClass('alert-success').addClass('alert-danger').text(response.message).show();
          }
        },
        error: function(response) {
          $("#message").removeClass('alert-success').addClass('alert-danger').text('An error occurred. Please try again.').show();
        }
      });
    } else {
      $("#message").removeClass('alert-success').addClass('alert-danger').text('Please fix the errors above').show();
    }
  });
});
  </script>
</body>
</html>
