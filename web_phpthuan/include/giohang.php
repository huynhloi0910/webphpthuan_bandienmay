<?php
	//Khi click Thêm giỏ hàng 
	if (isset($_POST['themgiohang'])) {
		//Lấy dữ liệu
		$namesp  = $_POST['namesp'];
		$idsp    = $_POST['idsp'];
		$pricesp = $_POST['pricesp'];
		$imgsp   = $_POST['imagesp'];
		$qtysp   = $_POST['quantitysp'];
		//Truy vấn lấy dữ liệu từ tbl_giohang
		$sql_getgiohang = mysqli_query($con, "SELECT * FROM tbl_giohang WHERE sanpham_id = '$idsp'");
		//Lấy dữ liệu từ tbl_giohang lưu vào $row_getgiohang dưới dạng một mảng số và dưới dạng một mảng kết hợp
		$row_getgiohang = mysqli_fetch_array($sql_getgiohang);
		//Trả về số hàng trong tập kết quả của câu truy vấn
		$count = mysqli_num_rows($sql_getgiohang);
		//Nếu trong tbl_giohang có dữ liệu sản phẩm với sanpham_id = $idsp thì Update lại sản phẩm với sl cộng thêm 1
		if ($count > 0) {
			$qtysp = $row_getgiohang['soluong'] + 1;
			$sql_giohang = "UPDATE tbl_giohang SET tensanpham = '$namesp', sanpham_id = '$idsp', giasanpham = '$pricesp', hinhanh = '$imgsp', soluong = '$qtysp' WHERE sanpham_id = '$idsp'  ";
		//Không thì chỉ Insert dữ liệu sản phẩm vào tbl_giohang
		} else {
			$qtysp = $qtysp;
			$sql_giohang = "INSERT INTO tbl_giohang(tensanpham, sanpham_id, giasanpham, hinhanh, soluong) VALUES('$namesp', '$idsp', '$pricesp','$imgsp','$qtysp')";
		}

		$insert_rowgiohang = mysqli_query($con,$sql_giohang);
		//Nếu trong quá trình Insert dữ liệu vào tbl_giohang gặp lỗi thì cho header về trang chitietsp
		if ($insert_rowgiohang == 0) {
			header('Location:index.php?quanly=chitietsp&id='.$idsp);
		}
	//Khi click Cập nhật số lượng 	
	} else if (isset($_POST['capnhatsoluong'])) {
		if (isset($_POST['product_id'])) {
			//Update số lượng của từng cái sp dựa vào sanpham_id (vì mỗi sp có số lượng khác nhau)
			//Vì update từng sl cho từng sp nên phải dùng array[] để lưu
			//Count đếm xem có bao nhiêu sp (có bao nhiêu sanpham_id thì tương ứng bấy nhiêu sp)
			for ($i=0; $i < count($_POST['product_id']) ; $i++) {
				$idsp  = $_POST['product_id'][$i];//Lấy product_id thứ $i tương ứng
				$qtysp = $_POST['soluong'][$i];
				//Nếu số lượng sản phẩm <= 0 thì xóa khỏi giỏ hàng
				if ($qtysp <= 0) {
					$sql_delete = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id = '$idsp'");
				//Không thì Update sl mới vào giỏ hàng
				} else {
					$sql_update = mysqli_query($con, "UPDATE tbl_giohang SET soluong = '$qtysp' WHERE sanpham_id = '$idsp'");
				}
			}
		} 
	//Khi click dấu X thì xóa sản phẩm tương ứng trong giỏ hàng dựa vào giohang_id	
	} else if (isset($_GET['xoa'])) {
		$idxoa = $_GET['xoa'];
		$sql_delete_product = mysqli_query($con, "DELETE FROM tbl_giohang WHERE giohang_id = '$idxoa'");
	//Khi click Thanh Toán
	} else if (isset($_POST['thanhtoan'])) {
		$name     = $_POST['name'];
		$phone    = $_POST['phone'];
		$address  = $_POST['address'];
		$email    = $_POST['email'];
		$password = md5($_POST['password']);
		$note     = $_POST['note'];
		$giaohang = $_POST['giaohang'];
		//Insert dữ liệu vào tbl_khachhang
		$sql_khachhang = mysqli_query($con, "INSERT INTO tbl_khachhang(name, phone, address, email, password, note, giaohang) VALUES('$name', '$phone', '$address','$email', '$password', '$note','$giaohang')");
		//Nếu trong tbl_khachhang có dữ liệu thì
		if ($sql_khachhang) {
			$sql_select_khachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
			$row_select_khachhang = mysqli_fetch_array($sql_select_khachhang);
			$khachhang_id = $row_select_khachhang['khachhang_id'];
			$_SESSION['home_id'] = $khachhang_id;
			$_SESSION['home_name'] = $row_select_khachhang['name'];
			$mahang = rand(0,9999);
			for ($i=0; $i < count($_POST['thanhtoan_product_id']) ; $i++) { 
				$idsp  = $_POST['thanhtoan_product_id'][$i];
				$qtysp = $_POST['thanhtoan_soluong'][$i];
				//Khi cick thanh toán thì Insert dữ liệu vào tbl_donhang
				$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id, soluong, mahang, khachhang_id) VALUES('$idsp', '$qtysp', '$mahang','$khachhang_id')");
				//Khi cick thanh toán thì Insert dữ liệu vào tbl_giaodich
				$sql_giaodich = mysqli_query($con, "INSERT INTO tbl_giaodich(sanpham_id, soluong, magiaodich, khachhang_id) VALUES('$idsp', '$qtysp', '$mahang', '$khachhang_id')");
				//Khi đã thanh toán và insert dữ liệu vào tbl_donhang thì xóa tất cả sp từ tbl_giohang
				$sql_delete_giohang = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id = '$idsp'");
			}
		}	
	} else if (isset($_POST['thanhtoandangnhap'])) {
		$khachhang_id = $_SESSION['home_id'];
		$mahang = rand(0,9999);
		for ($i=0; $i < count($_POST['product_id']) ; $i++) { 
			$idsp  = $_POST['product_id'][$i];
			$qtysp = $_POST['soluong'][$i];
			//Khi cick thanh toán thì Insert dữ liệu vào tbl_donhang
			$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id, soluong, mahang, khachhang_id) VALUES('$idsp', '$qtysp', '$mahang','$khachhang_id')");
			//Khi cick thanh toán thì Insert dữ liệu vào tbl_giaodich
			$sql_giaodich = mysqli_query($con, "INSERT INTO tbl_giaodich(sanpham_id, soluong, magiaodich, khachhang_id) VALUES('$idsp', '$qtysp', '$mahang', '$khachhang_id')");
			//Khi đã thanh toán và insert dữ liệu vào tbl_donhang thì xóa tất cả sp từ tbl_giohang
			$sql_delete_giohang = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id = '$idsp'");
		}
	} elseif(isset($_GET['dangxuat'])){
	 	$id = $_GET['dangxuat'];
	 	if($id=='dangxuat'){
	 		unset($_SESSION['home_name']);
	 	}
	}
