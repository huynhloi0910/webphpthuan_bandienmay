<?php
	if (isset($_GET['id_tin'])) {
		$id_tin = $_GET['id_tin'];
	} else {
		$id_tin = '';
	}

?>
<!-- page -->
<div class="services-breadcrumb">
	<div class="agile_inner_breadcrumb">
		<div class="container">
			<ul class="w3_short">
				<li>
					<a href="index.php">Trang chủ</a>
					<i>|</i>
				</li>
				<?php
					$sql_tentin = mysqli_query($con, "SELECT * FROM tbl_danhmuctin WHERE danhmuctin_id = '$id_tin'");
					$row_tentin = mysqli_fetch_array($sql_tentin);
				?>
				<li><h3><?php echo $row_tentin['tendanhmuc']; ?></h3></li>
			</ul>
		</div>
	</div>
</div>
<!-- //page -->

<!-- about -->
<div class="welcome py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>D</span>anh
			<span>M</span>ục
			<span>T</span>in</h3>
		<!-- //tittle heading -->
		<?php
			$sql_baiviet = mysqli_query($con , "SELECT * FROM tbl_baiviet, tbl_danhmuctin WHERE tbl_baiviet.danhmuctin_id = tbl_danhmuctin.danhmuctin_id AND tbl_baiviet.danhmuctin_id = '$id_tin'");
			while ($row_baiviet = mysqli_fetch_array($sql_baiviet)) {
		?>
		<div class="row">
			<div class="col-lg-7 welcome-left">
				<h3><a href="?quanly=chitiettin&id_baiviet=<?php echo $row_baiviet['baiviet_id'] ?>"><?php echo $row_baiviet['tenbaiviet'] ?></a></h3>
				<h4 class="my-sm-3 my-2"><?php echo $row_baiviet['tomtat']; ?></h4>
			</div>
			<div class="col-lg-5 welcome-right-top mt-lg-0 mt-sm-5 mt-4">
				<img src="images/<?php echo $row_baiviet['baiviet_image']; ?>" class="img-fluid" alt=" ">
			</div>
		</div>
		<?php
			}
		?>
	</div>
</div>
<!-- //about -->
