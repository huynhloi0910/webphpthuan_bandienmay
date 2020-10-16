<?php
	if (isset($_GET['huydon']) && isset($_GET['magiaodich'])) {
		$huydon = $_GET['huydon'];
		$mahang = $_GET['magiaodich'];
	} else {
		$huydon = '';
		$mahang = '';
	}
	$sql_update_huydonhang = mysqli_query($con, "UPDATE tbl_donhang SET huydon = '$huydon' WHERE mahang = '$mahang'");
	$sql_update_huydonhanggiaodich = mysqli_query($con, "UPDATE tbl_giaodich SET huydon = '$huydon' WHERE magiaodich = '$mahang'");
?>
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Xem đơn hàng</h3>

		<!-- //tittle heading -->
		<div class="row">
			<!-- product left -->
			<div class="agileinfo-ads-display col-lg-9">
				<div class="wrapper">
					<!-- first section -->
						<div class="row">
							<?php 
								if (isset($_SESSION['home_name'])) {
									echo 'Đơn hàng:'.$_SESSION['home_name'];
								}
							?>
						<div class="col-md-12"><br>
							<?php
								if (isset($_GET['khachhang'])) {
									$id_khachhang = $_GET['khachhang'];
								} else {
									$id_khachhang = '';
								}

								$sql_laygiaodich = mysqli_query($con, "SELECT * FROM tbl_giaodich WHERE khachhang_id = '$id_khachhang' GROUP BY magiaodich");

							?>
								<table class="table table-bordered">
									<tr>
										<th>Thứ tự</th>
										<th>Mã giao dịch</th>
										<th>Ngày đặt</th>
										<th>Tình trạng</th>
										<th>Yêu cầu</th>
										<th>Quản lý</th>
									</tr>
									<?php
										$stt = 0;
										while ($row_laygiaodich = mysqli_fetch_array($sql_laygiaodich)) {
									?>
									<tr>
										<td><?php echo ++$stt; ?></td>
										<td><?php echo $row_laygiaodich['magiaodich'] ?></td>
										<td><?php echo $row_laygiaodich['ngaythang'] ?></td>
										<td><?php 
												if ($row_laygiaodich['tinhtrangdon'] == 0) {
													echo 'Đã đặt hàng';
												} else {
													echo "Đã xử lý | Đang giao hàng";
												}
											?>		
										</td>
										<td>
											<?php 
												if ($row_laygiaodich['huydon'] == 0) {								
											?>
											<a href="?quanly=xemdonhang&khachhang=<?php echo $_SESSION['home_id'] ?>&magiaodich=<?php echo $row_laygiaodich['magiaodich'] ?>&huydon=1">Yêu cầu hủy đơn</a>
											<?php
												} else if ($row_laygiaodich['huydon'] == 1) {
											?>
													<p>Đang chờ hủy...</p>
												<?php
													} else {
														echo "Đã hủy";
														}
												?>
										</td>
										<td><a href="?quanly=xemdonhang&khachhang=<?php echo $_SESSION['home_id'] ?>&magiaodich=<?php echo $row_laygiaodich['magiaodich'] ?>">Xem chi tiết</a></td>
									</tr>
									<?php
										}
									?>
								</table>
						</div>

						<div class="col-md-12">
							<?php
								if (isset($_GET['magiaodich'])) {
									$magiaodich = $_GET['magiaodich'];
								$sql_laygiaodich1 = mysqli_query($con, "SELECT * FROM tbl_giaodich,tbl_sanpham,tbl_khachhang WHERE tbl_giaodich.sanpham_id = tbl_sanpham.sanpham_id AND tbl_giaodich.khachhang_id = tbl_khachhang.khachhang_id AND tbl_giaodich.magiaodich = '$magiaodich' ORDER BY tbl_giaodich.giaodich_id DESC");
							?>
								<p>Chi tiết đơn hàng</p><br>
								<table class="table table-bordered">
									<tr>
										<th>Thứ tự</th>
										<th>Mã hàng</th>
										<th>Tên sản phẩm</th>
										<th>Số lượng</th>
										<th>Ngày đặt</th>
									</tr>
									<?php
										$stt = 0;
										while ($row_laygiaodich1 = mysqli_fetch_array($sql_laygiaodich1)) {
									?>
									<tr>
										<td><?php echo ++$stt; ?></td>
										<td><?php echo $row_laygiaodich1['magiaodich'] ?></td>
										<td><?php echo $row_laygiaodich1['sanpham_name'] ?></td>
										<td><?php echo $row_laygiaodich1['soluong'] ?></td>
										<td><?php echo $row_laygiaodich1['ngaythang'] ?></td>
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
					<!-- //first section -->

				</div>
			</div>
			<!-- //product left -->
		</div>
	</div>
</div>
<!-- //top products -->