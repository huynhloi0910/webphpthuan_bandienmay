<?php
	// session_destroy();
	// unset('dangnhap');
	if (isset($_POST['dangnhap_home'])) {
		$taikhoan = $_POST['email_login'];
		$matkhau  = md5($_POST['password_login']);
		if ($taikhoan == '' || $matkhau == '') {
			echo "<script>alert('Vui lòng nhập đủ')</script>";
		} else {
			$sql_dangnhap_home = mysqli_query($con, "SELECT * FROM tbl_khachhang WHERE email='$taikhoan' AND password='$matkhau' LIMIT 1");
			$row_dangnhap_home = mysqli_fetch_array($sql_dangnhap_home);
			$result = mysqli_num_rows($sql_dangnhap_home);
			if ($result > 0) {
				$_SESSION['home_id'] = $row_dangnhap_home['khachhang_id'];
				$_SESSION['home_name'] = $row_dangnhap_home['name'];
				
				header('Location: index.php?quanly=giohang');
			} else {
				echo "<script>alert('Tên đăng nhập hoặc mật khẩu sai')</script>";
				header('Location: ?');
			}		
		}
	}
	if (isset($_POST['dangky'])) {
		$name     = $_POST['name'];
		$phone    = $_POST['phone'];
		$address  = $_POST['address'];
		$email    = $_POST['email_dangky'];
		$password = md5($_POST['password_dangky']);
		$note     = $_POST['note'];
		$giaohang = $_POST['giaohang'];
		//Insert dữ liệu vào tbl_khachhang
		$sql_khachhang = mysqli_query($con, "INSERT INTO tbl_khachhang(name, phone, address, email, password, note, giaohang) VALUES('$name', '$phone', '$address','$email', '$password', '$note','$giaohang')");
		$sql_select_khachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
		$row_select_khachhang = mysqli_fetch_array($sql_select_khachhang);
		$_SESSION['home_id'] = $row_select_khachhang['khachhang_id'];
		$_SESSION['home_name'] = $name;
		header('Location:?quanly=giohang');
	}
?>
<!-- top-header -->
<div class="agile-main-top">
	<div class="container-fluid">
		<div class="row main-top-w3l py-2">
			<div class="col-lg-4 header-most-top">
			</div>
			<div class="col-lg-8 header-right mt-lg-0 mt-2">
				<!-- header lists -->
				<ul>
					<?php 
						if (isset($_SESSION['home_name'])) {
					?>
					<li class="text-center border-right text-white">
						<a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['home_id'] ?>" class="text-white">
							<i class="fas fa-truck mr-2"></i>Xem đơn hàng</a>
					</li>
					<?php
						}
					?>
					<li class="text-center border-right text-white">
						<i class="fas fa-phone mr-2"></i> 090 500 8910
					</li>
					<?php 
						if(isset($_SESSION['home_name']) && !empty($_SESSION['home_name'])) {
					?>
					<li class="text-center border-right text-white">
						<a href="index.php?quanly=giohang" class="text-white">
							<i class="fas fa-sign-in-alt mr-2"></i> Quay lại giỏ hàng </a>
					</li>
					<?php
						} else {
					?>
					<li class="text-center border-right text-white">
						<a href="#" data-toggle="modal" data-target="#dangnhap" class="text-white">
							<i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập </a>
					</li>
					<li class="text-center text-white">
						<a href="#" data-toggle="modal" data-target="#dangky" class="text-white">
							<i class="fas fa-sign-out-alt mr-2"></i>Đăng ký </a>
					</li>
					<?php	
						}
					?>
				</ul>
				<!-- //header lists -->
			</div>
		</div>
	</div>
</div>

<!-- modals -->
<!-- log in -->
<div class="modal fade" id="dangnhap" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center">Đăng nhập</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<div class="form-group">
						<label class="col-form-label">Email</label>
						<input type="email" class="form-control" placeholder=" " name="email_login">
					</div>
					<div class="form-group">
						<label class="col-form-label">Mật khẩu</label>
						<input type="password" class="form-control" placeholder=" " name="password_login">
					</div>
					<div class="right-w3l">
						<input type="submit" class="form-control" value="Đăng nhập" name="dangnhap_home">
					</div>
					<p class="text-center dont-do mt-3">Chưa có tài khoản
						<a href="#" data-toggle="modal" data-target="#dangky">
							Đăng ký</a>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- register -->
<div class="modal fade" id="dangky" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Đăng ký</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<div class="form-group">
						<label class="col-form-label">Tên khách hàng</label>
						<input type="text" class="form-control" placeholder=" " name="name" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Email</label>
						<input type="email" class="form-control" placeholder=" " name="email_dangky" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Mật khẩu</label>
						<input type="password" class="form-control" placeholder=" " name="password_dangky" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Số điện thoại</label>
						<input type="text" class="form-control" placeholder=" " name="phone" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Địa chỉ</label>
						<input type="text" class="form-control" placeholder=" " name="address" required="">
						<input type="hidden" name="giaohang" value="0">
					</div>
					<div class="form-group">
						<label class="col-form-label">Ghi chú</label>
						<textarea class="form-control" name="note" required="" style="resize: none;"></textarea>
					</div>
					<div class="right-w3l">
						<input type="submit" class="form-control" value="Đăng ký" name="dangky">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- //modal -->
<!-- //top-header -->

<!-- header-bottom-->
<div class="header-bot">
	<div class="container">
		<div class="row header-bot_inner_wthreeinfo_header_mid">
			<!-- logo -->
			<div class="col-md-3 logo_agile">
				<h1 class="text-center">
					<a href="index.php" class="font-weight-bold font-italic">
						<img src="images/logo2.png" alt=" " class="img-fluid">Electro Store
					</a>
				</h1>
			</div>
			<!-- //logo -->
			<!-- header-bot -->
			<div class="col-md-9 header mt-4 mb-md-0 mb-4">
				<div class="row">
					<!-- search -->
					<div class="col-10 agileits_search">
						<form class="form-inline" action="?quanly=timkiem" method="post">
							<input class="form-control mr-sm-2" type="search" name="search_product" placeholder="Tìm kiếm sản phẩm" aria-label="Search" required>
							<button class="btn my-2 my-sm-0" name="search" type="submit">Tìm kiếm</button>
						</form>
					</div>
					<!-- //search -->
					<!-- cart details -->
					<div class="col-2 top_nav_right text-center mt-sm-0 mt-2">
						<div class="wthreecartaits wthreecartaits2 cart cart box_1">
							<form action="" method="post" class="last">
								<input type="hidden" name="cmd" value="_cart">
								<input type="hidden" name="display" value="1">
								<button class="btn w3view-cart" type="submit" name="submit" value="">
									<i class="fas fa-cart-arrow-down"></i>
								</button>
							</form>
						</div>
					</div>
					<!-- //cart details -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- shop locator (popup) -->
<!-- //header-bottom -->
<!-- navigation -->