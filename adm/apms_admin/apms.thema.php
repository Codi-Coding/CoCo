<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

$is_use_partner = (file_exists(G5_SHOP_PATH.'/partner/index.php')) ? true : false;

//SEO 저장파일
$seometa_file = G5_DATA_PATH.'/seometa.php';

if($mode == 'thema') {

	if(!$_POST['as_thema']) alert("기본 테마를 설정해 주세요.");

	if(IS_YC && !$_POST['as_shop_thema']) alert("쇼핑몰 기본 테마를 설정해 주세요.");

	if($_POST['as_intro_skin'] || $_POST['as_mobile_intro_skin']) {
		if($_POST['as_intro_type'] == "2") {
			$as_intro_set = $_POST['as_intro_type'].'|'.strtotime($_POST['as_intro_day'].' '.$_POST['as_intro_hour'].':00:00');
		} else {
			$as_intro_set = $_POST['as_intro_type'];
		}
	} else {
		$as_intro_set = '';
	}
	
	//config_table
	$sql = " update {$g5['config_table']}
				set as_thema					= '{$_POST['as_thema']}'
					, as_color					= '{$_POST['as_color']}'
					, as_mobile_thema			= '{$_POST['as_mobile_thema']}'
					, as_mobile_color			= '{$_POST['as_mobile_color']}'
					, as_xp						= '{$_POST['as_xp']}'
					, as_mp						= '{$_POST['as_mp']}'
					, as_admin					= '{$_POST['as_admin']}'
					, as_intro					= '{$as_intro_set}'
					, as_intro_skin				= '{$_POST['as_intro_skin']}'
					, as_mobile_intro_skin		= '{$_POST['as_mobile_intro_skin']}'
					, as_gnu					= '{$_POST['as_gnu']}'
					";
	sql_query($sql);

	//Shop
	if(IS_YC) {

		$as_partner = ($is_use_partner) ? $_POST['as_partner'] : 0;

		if($_POST['as_shop_intro_skin'] || $_POST['as_shop_mobile_intro_skin']) {
			if($_POST['as_shop_intro_type'] == "2") {
				$as_shop_intro_set = $_POST['as_shop_intro_type'].'|'.strtotime($_POST['as_shop_intro_day'].' '.$_POST['as_shop_intro_hour'].':00:00');
			} else {
				$as_shop_intro_set = $_POST['as_shop_intro_type'];
			}
		} else {
			$as_shop_intro_set = '';;
		}

		$sql = " update {$g5['g5_shop_default_table']}
					set as_thema					= '{$_POST['as_shop_thema']}'
						, as_color					= '{$_POST['as_shop_color']}'
						, as_mobile_thema			= '{$_POST['as_shop_mobile_thema']}'
						, as_mobile_color			= '{$_POST['as_shop_mobile_color']}'
						, as_intro					= '{$as_shop_intro_set}'
						, as_intro_skin				= '{$_POST['as_shop_intro_skin']}'
						, as_mobile_intro_skin		= '{$_POST['as_shop_mobile_intro_skin']}'
						, as_partner                = '{$as_partner}'
						, pt_shingo                 = '{$_POST['pt_shingo']}'
						, pt_lucky                  = '{$_POST['pt_lucky']}'
						, pt_code					= '{$_POST['pt_code']}'
						, pt_auto					= '{$_POST['pt_auto']}'
						, pt_auto_cache				= '{$_POST['pt_auto_cache']}'
						, pt_good_use               = '{$_POST['pt_good_use']}'
						, pt_good_point			    = '{$_POST['pt_good_point']}'
						, pt_review_use				= '{$_POST['pt_review_use']}'
						, pt_comment_use			= '{$_POST['pt_comment_use']}'
						, pt_comment_sns			= '{$_POST['pt_comment_sns']}'
						, pt_comment_point			= '{$_POST['pt_comment_point']}'
						, pt_comment_limit			= '{$_POST['pt_comment_limit']}'
						, pt_reserve_use			= '{$_POST['pt_reserve_use']}'
						, pt_reserve_end			= '{$_POST['pt_reserve_end']}'
						, pt_reserve_day			= '{$_POST['pt_reserve_day']}'
						, pt_reserve_cache			= '{$_POST['pt_reserve_cache']}'
						, pt_reserve_none			= '{$_POST['pt_reserve_none']}'
						, pt_img_width				= '{$_POST['pt_img_width']}'
						, pt_upload_size			= '{$_POST['pt_upload_size']}'
						, de_search_list_mod		= '{$_POST['de_search_list_mod']}'
						, de_search_list_row		= '{$_POST['de_search_list_row']}'
						, de_search_img_width		= '{$_POST['de_search_img_width']}'
						, de_search_img_height		= '{$_POST['de_search_img_height']}'
						, de_mobile_search_list_mod	= '{$_POST['de_mobile_search_list_mod']}'
						, de_mobile_search_list_row	= '{$_POST['de_mobile_search_list_row']}'
						, de_mobile_search_img_width	= '{$_POST['de_mobile_search_img_width']}'
						, de_mobile_search_img_height	= '{$_POST['de_mobile_search_img_height']}'
						, de_rel_img_width			= '{$_POST['de_rel_img_width']}'
						, de_rel_img_height			= '{$_POST['de_rel_img_height']}'
						, de_mobile_rel_img_width	= '{$_POST['de_mobile_rel_img_width']}'
						, de_mobile_rel_img_height	= '{$_POST['de_mobile_rel_img_height']}'
						, de_search_list_skin		= '{$_POST['de_search_list_skin']}'
						, de_mobile_search_list_skin	= '{$_POST['de_mobile_search_list_skin']}'
						";
		sql_query($sql);

		//Rows Table
		$sql = " update {$g5['apms_rows']}
					set icomment_rows				= '{$_POST['icomment_rows']}'
						, icomment_mobile_rows		= '{$_POST['icomment_mobile_rows']}'
						, iuse_rows					= '{$_POST['iuse_rows']}'
						, iuse_mobile_rows			= '{$_POST['iuse_mobile_rows']}'
						, iqa_rows					= '{$_POST['iqa_rows']}'
						, iqa_mobile_rows			= '{$_POST['iqa_mobile_rows']}'
						, irelation_mods			= '{$_POST['irelation_mods']}'
						, irelation_mobile_mods		= '{$_POST['irelation_mobile_mods']}'
						, irelation_rows			= '{$_POST['irelation_rows']}'
						, irelation_mobile_rows		= '{$_POST['irelation_mobile_rows']}'
						, type_mods					= '{$_POST['type_mods']}'
						, type_mobile_mods			= '{$_POST['type_mobile_mods']}'
						, type_rows					= '{$_POST['type_rows']}'
						, type_mobile_rows			= '{$_POST['type_mobile_rows']}'
						, event_mods				= '{$_POST['event_mods']}'
						, event_mobile_mods			= '{$_POST['event_mobile_mods']}'
						, event_rows				= '{$_POST['event_rows']}'
						, event_mobile_rows			= '{$_POST['event_mobile_rows']}'
						, myshop_mods				= '{$_POST['myshop_mods']}'
						, myshop_mobile_mods		= '{$_POST['myshop_mobile_mods']}'
						, myshop_rows				= '{$_POST['myshop_rows']}'
						, myshop_mobile_rows		= '{$_POST['myshop_mobile_rows']}'
						, ppay_mods					= '{$_POST['ppay_mods']}'
						, ppay_mobile_mods			= '{$_POST['ppay_mobile_mods']}'
						, ppay_rows					= '{$_POST['ppay_rows']}'
						, ppay_mobile_rows			= '{$_POST['ppay_mobile_rows']}'
						, type_img_width			= '{$_POST['type_img_width']}'
						, type_img_height			= '{$_POST['type_img_height']}'
						, type_mobile_img_width		= '{$_POST['type_mobile_img_width']}'
						, type_mobile_img_height	= '{$_POST['type_mobile_img_height']}'
						, myshop_img_width			= '{$_POST['myshop_img_width']}'
						, myshop_img_height			= '{$_POST['myshop_img_height']}'
						, myshop_mobile_img_width	= '{$_POST['myshop_mobile_img_width']}'
						, myshop_mobile_img_height	= '{$_POST['myshop_mobile_img_height']}'
						, type_skin					= '{$_POST['type_skin']}'
						, type_mobile_skin			= '{$_POST['type_mobile_skin']}'
						, myshop_skin				= '{$_POST['myshop_skin']}'
						, myshop_mobile_skin		= '{$_POST['myshop_mobile_skin']}'
						, order_skin				= '{$_POST['order_skin']}'
						, order_mobile_skin			= '{$_POST['order_mobile_skin']}'
						, event_skin				= '{$_POST['event_skin']}'
						, event_mobile_skin			= '{$_POST['event_mobile_skin']}'
						, editor_skin				= '{$_POST['editor_skin']}'
						, editor_mobile_skin		= '{$_POST['editor_mobile_skin']}'
						, qa_rows					= '{$_POST['qa_rows']}'
						, qa_mobile_rows			= '{$_POST['qa_mobile_rows']}'
						, qa_skin					= '{$_POST['qa_skin']}'
						, qa_mobile_skin			= '{$_POST['qa_mobile_skin']}'
						, use_rows					= '{$_POST['use_rows']}'
						, use_mobile_rows			= '{$_POST['use_mobile_rows']}'
						, use_skin					= '{$_POST['use_skin']}'
						, use_mobile_skin			= '{$_POST['use_mobile_skin']}'
						, cz_skin					= '{$_POST['cz_skin']}'
						, cz_mobile_skin			= '{$_POST['cz_mobile_skin']}'

						";
		sql_query($sql);
	}

	//XP Table
	$sql = " update {$g5['apms_xp']}
				set xp_now						= '{$_POST['xp_now']}'
					, xp_point					= '{$_POST['xp_point']}'
					, xp_rate					= '{$_POST['xp_rate']}'
					, xp_max					= '{$_POST['xp_max']}'
					, xp_icon					= '{$_POST['xp_icon']}'
					, xp_icon_skin				= '{$_POST['xp_icon_skin']}'
					, xp_icon_css				= '{$_POST['xp_icon_css']}'
					, xp_icon_admin				= '{$_POST['xp_icon_admin']}'
					, xp_icon_guest				= '{$_POST['xp_icon_guest']}'
					, xp_icon_special			= '{$_POST['xp_icon_special']}'
					, xp_special				= '{$_POST['xp_special']}'
					, xp_designer				= '{$_POST['xp_designer']}'
					, xp_manager				= '{$_POST['xp_manager']}'
					, xp_photo					= '{$_POST['xp_photo']}'
					, xp_photo_url				= '{$_POST['xp_photo_url']}'
					, xp_grade1					= '{$_POST['xp_grade1']}'
					, xp_grade2					= '{$_POST['xp_grade2']}'
					, xp_grade3					= '{$_POST['xp_grade3']}'
					, xp_grade4					= '{$_POST['xp_grade4']}'
					, xp_grade5					= '{$_POST['xp_grade5']}'
					, xp_grade6					= '{$_POST['xp_grade6']}'
					, xp_grade7					= '{$_POST['xp_grade7']}'
					, xp_grade8					= '{$_POST['xp_grade8']}'
					, xp_grade9					= '{$_POST['xp_grade9']}'
					, xp_grade10				= '{$_POST['xp_grade10']}'
					, xp_auto1					= '{$_POST['xp_auto1']}'
					, xp_auto2					= '{$_POST['xp_auto2']}'
					, xp_auto3					= '{$_POST['xp_auto3']}'
					, xp_auto4					= '{$_POST['xp_auto4']}'
					, xp_auto5					= '{$_POST['xp_auto5']}'
					, xp_auto6					= '{$_POST['xp_auto6']}'
					, xp_auto7					= '{$_POST['xp_auto7']}'
					, xp_from					= '{$_POST['xp_from']}'
					, xp_to						= '{$_POST['xp_to']}'
					, xp_except					= '{$_POST['xp_except']}'
					, exp_point					= '{$_POST['exp_point']}'
					, exp_login					= '{$_POST['exp_login']}'
					, exp_write					= '{$_POST['exp_write']}'
					, exp_comment				= '{$_POST['exp_comment']}'
					, exp_read					= '{$_POST['exp_read']}'
					, exp_good					= '{$_POST['exp_good']}'
					, exp_nogood				= '{$_POST['exp_nogood']}'
					, exp_chulsuk				= '{$_POST['exp_chulsuk']}'
					, exp_delivery				= '{$_POST['exp_delivery']}'
					, item_cnt					= '{$_POST['item_cnt']}'
					, https_url					= '{$_POST['https_url']}'
					, editor_img				= '{$_POST['editor_img']}'
					, comment_limit				= '{$_POST['comment_limit']}'
					, lucky_point				= '{$_POST['lucky_point']}'
					, lucky_dice				= '{$_POST['lucky_dice']}'
					, lucky_msg					= '{$_POST['lucky_msg']}'
					, auto_size					= '{$_POST['auto_size']}'
					, jwplayer_key				= '{$_POST['jwplayer_key']}'
					, facebook_token			= '{$_POST['facebook_token']}'
					, google_map_key			= '{$_POST['google_map_key']}'
					, seo_img					= '{$_POST['seo_img']}'
					, seo_key					= '{$_POST['seo_key']}'
					, seo_desc					= '{$_POST['seo_desc']}'
					";
	sql_query($sql);

	//Move
	goto_url($go_url);
}

