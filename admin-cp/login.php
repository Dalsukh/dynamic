<?php 
  require_once("../include/config.php");
  $errors = array(
            "email"=>"",
            "password"=>"",
            );
    $data = array(
            'email'=>"",
            );
    $message = "";

    if(isset($_POST['Login'])){

        $gump = new GUMP();
        
        $gump->validation_rules(array(
        'password'    => 'required|max_len:100',
        'email'       => 'required|valid_email',    
        ));

        
        $validated_data = $gump->run($_POST);

        if($validated_data === false) {

        $result = $gump->get_errors_array();
        $errors =array_merge($errors,$result);
        $data = $_POST;

        } else {

        $data = $_POST;
        $SELECT = "SELECT * FROM super_admin WHERE email='".$data['email']."' AND password='".md5($data['password'])."' AND deleted='0'";

        $result = mysqli_query($db,$SELECT);
        if(mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            $_SESSION['admin_id']=$row['id'];
            $_SESSION['name']=$row['first_name']." ".$row['last_name'];
            header("Location:index.php");
        }else{
            $errors['password'] = "Wrong email or Password";
        }       
        $message = "Record Insert Successfully";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dynamic | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .errors{
        font-weight: bold;
        color: #FF0000;
    }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./index2.html"><b>Dynamic</b> Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" name='email' class="form-control" placeholder="Email" value="<?php echo $data["email"];?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="errors"><?php echo $errors['email']?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="errors"><?php echo $errors['password']?></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="Login">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.php" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="./bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
