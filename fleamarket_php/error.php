<?php 
    if(isset($_GET['errorMsg'])) $errorMsg = $_GET['errorMsg'];
    if(isset($_GET['path'])) $path = $_GET['path'];
    
    
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title</title>
</head>
<body>
<?php
echo $errorMsg;
echo $path;
?>​
</body>
</html>