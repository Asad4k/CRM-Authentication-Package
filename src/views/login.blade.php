<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/css/mdb.min.css" rel="stylesheet">
        <style media="screen">
            .vertical-center {
                min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
                min-height: 100vh; /* These two lines are counted as one :-)       */

                display: flex;
                align-items: center;
            }
        </style>
    </head>
    <body class="bg-dark">
        <div class="container py-5  vertical-center">
            <div class="col-md-6 mx-auto">
              
                <!-- form card login -->
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="mb-0">Login</h3>
                    </div>
                    <div class="card-body">
                        <div class="form">
                            <div class="form-group">
                                <label for="uname1">Username</label>
                                <input type="text" class="form-control form-control-lg rounded-0" name="uname1" id="usernameInput" required="">
                                <div class="invalid-feedback">Oops, you missed this one.</div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control form-control-lg rounded-0" id="passwordInput" required="" autocomplete="new-password">
                                <div class="invalid-feedback">Enter your password too!</div>
                            </div>
                            {{-- <div>
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                    <label class="custom-control-label" for="defaultUnchecked">Remember me on this computer.</label>
                                </div>
                            </div> --}}
                            <button onclick="authenticate()" class="btn btn-success btn-lg float-right" id="btnLogin">Login</button>
                        </div>
                    </div>
                    <!--/card-block-->
                </div>
                <!-- /form card login -->
            </div>
        </div>
        <!-- JQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/js/mdb.min.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function authenticate () {
                let username = $('#usernameInput')[0].value;
                let password = $('#passwordInput')[0].value;
                // e.preventDefault();
                $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
                jQuery.ajax({
                   url: "{{'/a' . config('crm_authentication.main.login_route')}}",
                   method: 'post',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: {
                      "_token": "{{ csrf_token() }}",
                      username: username,
                      password: password
                   },
                   success: function(result){
                       console.log(result);
                       if(result == 'true') {
                           window.location = "{!! config('crm_authentication.main.home_route') !!}"
                       } else {
                           console.log('failed login.');
                       }
                   }
               });
        	}
        </script>
        <!--/container-->

    </body>
</html>
