<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="views/template/images/favicon.png" type="image/png">

  <title>Login</title>

  <link href="views/template/css/style.default.css?var=100" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="signin">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
    <div class="signinpanel">
        
        <div class="row">
            
            <!-- col-sm-7 -->
            
            <div class="col-md-6 col-md-offset-3">
                <form method="post" action="index.php">
                    <h4 class="nomargin">Sign In</h4>
                    <p class="mt5 mb20">Login to access your admin panel.</p>
                
                    <input type="text" name="username" class="form-control uname" placeholder="Username" />
                    <input type="password" name="password" class="form-control pword" placeholder="Password" />
                    <button class="btn btn-success btn-block">Sign In</button>
                    
                </form>
            </div><!-- col-sm-5 -->
            
        </div><!-- row -->
        
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2014. All Rights Reserved. 
            </div>
            <div class="pull-right">
                
            </div>
        </div>
        
    </div><!-- signin -->
  
</section>


<script src="views/template/js/jquery-1.10.2.min.js"></script>
<script src="views/template/js/jquery-migrate-1.2.1.min.js"></script>
<script src="views/template/js/bootstrap.min.js"></script>
<script src="views/template/js/modernizr.min.js"></script>
<script src="views/template/js/retina.min.js"></script>

<script src="views/template/js/custom.js"></script>

</body>

</html>
