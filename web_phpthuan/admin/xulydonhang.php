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
		$sql_update_tinhtrangdongiaodich = mysqli_query($con, "UPDATE tbl_giaodich SET tinhtrangdon = '$tinhtrang' WHERE magiaodich = '$mahang'");
		header('Location:xulydonhang.php');
	}
	//Delete đơn hàng
	if (isset($_GET['xoa'])) {
		$id_xoa = $_GET['xoa'];
		$sql_delete_donhang = mysqli_query($con, "DELETE FROM tbl_donhang WHERE mahang = '$id_xoa'");
	}
	//Click xác nhận hủy đơn hàng
	if (isset($_GET['xacnhanhuy']) && isset($_GET['mahang'])) {
		$huydon = $_GET['xacnhanhuy'];
		$mahang = $_GET['mahang'];
	} else {
		$huydon = '';
		$mahang = '';
	}
	$sql_update_xacnhanhuydon = mysqli_query($con, "UPDATE tbl_donhang SET huydon = '$huydon' WHERE mahang = '$mahang'");
	$sql_update_xacnhanhuydonhanggiaodich = mysqli_query($con, "UPDATE tbl_giaodich SET huydon = '$huydon' WHERE magiaodich = '$mahang'");
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Đơn hàng</title>
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
				//Nếu tồn tại $_GET['xemdonhang'] (click vào Xem chi tiết đơn hàng) thì hiện form Chi tiết đơn hàng
				if (isset($_GET['xemdonhang'])) {
					$mahang  = $_GET['xemdonhang'];
					$sql_show_chitietdonhang = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_sanpham WHERE tbl_donhang.sanpham_id = tbl_sanpham.sanpham_id AND tbl_donhang.mahang = '$mahang'");
			?>	
				<div class="col-md-12">	
					<h4>Chi tiết đơn hàng</h4>
					<form action="" method="POST">
						<table class="table table-bordered">
							<tr>
								<th>Thứ tự</th>
								<th>Mã hàng</th>
								<th>Tên sản phẩm</th>
								<th>Hình ảnh</th>
								<th>Số lượng</th>
								<th>Giá</th>
								<th>Tổng tiền</th>
								<th>Ngày đặt</th>
							</tr>
							<?php
								$stt = 0;
								while ($row_show_chitietdonhang = mysqli_fetch_array($sql_show_chitietdonhang)) {
							?>
							<tr>
								<td><?php echo ++$stt; ?></td>
								<td><?php echo $row_show_chitietdonhang['mahang'] ?></td>
								<td><?php echo $row_show_chitietdonhang['sanpham_name'] ?></td>
								<td><img style="width: 100px; height: 120px; image-rendering: pixelated;" src="<?php echo '../uploads/'.$row_show_chitietdonhang['sanpham_image'] ?>"></td>
								<td><?php echo $row_show_chitietdonhang['soluong'] ?></td>
								<td><?php echo number_format($row_show_chitietdonhang['sanpham_giakhuyenmai']).'vnđ' ?></td>
								<td><?php echo number_format($row_show_chitietdonhang['soluong'] * $row_show_chitietdonhang['sanpham_giakhuyenmai']).'vnđ' ?></td>
								<td><?php echo $row_show_chitietdonhang['ngaythang'] ?></td>
								<input type="hidden" name="mahang" value="<?php echo $row_show_chitietdonhang['mahang'] ?>">
							</tr>
							<?php
								}
							?>
						</table>
						<select class="form-control" name="tinhtrang" style="width: 35%">
							<option value="1">Đã xử lý | Giao hàng</option>
							<option value="0">Chưa xử lý</option>
						</select><br>
						<input type="submit" name="capnhatdonhang" value="Cập nhật đơn hàng" class="btn btn-success">
						<a class="btn btn-success" href="xulydonhang.php">Quay lại đơn hàng</a>
					</form>
				</div>
			<?php
				//Không thì hiện form Liệt kê đơn hàng
				} else {
			?>
					
					<div class="col-md-12">
						<h4>Liệt kê đơn hàng</h4><br>
						<?php
							$sql_laydonhang = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_sanpham,tbl_khachhang WHERE tbl_donhang.sanpham_id = tbl_sanpham.sanpham_id AND tbl_donhang.khachhang_id = tbl_khachhang.khachhang_id GROUP BY tbl_donhang.mahang");
						?>
						<table class="table table-bordered">
							<tr>
								<th>Thứ tự</th>
								<th>Mã hàng</th>
								<th>Tình trạng đơn hàng</th>
								<th>Tên khách hàng</th>
								<th>Ngày đặt</th>
								<th>Ghi chú</th>
								<th>Hủy đơn</th>
								<th>Quản lý</th>
							</tr>
							<?php
								$stt = 0;
								while ($row_laydonhang = mysqli_fetch_array($sql_laydonhang)) {
							?>
							<tr>
								<td><?php echo ++$stt; ?></td>
								<td><?php echo $row_laydonhang['mahang'] ?></td>
								<td>
									<?php 
										if ($row_laydonhang['tinhtrang'] == 0) {
											echo "Chưa xử lý";
										} else {
											echo "Đã xử lý";
										}
									?>
									
								</td>
								<td><?php echo $row_laydonhang['name'] ?></td>
								<td><?php echo $row_laydonhang['ngaythang'] ?></td>
								<td><?php echo $row_laydonhang['note'] ?></td>
								<td><?php 
										if ($row_laydonhang['huydon'] == 0) {

										} else if ($row_laydonhang['huydon'] == 1) {
											echo '<a href="xulydonhang.php?quanly=xemdonhang&mahang='.$row_laydonhang['mahang'].'&xacnhanhuy=2">Xác nhận hủy đơn</a>';
										} else {
											echo "Đã hủy";
										}
									?>	
								</td>
								<td><a href="?xoa=<?php echo $row_laydonhang['mahang'] ?>">Xóa đơn hàng</a> || <a href="?xemdonhang=<?php echo $row_laydonhang['mahang'] ?>">Xem chi tiết đơn hàng</a></td>
							</tr>
							<?php
								}
							?>
						</table>
					</div>
			<?php
					}
			?>

		</div>
	</div>
</body>
</html>