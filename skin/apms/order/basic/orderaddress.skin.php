<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['ahead']) && $wset['ahead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['ahead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['acolor']) && $wset['acolor']) ? 'tr-head border-'.$wset['acolor'] : 'tr-head border-black';
}

?>

<form class="form" role="form" name="forderaddress" method="post" action="<?php echo $action_url; ?>" autocomplete="off">
<div id="sod_addr">
	<div class="table-responsive">
		<table class="div-table table">
		<tbody>
		<tr class="<?php echo $head_class;?>">
            <th scope="col">
                <label for="chk_all" class="sound_only">전체선택</label>
                <span><input type="checkbox" name="chk_all" id="chk_all"></span>
            </th>
            <th scope="col"><span>배송지명</span></th>
            <th scope="col"><span>기본</span></th>
            <th scope="col"><span>이름</span></th>
            <th scope="col"><span>전화번호</span></th>
            <th scope="col"><span>주소</span></th>
            <th scope="col"><span class="last">관리</span></th>
        </tr>
        <?php for($i=0; $i < count($list); $i++) { ?>
			<tr<?php echo ($i == 0) ? ' class="tr-line"' : '';?>>
				<td class="text-center">
					<input type="hidden" name="ad_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['ad_id'];?>">
					<label for="chk_<?php echo $i;?>" class="sound_only">배송지선택</label>
					<input type="checkbox" name="chk[]" value="<?php echo $i;?>" id="chk_<?php echo $i;?>">
				</td>
				<td class="text-center">
					<label for="ad_subject<?php echo $i;?>" class="sound_only">배송지명</label>
					<input type="text" name="ad_subject[<?php echo $i; ?>]" id="ad_subject<?php echo $i;?>" class="form-control input-sm" size="12" maxlength="20" value="<?php echo $list[$i]['ad_subject']; ?>">
				</td>
				<td class="text-center">
					<label for="ad_default<?php echo $i;?>" class="sound_only">기본배송지</label>
					<input type="radio" name="ad_default" value="<?php echo $list[$i]['ad_id'];?>" id="ad_default<?php echo $i;?>" <?php if($list[$i]['ad_default']) echo 'checked="checked"';?>>
				</td>
				<td class="text-center"><?php echo $list[$i]['ad_name']; ?></td>
				<td class="text-center"><?php echo $list[$i]['ad_tel']; ?><br><?php echo $list[$i]['ad_hp']; ?></td>
				<td><?php echo $list[$i]['print_addr']; ?></td>
				<td class="text-center">
					<input type="hidden" value="<?php echo $list[$i]['addr']; ?>">
					<button type="button" class="sel_address btn btn-color btn-xs" title="선택"><i class="fa fa-check fa-lg"></i><span class="sound_only">선택</span></button>
					<a href="<?php echo $list[$i]['del_href']; ?>" class="del_address btn btn-black btn-xs" title="삭제"><i class="fa fa-times fa-lg"></i><span class="sound_only">삭제</span></a>
				</td>
			</tr>
        <?php } ?>
        </tbody>
        </table>
    </div>

	<div style="margin:0px 20px 20px;">
		<div class="pull-left">
			<input type="submit" name="act_button" value="선택수정" id="btn_submit" class="btn btn-color btn-sm">
			<button type="button" onclick="self.close();" class="btn btn-black btn-sm">닫기</button>
		</div>

		<?php if($total_count > 0) { ?>
			<div class="pull-right">
				<ul class="pagination pagination-sm" style="margin-top:0; padding-top:0;">
					<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
				</ul>
			</div>
		<?php } ?>

		<div class="clearfix"></div>
	</div>
</div>
</form>

<script>
$(function() {
    $(".sel_address").on("click", function() {
        var addr = $(this).siblings("input").val().split(String.fromCharCode(30));

        var f = window.opener.forderform;
        f.od_b_name.value        = addr[0];
        f.od_b_tel.value         = addr[1];
        f.od_b_hp.value          = addr[2];
        f.od_b_zip.value         = addr[3] + addr[4];
        f.od_b_addr1.value       = addr[5];
        f.od_b_addr2.value       = addr[6];
        f.od_b_addr3.value       = addr[7];
        f.od_b_addr_jibeon.value = addr[8];
        f.ad_subject.value       = addr[9];

        var zip1 = addr[3].replace(/[^0-9]/g, "");
        var zip2 = addr[4].replace(/[^0-9]/g, "");

        if(zip1 != "" && zip2 != "") {
            var code = String(zip1) + String(zip2);

            if(window.opener.zipcode != code) {
                window.opener.zipcode = code;
                window.opener.calculate_sendcost(code);
            }
        }

        window.close();
    });

    $(".del_address").on("click", function() {
        return confirm("배송지 목록을 삭제하시겠습니까?");
    });

    // 전체선택 부분
    $("#chk_all").on("click", function() {
        if($(this).is(":checked")) {
            $("input[name^='chk[']").attr("checked", true);
        } else {
            $("input[name^='chk[']").attr("checked", false);
        }
    });

    $("#btn_submit").on("click", function() {
        if($("input[name^='chk[']:checked").length==0 ){
            alert("수정하실 항목을 하나 이상 선택하세요.");
            return false;
        }
    });

});
</script>