//날자용
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">'.PHP_EOL;
$frm_submit .= '<input type="submit" value="확인" class="btn_submit" accesskey="s">'.PHP_EOL;
$frm_submit .= '<a href="./apms.admin.php?ap=update" class="btn_frmline">DB 업데이트</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.exp.update.php" class="btn_frmline win_memo">레벨 업데이트</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.new.update.php" class="btn_frmline win_memo">게시물 업데이트</a>'.PHP_EOL;
if(IS_YC) {
	$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.it.update.php" class="btn_frmline win_memo">상품 업데이트</a>'.PHP_EOL;
}
/* 추후 반영
if(USE_PARTNER) {
	$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.net.update.php" class="btn_frmline win_memo">파트너 업데이트</a>'.PHP_EOL;
}
*/
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.new.recover.php" class="btn_frmline win_memo">새글DB 복구</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.img.delete.php" class="btn_frmline win_memo">이미지 정리</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.exp.default.php" class="btn_frmline win_memo">포인트 정리</a>'.PHP_EOL;
$frm_submit .= '</div>';

// 시간
$harr = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16" , "17", "18", "19", "20", "21", "22", "23");

?>
<style>
.select-120 { width:120px; }
</style>
<div class="local_ov01 local_ov">
	<span class="ov_listall"><b>빌더정보</b></span>
	<span class="ov_listall"><?php echo APMS_VERSION;?> 버전</span>
	<a href="http://amina.co.kr/bbs/board.php?bo_table=apms" target="_blank">업데이트 확인하기</a>
</div>

