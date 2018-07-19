<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if(!$at_set['font']) $at_set['font'] = 'ko';

add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/assets/bs3/css/bootstrap.min.css" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="'.COLORSET_URL.'/colorset.css" type="text/css">',0);
?>
<div class="<?php echo $at_set['font'];?>">