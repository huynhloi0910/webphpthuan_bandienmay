<?php session_start();
	if (!isset($_SESSION['admin_name'])) {
		header('Location: index.php');
	}
	include('../db/connect.php');
?>
<?php
	//Update tình trạng của đơn hàng
	if (isset($_POST['capnhatdonhang'])) {
		$tinhtrang = $_POST['tinhtrang'];
		$mahang    = $_POST['mahang'];
		$sql_update_tinhtrangdonhang = mysqli_query($con, "UPDATE tbl_donhang SET tinhtrang = '$tinhtrang' WHERE mahang = '$mahang'");
		header('Location:xulydonhang.php');
	}
	//Delete đơn hàng
	if (isset($_GET['xoa'])) {
		$id_xoa = $_GET['xoa'];
		$sql_delete_donhang = mysqli_query($con, "DELETE FROM tbl_donhang WHERE mahang = '$id_xoa'");
	}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Khách hàng</title>
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
			<div class="col-md-12">
				<h4>Khách hàng</h4><br>
				<?php
					$sql_laykhachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang,tbl_giaodich WHERE tbl_khachhang.khachhang_id = tbl_giaodich.khachhang_id GROUP BY tbl_giaodich.magiaodich");
				?>
				<table class="table table-bordered">
					<tr>
						<th>Thứ tự</th>
						<th>Tên khách hàng</th>
						<th>Số điện thoại</th>
						<th>Địa chỉ</th>
						<th>Email</th>
						<th>Ngày mua</th>
						<th>Quản lý</th>
					</tr>
					<?php
						$stt = 0;
						while ($row_laykhachhang = mysqli_fetch_array($sql_laykhachhang)) {
					?>
					<tr>
						<td><?php echo ++$stt; ?></td>
						<td><?php echo $row_laykhachhang['name'] ?></td>
						<td><?php echo $row_laykhachhang['phone'] ?></td>
						<td><?php echo $row_laykhachhang['address'] ?></td>
						<td><?php echo $row_laykhachhang['email'] ?></td>
						<td><?php echo $row_laykhachhang['ngaythang'] ?></td>
						<td><a href="?xemgiaodich=<?php echo $row_laykhachhang['magiaodich'] ?>">Xem giao dịch</a></td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
			<div class="col-md-12">
				<?php
					if (isset($_GET['xemgiaodich'])) {
						$magiaodich = $_GET['xemgiaodich'];
					$sql_laygiaodich = mysqli_query($con, "SELECT * FROM tbl_giaodich,tbl_sanpham,tbl_khachhang WHERE tbl_giaodich.sanpham_id = tbl_sanpham.sanpham_id AND tbl_giaodich.khachhang_id = tbl_khachhang.khachhang_id AND tbl_giaodich.magiaodich = '$magiaodich' ORDER BY tbl_giaodich.giaodich_id DESC");
				?>
					<h4>Liệt kê lịch sử đơn hàng</h4><br>
					<table class="table table-bordered">
						<tr>
							<th>Thứ tự</th>
							<th>Mã hàng</th>
							<th>Tên sản phẩm</th>
							<th>Ngày đặt</th>
						</tr>
						<?php
							$stt = 0;
							while ($row_laygiaodich = mysqli_fetch_array($sql_laygiaodich)) {
						?>
						<tr>
							<td><?php echo ++$stt; ?></td>
							<td><?php echo $row_laygiaodich['magiaodich'] ?></td>
							<td><?php echo $row_laygiaodich['sanpham_name'] ?></td>
							<td><?php echo $row_laygiaodich['ngaythang'] ?></td>
						</tr>
						<?php
							}
						?>
					</table>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>