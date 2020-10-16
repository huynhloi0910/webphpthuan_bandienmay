<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = '';
	}

	$sql_chitietsp = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_id = '$id'");
	$row_chitietsp = mysqli_fetch_array($sql_chitietsp);			
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
				<li><?php echo $row_chitietsp['sanpham_name'] ?></li>
			</ul>
		</div>
	</div>
</div>
<!-- //page -->

<!-- Single Page -->
<div class="banner-bootom-w3-agileits py-5">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>S</span>ản
			<span>P</span>hẩm</h3>
		<!-- //tittle heading -->
		<div class="row">
			<div class="col-lg-5 col-md-8 single-right-left ">
				<div class="grid images_3_of_2">
					<div class="flexslider">
						<ul class="slides">
							<li data-thumb="images/<?php echo $row_chitietsp['sanpham_image'] ?>">
								<div class="thumb-image">
									<img style="image-rendering: pixelated;" src="images/<?php echo $row_chitietsp['sanpham_image'] ?>" data-imagezoom="true" class="img-fluid" alt=""> </div>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-7 single-right-left simpleCart_shelfItem">
				<h3 class="mb-3"><?php echo $row_chitietsp['sanpham_name'] ?></h3>
				<p class="mb-3">
					<span class="item_price"><?php echo number_format($row_chitietsp['sanpham_giakhuyenmai'] ) ?></span>
					<del class="mx-2 font-weight-light"><?php echo number_format($row_chitietsp['sanpham_gia'] ) ?></del>
					<label>Miễn phí vận chuyển</label>
				</p>
				<div class="product-single-w3l">
					<P><?php echo $row_chitietsp['sanpham_mota'] ?></P><br><br>
					<P><?php echo $row_chitietsp['sanpham_chitiet'] ?></P><br>
				</div>
				<div class="occasion-cart">
					<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
						<form action="?quanly=giohang" method="post">
							<fieldset>
								<input type="hidden" name="namesp" value="<?php echo $row_chitietsp['sanpham_name'] ?>" />
								<input type="hidden" name="idsp" value="<?php echo $row_chitietsp['sanpham_id'] ?>" />
								<input type="hidden" name="pricesp" value="<?php echo $row_chitietsp['sanpham_giakhuyenmai'] ?>" />
								<input type="hidden" name="imagesp" value="<?php echo $row_chitietsp['sanpham_image'] ?>" />
								<input type="hidden" name="quantitysp" value="<?php echo $row_chitietsp['sanpham_soluong'] ?>" />

								<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button" />
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //Single Page -->