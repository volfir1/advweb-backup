<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bake to go Signup</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/customer/css/login-signup.css">
  <link rel="stylesheet" href="/customer/css/error.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
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
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form id="signupForm" class="pt-3" method="POST">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="name" placeholder="Username" value="{{ old('name') }}">
                  <span class="danger-text" id="error-name"></span>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email" placeholder="Email" value="{{ old('email') }}">
                  <span class="danger-text" id="error-email"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" value="{{ old('password') }}">
                  <span class="danger-text" id="error-password"></span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="inputFirstName" name="fname" placeholder="First Name" value="{{ old('fname') }}">
                  <span class="danger-text" id="error-fname"></span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="inputLastName" name="lname" placeholder="Last Name" value="{{ old('lname') }}">
                  <span class="danger-text" id="error-lname"></span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="inputContact" name="contact" placeholder="Contact Number" value="{{ old('contact') }}">
                  <span class="danger-text" id="error-contact"></span>
                </div>
                <div class="form-group">
                  <textarea class="form-control form-control-lg" id="inputAddress" name="address" rows="3" placeholder="Address">{{ old('address') }}</textarea>
                  <span class="danger-text" id="error-address"></span>
                </div>
                
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                </div>
                <div id="message" class="alert" style="display:none;"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="popup-message success" id="success-popup">Registration successful</div>
  <div class="popup-message error" id="error-popup">Please fix the errors above</div>

  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#signupForm").submit(function(event) {
        event.preventDefault();
        $(".danger-text").text(''); // Clear previous errors
        var name = $("#exampleInputUsername1").val();
        var email = $("#exampleInputEmail1").val();
        var password = $("#exampleInputPassword1").val();
        var fname = $("#inputFirstName").val();
        var lname = $("#inputLastName").val();
        var contact = $("#inputContact").val();
        var address = $("#inputAddress").val();
        var isValid = true;

        // Validate name
        if (name === "") {
            $("#error-name").text('This field is required');
            isValid = false;
        }

        // Validate email
        if (email === "") {
            $("#error-email").text('This field is required');
            isValid = false;
        } else if (!validateEmail(email)) {
            $("#error-email").text('Please enter a valid email address');
            isValid = false;
        }

        // Validate password
        if (password === "") {
            $("#error-password").text('This field is required');
            isValid = false;
        } else if (password.length < 3 || password.length > 12) {
            $("#error-password").text('The password must be between 3 and 12 characters long');
            isValid = false;
        }

        // Validate first name
        if (fname === "") {
            $("#error-fname").text('This field is required');
            isValid = false;
        }

        // Validate last name
        if (lname === "") {
            $("#error-lname").text('This field is required');
            isValid = false;
        }

        // Validate contact
        if (contact === "") {
            $("#error-contact").text('This field is required');
            isValid = false;
        } else if (!validateContact(contact)) {
            $("#error-contact").text('Please enter a valid contact number');
            isValid = false;
        }

        // Validate address
        if (address === "") {
            $("#error-address").text('This field is required');
            isValid = false;
        }

        if (isValid) {
            // Check email uniqueness
            $.ajax({
                url: "{{ route('check-email') }}",
                type: "POST",
                data: { email: email },
                success: function(response) {
                    if (response.exists) {
                        $("#error-email").text('This email is already registered');
                    } else {
                        // Proceed with form submission
                        $.ajax({
                            url: "{{ route('register-user') }}",
                            type: "POST",
                            data: {
                                name: name,
                                email: email,
                                password: password,
                                fname: fname,
                                lname: lname,
                                contact: contact,
                                address: address
                            },
                            success: function(response) {
                                if (response.success) {
                                    showPopupMessage('success-popup', 'Registration successful');
                                    setTimeout(function() {
                                        window.location.href = "{{ route('login') }}";
                                    }, 2000); // Redirect after 2 seconds
                                } else {
                                    showPopupMessage('error-popup', response.message);
                                }
                            },
                            error: function(xhr) {
                                handleAjaxError(xhr);
                            }
                        });
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        } else {
            showPopupMessage('error-popup', 'Please fix the errors above');
        }
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
        return re.test(String(email).toLowerCase());
    }

    function validateContact(contact) {
        var re = /^\d{11}$/; // Updated to match the 11 digits requirement
        return re.test(String(contact));
    }

    function showPopupMessage(id, message) {
        var popup = $('#' + id);
        popup.text(message);
        popup.fadeIn();
        setTimeout(function() {
            popup.fadeOut();
        }, 3000); // Show for 3 seconds
    }

    function handleAjaxError(xhr) {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            if (errors.name) {
                $("#error-name").text(errors.name[0]);
            }
            if (errors.email) {
                $("#error-email").text(errors.email[0]);
            }
            if (errors.password) {
                $("#error-password").text(errors.password[0]);
            }
            if (errors.fname) {
                $("#error-fname").text(errors.fname[0]);
            }
            if (errors.lname) {
                $("#error-lname").text(errors.lname[0]);
            }
            if (errors.contact) {
                $("#error-contact").text(errors.contact[0]);
            }
            if (errors.address) {
                $("#error-address").text(errors.address[0]);
            }
        } else {
            showPopupMessage('error-popup', 'An error occurred. Please try again.');
        }
    }
});


  </script>

</body>
</html>
