<?php
    require_once("../include/config.php");
    require_once("./GUMP/gump.class.php");
    $errors = array(
            "first_name"=>"",
            "last_name"=>"",
            "email"=>"",
            "mobile"=>"",
            "password"=>"",
            "confirm_password"=>""
            );
    $data = array(
            "first_name"=>"",
            "last_name"=>"",
            "email"=>"",
            "mobile"=>"",
            );
    $message = "";

    if(isset($_POST['Register'])){

        $gump = new GUMP();
        
        $gump->validation_rules(array(
        'first_name'  => 'required|alpha_numeric',
        'last_name'   => 'required|alpha_numeric',
        "mobile" => "required|numeric|min_len,10",
        'password'    => 'required|max_len,100',
        'confirm_password'    => 'confirm,password',
        'email'       => 'required|valid_email',    
        ));

        
        $validated_data = $gump->run($_POST);

        if($validated_data === false) {

        $result = $gump->get_errors_array();
        $errors =array_merge($errors,$result);
        $data = $_POST;

        } else {

        $INSERT = "INSERT INTO super_admin (`id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `status`, `created_at`, `updated_at`, `deleted`)
             VALUES 
             (NULL, '".re_db_input($_POST['first_name'],$db)."',
                    '".re_db_input($_POST['last_name'],$db)."',
                    '".re_db_input($_POST['email'],$db)."',
                    '".md5(re_db_input($_POST['password'],$db))."',
                    '".re_db_input($_POST['mobile'],$db)."',
                    '1',CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), '0');";
        $result = mysqli_query($db,$INSERT);
        $message = "Record Insert Successfully";
        }
        
        
    }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="./index.php"><b>Dynamic</b> Dashboard</a>
  </div>
    <?php if(!empty($message)) { ?>
    
    <div class="alert alert-dissmable alert-success"><?php echo $message; ?></div>
    <?php } ?>
  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="register.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="First name" name="first_name" 
        value="<?php echo $data['first_name']; ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <span class="errors"><?php echo $errors['first_name'];?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Last Name" name="last_name"
        value="<?php echo $data['last_name']; ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <span class="errors"><?php echo $errors['last_name'];?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email"
        value="<?php echo $data['email']; ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="errors"><?php echo $errors['email'];?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Mobile" name="mobile"
        value="<?php echo $data['mobile']; ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="errors"><?php echo $errors['mobile'];?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="errors"><?php echo $errors['password'];?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="confirm_password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <span class="errors"><?php echo $errors['confirm_password'];?></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="Register" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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
