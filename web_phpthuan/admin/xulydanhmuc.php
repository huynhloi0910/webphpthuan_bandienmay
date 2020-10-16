<?php session_start();
	if (!isset($_SESSION['admin_name'])) {
		header('Location: index.php');
	}
	include('../db/connect.php');
?>
<?php
	if (isset($_POST['themdanhmuc'])) {
		$tendanhmuc = $_POST['danhmuc'];
		$sql_themdanhmuc = mysqli_query($con, "INSERT INTO tbl_category(category_name) VALUES('$tendanhmuc')");
	} else if (isset($_POST['capnhatdanhmuc'])) {
		//Dùng phương thức POST để lấy dữ liệu biến capnhat trong phương thức GET 
		//$id = $_POST['id'];
		$id = $_GET['capnhat'];
		$update_name = $_POST['updatedanhmuc'];
		$sql_update_danhmuc = mysqli_query($con, "UPDATE tbl_category SET category_name = '$update_name' WHERE category_id = '$id'");
		header("Location: xulydanhmuc.php");
	}

	if (isset($_GET['xoa'])) {
		$id_xoa = $_GET['xoa'];
		$sql_delete_danhmuc = mysqli_query($con, "DELETE FROM tbl_category WHERE category_id = '$id_xoa'");
	}

?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Danh mục</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
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
			        <a class="nav-link" href="xulybaiviet.php">Bài viết</a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link" href="xulykhachhang.php">Khách hàng</a>
			    </li>
		    </ul>
	    </div>
	</nav><br><br>

	<div class="container">
		<div class="row">
			<?php
				if (isset($_GET['capnhat'])) {
					$id_capnhat  = $_GET['capnhat'];
					$sql_show_danhmuc = mysqli_query($con, "SELECT * FROM tbl_category WHERE category_id = '$id_capnhat'");
					$row_show_danhmuc = mysqli_fetch_array($sql_show_danhmuc);			
			?>
				<div class="col-md-4">
					<h4>Cập nhật danh mục</h4>
					<label>Tên danh mục</label>
					<form action="" method="POST">
						<input type="text" name="updatedanhmuc" class="form-control" value="<?php echo $row_show_danhmuc['category_name'] ?>"><br>
						<!-- <input type="hidden" name="id" value="<?php echo $row_show_danhmuc['category_id'] ?>"> -->
						<input type="submit" name="capnhatdanhmuc" class="btn btn-default" value="Cập nhật danh mục">
					</form>
				</div>
			<?php
				} else {
			?>
					<div class="col-md-4">
						<h4>Thêm danh mục</h4>
						<label>Tên danh mục</label>
						<form action="" method="POST">
							<input type="text" name="danhmuc" class="form-control" placeholder="Tên danh mục" required=""><br>
							<input type="submit" name="themdanhmuc" class="btn btn-default" value="Thêm danh mục">
						</form>
					</div>
			<?php
					}
			?>

			<div class="col-md-8">
				<h4>Liệt kê danh mục</h4><br>
				<?php
					$sql_laydanhmuc = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
				?>
				<table class="table table-bordered">
					<tr>
						<th>Thứ tự</th>
						<th>Tên danh mục</th>
						<th>Quản lý</th>
					</tr>
					<?php
						$stt = 0;
						while ($row_laydanhmuc = mysqli_fetch_array($sql_laydanhmuc)) {
					?>
					<tr>
						<td><?php echo ++$stt; ?></td>
						<td><?php echo $row_laydanhmuc['category_name'] ?></td>
						<td><a href="?xoa=<?php echo $row_laydanhmuc['category_id'] ?>">Xóa</a> || <a href="?capnhat=<?php echo $row_laydanhmuc['category_id'] ?>">Cập nhật</a></td>

					</tr>
					<?php
						}
					?>
				</table>
	
			</div>
		</div>
	</div>
</body>
</html>