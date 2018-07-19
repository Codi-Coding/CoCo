<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$res = sql_query(" select distinct cf_id from {$g5['config2w_table']} ");
$tmpl_arr_db = array();
while($row = sql_fetch_array($res)) { if($row['cf_id']) $tmpl_arr_db[] = $row['cf_id']; }

$res = sql_query(" select distinct cf_id from {$g5['config2w_m_table']} ");
$mobile_tmpl_arr_db = array();
while($row = sql_fetch_array($res)) { if($row['cf_id']) $mobile_tmpl_arr_db[] = $row['cf_id']; }
?>
<?php ///if($is_admin && defined('DEMO_BUTTON') && DEMO_BUTTON) { ?>
<?php if(defined('DEMO_BUTTON') && DEMO_BUTTON) { ?>
<link rel="stylesheet" href="<?php echo G5_URL?>/css/demo_button.css">

<div id="demo">
<form method=post>
<div id="title"><?php echo BUILDER_NAME.' '.BUILDER_VERSION_NUMBER.' '.BUILDER_VERSION_CLASS.' '?>데모 템플릿 (<span><?php if(G5_IS_MOBILE) echo 'mobile'; else echo 'pc'; ?></span>)</div>
<div id="box">
<a href='<?php echo G5_URL?>/?device=pc' class='pc'>PC</a>
<select name=tmpl>
<option value="">Default 설정값
<?php
    for ($i = 0; $i < count($tmpl_arr); $i++) {
          if(!in_array($tmpl_arr[$i], $tmpl_arr_db)) continue;

          if($tmpl_arr[$i] == $g5['tmpl']) $selected = " selected";
          else $selected = "";
          echo '<option value="'.$tmpl_arr[$i].'"'.$selected.'>'.$i.'. '.$tmpl_arr[$i].PHP_EOL;
    }
?>
</select>
<br/>
<a href='<?php echo G5_URL?>/?device=mobile'>모바일</a>
<select name=mobile_tmpl>
<option value="">Default 설정값
<?php
    for ($i = 0; $i < count($mobile_tmpl_arr); $i++) {
          if(!in_array($mobile_tmpl_arr[$i], $mobile_tmpl_arr_db)) continue;

          if($mobile_tmpl_arr[$i] == $g5['mobile_tmpl']) $selected = " selected";
          else $selected = "";
          echo '<option value="'.$mobile_tmpl_arr[$i].'"'.$selected.'>'.$i.'. '.$mobile_tmpl_arr[$i].PHP_EOL;
    }
?>
</select>
<br/>
<input type=submit value="선 택">
</div>
</form>
</div>
<?php } ?>
