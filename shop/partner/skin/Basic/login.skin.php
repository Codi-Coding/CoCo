<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/assets/css/bootstrap.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);

?>

<style>
	html { width:100%; height:100%; }
	body { width:100%; height:100%; }
</style>

<div id="sub-wrapper" class="sub-container">
	<div class="box-login">
		<div class="box-block">
			<div class="header">							
				<h3 class="text-center">Partner Login Access</h3>
			</div>
			<form role="form" name="flogin" class="form-horizontal" action="<?php echo $action_url; ?>" method="post" style="margin-bottom: 0px !important;">
			<div class="content">
				<div class="form-group">
					<div class="col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" placeholder="User ID" id="login_id" name="mb_id" required class="form-control input-sm">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" placeholder="Password" id="login_pw" required name="mb_password" class="form-control input-sm">
						</div>
					</div>
				</div>
			</div>
			<div class="foot">
				<button class="btn btn-primary" type="submit">Login</button>
			</div>
			</form>
		</div>
		<div class="text-center box-links"><a href="<?php echo G5_URL;?>">Home</a></div>
	</div> 
</div>

<!-- JavaScript -->
<script type="text/javascript" src="<?php echo $skin_url;?>/assets/js/bootstrap.min.js"></script>
