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
	
	$list[$i]['img'] = apms_it_thumbnail($list[$i], 70, 70, false, true);	

}


// 사용자 피팅룸 정보 가져오는 부분
$mb_id = $member['mb_id'];
$codi_row = getCodiRow($mb_id);
$pre_codi_url = $codi_row['image_url'];

$pre_codi_url = NULL;
if($pre_codi_url == NULL)
	$pre_codi_url = $coco_photo = $member['coco_photo'];

$sql = sql_fetch_array(sql_query("select mb_memo from `CoCo_member` where mb_id = '{$mb_id}'"));
$imageid = $sql["mb_memo"];

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


	<?php
	if(!$isFittingroom){
	?>
	<div id="coco-bottom-nav">
		<div class="coco-bottom-wrapper">
			<a id="coco-button" onclick="slideHideBar()">
				<div class="bottom-button">
					Fitting Room
					<img src="/img/coco/arrow.png" style="width: 20px;"/>
				</div>
			</a>
			<div id="bottom-user">
				<img id="bottom-user-image" class="img-thumbnail" src="<?php echo ($pre_codi_url);?>" />
				<div class="back_modal" id="loader" style="width: 80%;left: 11px;">
					<div class="loader" style="width: 70px; height: 70px;"></div>
				</div>
			</div>
		</div>
		<div id="bottom-fc">
			<div class="bottom-fc-wrapper">
				<div style="min-width: 48px;height: 48px;margin-right: 13px;">
					<img src="/img/coco/fittingcart.png" style="width: 65px;"/>
				</div>
			<div style="display: flex;overflow-x: auto;flex-wrap: nowrap;min-width: 100%;margin-left: 11px;">
			<?php 
				for($i=0; $i < count($list);$i++) { 
				?>
				<div class="bottom-item" item-id="<?php echo($list[$i]['it_id']);?>" cate-id="<?php echo($list[$i]['ca_id2']);?>">
					<img src="<?php echo($list[$i]['img']['src']);?>" alt="<?php echo $list[$i]['img']['alt'];?>" class="bottom-user-fci"/>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<?php
	}
	?>

<script src="/js/coco.js"></script>




	<?php if(!$is_main_footer) { ?>
		<footer class="at-footer">
			<!-- <nav class="at-links">
				<div c	<ul class="pull-left">
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
					</ul>lass="at-container">
				
					<div class="clearfix"></div>
				</div>
			</nav> -->
			
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
<script>
	var t_codi_bottom = {'lowerid' : '000000', 'upperid': '000000'};
	var user_id_bottom = '<?php echo($member['mb_id']) ?>';
	var imageid_bottom = "<?php echo($imageid); ?>"
	var isFitting_bottom = false;

	function addFC(it_id){
		$.post("/shop/fitting_update.php", { it_id: it_id }, function(res) {
			console.log(res);
			var re = JSON.parse(res);
			if(re['re'] == 1){
				console.log(re);
				$('#bottom-user-fc').prepend('<img class="theImg" src="'+re["src"]+'" />')
			}
		});
	}

	function removeActi(){
		$('#m-nav li').first().removeClass("active");
	}

	function slideHideBar(){
		$("#bottom-user").hide();
		$("#bottom-fc").hide();
		$("#coco-button").attr("onclick", "slideShowBar()");
		localStorage.setItem("cocoBottomStatus", "false");
	}

	function slideShowBar(){
		$("#bottom-user").css("display", "flex");
		$("#bottom-fc").css("display", "flex");
		$("#coco-button").attr("onclick", "slideHideBar()");
		localStorage.setItem("cocoBottomStatus", "true");
	}

	function request_fitting_bottom(it_id, ca_id){
		var data = {
			"userid" : user_id_bottom ,
			"isupper" : 0,
			"imageid" : imageid_bottom,
			"category" : ca_id,
		};


		var cate_code = getCateCode(ca_id);
		console.log(cate_code);

		if(cate_code == "upperid"){
			data["isupper"] = 1;
		}

		t_codi_bottom[cate_code] = it_id;

		if(t_codi_bottom["upperid"] == t_codi_bottom["lowerid"]){
			$('#coco-fitting').attr('src', "/data/apms/photo/"+user_id_bottom+"/"+user_id_bottom+"_large.jpg");
			return 0;
		}

		$('#loader').show();  

		data["upperid"] = t_codi_bottom["upperid"];
		data["lowerid"] = t_codi_bottom["lowerid"];
		

		isFitting_bottom = true;
		console.log(data);
		$.ajax({
			url:"/shop/fitting_request.php ",
			type:"POST",
			data: data,
			success:function(response) {
				setTimeout(() => {
					$('#loader').hide();  
					try{
						var data = JSON.parse(response);
						if(data["result"]){
							$('#bottom-user-image').attr('src', data["src"]);
							t_codi_bottom["codi_url"] = data["src"];
						}
					}
					catch{
					}
					isFitting_bottom = false;
					console.log(response);
				}, 3000);
				},
				error:function(){
					alert("error");
				}
		});
		
		return true;
	}
	
		
	$(function() {
		removeActi();

		var status = localStorage.getItem("cocoBottomStatus");

		if(status == "false"){
			$("#bottom-user").hide();
			$("#bottom-fc").hide();
			$("#coco-button").attr("onclick", "slideShowBar()");
		}

		else{
			$("#bottom-user").slideDown();
			$("#bottom-fc").slideDown();
			$("#coco-button").attr("onclick", "slideHideBar()");
		}

		$('div .bottom-item').click(function(){
			var cate = $(this).attr("cate-id");
			var item = $(this).attr("item-id");
			request_fitting_bottom(item, cate);
		});

	})

</script>

<?php if($is_designer || $is_demo) include_once(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>
