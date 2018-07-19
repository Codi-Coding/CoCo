<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//주문폼에서는 작동안함
if(isset($pid) && $pid == 'orderform') return;

include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

// 설정토글
$toggle = 0;

// 테마스킨
$tmain = apms_file_list('thema/'.THEMA.'/main', 'php');
$tside = apms_file_list('thema/'.THEMA.'/side', 'php');
?>
<aside class="<?php echo $is_thema_font;?>">
	<script>
		var sw_url = "<?php echo THEMA_URL;?>";
	</script>
	<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/spectrum.css">
	<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/switcher.css">
	<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/spectrum.js"></script>
	<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/switcher.js"></script>
	<section id="style-switcher" class="font-12 ko-12">
		<div class="cursor switcher-icon layout-setup" title="테마설정">
			<i class="fa fa-desktop"></i>
		</div>
		<div class="cursor switcher-icon widget-setup" title="위젯설정">
			<i class="fa fa-cogs"></i>
		</div>
		<div class="switcher-wrap">
			<div class="switcher-title layout-setup cursor en">
				<i class="fa fa-magic"></i>
				Style Switcher
			</div>
			<div class="switcher-content">
				<?php if($is_demo) { ?>
					<form id="themaSwitcher" name="themaSwitcher" method="post" class="form">
					<input type="hidden" name="dpv" value="1" id="dvp">
					<input type="hidden" name="at_set[dpv]" value="1">
				<?php } else { ?>
					<form id="themaSwitcher" name="themaSwitcher" action="<?php echo $at_href['switcher_submit'];?>" method="post" onsubmit="return switcher_submit(this);" class="form">
					<input type="hidden" name="sw_type" value="<?php echo $sw_type;?>">
					<input type="hidden" name="sw_code" value="<?php echo $sw_code;?>">
					<input type="hidden" name="sw_thema" value="<?php echo THEMA;?>">
					<input type="hidden" name="url" value="<?php echo urldecode($urlencode);?>">
				<?php } ?>
				<input type="hidden" name="at_set[thema]" value="<?php echo THEMA;?>">

				<div class="panel-group" id="switcherSet" role="tablist" aria-multiselectable="true">

					<div class="panel">
						<div class="panel-heading" role="tab" id="swHead<?php $toggle++; echo $toggle;?>" aria-expanded="true" aria-controls="swSet<?php echo $toggle;?>">
							<a data-toggle="collapse" data-parent="#switcherSet" href="#swSet<?php echo $toggle;?>">
								<i class="fa fa-caret-right"></i> 사이트 설정
							</a>
						</div>
						<div id="swSet<?php echo $toggle;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="swHead<?php echo $toggle;?>">
							<div class="panel-body">
								<div class="input-group input-group-sm input-line">
									<span class="input-group-addon">컬러셋</span>
									<select id="colorset-style" name="<?php echo ($is_demo) ? 'pvc' : 'colorset';?>" class="form-control input-sm">
										<?php //Colorset
											$srow = thema_switcher('thema', 'colorset', COLORSET);
											for($i=0; $i < count($srow); $i++) {
										?>
											 <option value="<?php echo $srow[$i]['value'];?>"<?php echo ($srow[$i]['selected']) ? ' selected' : '';?>>
												<?php echo $srow[$i]['name'];?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="text-muted ko-11 input-bottom">
									테마 내 /colorset 폴더
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">스타일</span>
									<select id="layout-style" name="at_set[layout]" class="form-control">
										<option value="">와이드형</option>
										<option value="boxed"<?php echo get_selected('boxed', $at_set['layout']);?>>박스형</option>
									</select>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">반응형</span>
									<select id="pc-style" name="at_set[pc]" class="form-control">
										<option value="">반응형 PC</option>
										<option value="1"<?php echo get_selected('1', $at_set['pc']);?>>비반응형 PC</option>
									</select>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">총너비</span>
									<input type="text" class="form-control input-sm" name="at_set[size]" value="<?php echo $at_set['size'];?>" placeholder="1200">
									<span class="input-group-addon">px</span>
								</div>

								<div class="text-muted ko-11 input-line">
									배경은 박스형 레이아웃에서 출력
								</div>

								<div class="row row-10 input-bottom">
									<div class="col-xs-8 col-10">
										<input type="hidden" id="input-body-background" name="at_set[background]" value="<?php echo $at_set['background'];?>">
										<a role="button" class="switcher-win btn btn-black btn-sm btn-block" target="_balnk" href="<?php echo $at_href['switcher'];?>&amp;type=html&amp;fid=input-body-background&amp;cid=body-background">
											<i class="fa fa-picture-o"></i> 배경이미지
										</a>
									</div>
									<div class="col-xs-4 col-10">
										<input type="text" class="body-bgcolor" name="at_set[bgcolor]" value="<?php echo $at_set['bgcolor'];?>">
									</div>
								</div>
	
								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">스타일</span>
									<select id="back-style" name="at_set[bg]" class="form-control input-sm">
										<option value="center"<?php echo get_selected('center', $at_set['bg']);?>>중앙맞춤</option>
										<option value="top"<?php echo get_selected('top', $at_set['bg']);?>>상단맞춤</option>
										<option value="bottom"<?php echo get_selected('bottom', $at_set['bg']);?>>하단맞춤</option>
										<option value="fixed"<?php echo get_selected('fixed', $at_set['bg']);?>>상단고정</option>
										<option value="pattern"<?php echo get_selected('pattern', $at_set['bg']);?>>패턴배경</option>
									</select>
								</div>

								<label>
									<input type="checkbox" id="font-style" name="at_set[font]" value="en"<?php echo get_checked('en', $at_set['font']);?>>
									영문폰트 적용
								</label>

							</div>
						</div>
					</div>

					<div class="panel">
						<div class="panel-heading" role="tab" id="swHead<?php $toggle++; echo $toggle;?>" aria-expanded="true" aria-controls="swSet<?php echo $toggle;?>">
							<a data-toggle="collapse" data-parent="#switcherSet" href="#swSet<?php echo $toggle;?>">
								<i class="fa fa-caret-right"></i> 메뉴바 설정
							</a>
						</div>
						<div id="swSet<?php echo $toggle;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="swHead<?php echo $toggle;?>">
							<div class="panel-body">

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">메뉴타입</span>
									<select id="nav-style" name="at_set[nav]" class="form-control">
										<option value="both">배분</option>
										<option value="float"<?php echo get_selected('float', $at_set['nav']);?>>좌측</option>
									</select>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">서브보임</span>
									<select name="at_set[subv]" class="form-control">
										<option value="slide">슬라이더</option>
										<option value="show"<?php echo get_selected('show', $at_set['subv']);?>>보이기</option>
										<option value="fade"<?php echo get_selected('fade', $at_set['subv']);?>>페이드</option>
									</select>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">서브숨김</span>
									<select name="at_set[subh]" class="form-control">
										<option value=""<?php echo get_selected('hide', $at_set['subh']);?>>숨기기</option>
										<option value="fade"<?php echo get_selected('fade', $at_set['subh']);?>>페이드</option>
										<option value="slide"<?php echo get_selected('slide', $at_set['subh']);?>>슬라이드</option>
									</select>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">서브너비</span>
									<input type="text" class="form-control input-sm" name="at_set[subw]" value="<?php echo $at_set['subw'];?>" placeholder="170">
									<span class="input-group-addon">px</span>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">메뉴높이</span>
									<input type="text" class="form-control input-sm" name="at_set[mh]" value="<?php echo $at_set['mh'];?>" placeholder="44">
									<span class="input-group-addon">px</span>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">메뉴간격</span>
									<input type="text" class="form-control input-sm" name="at_set[ms]" value="<?php echo $at_set['ms'];?>" placeholder="25">
									<span class="input-group-addon">px</span>
								</div>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">전체가로</span>
									<input type="text" class="form-control input-sm" name="at_set[allm]" value="<?php echo $at_set['allm'];?>" placeholder="7">
									<span class="input-group-addon">개</span>
								</div>

								<label>
									<input type="checkbox" id="sticky-style" name="at_set[sticky]" value="1"<?php echo get_checked('1', $at_set['sticky']);?>>
									메뉴바 상단고정(sticky)
								</label>

							</div>
						</div>
					</div>

					<div class="panel">
						<div class="panel-heading" role="tab" id="swHead<?php $toggle++; echo $toggle;?>" aria-expanded="true" aria-controls="swSet<?php echo $toggle;?>">
							<a data-toggle="collapse" data-parent="#switcherSet" href="#swSet<?php echo $toggle;?>">
								<i class="fa fa-caret-right"></i> 인덱스 설정
							</a>
						</div>
						<div id="swSet<?php echo $toggle;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="swHead<?php echo $toggle;?>">
							<div class="panel-body">
								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">파일</span>
									<select name="at_set[mfile]" class="form-control input-sm">
										<?php for ($i=0; $i<count($tmain); $i++) { ?>
											<option value="<?php echo $tmain[$i];?>"<?php echo get_selected($at_set['mfile'], $tmain[$i]);?>><?php echo $tmain[$i];?></option>
										<?php } ?>
									</select>
								</div>

								<div class="text-muted ko-11">
									테마 내 /main 폴더 파일
								</div>

							</div>
						</div>
					</div>

					<div class="panel">
						<div class="panel-heading" role="tab" id="swHead<?php $toggle++; echo $toggle;?>" aria-expanded="true" aria-controls="swSet<?php echo $toggle;?>">
							<a data-toggle="collapse" data-parent="#switcherSet" href="#swSet<?php echo $toggle;?>">
								<i class="fa fa-caret-right"></i> 페이지 설정
							</a>
						</div>
						<div id="swSet<?php echo $toggle;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="swHead<?php echo $toggle;?>">
							<div class="panel-body">

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">칼럼</span>
									<select id="page-style" name="at_set[page]" class="form-control input-sm">
										<option value="9">2단 - 라지</option>
										<option value="8"<?php echo get_selected('8', $at_set['page']);?>>2단 - 미디엄</option>
										<option value="7"<?php echo get_selected('7', $at_set['page']);?>>2단 - 스몰</option>
										<option value="12"<?php echo get_selected('12', $at_set['page']);?>>1단 - 박스형</option>
										<option value="13"<?php echo get_selected('13', $at_set['page']);?>>1단 - 와이드</option>
									</select>
								</div>				

								<label style="margin-top:8px;">
									<i class="fa fa-caret-right"></i>
									<b>사이드</b> <span class="text-muted ko-11">테마 내 /side 폴더 파일</span>
								</label>

								<div class="input-group input-group-sm input-bottom">
									<span class="input-group-addon">파일</span>
									<select name="at_set[sfile]" class="form-control input-sm">
										<?php for ($i=0; $i<count($tside); $i++) { ?>
											<option value="<?php echo $tside[$i];?>"<?php echo get_selected($at_set['sfile'], $tside[$i]);?>><?php echo $tside[$i];?></option>
										<?php } ?>
									</select>
								</div>

								<label>
									<input type="checkbox" id="side-style" name="at_set[side]" value="1"<?php echo get_checked('1', $at_set['side']);?>>
									좌측 사이드 사용
								</label>

							</div>
						</div>
					</div>

				</div>

				<button type="submit" class="btn btn-color btn-sm btn-block">
					<i class="fa fa-check"></i> <?php echo ($is_demo) ? '데모적용' : '저장하기';?>
				</button>
				<?php if($is_demo) { ?>
					<div class="h10"></div>
					<label><input type="checkbox" name="reset" value="1"> 데모설정 초기화</label>
				<?php } ?>
				</form>
			</div>
			<script>
				function switcher_submit(f) {
					<?php if(!$is_demo) { ?>
					if (!confirm("<?php echo $sw_msg;?>의 설정으로 저장하시겠습니까?")) {
						return false;
					}
					<?php } ?>
					return true;
				}
				$(document).ready(function($) {
					//Background Color Change
					$(".body-bgcolor").spectrum({
						<?php if($at_set['bgcolor']) { ?>
							color: "<?php echo $at_set['bgcolor'];?>",
						<?php } ?>
						allowEmpty: true,
						clickoutFiresChange: true,
						showButtons: false,
						preferredFormat: "hex6",
						showInput: true,
						move: switcher_bgcolor
					});
				});
			</script>
		</div>
	</section>
</aside>

