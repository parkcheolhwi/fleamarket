    	<?php 
    	if(isset($_GET['successMsg'])) {
    	    echo "<script>alert('{$_GET['successMsg']}')</script>";
    	}
    	if(isset($_GET['errorMsg'])) {
    	    echo "<script>alert('{$_GET['errorMsg']}')</script>";
    	}
    	?>
    	<!-- 管理者navbar -->
	<?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] == '9'){?>
	    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: white;">
    		<a class="navbar-brand" href="http://localhost:8712/fleamarket_php/index.php">フリマシステム</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
    		</button>
    		
    		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    			<ul class="navbar-nav mr-auto">
    				<li class="nav-item"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
    				<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    				<li class="nav-item"><a class="nav-link" href="#">Disabled</a></li>
    				<li class="nav-item"><a class="nav-link" href="http://localhost:8712/fleamarket_php/user/listUser.php">ユーザー管理</a></li>
    				<li class="nav-item"><a class="nav-link" href="http://localhost:8712/fleamarket_php/inquiry/listInquiry.php">お問い合わせ</a></li>
    			</ul>
    			<form class="form-inline my-2 my-lg-0">
    				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    			</form>
    			<ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i><?=$_SESSION['userInfo']['user_id'] ?>様</a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                            <a class="dropdown-item" href="http://localhost:8712/fleamarket_php/user/detailUser.php">My account</a>
                            <a class="dropdown-item" href="http://localhost:8712/fleamarket_php/user/logout.php">Log out</a>
                        </div>
                    </li>
    			</ul>	
    		</div>
    	</nav>
    	<!-- 一般ユーザー -->
    <?php }else if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] == '1') {?>
    	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    		<a class="navbar-brand" href="http://localhost:8712/fleamarket_php/index.php">Navbar</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
    		</button>
    		
    		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    			<ul class="navbar-nav mr-auto">
    				<li class="nav-item"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
    				<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    				<li class="nav-item"><a class="nav-link disabled" href="#">Disabled</a></li>
    				<li class="nav-item"><a class="nav-link" href="http://localhost:8712/fleamarket_php/inquiry/inquiry.php">お問い合わせ</a></li>
    			</ul>
    			<form class="form-inline my-2 my-lg-0">
    				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    			</form>
    			<ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i><?=$_SESSION['userInfo']['user_id'] ?>様</a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                            <a class="dropdown-item" href="http://localhost:8712/fleamarket_php/user/detailUser.php">My account</a>
                            <a class="dropdown-item" href="http://localhost:8712/fleamarket_php/inquiry/inquiry.php">Help</a>
                            <a class="dropdown-item" href="http://localhost:8712/fleamarket_php/user/logout.php">Log out</a>
                        </div>
                    </li>
    			</ul>	
    		</div>
    	</nav>
    	<!-- 全て -->
	<?php } else {?>
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    		<a class="navbar-brand" href="http://localhost:8712/fleamarket_php/index.php">Navbar</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
    		</button>
    		
    		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    			<ul class="navbar-nav mr-auto">
    				<li class="nav-item"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
    				<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    				<li class="nav-item"><a class="nav-link disabled" href="#">Disabled</a></li>
    			</ul>
    			<form class="form-inline my-2 my-lg-0">
    				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    			</form>
	
    			<ul class="navbar-nav">	
    				<li class="nav-item"><a class="nav-link" href="http://localhost:8712/fleamarket_php/user/login.php">Sign in</a></li>
    				<li class="nav-item"><a class="nav-link" href="http://localhost:8712/fleamarket_php/user/signup.php">Sign up</a></li>
    			</ul>	
    		</div>
    	</nav>
	<?php }?>
	