<form name="basicform" id="basicform" method="post">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="mode" value="<?php echo $ap;?>">
<div class="tbl_head01 tbl_wrap">
	<table>
    <thead>
    <tr>
        <th rowspan="2">구분</th>
		<th colspan="2">PC 버전</th>
        <th colspan="2">모바일 버전</th>
        <th colspan="4">인덱스</th>
	</tr>
    <tr>
		<th scope="col">테마</th>
        <th scope="col">컬러셋</th>
        <th scope="col">테마</th>
        <th scope="col">컬러셋</th>
        <th scope="col">PC 인트로</th>
        <th scope="col">모바일 인트로</th>
		<th scope="col">유지체크</th>
        <th scope="col">지정일자</th>
	</tr>
	</thead>
    <tbody>
	<?php $thema_list = apms_dir_list('thema'); ?>
	<tr>
	<td align="center"><b>커뮤니티</b></td>
	<td align="center"><?php echo apms_thema_skin($thema_list, 'as_thema', $config['as_thema'], 'basic_thema', 'as_color', '테마 선택', 120);?></td>
	<td align="center">
		<div id="basic_thema">
			<?php echo apms_colorset_skin($config['as_thema'], 'as_color', $config['as_color'], '', 120);?>
		</div>	
	</td>
	<td align="center"><?php echo apms_thema_skin($thema_list, 'as_mobile_thema', $config['as_mobile_thema'], 'basic_mobile_thema', 'as_mobile_color', '테마 선택', 120);?></td>
	<td align="center">
		<div id="basic_mobile_thema">
			<?php echo apms_colorset_skin($config['as_mobile_thema'], 'as_mobile_color', $config['as_mobile_color'], '', 120);?>
		</div>	
	</td>
	<?php 
		$introskin = get_skin_dir('intro', G5_SKIN_PATH); 
		list($as_intro_type, $as_intro_time) = explode("|", $config['as_intro']);
	?>
	<td align="center">
		<select name="as_intro_skin" class="select-120">
			<option value="">사용안함</option>
			<?php 
				for ($k=0; $k<count($introskin); $k++) {
					echo "<option value=\"".$introskin[$k]."\"".get_selected($config['as_intro_skin'], $introskin[$k]).">".$introskin[$k]."</option>\n";
				} 
			?>
		</select>
	</td>
	<td align="center">
		<select name="as_mobile_intro_skin" class="select-120">
			<option value="">사용안함</option>
			<?php 
				for ($k=0; $k<count($introskin); $k++) {
					echo "<option value=\"".$introskin[$k]."\"".get_selected($config['as_mobile_intro_skin'], $introskin[$k]).">".$introskin[$k]."</option>\n";
				} 
			?>
		</select>
	</td>
	<td align="center">
		<select name="as_intro_type">
			<option value="0">세션체크</option>
			<option value="1"<?php echo get_selected($as_intro_type, "1");?>>캐시체크(1일)</option>
			<option value="2"<?php echo get_selected($as_intro_type, "2");?>>지정일자까지</option>
		</select>
	</td>
	<td align="center">
	    <input type="text" id="as_intro_day"  name="as_intro_day" value="<?php echo ($as_intro_time) ? date("Y-m-d", $as_intro_time) : '';?>" class="frm_input" size="10" maxlength="10"> 일
		<select id="as_intro_hour" name="as_intro_hour">
		<?php
			$as_intro_hour = ($as_intro_time) ? date("H", $as_intro_time) : '';
			for($i=0; $i < count($harr); $i++) {
				$selected = ($harr[$i] == $as_intro_hour) ? ' selected' : '';
				echo '<option value="'.$harr[$i].'"'.$selected.'>'.$harr[$i].'</option>'.PHP_EOL;
			}
		?>
		</select>
		시 까지
	</td>
    </tr>
	<?php if(IS_YC) { ?>
		<tr>
		<td align="center"><b>쇼핑몰</b></td>
		<td align="center"><?php echo apms_thema_skin($thema_list, 'as_shop_thema', $default['as_thema'], 'basic_shop_thema', 'as_shop_color', '테마 선택', 120);?></td>
		<td align="center">
			<div id="basic_shop_thema">
				<?php echo apms_colorset_skin($default['as_thema'], 'as_shop_color', $default['as_color'], '', 120);?>
			</div>	
		</td>
		<td align="center"><?php echo apms_thema_skin($thema_list, 'as_shop_mobile_thema', $default['as_mobile_thema'], 'basic_shop_mobile_thema', 'as_shop_mobile_color', '테마 선택', 120);?></td>
		<td align="center">
			<div id="basic_shop_mobile_thema">
				<?php echo apms_colorset_skin($default['as_mobile_thema'], 'as_shop_mobile_color', $default['as_mobile_color'], '', 120);?>
			</div>	
		</td>
		<?php list($as_shop_intro_type, $as_shop_intro_time) = explode("|", $default['as_intro']); ?>
		<td align="center">
			<select name="as_shop_intro_skin" class="select-120">
				<option value="">사용안함</option>
				<?php 
					for ($k=0; $k<count($introskin); $k++) {
						echo "<option value=\"".$introskin[$k]."\"".get_selected($default['as_intro_skin'], $introskin[$k]).">".$introskin[$k]."</option>\n";
					} 
				?>
			</select>
		</td>
		<td align="center">
			<select name="as_shop_mobile_intro_skin" class="select-120">
				<option value="">사용안함</option>
				<?php 
					for ($k=0; $k<count($introskin); $k++) {
						echo "<option value=\"".$introskin[$k]."\"".get_selected($default['as_mobile_intro_skin'], $introskin[$k]).">".$introskin[$k]."</option>\n";
					} 
				?>
			</select>
		</td>
		<td align="center">
			<select name="as_shop_intro_type">
				<option value="0">세션체크</option>
				<option value="1"<?php echo get_selected($as_shop_intro_type, "1");?>>캐시체크(1일)</option>
				<option value="2"<?php echo get_selected($as_shop_intro_type, "2");?>>지정일자까지</option>
			</select>
		</td>
		<td align="center">
			<input type="text" id="as_shop_intro_day"  name="as_shop_intro_day" value="<?php echo ($as_shop_intro_time) ? date("Y-m-d", $as_shop_intro_time) : '';?>" class="frm_input" size="10" maxlength="10"> 일
			<select id="as_shop_intro_hour" name="as_shop_intro_hour">
			<?php
				$as_shop_intro_hour = ($as_shop_intro_time) ? date("H", $as_shop_intro_time) : '';
				for($i=0; $i < count($harr); $i++) {
					$selected = ($harr[$i] == $as_shop_intro_hour) ? ' selected' : '';
					echo '<option value="'.$harr[$i].'"'.$selected.'>'.$harr[$i].'</option>'.PHP_EOL;
				}
			?>
			</select>
			시 까지
		</td>
		</tr>
	<?php } ?>
	</tbody>
    </table>
</div>
<div class="local_desc01 local_desc">
	<p>
		<?php echo (IS_YC) ? help('그누테마 적용후 기본환경설정, 게시판 관리(게시판, 1:1문의, FAQ), 쇼핑몰설정, 분류관리, 이벤트관리에서 각 스킨을 재설정해 주셔야 합니다.') : help('그누테마 적용후 기본환경설정, 게시판 관리(게시판, 1:1문의, FAQ)에서 각 스킨을 재설정해 주셔야 합니다.'); ?>
		<label><input type="checkbox" name="as_gnu" value="1"<?php echo ($config['as_gnu']) ? ' checked' : ''; ?> id="as_gnu"> 환경설정 > 테마설정에 있는 그누테마를 사용합니다. (그누테마 사용시 아미나빌더의 자동메뉴 등 중 일부 기능은 작동안함)</label>
	</p>
</div>
<?php echo $frm_submit; ?>

<br>

