<?php 
    if(isset($_GET['errorMsg'])) $errorMsg = $_GET['errorMsg'];
    if(isset($_GET['path'])) $path = $_GET['path'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>エラー | フリマシステム</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/user.css">
</head>
<body>
<?php require_once './menu/menunav.php';?>
<div class="container">
	<h1 style="text-align:center"><?=$errorMsg ?></h1>
	
	<h5 style="text-align:center"><a href="./index.php"><?=$path ?></a></h5>
</div>


<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/user.js"></script>
​
</body>
</html>