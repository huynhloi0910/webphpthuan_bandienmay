<?php session_start();
	include('../db/connect.php');
	//session_destroy();
?>
<?php
	if (isset($_POST['dangnhap'])) {
		$taikhoan = $_POST['taikhoan'];
		$matkhau  = md5($_POST['matkhau']);
		if ($taikhoan == '' || $matkhau == '') {
			echo "<p>Xin nhập đủ</p>";
		} else {
			$sql_dangnhap = mysqli_query($con, "SELECT * FROM tbl_admin WHERE email = '$taikhoan' AND password = '$matkhau' LIMIT 1");
			$row_dangnhap = mysqli_fetch_array($sql_dangnhap);
			$result = mysqli_num_rows($sql_dangnhap);
			if ($result > 0) {
				$_SESSION['admin_id'] = $row_dangnhap['admin_id'];
				$_SESSION['admin_name'] = $row_dangnhap['admin_name'];
				header('Location:dashboard.php');
			} else {
				echo "<p>Tên đăng nhập hoặc mật khẩu sai</p>";
			}
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Đăng nhập Admin</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<h3 align="center">Đăng nhập Admin</h3>
	<div class="col-md-6">
		<div class="form-group">
			<form action="" method="post">
				<label>Tài khoản</label>
				<input type="email" name="taikhoan" placeholder="Điền email" class="form-control" required=""><br>
				<label>Mật khẩu</label>
				<input type="password" name="matkhau" placeholder="Điền mật khẩu" class="form-control" required=""><br>
				<input type="submit" name="dangnhap" class="btn btn-primary" value="Đăng nhập Admin">
			</form>
		</div>
	</div>
	

</body>
</html>