<?php if(IS_YC) { 
	$rows = apms_rows();
?>
	<div class="local_desc01 local_desc">
		<p><b>● 쇼핑몰 기본 설정</b> - 쇼핑몰 관련 추가설정입니다.</p>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
	    <thead>
		<tr>
		<th width=80>구분</th>
		<th width=80>항목</th>
		<th>설정</th>
		</tr>
		</thead>
		<tbody>
		<?php if($is_use_partner) { ?>
			<tr>
			<td><b>파트너</b></td>
			<td>사용여부</td>
			<td>
				<label>
				<input type="checkbox" name="as_partner" value="1"<?php echo ($default['as_partner']) ? ' checked' : ''; ?> id="as_partner">
				파트너 플러그인 사용 - 아미나빌더 파트너 플러그인이 설치되어 있어야 적용됩니다.
				</label>
			</td>
			</tr>
			<tr>
		<?php } ?>
		<td rowspan="2"><b>상품추천</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_good_use" id="pt_good_use">
				<option value="0"<?php echo get_selected('0', $default['pt_good_use']); ?>>사용안함</option>
				<option value="1"<?php echo get_selected('1', $default['pt_good_use']); ?>>회원만 가능</option>
				<option value="2"<?php echo get_selected('2', $default['pt_good_use']); ?>>구매회원만 가능</option>
			</select>
		</td>
		</tr>
		<tr>
		<td>추천점수</td>
		<td>
			<input type="text" name="pt_good_point" value="<?php echo $default['pt_good_point'] ?>" id="pt_good_point" class="frm_input" size="7"> 포인트
		</td>
		</tr>
		<tr>
		<td rowspan="4"><b>상품댓글</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_comment_use" id="pt_comment_use">
				<option value="0"<?php echo get_selected('0', $default['pt_comment_use']); ?>>우리만 사용</option>
				<option value="1"<?php echo get_selected('1', $default['pt_comment_use']); ?>>파트너도(안함포함)</option>
				<option value="2"<?php echo get_selected('2', $default['pt_comment_use']); ?>>파트너도(안함제외)</option>
			</select>
			&nbsp;
			<label>
			<input type="checkbox" name="pt_comment_sns" value="1"<?php echo $default['pt_comment_sns']?' checked':''; ?> id="pt_comment_sns">
			SNS 동시등록 사용
			</label>
		</td>
		</tr>
		<tr>
		<td>댓글점수</td>
		<td>
			<input type="text" name="pt_comment_point" value="<?php echo $default['pt_comment_point'] ?>" id="pt_comment_point" class="frm_input" size="7"> 포인트를
			<input type="text" name="pt_comment_limit" value="<?php echo $default['pt_comment_limit'] ?>" id="pt_comment_limit" class="frm_input" size="4"> 일 이내 등록상품에만 적립 (0일이면 항상 적립)
		</td>
		</tr>
		<tr>
		<td>블라인드</td>
		<td>
			<input type="text" name="pt_shingo" value="<?php echo $default['pt_shingo'] ?>" id="pt_shingo" class="frm_input" size="4"> 개 이상 신고가 접수되면 블라인드처리합니다. (최고 120개)
		</td>
		</tr>
		<tr>
		<td>럭키점수</td>
		<td>
			<label>
			<input type="checkbox" name="pt_lucky" value="1"<?php echo $default['pt_lucky']?' checked':''; ?> id="pt_lucky">
			럭키포인트를 사용합니다.
			</label>
		</td>
		</tr>
		<tr>
		<td><b>상품후기</b></td>
		<td>등록권한</td>
		<td>
			<label>
			<input type="checkbox" name="pt_review_use" value="1"<?php echo $default['pt_review_use']?' checked':''; ?> id="pt_review_use">
			파트너도 아이템별로 후기 등록권한 설정이 가능하도록 합니다.
			</label>
		</td>
		</tr>
		<tr>
		<td rowspan=3><b>예약기능</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_reserve_use" id="pt_reserve_use">
				<option value="0"<?php echo get_selected('0', $default['pt_reserve_use']); ?>>우리만 사용</option>
				<option value="1"<?php echo get_selected('1', $default['pt_reserve_use']); ?>>파트너도 사용</option>
			</select>
			&nbsp;
			<input type="text" name="pt_reserve_end" value="<?php echo $default['pt_reserve_end'] ?>" id="pt_reserve_end" class="numeric frm_input" size="4"> 일 이후까지 예약가능
		</td>
		</tr>
		<tr>
		<td>예약불가</td>
		<td>
			<input type="text" name="pt_reserve_none" value="<?php echo $default['pt_reserve_none'] ?>" id="pt_reserve_none" class="numeric frm_input" size="7"> 시간 지난 상품(파트너)은 예약불가
		</td>
		</tr>
		<tr>
		<td>예약체크</td>
		<td>
			<input type="text" name="pt_reserve_day" value="<?php echo $default['pt_reserve_day'] ?>" id="pt_reserve_day" class="numeric frm_input" size="7"> 일 이내 등록상품에 대해 
			<input type="text" name="pt_reserve_cache" value="<?php echo $default['pt_reserve_cache'] ?>" id="pt_reserve_cache" class="numeric frm_input" size="7"> 분 간격으로 체크
		</td>
		</tr>
		<tr>
		<td><b>자동기능</b></td>
		<td>구매완료</td>
		<td>
			<input type="text" name="pt_auto" value="<?php echo $default['pt_auto'] ?>" id="pt_auto" class="frm_input" size="7"> 일 경과된 파트너 배송상품에 대해
			<input type="text" name="pt_auto_cache" value="<?php echo $default['pt_auto_cache'] ?>" id="pt_auto_cache" class="numeric frm_input" size="7"> 시간 간격으로 체크
			(포인트 적립)
		</td>
		</tr>
		<tr>
		<td><b>첨부기능</b></td>
		<td>파일용량</td>
		<td>
			업로드 파일 한개당 <input type="text" name="pt_upload_size" value="<?php echo $default['pt_upload_size'] ?>" id="pt_upload_size" class="required numeric frm_input"  size="10"> bytes 이하 가능 - 최대 <?php echo ini_get("upload_max_filesize");?> 이하 업로드 가능, 1 MB = 1,048,576 bytes
		</td>
		</tr>
		<tr>
		<td><b>내용사진</b></td>
		<td>썸네일너비</td>
		<td>
			<input type="text" name="pt_img_width" value="<?php echo $default['pt_img_width'] ?>" id="pt_img_width" class="required numeric frm_input"  size="10"> px - 상품후기와 상품문의 글내용의 이미지 썸네일 너비값입니다.
		</td>
		</tr>
		<tr>
		<td rowspan="3"><b>기타설정</b></td>
		<td>에디터</td>
		<td>
			<select name="editor_skin" id="editor_skin">
			<option value="">PC 기본 에디터</option>
			<?php
			$arr = get_skin_dir('', G5_EDITOR_PATH);
			for ($i=0; $i<count($arr); $i++) {
				echo "<option value=\"".$arr[$i]."\"".get_selected($rows['editor_skin'], $arr[$i]).">".$arr[$i]."</option>\n";
			}
			?>
			</select>
			&nbsp;
			<select name="editor_mobile_skin" id="editor_mobile_skin">
			<option value="">모바일 사용안함</option>
			<?php
			for ($i=0; $i<count($arr); $i++) {
				echo "<option value=\"".$arr[$i]."\"".get_selected($rows['editor_mobile_skin'], $arr[$i]).">".$arr[$i]."</option>\n";
			}
			?>
			</select>
			&nbsp;
			상품후기와 상품문의에서 사용할 에디터를 설정합니다.
		</td>
		</tr>
		<tr>
		<td>자동메뉴</td>
		<td>
		<label><input type="checkbox" name="item_cnt" value="1"<?php if($xp['item_cnt']) echo ' checked';?>> 자동메뉴에서 상품갯수를 카운팅합니다. (사용시 속도가 느려질 수 있습니다.)</label>
		</td>
		</tr>
		<tr>
		<td>코드출력</td>
		<td>
		<label><input type="checkbox" name="pt_code" value="1"<?php if($default['pt_code']) echo ' checked';?>> 상품설명페이지에 SyntaxHighlighter 를 적용합니다.</label>
		</td>
		</tr>

		</tbody>
		</table>
	</div>

	<?php echo $frm_submit; ?>

	<br>

	<div class="local_desc01 local_desc">
		<p><b>● 쇼핑몰 페이지 설정</b> - 페이지별 기본 출력 목록수, 페이지 스킨 등</p>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
	    <thead>
		<tr>
		<th width=80 rowspan=2>구분</th>
		<th width=80 rowspan=2>항목</th>
		<th colspan=2>PC</th>
		<th colspan=2>모바일</th>
		<th colspan=2>PC 썸네일</th>
		<th colspan=2>모바일 썸네일</th>
		<th colspan=2>페이지스킨</th>
		<th rowspan=2>설명</th>
		</tr>
		<tr>
		<th width=80>가로수</th>
		<th width=80>세로수</th>
		<th width=80>가로수</th>
		<th width=80>세로수</th>
		<th width=80>가로너비</th>
		<th width=80>세로너비</th>
		<th width=80>가로너비</th>
		<th width=80>세로너비</th>
		<th width=80>PC</th>
		<th width=80>모바일</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td rowspan=4><b>상품설명</b></td>
		<td>상품댓글</td>
		<td></td>
		<td><input type="text" name="icomment_rows" value="<?php echo $rows['icomment_rows'] ?>" id="icomment_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="icomment_mobile_rows" value="<?php echo $rows['icomment_mobile_rows'] ?>" id="icomment_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>상품후기</td>
		<td></td>
		<td><input type="text" name="iuse_rows" value="<?php echo $rows['iuse_rows'] ?>" id="iuse_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="iuse_mobile_rows" value="<?php echo $rows['iuse_mobile_rows'] ?>" id="iuse_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>상품문의</td>
		<td></td>
		<td><input type="text" name="iqa_rows" value="<?php echo $rows['iqa_rows'] ?>" id="iqa_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="iqa_mobile_rows" value="<?php echo $rows['iqa_mobile_rows'] ?>" id="iuse_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>관련상품</td>
		<td><input type="text" name="irelation_mods" value="<?php echo $rows['irelation_mods'] ?>" id="irelation_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_rows" value="<?php echo $rows['irelation_rows'] ?>" id="irelation_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_mobile_mods" value="<?php echo $rows['irelation_mobile_mods'] ?>" id="irelation_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_mobile_rows" value="<?php echo $rows['irelation_mobile_rows'] ?>" id="irelation_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="de_rel_img_width" value="<?php echo $default['de_rel_img_width']; ?>" id="de_rel_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_rel_img_height" value="<?php echo $default['de_rel_img_height']; ?>" id="de_rel_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_rel_img_width" value="<?php echo $default['de_mobile_rel_img_width']; ?>" id="de_mobile_rel_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_rel_img_height" value="<?php echo $default['de_mobile_rel_img_height']; ?>" id="de_mobile_rel_img_height" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td rowspan=8><b>샵페이지</b></td>
		<td><a href="<?php echo G5_SHOP_URL;?>/personalpay.php">주문/결제</a></td>
		<td><input type="text" name="ppay_mods" value="<?php echo $rows['ppay_mods'] ?>" id="ppay_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_rows" value="<?php echo $rows['ppay_rows'] ?>" id="ppay_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_mobile_mods" value="<?php echo $rows['ppay_mobile_mods'] ?>" id="ppay_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_mobile_rows" value="<?php echo $rows['ppay_mobile_rows'] ?>" id="ppay_mobile_rows" class="frm_input" size="8"></td>
		<td colspan=4 class="gray">개인결제 리스트 목록수</td>
		<td>
			<select name="order_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('order', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['order_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="order_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['order_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td>장바구니, 주문서, 주문내역, 개인결제 등</td>
		</tr>
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/search.php">상품검색</a></td>
		<td><input type="text" name="de_search_list_mod" value="<?php echo $default['de_search_list_mod']; ?>" id="de_search_list_mod" class="frm_input" size="8"></td>
		<td><input type="text" name="de_search_list_row" value="<?php echo $default['de_search_list_row']; ?>" id="de_search_list_row" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_list_mod" value="<?php echo $default['de_mobile_search_list_mod']; ?>" id="de_mobile_search_list_mod" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_list_row" value="<?php echo $default['de_mobile_search_list_row']; ?>" id="de_mobile_search_list_row" class="frm_input" size="8"></td>
		<td><input type="text" name="de_search_img_width" value="<?php echo $default['de_search_img_width']; ?>" id="de_search_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_search_img_height" value="<?php echo $default['de_search_img_height']; ?>" id="de_search_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_img_width" value="<?php echo $default['de_mobile_search_img_width']; ?>" id="de_mobile_search_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_img_height" value="<?php echo $default['de_mobile_search_img_height']; ?>" id="de_mobile_search_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="de_search_list_skin" id="de_search_list_skin" class="select-120">
			<?php 
				if(USE_G5_THEME) {
					echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_search_list_skin']);
				} else {
					$listskin = get_skin_dir('search', G5_SKIN_PATH.'/apms');
					for ($k=0; $k<count($listskin); $k++) {
						echo "<option value=\"".$listskin[$k]."\"".get_selected($default['de_search_list_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
					}
				}
			?>
			</select>
		</td>
		<td>
			<select name="de_mobile_search_list_skin" id="de_mobile_search_list_skin" class="select-120">
			<?php 
				if(USE_G5_THEME) {
					echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $default['de_mobile_search_list_skin']);
				} else {
					for ($k=0; $k<count($listskin); $k++) {
						echo "<option value=\"".$listskin[$k]."\"".get_selected($default['de_mobile_search_list_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
					}
				}
			?>
			</select>
		</td>
		<td></td>
		</tr>	

		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/listtype.php">상품유형</a></td>
		<td><input type="text" name="type_mods" value="<?php echo $rows['type_mods'] ?>" id="type_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="type_rows" value="<?php echo $rows['type_rows'] ?>" id="type_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_mods" value="<?php echo $rows['type_mobile_mods'] ?>" id="type_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_rows" value="<?php echo $rows['type_mobile_rows'] ?>" id="type_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="type_img_width" value="<?php echo $rows['type_img_width'] ?>" id="type_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="type_img_height" value="<?php echo $rows['type_img_height'] ?>" id="type_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_img_width" value="<?php echo $rows['type_mobile_img_width'] ?>" id="type_mobile_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_img_height" value="<?php echo $rows['type_mobile_img_height'] ?>" id="type_mobile_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="type_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('type', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['type_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="type_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['type_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td>인기,추천,할인 등 상품유형별 페이지</td>
		</tr>	
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/myshop.php?id=<?php echo $config['cf_admin'];?>">마이샵</a></td>
		<td><input type="text" name="myshop_mods" value="<?php echo $rows['myshop_mods'] ?>" id="myshop_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_rows" value="<?php echo $rows['myshop_rows'] ?>" id="myshop_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_mods" value="<?php echo $rows['myshop_mobile_mods'] ?>" id="myshop_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_rows" value="<?php echo $rows['myshop_mobile_rows'] ?>" id="myshop_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_img_width" value="<?php echo $rows['myshop_img_width'] ?>" id="myshop_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_img_height" value="<?php echo $rows['myshop_img_height'] ?>" id="myshop_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_img_width" value="<?php echo $rows['myshop_mobile_img_width'] ?>" id="myshop_mobile_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_img_height" value="<?php echo $rows['myshop_mobile_img_height'] ?>" id="myshop_mobile_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="myshop_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('myshop', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['myshop_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="myshop_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['myshop_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td>파트너 개별 샵 페이지</td>
		</tr>	
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/event.php">이벤트</a></td>
		<td><input type="text" name="event_mods" value="<?php echo $rows['event_mods'] ?>" id="event_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="event_rows" value="<?php echo $rows['event_rows'] ?>" id="event_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="event_mobile_mods" value="<?php echo $rows['event_mobile_mods'] ?>" id="event_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="event_mobile_rows" value="<?php echo $rows['event_mobile_rows'] ?>" id="event_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>
			<select name="event_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('event', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['event_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="event_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['event_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td>이벤트 배너 페이지</td>
		</tr>	
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/itemuselist.php">상품후기</a></td>
		<td></td>
		<td><input type="text" name="use_rows" value="<?php echo $rows['use_rows'] ?>" id="use_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="use_mobile_rows" value="<?php echo $rows['use_mobile_rows'] ?>" id="use_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>
			<select name="use_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('use', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['use_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="use_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['use_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td></td>
		</tr>
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/itemqalist.php">상품문의</a></td>
		<td></td>
		<td><input type="text" name="qa_rows" value="<?php echo $rows['qa_rows'] ?>" id="qa_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="qa_mobile_rows" value="<?php echo $rows['qa_mobile_rows'] ?>" id="qa_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>
			<select name="qa_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('qa', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['qa_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="qa_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['qa_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td></td>
		</tr>				
		<tr>
		<td><a href="<?php echo G5_SHOP_URL;?>/couponzone.php">쿠폰존</a></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>
			<select name="cz_skin" class="select-120">
			<?php 
				$listskin = get_skin_dir('couponzone', G5_SKIN_PATH.'/apms');
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['cz_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>
		</td>
		<td>
			<select name="cz_mobile_skin" class="select-120">
			<?php 
				for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['cz_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} 
			?>
			</select>		
		</td>
		<td></td>
		</tr>				
		</tbody>
		</table>
	</div>

	<?php echo $frm_submit; ?>

	<br>

<?php } ?>

<div class="local_desc01 local_desc">
	<p><b>● 회원 설정</b> - XP는 처음 설정 저장 후 또는 설정 변경시 <b>'업데이트'</b>를 실행해야 모든 회원에게 일괄적용됩니다.</p>
</div>

<style>
	.grade-txt span { display:inline-block; width:250px; margin:3px 0px;}
</style>
<div class="tbl_head01 tbl_wrap">
	<table>
    <thead>
	<tr>
	<th width=80>구분</th>
	<th width=80>항목</th>
	<th>설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td rowspan="6"><b>XP 설정</b></td>
	<td>경험치룰</td>
	<td>
		<label><input type="checkbox" name="exp_point" value="1"<?php if($xp['exp_point']) echo ' checked';?>> 현재 회원 포인트(<?php echo AS_MP;?>) - 설정시 다른 룰은 무시되며, 포인트 사용에 따라 경험치와 레벨 등락 발생</label>

		<div style="height:1px; border-top:1px solid #ececec; margin:8px 0px;"></div>
		<style>
			.exp-rule label { display:inline-block; width:120px;}
		</style>
		<div class="exp-rule">
			<label><input type="checkbox" name="exp_login" value="1"<?php if($xp['exp_login']) echo ' checked';?>> 로그인 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_write" value="1"<?php if($xp['exp_write']) echo ' checked';?>> 쓰기 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_comment" value="1"<?php if($xp['exp_comment']) echo ' checked';?>> 댓글 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_read" value="1"<?php if($xp['exp_read']) echo ' checked';?>> 읽기 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_good" value="1"<?php if($xp['exp_good']) echo ' checked';?>> 추천 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_nogood" value="1"<?php if($xp['exp_nogood']) echo ' checked';?>> 비추천 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_chulsuk" value="1"<?php if($xp['exp_chulsuk']) echo ' checked';?>> 출석 <?php echo AS_MP;?></label>
			<?php if(IS_YC) { ?>
				<label><input type="checkbox" name="exp_delivery" value="1"<?php if($xp['exp_delivery']) echo ' checked';?>> 구매 <?php echo AS_MP;?></label>
			<?php } ?>
		</div>
	</td>
	</tr>
	<tr>
	<td>레벨업룰</td>
	<td>
		<?php 
			//Default
			$xp['xp_point'] = ($xp['xp_point'] > 0) ? $xp['xp_point'] : 1000;
			$xp['xp_rate'] = ($xp['xp_rate'] > 0) ? $xp['xp_rate'] : 0.0;
			$xp['xp_max'] = ($xp['xp_max'] > 0) ? $xp['xp_max'] : 99; 
		?>
		<input type="text" id="xp_point" name="xp_point" size="6" value="<?php echo $xp['xp_point'];?>" class="frm_input"> <?php echo AS_MP;?>를 기준으로
		레벨당 기준 <?php echo AS_MP;?>의 <input type="text" id="xp_rate" name="xp_rate" size="4" value="<?php echo $xp['xp_rate'];?>" class="frm_input"> 배 추가 <?php echo AS_MP;?> 증가 
		(최고 <input type="text" id="xp_max" name="xp_max" size="4" value="<?php echo $xp['xp_max'];?>" class="frm_input"> 레벨)
		&nbsp;
		<a class="btn_frmline win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.php">레벨 시뮬레이터</a>
		<a class="btn_frmline win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.update.php">레벨 업데이트</a>
		<a class="btn_frmline win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.default.php">포인트 및 경험치 정리</a>

	</td>
	</tr>
	<tr>
	<td>레벨표시</td>
	<td>
		<select name="xp_icon">
			<option value="txt">텍스트 표시</option>
			<option value="img"<?php if($xp['xp_icon'] == 'img') echo ' selected'; ?>>아이콘 표시</option>
		</select>
		&nbsp; &nbsp;
		텍스트 스킨
		<?php $xp_icon_css = apms_file_list('css/level', 'css');?>
		<select name="xp_icon_css" id="xp_icon_css">
			<?php for($i=0; $i < count($xp_icon_css); $i++) { ?>
				<option value="<?php echo $xp_icon_css[$i];?>"<?php echo get_selected($xp_icon_css[$i], $xp['xp_icon_css']); ?>><?php echo $xp_icon_css[$i];?></option>
			<?php } ?>
		</select>
		&nbsp; &nbsp;
		아이콘 스킨
		<?php $xp_icon_list = apms_dir_list('img/level');?>
		<select name="xp_icon_skin" id="xp_icon_skin">
			<?php for($i=0; $i < count($xp_icon_list); $i++) { ?>
				<option value="<?php echo $xp_icon_list[$i];?>"<?php echo get_selected($xp_icon_list[$i], $xp['xp_icon_skin']); ?>><?php echo $xp_icon_list[$i];?></option>
			<?php } ?>
		</select>
		&nbsp; &nbsp;
		<label><input type="checkbox" name="xp_now" value="1"<?php if($xp['xp_now']) echo ' checked';?>> 이름 앞에 회원레벨 표시 안함(보드는 개별설정)</label>
	</td>
	</tr>
	<tr>
	<td>레벨마크</td>
	<td>
		<div class="grade-txt">
			<span><input type="text" name="xp_icon_admin" size="15" value="<?php echo $xp['xp_icon_admin'];?>" class="frm_input"> 관리자 텍스트 마크</span>
			<span><input type="text" name="xp_icon_guest" size="15" value="<?php echo $xp['xp_icon_guest'];?>" class="frm_input"> 비회원 텍스트 마크</span>
			<span><input type="text" name="xp_icon_special" size="15" value="<?php echo $xp['xp_icon_special'];?>" class="frm_input"> 스페셜 텍스트 마크</span>
		</div>
	</td>
	</tr>
	<tr>
	<td>자동등업</td>
	<td>
		<?php echo help("등업구간은 지정한 각 등급의 시작레벨을 차례대로 입력하는데, 첫번째 등급의 시작레벨은 1레벨로 고정입니다. 따라서 두번째 등급의 시작레벨부터 입력하시면 됩니다."); ?>
		<select name="xp_from">
			<option value="0">등급</option>
			<option value="2"<?php if($xp['xp_from'] == "2") echo ' selected';?>>2등급</option>
			<option value="3"<?php if($xp['xp_from'] == "3") echo ' selected';?>>3등급</option>
			<option value="4"<?php if($xp['xp_from'] == "4") echo ' selected';?>>4등급</option>
			<option value="5"<?php if($xp['xp_from'] == "5") echo ' selected';?>>5등급</option>
			<option value="6"<?php if($xp['xp_from'] == "6") echo ' selected';?>>6등급</option>
			<option value="7"<?php if($xp['xp_from'] == "7") echo ' selected';?>>7등급</option>
			<option value="8"<?php if($xp['xp_from'] == "8") echo ' selected';?>>8등급</option>
			<option value="9"<?php if($xp['xp_from'] == "9") echo ' selected';?>>9등급</option>
		</select>
		부터
		<select name="xp_to">
			<option value="0">등급</option>
			<option value="9"<?php if($xp['xp_to'] == "9") echo ' selected';?>>9등급</option>
			<option value="8"<?php if($xp['xp_to'] == "8") echo ' selected';?>>8등급</option>
			<option value="7"<?php if($xp['xp_to'] == "7") echo ' selected';?>>7등급</option>
			<option value="6"<?php if($xp['xp_to'] == "6") echo ' selected';?>>6등급</option>
			<option value="5"<?php if($xp['xp_to'] == "5") echo ' selected';?>>5등급</option>
			<option value="4"<?php if($xp['xp_to'] == "4") echo ' selected';?>>4등급</option>
			<option value="3"<?php if($xp['xp_to'] == "3") echo ' selected';?>>3등급</option>
			<option value="2"<?php if($xp['xp_to'] == "2") echo ' selected';?>>2등급</option>
		</select>
		까지 회원레벨에 따른 자동등업 적용
		<i class="fa fa-arrow-circle-right"></i> 회원등급별 회원레벨구간 :
		1레벨
		>
		<input type="text" name="xp_auto1" size="3" value="<?php echo $xp['xp_auto1'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto2" size="3" value="<?php echo $xp['xp_auto2'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto3" size="3" value="<?php echo $xp['xp_auto3'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto4" size="3" value="<?php echo $xp['xp_auto4'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto5" size="3" value="<?php echo $xp['xp_auto5'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto6" size="3" value="<?php echo $xp['xp_auto6'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto7" size="3" value="<?php echo $xp['xp_auto7'];?>" class="frm_input">
		레벨 
	</td>
	</tr>
	<tr>
	<td>스페셜회원</td>
	<td>
		<?php echo help("스페셜아이콘을 적용할 회원아이디를 콤마(,)로 구분해서 등록해 주세요."); ?>
		<input type="text" name="xp_special" value="<?php echo $xp['xp_special'];?>" class="frm_input" style="width:98%">
	</td>
	</tr>
	<tr>
	<td rowspan=2><b>최고관리자</b></td>
	<td>등록회원</td>
	<td>
		<?php echo help("최고관리자로 등록할 회원아이디를 콤마(,)로 구분해서 등록해 주세요."); ?>
		<input type="text" name="as_admin" size="45" value="<?php echo $config['as_admin'];?>" class="frm_input" style="width:98%;">
	</td>
	</tr>
	<tr>
	<td>일반표시</td>
	<td>
		<?php echo help("최고관리자 지정회원 중 최고관리자 레벨표시를 하지 않고 일반회원레벨로 표시할 회원아이디를 콤마(,)로 구분해서 등록해 주세요."); ?>
		<input type="text" name="xp_except" size="45" value="<?php echo $xp['xp_except'];?>" class="frm_input" style="width:98%;">	
	</td>
	</tr>
	<tr>
	<td rowspan="2"><b>특수관리자</b></td>
	<td>디자이너</td>
	<td>
		<?php echo help("테마/위젯/스킨의 디자인설정 관리자로 등록할 회원아이디를 콤마(,)로 구분해서 등록해 주세요. 또한 내용관리, 보드스킨 등 관리권한이 필요한 페이지는 환경설정 > 관리권한설정에도 등록해 주셔야 합니다."); ?>
		<input type="text" name="xp_designer" size="45" value="<?php echo $xp['xp_designer'];?>" class="frm_input" style="width:98%;">	
	</td>
	</tr>
	<tr>
	<td>자료관리</td>
	<td>
		<?php echo help("게시판/쇼핑몰 첨부자료의 검수 관리자로 등록할 회원아이디를 콤마(,)로 구분해서 등록해 주세요."); ?>
		<input type="text" name="xp_manager" size="45" value="<?php echo $xp['xp_manager'];?>" class="frm_input" style="width:98%;">	
	</td>
	</tr>
	<tr>
	<td rowspan="2"><b>회원사진</b></td>
	<td>사진크기</td>
	<td>
		<input type="text" name="xp_photo" size="4" value="<?php echo $xp['xp_photo'];?>" class="frm_input"> px - 회원사진 등록시 자동으로 리사이징 됩니다.
	</td>
	</tr>
	<tr>
	<td>사진없음</td>
	<td>
		<?php echo help("비회원 또는 회원사진 미등록시 출력될 회원 대표사진 이미지 주소를 등록해 주세요. 미등록시 스킨에 따라 FA 아이콘 등이 출력됩니다."); ?>
		<input type="text" name="xp_photo_url" size="45" value="<?php echo $xp['xp_photo_url'];?>" class="frm_input" style="width:98%;">	
	</td>
	</tr>
	<tr>
	<td><b>회원등급</b></td>
	<td>표시문구</td>
	<td>
		<?php echo help("회원등급은 그누회원레벨(mb_level)을 뜻합니다."); ?>
		<div class="grade-txt">
			<span><input type="text" name="xp_grade1" size="15" value="<?php echo $xp['xp_grade1'];?>" class="frm_input"> 1등급 - 예) 비회원</span>
			<span><input type="text" name="xp_grade2" size="15" value="<?php echo $xp['xp_grade2'];?>" class="frm_input"> 2등급 - 예) 실버회원</span>
			<span><input type="text" name="xp_grade3" size="15" value="<?php echo $xp['xp_grade3'];?>" class="frm_input"> 3등급 - 예) 골드회원</span>
			<span><input type="text" name="xp_grade4" size="15" value="<?php echo $xp['xp_grade4'];?>" class="frm_input"> 4등급 - 예) 로열회원</span>
			<span><input type="text" name="xp_grade5" size="15" value="<?php echo $xp['xp_grade5'];?>" class="frm_input"> 5등급 - 예) 프렌드회원</span>
			<span><input type="text" name="xp_grade6" size="15" value="<?php echo $xp['xp_grade6'];?>" class="frm_input"> 6등급 - 예) 패밀리회원</span>
			<span><input type="text" name="xp_grade7" size="15" value="<?php echo $xp['xp_grade7'];?>" class="frm_input"> 7등급 - 예) 스페셜회원</span>
			<span><input type="text" name="xp_grade8" size="15" value="<?php echo $xp['xp_grade8'];?>" class="frm_input"> 8등급 - 예) 운영자</span>
			<span><input type="text" name="xp_grade9" size="15" value="<?php echo $xp['xp_grade9'];?>" class="frm_input"> 9등급 - 예) 관리자</span>
			<span><input type="text" name="xp_grade10" size="15" value="<?php echo $xp['xp_grade10'];?>" class="frm_input"> 10등급 - 예) 최고관리자</span>
		</div>
	</td>
	</tr>
	<tr>
	<td rowspan="2"><b>표현설정</b></td>
	<td>경험치</td>
	<td><input type="text" name="as_xp" size="15" value="<?php echo $config['as_xp'];?>" class="frm_input"> 표현코드 : &lt;?php echo AS_XP;?></td>
	</tr>
	<tr>
	<td>포인트</td>
	<td><input type="text" name="as_mp" size="15" value="<?php echo $config['as_mp'];?>" class="frm_input"> 표현코드 : &lt;?php echo AS_MP;?></td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>

<br>

<div class="local_desc01 local_desc">
	<p><b>● 기능 설정</b> - SEO, 럭키포인트, API Key 등 설정</p>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
	<thead>
	<tr>
	<th align="center" width=80>구분</th>
	<th width=80>항목</th>
	<th>설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td rowspan="3"><b>SEO</b></td>
	<td>이미지</td>
	<td>
		<?php echo help("각 페이지에 이미지가 없을 경우 노출될 사이트 대표이미지 URL을 등록해 주세요."); ?>
		<input type="text" id="seo_img" name="seo_img" size="100" value="<?php echo $xp['seo_img'];?>" class="frm_input">	
		<a class="btn_frmline win_memo" href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=seo_img">이미지 선택</a>
	</td>
	</tr>
	<tr>
	<td>키워드</td>
	<td>
		<?php echo help("사이트 대표 키워드를 콤마를 이용해서 등록해 주세요."); ?>
		<textarea name="seo_key" rows="3" id="seo_key"><?php echo $xp['seo_key'];?></textarea>
	</td>
	</tr>
	<tr>
	<td>설명글</td>
	<td>
		<?php echo help("사이트 대표 설명글을 등록해 주세요."); ?>
		<textarea name="seo_desc" rows="6" id="seo_desc"><?php echo $xp['seo_desc'];?></textarea>
	</td>
	</tr>
	<tr>
	<td><b>SSL</b></td>
	<td>https</td>
	<td>
		<label>
			<input type="checkbox" name="https_url" value="1"<?php if($xp['https_url']) echo ' checked';?>> 
			https 전용 사이트입니다.
		</label>
	</td>
	</tr>
	<tr>
	<td><b>에디터</b></td>
	<td>이미지</td>
	<td>
		<label>
			<input type="checkbox" name="editor_img" value="1"<?php if($xp['editor_img']) echo ' checked';?>> 
			게시물 삭제시 에디터 이미지를 삭제하거나 게시물 복사시 에디터 이미지를 별도 복사합니다.
		</label>
	</td>
	</tr>
	<tr>
	<td><b>미디어</b></td>
	<td>최대너비</td>
	<td>
		<input type="text" id="auto_size" name="auto_size" size="7" value="<?php echo $xp['auto_size'];?>" class="frm_input">	
		동영상, 구글맵 등의 iframe 최대 너비로 설정시 단위(px,%)까지 입력해 주셔야 합니다. 
	</td>
	</tr>
	<tr>
	<td><b>적립제한</b></td>
	<td>댓글점수</td>
	<td>
		<input type="text" name="comment_limit" value="<?php echo $xp['comment_limit'] ?>" id="comment_limit" class="frm_input" size="7"> 일 이내 등록된 게시물에 대해서만 댓글포인트를 적립합니다. (0일이면 항상 적립)
	</td>
	</tr>
	<tr>
	<td rowspan="3"><b>댓글럭키</b></td>
	<td>포인트</td>
	<td>
		<input type="text" name="lucky_point" value="<?php echo $xp['lucky_point'] ?>" id="lucky_point" class="frm_input" size="7"> 포인트 내에서 랜덤으로 럭키포인트를 적립합니다. (0 입력시 댓글 럭키포인트 사용안함)
	</td>
	</tr>
	<tr>
	<td>주사위</td>
	<td>
		<input type="text" name="lucky_dice" value="<?php echo $xp['lucky_dice'] ?>" id="lucky_dice" class="frm_input" size="7"> 면체 주사위 2개를 던져 같은 숫자가 나오면 럭키포인트를 지급합니다. (0 입력시 댓글 럭키포인트 사용안함)
	</td>
	</tr>
	<tr>
	<td>메시지</td>
	<td>
		<?php echo help("댓글에 출력되는 럭키포인트 당첨 메시지 중 [point]가 럭키포인트로 치환됩니다."); ?>
		<?php //럭키메시지 초기값 
			if(!$xp['lucky_msg']) {
				$xp['lucky_msg'] = '<p class="en" style="margin-top:10px;"><i class="fa fa-gift"></i> Congratulation! You win the <b class="orangered">[point]</b> Lucky Point!</p>';
			}
		?>
		<textarea name="lucky_msg" rows="3" id="lucky_msg"><?php echo $xp['lucky_msg'];?></textarea>
	</td>
	</tr>
	<tr>
	<td><b>JWPlayer6</b></td>
	<td>라이센스키</td>
	<td>
		<?php echo help("JWPlayer 6은 상업 사이트 또는 JWPlayer 로고 삭제시 JWPlayer 6 라이센스키를 발급받아서 등록해 주셔야 합니다."); ?>
		<input type="text" id="jwplayer_key" name="jwplayer_key" size="100" value="<?php echo $xp['jwplayer_key'];?>" class="frm_input">	
		<a class="btn_frmline" href="https://www.jwplayer.com/" target="_blank">발급받기</a>
	</td>
	</tr>
	<tr>
	<td><b>페이스북</b></td>
	<td>접속토큰</td>
	<td>
		<?php echo help("페북 동영상 썸네일을 가져오기 위해서는 페북 개발자센터에서 앱을 등록하고 Tools & Support > Graph API Explorer 메뉴에서 Get Token > Get App Token 실행 후 생성된 값을 등록해 주셔야 합니다."); ?>
		<input type="text" id="facebook_token" name="facebook_token" size="100" value="<?php echo $xp['facebook_token'];?>" class="frm_input">	
		<a class="btn_frmline" href="https://developers.facebook.com" target="_blank">발급받기</a>
	</td>
	</tr>
	<tr>
	<td><b>구글맵</b></td>
	<td>API키</td>
	<td>
		<?php echo help("Google API Console에서 서버키(안되면 브라우저 API 키)를 발급받은 후 라이브러리에서 Google Maps JavaScript API를 사용설정해야 합니다."); ?>
		<input type="text" id="google_map_key" name="google_map_key" size="100" value="<?php echo $xp['google_map_key'];?>" class="frm_input">	
		<a class="btn_frmline" href="https://developers.google.com/maps/documentation/geocoding/get-api-key?hl=ko" target="_blank">발급받기</a>
	</td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>

</form>
<script>
$(function(){
	$("#as_intro_day, #as_shop_intro_day").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true });
});
</script>