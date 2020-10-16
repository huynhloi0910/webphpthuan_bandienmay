<?php session_start();
	//Nếu tồn tại $_SESSION['admin_name'] thì mấy cho vào trang xulybaiviet.php
	if (!isset($_SESSION['admin_name'])) {
		header('Location: index.php');
	}
	include('../db/connect.php');
?>
<?php
	//Khi click Thêm bài viết
	if (isset($_POST['thembaiviet'])) {
		$namesp    = $_POST['tenbaiviet'];
		$imgsp     = $_FILES['hinhanh']['name'];
		$imgsp_tmp = $_FILES['hinhanh']['tmp_name'];
		$des       = $_POST['tomtat'];
		$detail    = $_POST['noidung'];
		$category  = $_POST['danhmucbaiviet'];
		$path      = '../uploads/';
		//Insert dữ liệu vào tbl_baiviet
		$sql_insert_post = mysqli_query($con, "INSERT INTO tbl_baiviet(tenbaiviet, tomtat, noidung, danhmuctin_id, baiviet_image) VALUES ('$namesp','$des','$detail','$category','$imgsp')");
		//Upload file ảnh vào folder Uploads
		move_uploaded_file($imgsp_tmp, $path.$imgsp);
	//Khi click cập nhật bài viết	
	} else if (isset($_POST['capnhatbaiviet'])) {
		$id_update = $_GET['capnhat'];
		$namesp    = $_POST['tenbaiviet'];
		$imgsp     = $_FILES['hinhanh']['name'];
		$imgsp_tmp = $_FILES['hinhanh']['tmp_name'];
		$des       = $_POST['tomtat'];
		$detail    = $_POST['noidung'];
		$category  = $_POST['danhmucbaiviet'];
		$path      = '../uploads/';
		//Nếu người dùng không chọn hình ảnh thì không Update dữ liệu ảnh cho tbl_baiviet
		if ($imgsp == '') {
			$sql_update_image = "UPDATE tbl_baiviet SET tenbaiviet = '$namesp', tomtat = '$des', noidung = '$detail',danhmuctin_id = '$category' WHERE baiviet_id = '$id_update'";
		//Update dữ liệu có chọn hình ảnh
		} else {
			$sql_update_image = "UPDATE tbl_baiviet SET tenbaiviet = '$namesp', tomtat = '$des', noidung = '$detail',danhmuctin_id = '$category', baiviet_image = '$imgsp' WHERE baiviet_id = '$id_update'";
			//Upload file ảnh vào folder Uploads
			// move_uploaded_file($imgsp_tmp, $path.$imgsp);
		}
		mysqli_query($con, $sql_update_image);
	}
	//Khi click Xóa
	if (isset($_GET['xoa'])) {
		$id_xoa = $_GET['xoa'];
		$sql_delete_baiviet = mysqli_query($con, "DELETE FROM tbl_baiviet WHERE baiviet_id = '$id_xoa'");
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
					$sql_show_baiviet = mysqli_query($con, "SELECT * FROM tbl_baiviet WHERE baiviet_id = '$id_capnhat'");
					$row_show_baiviet = mysqli_fetch_array($sql_show_baiviet);		
					$id_danhmuctin = $row_show_baiviet['danhmuctin_id'];	
			?>
					<div class="col-md-4">
						<h4>Cập nhật bài viết</h4>
						<form action="" method="POST" enctype="multipart/form-data">
							<label>Tên bài viết</label>
							<input type="text" name="tenbaiviet" class="form-control" value="<?php echo $row_show_baiviet['tenbaiviet'] ?>"><br>
							<label>Hình ảnh</label>
							<input type="file" name="hinhanh" class="form-control"><br>
							<img style="height: 120px; image-rendering: pixelated;" src="../uploads/<?php echo $row_show_baiviet['baiviet_image'] ?>" data-imagezoom="true" class="img-fluid" alt=""> <br>
							<label>Tóm tắt</label>
							<textarea class="form-control" name="tomtat" style="resize: none;"><?php echo $row_show_baiviet['tomtat'] ?></textarea><br>
							<label>Nội dung</label>
							<textarea class="form-control" name="noidung" style="resize: none;"><?php echo $row_show_baiviet['noidung'] ?></textarea><br>
							<label>Danh mục bài viết</label>
							<select class="form-control" name="danhmucbaiviet">
								<option value="0">-----Chọn danh mục bài viết-----</option>
							<?php
								$sql_danhmucbaiviet = mysqli_query($con, "SELECT * FROM tbl_danhmuctin ORDER BY danhmuctin_id DESC");
								while ($row_danhmucbaiviet = mysqli_fetch_array($sql_danhmucbaiviet)) {
									if ($id_danhmuctin == $row_danhmucbaiviet['danhmuctin_id']) {
							?>
								<option selected value="<?php echo $row_danhmucbaiviet['danhmuctin_id'] ?>"><?php echo $row_danhmucbaiviet['tendanhmuc'] ?></option>
							<?php
									} else {
							?>
										<option value="<?php echo $row_danhmucbaiviet['danhmuctin_id'] ?>"><?php echo $row_danhmucbaiviet['tendanhmuc'] ?></option>
								<?php
										}
									}
								?>
								}
							?>
							</select><br>
							<input type="submit" name="capnhatbaiviet" class="btn btn-default" value="Cập nhật bài viết">
						</form>
					</div>
			<?php
				} else {
			?>
					<div class="col-md-4">
						<h4>Thêm bài viết</h4>
						<form action="" method="POST" enctype="multipart/form-data">
							<label>Tên bài viết</label>
							<input type="text" name="tenbaiviet" class="form-control" placeholder="Tên bài viết" required=""><br>
							<label>Hình ảnh</label>
							<input type="file" name="hinhanh" class="form-control" required=""><br>
							<label>Tóm tắt</label>
							<textarea class="form-control" name="tomtat" style="resize: none;" required=""></textarea><br>
							<label>Nội dung</label>
							<textarea class="form-control" name="noidung" style="resize: none;" required=""></textarea><br>
							<label>Danh mục bài viết</label>
							<select class="form-control" name="danhmucbaiviet" required="">
								<option value="0">-----Chọn danh mục bài viết-----</option>
							<?php
								$sql_danhmuctin = mysqli_query($con, "SELECT * FROM tbl_danhmuctin ORDER BY danhmuctin_id DESC");
								while ($row_danhmuctin = mysqli_fetch_array($sql_danhmuctin)) {
							?>
								<option value="<?php echo $row_danhmuctin['danhmuctin_id'] ?>"><?php echo $row_danhmuctin['tendanhmuc'] ?></option>
							<?php
								}
							?>
							</select><br>

							<input type="submit" name="thembaiviet" class="btn btn-default" value="Thêm bài viết">
						</form>
					</div>
			<?php
					}
			?>

			<div class="col-md-8">
				<h4>Liệt kê bài viết</h4><br>
				<?php
					$sql_laybaiviet= mysqli_query($con, "SELECT * FROM tbl_baiviet,tbl_danhmuctin WHERE tbl_baiviet.danhmuctin_id = tbl_danhmuctin.danhmuctin_id ORDER BY tbl_baiviet.baiviet_id DESC");
				?>
				<table class="table table-bordered">
					<tr>
						<th>Thứ tự</th>
						<th>Tên bài viết</th>
						<th>Hình ảnh</th>
						<th>Tóm tắt</th>
						<th>Nội dung</th>
						<th>Danh mục tin bài viết</th>
						<th>Quản lý</th>
					</tr>
					<?php
						$stt = 0;
						while ($row_laybaiviet = mysqli_fetch_array($sql_laybaiviet)) {
					?>
					<tr>
						<td><?php echo ++$stt; ?></td>
						<td><?php echo $row_laybaiviet['tenbaiviet'] ?></td>
						<td><img style="width: 100px; height: 120px; image-rendering: pixelated;" src="<?php echo '../uploads/'.$row_laybaiviet['baiviet_image'] ?>"></td>
						<td><?php echo $row_laybaiviet['tomtat'] ?></td>
						<td><?php echo $row_laybaiviet['noidung'] ?></td>
						<td><?php echo $row_laybaiviet['tendanhmuc'] ?></td>
						<td><a href="?xoa=<?php echo $row_laybaiviet['baiviet_id'] ?>">Xóa</a> || <a href="?capnhat=<?php echo $row_laybaiviet['baiviet_id'] ?>">Cập nhật</a></td>

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