?>
<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>G</span>iỏ hàng của bạn
		</h3>
			<?php 

				if(isset($_SESSION['home_name']) && !empty($_SESSION['home_name'])) {
					echo '<p style="color:#000;">Xin chào bạn: '.$_SESSION['home_name'].'<a href="index.php?quanly=giohang&dangxuat=dangxuat">Đăng xuất</a></p>';
				}else{
					echo '';
				}
			?>
		<!-- //tittle heading -->
		<div class="checkout-right">
			<?php
				$sql_laygiohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
				$count_sanpham = mysqli_num_rows($sql_laygiohang);
			?>
			<h4 class="mb-sm-4 mb-3">Giỏ hàng của bạn có:
				<span><?php echo $count_sanpham; ?> Sản phẩm</span>
			</h4>

			<div class="table-responsive">
				<form action="" method="post">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>Thứ tự</th>
							<th>Sản phẩm</th>
							<th>Số lượng</th>
							<th>Tên sản phẩm</th>
							<th>Giá</th>
							<th>Tổng giá</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$stt   = 0;
							$total = 0;
							while ($row_laygiohang = mysqli_fetch_array($sql_laygiohang)) {
								$subtotal = $row_laygiohang['soluong']*$row_laygiohang['giasanpham'];
								$total += $subtotal;
						?>
						<tr class="rem1">
							<td class="invert"><?php echo ++$stt; ?></td>
							<td class="invert-image">
								<img style="height: 120px; image-rendering: pixelated;" src="images/<?php echo $row_laygiohang['hinhanh'] ?>" alt=" " class="img-responsive">
							</td>
							<td class="invert">
								<input type="number" name="soluong[]" min="1" value="<?php echo $row_laygiohang['soluong'] ?>">
								<input type="hidden" name="product_id[]" value="<?php echo $row_laygiohang['sanpham_id'] ?>">
							</td>
							<td class="invert"><?php echo $row_laygiohang['tensanpham'] ?></td>
							<td class="invert"><?php echo number_format($row_laygiohang['giasanpham']).'vnđ' ?></td>
							<td class="invert"><?php echo number_format($subtotal).'vnđ' ?></td>
							<td class="invert">
								<a href="?quanly=giohang&xoa=<?php echo $row_laygiohang['giohang_id'] ?>">Xoá</a>
							</td>
						</tr>
						<?php
							}
						?>
						<tr>
							<td colspan="7">Tổng tiền : <?php echo number_format($total).'vnđ' ?> </td>
						</tr>
						<tr>
							<td colspan="7"><input type="submit" name="capnhatsoluong" class="btn btn-success" value="Cập nhật giỏ hàng">
							<?php
								//Nếu tồn tại $_SESSION['home_name'] và giỏ hàng có sp thì xuất hiện nút Thanh toán
								if (isset($_SESSION['home_name']) && $count_sanpham > 0) {
							?>
							<input type="submit" name="thanhtoandangnhap" class="btn btn-primary" value="Thanh toán giỏ hàng">
							<?php
								}
							?>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
		<?php
			if (!isset($_SESSION['home_name'])) {
		?>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<h4 class="mb-sm-4 mb-3">Thêm địa chỉ giao hàng</h4>
					<form action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Điền tên" required="">
									</div>
									<div class="w3_agileits_card_number_grids">
										<div class="w3_agileits_card_number_grid_left form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Số phone" name="phone" required="">
											</div>
										</div>
										<div class="w3_agileits_card_number_grid_right form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Địa chỉ" name="address" required="">
											</div>
										</div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Email" name="email" required="">
									</div>
									<div class="controls form-group">
										<input type="password" class="form-control" placeholder="Password" name="password" required="">
									</div>
									<div class="controls form-group">
										<textarea style="resize: none;" class="form-control" placeholder="Ghi chú" name="note" required=""></textarea>
									</div>
									<div class="controls form-group">
										<select class="option-w3ls" name="giaohang">
											<option>Chọn hình thức giao hàng</option>
											<option value="1">Thanh toán ATM</option>
											<option value="0">Giao hàng tại nhà</option>
										</select>
									</div>
								</div>
								<?php
									$sql_select_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
									while ($row_select_giohang = mysqli_fetch_array($sql_select_giohang)) {
								?>
								<input type="hidden" name="thanhtoan_soluong[]" min="1" value="<?php echo $row_select_giohang['soluong'] ?>">
								<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_select_giohang['sanpham_id'] ?>">
								<?php
									}
								?>
								<input type="submit" name="thanhtoan" class="btn btn-success" style="width: 20%" value="Thanh toán tới địa chỉ này">
							</div>
						</div>
					</form>
				</div>
			</div>
		<?php
			}
		?>
	</div>
</div>
<!-- //checkout page -->