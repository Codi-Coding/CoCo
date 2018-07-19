<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

include_once(G5_PATH.'/head.sub.php');

if($act == 'ok') {

	check_admin_token();

	//자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	$directory = array();
	$dl = array('apms/video');

	foreach($dl as $val) {
		$dir = G5_DATA_PATH.'/'.$val;

		if(!is_dir($dir)) continue;

		if($handle = opendir($dir)) {
			while(false !== ($entry = readdir($handle))) {
				if($entry == '.' || $entry == '..')
					continue;

				$path = G5_DATA_PATH.'/'.$val.'/'.$entry;

				if(is_dir($path))
					$directory[] = $path;
			}
		}
	}

	flush();

	echo '<ul style="line-height:22px;">'.PHP_EOL;

	$num = 0;
	foreach($directory as $dir) {
		$files = glob($dir.'/*');
		if (is_array($files)) {
			$k = 0;
			foreach($files as $thumbnail) {
				@unlink($thumbnail);
				$k++;
				$num++;
			}
			
			if(!$k) continue;

			echo '<li>'.str_replace(G5_PATH, '', $dir).' 폴더 동영상 이미지 '.number_format($k).'개 삭제완료</li>'.PHP_EOL;
		}
	}

?>	
	</ul>

	<script type='text/javascript'> 
		alert('총 <?php echo number_format($num);?>개의 동영상 이미지 삭제를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-video-camera"></i> 동영상 이미지 삭제</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li>/data/apms/video 폴더에 저장된 동영상 이미지와 썸네일을 일괄삭제합니다.</li>
				<li>동영상 이미지가 삭제되더라도 해당 게시물 접속시 이미지는 자동으로 재생성됩니다.</li>
				<li>전체 동영상 이미지에 대해 처리되므로 시간이 걸릴 수 있습니다.</li>
			</ul>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function update_submit(f) {
			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>