<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フリマシステム</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</head>
<body>
	<?php 
	if(isset($_GET['successMsg'])) {
	    echo "<script>alert('{$_GET['successMsg']}')</script>";
	}
	?>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
				<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
				<li class="nav-item"><a class="nav-link disabled" href="#">Disabled</a></li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
			<?php if(isset($_SESSION['userInfo'])){ ?>
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="./detailUser.php"><?=$_SESSION['userInfo']['user_id'] ?>様</a></li>
				<li class="nav-item"><a class="nav-link" href="./user/logout.php">Logout</a></li>
			</ul>
			<?php } else { ?>
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="./user/login.php">Sign in</a></li>
				<li class="nav-item"><a class="nav-link" href="./user/signup.php">Sign up</a></li>
			</ul>
			<?php } ?>
		</div>
	</nav>

	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1>フリマシステム</h1>
			<p>フリマシステムは。。。。。</p>
		</div>
	</div>

	
</body>
</html>