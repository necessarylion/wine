<?php include '../config.php';
include "auth.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo $application_url ?>resource/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo $application_url ?>resource/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              
              <div class="col-lg-12 p-5">
             
                <div class="p-5">
                  <div class="text-center">
                  <img src="logo.svg" class="img-fluid" alt="" style='margin-top: 10px;'><br><br>
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" id='submit'>

                    <div class="form-group text-center"><span class="form-error"></span>
                      <input type="text" name='username' class="form-control form-control-user"  placeholder="Username">
                    </div>
                    <div class="form-group text-center"><span class="form-error"></span>
                      <input type="password" name='password' class="form-control form-control-user"  placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Sign In
                    </button>
                    <hr>
                    
                  </form>
                
                </div>

                <div class="text-center">Not A User  <a href="signup.php"><u>Click Here</a></u> To Sign Up</div>

              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo $application_url ?>resource/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo $application_url ?>resource/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo $application_url ?>resource/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo $application_url; ?>resource/vendor/bootbox/bootbox.all.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?php echo $application_url ?>resource/js/sb-admin-2.min.js"></script>
 
  <script src="public/js/ajax.js"></script>
  <script src="public/js/validate.js"></script>
</body>

</html>
<script>
$('#submit').submit(function(event){
	var data = new FormData(this);
	event.preventDefault();
	$('.form-error').html('');

	$$('username').checkempty();
	$$('password').checkempty();

	if(result.length != 0){ //set error to empty
      result = [];
	}
	else{ //check no error
		formAjax(data, 'action/login.php', function(out){
			if(out == 'success'){
				window.location.href = '../extension/calendar/';
			}
			else{
				bootbox.alert(out);
			}
		})
		
	}
})

</script>