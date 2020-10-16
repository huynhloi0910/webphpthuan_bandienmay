<?php session_start();
	//Nếu tồn tại $_SESSION['admin_name'] thì mấy cho vào trang xulysanpham.php
	if (!isset($_SESSION['admin_name'])) {
		header('Location: index.php');
	}
	include('../db/connect.php');
?>
<?php
	//Khi click Thêm sản phẩm
	if (isset($_POST['themsanpham'])) {
		$namesp    = $_POST['tensanpham'];
		$imgsp     = $_FILES['hinhanh']['name'];
		$imgsp_tmp = $_FILES['hinhanh']['tmp_name'];
		$price     = $_POST['gia'];
		$discount  = $_POST['giakhuyenmai'];
		$amount    = $_POST['soluong'];
		$des       = $_POST['mota'];
		$detail    = $_POST['chitiet'];
		$category  = $_POST['danhmuc'];
		$path      = '../uploads/';
		//Insert dữ liệu vào tbl_sanpham
		$sql_insert_product = mysqli_query($con, "INSERT INTO tbl_sanpham(category_id, sanpham_name, sanpham_chitiet, sanpham_mota, sanpham_gia, sanpham_giakhuyenmai, sanpham_soluong, sanpham_image) VALUES ('$category','$namesp','$detail','$des','$price','$discount','$amount','$imgsp')");
		//Upload file ảnh vào folder Uploads
		move_uploaded_file($imgsp_tmp, $path.$imgsp);
	//Khi click cập nhật sản phẩm	
	} else if (isset($_POST['capnhatsanpham'])) {
		$id_update = $_GET['capnhat'];
		$namesp    = $_POST['tensanpham'];
		$imgsp     = $_FILES['hinhanh']['name'];
		$imgsp_tmp = $_FILES['hinhanh']['tmp_name'];
		$price     = $_POST['gia'];
		$discount  = $_POST['giakhuyenmai'];
		$amount    = $_POST['soluong'];
		$des       = $_POST['mota'];
		$detail    = $_POST['chitiet'];
		$category  = $_POST['danhmuc'];
		$path      = '../uploads/';
		//Nếu người dùng không chọn hình ảnh thì không Update dữ liệu ảnh cho tbl_sanpham
		if ($imgsp == '') {
			$sql_update_image = "UPDATE tbl_sanpham SET category_id = '$category', sanpham_name = '$namesp', sanpham_chitiet = '$detail', sanpham_mota = '$des', sanpham_gia = '$price', sanpham_giakhuyenmai = '$discount', sanpham_soluong = '$amount' WHERE sanpham_id = '$id_update'";
		//Update dữ liệu có chọn hình ảnh
		} else {
			$sql_update_image = "UPDATE tbl_sanpham SET category_id = '$category', sanpham_name = '$namesp', sanpham_chitiet = '$detail', sanpham_mota = '$des', sanpham_gia = '$price', sanpham_giakhuyenmai = '$discount', sanpham_soluong = '$amount', sanpham_image = '$imgsp' WHERE sanpham_id = '$id_update'";
			//Upload file ảnh vào folder Uploads
			// move_uploaded_file($imgsp_tmp, $path.$imgsp);
		}
		mysqli_query($con, $sql_update_image);
	}
	//Khi click Xóa
	if (isset($_GET['xoa'])) {
		$id_xoa = $_GET['xoa'];
		$sql_delete_sanpham = mysqli_query($con, "DELETE FROM tbl_sanpham WHERE sanpham_id = '$id_xoa'");
	}

