<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service</title>
    <!-- Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
  </head>
<body>
<div class="well" style="background-color:#ABA2FF;color:#000132;font-family: Haettenschweiler, 'Franklin Gothic Bold', 'TimesNewRoman Black', sans-serif;letter-spacing:2px;font-size:25px">SMART SERVICE NAVIGATION SYSTEM </div>
<div class="container-fluid" style="margin-top:-21px">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#inverseNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <a class="navbar-brand" href="home.php"><span class="glyphicon glyphicon-home"></span></a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="inverseNavbar1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="area_list.php">Location<span class="sr-only">(current)</span></a></li>
        <li><a href="mech_list.php">Mechanic</a></li>
        <li><a href="hspt_list.php">Hospital</a></li>
        <li><a href="hot_list.php">Hotel</a></li>
         <li><a href="book.php">Service Booking</a></li>
         <li><a href="response_list.php">Response List</a></li>
         
          <li><a href="areawisemech.php">Location wise Mechanic</a></li>
          <li><a href="areawisehspt.php">Location wise Hospital</a></li>
          <li><a href="areawisehot.php">Location wise Hotel</a></li>
            <li><a href="feedback_list.php">User Feedback</a></li>
       </ul>
    
      <ul class="nav navbar-nav navbar-right">
      	

         <li><a href="adminlogin.php">Logout</a></li>
       
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
</div>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
</body>
</html>