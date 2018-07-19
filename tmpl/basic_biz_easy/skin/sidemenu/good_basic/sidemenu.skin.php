<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

if(defined('_INDEX_') && _INDEX_ == true) return;
?>

<link rel="stylesheet" href="<?php echo $sidemenu_skin_url ?>/style.css">

<!-- 사이드 메뉴 시작 -->
<section id="sidemenu_aside">
  <div>
    <header>
        <h2><a href="<?php echo $menu_list[$main_index][1]?>" onClick="<?php echo $target_link?>"><?php echo _t($menu_list[$main_index][0])?></a></h2>
    </header>
    <ul>
        <?php
        for($i=0; $i<count($menu[$main_index]); $i++) {
	        if($i == 0) { if($main_index == 0) continue; }

	        if($i==$side_index) {
		       $side_class="sublocalActive";
	        }
	        else {
		       $side_class="sublocalNormal";
	        }

	        if($menu[$main_index][$i][2]) {
		        $target_link="window.open(this.href, '{$menu[$main_index][$i][2]}'); return false;";
	        }
        ?>
        <li><a href="<?php echo $menu[$main_index][$i][1]?>" class="<?php echo $side_class?>" onClick="<?php echo $target_link?>"><?php echo _t($menu[$main_index][$i][0])?></a></li>
        <?php } ?>
    </ul>
  </div>
</section>
<!-- 사이드 메뉴 끝 -->