?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Sản Phẩm</title>
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
					$sql_show_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_id = '$id_capnhat'");
					$row_show_sanpham = mysqli_fetch_array($sql_show_sanpham);		
					$id_danhmuc = $row_show_sanpham['category_id'];	
			?>
					<div class="col-md-4">
						<h4>Cập nhật sản phẩm</h4>
						<form action="" method="POST" enctype="multipart/form-data">
							<label>Tên sản phẩm</label>
							<input type="text" name="tensanpham" class="form-control" value="<?php echo $row_show_sanpham['sanpham_name'] ?>"><br>
							<label>Hình ảnh</label>
							<input type="file" name="hinhanh" class="form-control"><br>
							<img style="height: 120px; image-rendering: pixelated;" src="../uploads/<?php echo $row_show_sanpham['sanpham_image'] ?>" data-imagezoom="true" class="img-fluid" alt=""> <br>
							<label>Giá</label>
							<input type="text" name="gia" class="form-control" value="<?php echo $row_show_sanpham['sanpham_gia'] ?>"><br>
							<label>Giá khuyến mãi</label>
							<input type="text" name="giakhuyenmai" class="form-control" value="<?php echo $row_show_sanpham['sanpham_giakhuyenmai'] ?>"><br>
							<label>Số lượng</label>
							<input type="text" name="soluong" class="form-control" value="<?php echo $row_show_sanpham['sanpham_soluong'] ?>"><br>
							<label>Mô tả</label>
							<textarea class="form-control" name="mota" style="resize: none;"><?php echo $row_show_sanpham['sanpham_mota'] ?></textarea><br>
							<label>Chi tiết</label>
							<textarea class="form-control" name="chitiet" style="resize: none;"><?php echo $row_show_sanpham['sanpham_chitiet'] ?></textarea><br>
							<label>Danh mục</label>
							<select class="form-control" name="danhmuc">
								<option value="0">-----Chọn danh mục-----</option>
							<?php
								$sql_danhmuc = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
								while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
									if ($id_danhmuc == $row_danhmuc['category_id']) {
							?>
								<option selected value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
							<?php
									} else {
							?>
										<option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
								<?php
										}
									}
								?>
								}
							?>
							</select><br>
							<input type="submit" name="capnhatsanpham" class="btn btn-default" value="Cập nhật sản phẩm">
						</form>
					</div>
			<?php
				} else {
			?>
					<div class="col-md-4">
						<h4>Thêm sản phẩm</h4>
						<form action="" method="POST" enctype="multipart/form-data">
							<label>Tên sản phẩm</label>
							<input type="text" name="tensanpham" class="form-control" placeholder="Tên sản phẩm" required=""><br>
							<label>Hình ảnh</label>
							<input type="file" name="hinhanh" class="form-control" required=""><br>
							<label>Giá</label>
							<input type="text" name="gia" class="form-control" placeholder="Giá sản phẩm" required=""><br>
							<label>Giá khuyến mãi</label>
							<input type="text" name="giakhuyenmai" class="form-control" placeholder="Giá khuyến mãi" required=""><br>
							<label>Số lượng</label>
							<input type="text" name="soluong" class="form-control" placeholder="Số lượng" required=""><br>
							<label>Mô tả</label>
							<textarea class="form-control" name="mota" style="resize: none;" required=""></textarea><br>
							<label>Chi tiết</label>
							<textarea class="form-control" name="chitiet" style="resize: none;" required=""></textarea><br>
							<label>Danh mục</label>
							<select class="form-control" name="danhmuc" required="">
								<option value="0">-----Chọn danh mục-----</option>
							<?php
								$sql_danhmuc = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
								while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
							?>
								<option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
							<?php
								}
							?>
							</select><br>

							<input type="submit" name="themsanpham" class="btn btn-default" value="Thêm sản phẩm">
						</form>
					</div>
			<?php
					}
			?>

			<div class="col-md-8">
				<h4>Liệt kê sản phẩm</h4><br>
				<?php
					$sql_laysanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.category_id = tbl_category.category_id ORDER BY tbl_sanpham.sanpham_id DESC");
				?>
				<table class="table table-bordered">
					<tr>
						<th>Thứ tự</th>
						<th>Tên sản phẩm</th>
						<th>Hình ảnh</th>
						<th>Số lượng</th>
						<th>Danh mục</th>
						<th>Giá sản phẩm</th>
						<th>Giá khuyến mãi</th>
						<th>Quản lý</th>
					</tr>
					<?php
						$stt = 0;
						while ($row_laysanpham = mysqli_fetch_array($sql_laysanpham)) {
					?>
					<tr>
						<td><?php echo ++$stt; ?></td>
						<td><?php echo $row_laysanpham['sanpham_name'] ?></td>
						<td><img style="width: 100px; height: 120px; image-rendering: pixelated;" src="<?php echo '../uploads/'.$row_laysanpham['sanpham_image'] ?>"></td>
						<td><?php echo $row_laysanpham['sanpham_soluong'] ?></td>
						<td><?php echo $row_laysanpham['category_name'] ?></td>
						<td><?php echo number_format($row_laysanpham['sanpham_gia']).'vnđ' ?></td>
						<td><?php echo number_format($row_laysanpham['sanpham_giakhuyenmai']).'vnđ' ?></td>
						<td><a href="?xoa=<?php echo $row_laysanpham['sanpham_id'] ?>">Xóa</a> || <a href="?capnhat=<?php echo $row_laysanpham['sanpham_id'] ?>">Cập nhật</a></td>

					</tr>
					<?php
						}
					?>
				</table>
	
			</div>
		</div>
	</div>
<script src="js/imagezoom.js"></script>
</body>
</html>