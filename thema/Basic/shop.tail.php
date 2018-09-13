<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/coco.lib.php');

// Item 정보 가져오는 부분
$list = array();
$sql  = " select a.fitting_cart_id, a.cart_time, b.* from CoCo_fitting_cart a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
$sql .= " where a.mb_id = '{$member['mb_id']}' order by a.fitting_cart_id desc ";
$result = sql_query($sql);


for ($i=0; $row = sql_fetch_array($result); $i++) {

	$list[$i] = $row;

	$list[$i]['out_cd'] = '';
	$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
	$tmp = sql_fetch($sql);
	if($tmp['cnt'])
		$list[$i]['out_cd'] = 'no';

	$list[$i]['price'] = get_price($row);

	if ($row['it_tel_inq']) $list[$i]['out_cd'] = 'tel';

	$list[$i]['is_soldout'] = is_soldout($row['it_id']);
	
	$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	

}


// 사용자 피팅룸 정보 가져오는 부분
$codi_row = getCodiRow($member['mb_id']);
$pre_codi_url = $codi_row['image_url'];

if($pre_codi_url == NULL)
	$pre_codi_url = $coco_photo = getEncPath($member['coco_photo']);

?>
		<?php if($col_name) { ?>
			<?php if($col_name == "two") { ?>
					</div>
					<div class="col-md-<?php echo $col_side;?><?php echo ($at_set['side']) ? ' pull-left' : '';?> at-col at-side">
						<?php include_once($is_side_file); // Side ?>
					</div>
				</div>
			<?php } else { ?>
				</div><!-- .at-content -->
			<?php } ?>
			</div><!-- .at-container -->
		<?php } ?>
	</div><!-- .at-body -->




	<div id="bottom-nav">
		<div class="bottom-box">
				<img id="bottom-user-image" class="img-thumbnail" src="<?php echo ($pre_codi_url);?>" 
				width="15%" height="80%"/>
		</div>
		<div id="bottom-user-fc" class="bottom-box">
			<?php 
				for($i=0; $i < count($list);$i++) { 
				?>
					<img width="75" height="75" src="<?php echo($list[$i]['img']['src']);?>" 
					alt="<?php echo $list[$i]['img']['alt'];?>"
					class="bottom-user-fci"/>
			<?php } ?>
		</div>
	</div>


<script>
	function addFC(it_id){
		$.post("shop/fitting_update.php", { it_id: it_id }, function(res) {
			console.log(res);
			var re = JSON.parse(res);
			if(re['re'] == 1){
				console.log(re);
				$('#bottom-user-fc').prepend('<img id="theImg" src="'+re["src"]+'" />')
			}
		});
	}
	addFC('1535094199');
</script>

	<?php if(!$is_main_footer) { ?>
		<footer class="at-footer">
			<nav class="at-links">
				<div class="at-container">
					<ul class="pull-left">
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보처리방침</a></li>
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=noemail">이메일 무단수집거부</a></li>
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=disclaimer">책임의 한계와 법적고지</a></li>
					</ul>
					<ul class="pull-right">
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=guide">이용안내</a></li>
						<li><a href="<?php echo $at_href['secret'];?>">문의하기</a></li>
						<li><a href="<?php echo $as_href['pc_mobile'];?>"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일';?>버전</a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
			</nav>
			<div class="at-infos">
				<div class="at-container">
					<?php if(IS_YC) { // YC5 ?>
						<div class="media">
							<div class="pull-right hidden-xs">
								<!-- 하단 우측 아이콘 -->
							</div>
							<div class="pull-left hidden-xs">
								<!-- 하단 좌측 로고 -->
								<i class="fa fa-leaf"></i>
							</div>
							<div class="media-body">
						
								<ul class="at-about hidden-xs">
									<li><b><?php echo $default['de_admin_company_name']; ?></b></li>
									<li>대표 : <?php echo $default['de_admin_company_owner']; ?></li>
									<li><?php echo $default['de_admin_company_addr']; ?></li>
									<li>전화 : <span><?php echo $default['de_admin_company_tel']; ?></span></li>
									<li>사업자등록번호 : <span><?php echo $default['de_admin_company_saupja_no']; ?></span></li>
									<li><a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a></li>
									<li>통신판매업신고 : <span><?php echo $default['de_admin_tongsin_no']; ?></span></li>
									<li>개인정보관리책임자 : <?php echo $default['de_admin_info_name']; ?></li>
									<li>이메일 : <span><?php echo $default['de_admin_info_email']; ?></span></li>
								</ul>
								
								<div class="clearfix"></div>

								<div class="copyright">
									<strong><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></strong>
									<span>All rights reserved.</span>
								</div>

								<div class="clearfix"></div>
							</div>
						</div>
					<?php } else { // G5 ?>
						<div class="at-copyright">
							<i class="fa fa-leaf"></i>
							<strong><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></strong>
							All rights reserved.
						</div>
					<?php } ?>
				</div>
			</div>
		</footer>
	<?php } ?>
</div><!-- .wrapper -->

<!-- <div class="at-go">
	<div id="go-btn" class="go-btn">
		<span class="go-top cursor"><i class="fa fa-chevron-up"></i></span>
		<span class="go-bottom cursor"><i class="fa fa-chevron-down"></i></span>
	</div>
</div> -->

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/respond.js"></script>
<![endif]-->

<!-- JavaScript -->
<script>
var sub_show = "<?php echo $at_set['subv'];?>";
var sub_hide = "<?php echo $at_set['subh'];?>";
var menu_startAt = "<?php echo ($m_sat) ? $m_sat : 0;?>";
var menu_sub = "<?php echo $m_sub;?>";
var menu_subAt = "<?php echo ($m_subsat) ? $m_subsat : 0;?>";
</script>
<script src="<?php echo THEMA_URL;?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/sly.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/custom.js"></script>
<?php if($is_sticky_nav) { ?>
<script src="<?php echo THEMA_URL;?>/assets/js/sticky.js"></script>
<?php } ?>

<?php echo apms_widget('basic-sidebar'); //사이드바 및 모바일 메뉴(UI) ?>

<?php if($is_designer || $is_demo) include_once(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>
