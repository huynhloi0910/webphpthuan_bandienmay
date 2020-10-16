<?php session_start();
	if (!isset($_SESSION['admin_name'])) {
		header('Location: index.php');
	}
	//Khi click đăng xuất
	if (isset($_GET['dangxuat'])) {
		$dangxuat = $_GET['dangxuat'];
	} else {
		$dangxuat = '';
	}
	if ($dangxuat == 'dangxuat') {
		unset($_SESSION['admin_name']);
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome Admin</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<p>Xin chào <?php echo $_SESSION["admin_name"] ?> <a href="?dangxuat=dangxuat">Đăng xuất</a></p>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	    <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
		    <li class="nav-item active">
		      	<a class="nav-link" href="xulydonhang.php">Đơn hàng<span class="sr-only">(current)</span></a>
		    </li>
		    <li class="nav-item">
		        <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
		    </li>
	    	<li class="nav-item">
		        <a class="nav-link" href="xulydanhmucbaiviet.php">Danh mục Bài viết</a>
		    </li>
		    <li class="nav-item">
		        <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
		    </li>
		    <li class="nav-item">
		        <a class="nav-link" href="xulykhachhang.php">Khách hàng</a>
		    </li>
	    </ul>
	    </div>
	</nav>

</body>
</html>