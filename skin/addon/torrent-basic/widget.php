<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

global $is_torrent, $torrent;

if(!$is_torrent) return;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

$view_font = (G5_IS_MOBILE) ? '' : ' font-12';

$torrent_cnt = count($torrent);

for($i=0; $i < $torrent_cnt; $i++) { 
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-share-alt fa-lg"></i> <?php echo $torrent[$i]['name'];?></h3>
		</div>
		<div class="panel-body">
			<span class="pull-right hidden-xs text-muted en font-11"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i", $torrent[$i]['date']);?></span>
			<?php if ($torrent[$i]['is_size']) { ?>
					<b class="en font-16"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['info']['name'];?> (<?php echo $torrent[$i]['info']['size'];?>)</b>
			<?php } else { ?>
				<p><b class="en font-16"><i class="fa fa-cube"></i> Total <?php echo $torrent[$i]['info']['total_size'];?></b></p>
				<div class="text-muted<?php echo $view_font;?>">
					<?php for ($j=0;$j < count($torrent[$i]['info']['file']);$j++) { 
						echo ($j + 1).'. '.implode(', ', $torrent[$i]['info']['file'][$j]['name']).' ('.$torrent[$i]['info']['file'][$j]['size'].')<br>'."\n";
					} ?>
				</div>
			<?php } ?>
		</div>
		<ul class="list-group">
			<li class="list-group-item en font-14 break-word"><i class="fa fa-magnet"></i> <?php echo $torrent[$i]['magnet'];?></li>
			<li class="list-group-item break-word">
				<div class="text-muted<?php echo $view_font;?>">
					<?php for ($j=0;$j < count($torrent[$i]['tracker']);$j++) { ?>
						<i class="fa fa-tags"></i> <?php echo $torrent[$i]['tracker'][$j];?><br>
					<?php } ?>
				</div>
			</li>
			<?php if($torrent[$i]['comment']) { ?>
				<li class="list-group-item en font-14 break-word"><i class="fa fa-bell"></i> <?php echo $torrent[$i]['comment'];?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>