<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<form name="fwishlist" method="post" action="./cartupdate.php">
<input type="hidden" name="act"       value="multi">
<input type="hidden" name="sw_direct" value="">
<input type="hidden" name="prog"      value="wish">

<div class="wishlist-skin">
	<table class="div-table table bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col" width="60">선택</th>
		<th class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">상품명</th>
		<th class="text-center" scope="col">보관일시</th>
		<th class="text-center" scope="col">삭제</th>
	</tr>
	<?php 
	for($i=0; $i < count($list);$i++) { 
		$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	
	?>
		<tr>
			<td class="text-center">
				<?php if($list[$i]['is_soldout']) { // 품절검사 ?>
					품절
				<?php } else { //품절이 아니면 체크할수 있도록한다 ?>
					<label for="chk_it_id_<?php echo $i; ?>" class="sound_only"><?php echo $list[$i]['it_name']; ?></label>
					<input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $list[$i]['out_cd']; ?>');">
				<?php } ?>
				<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['it_id']; ?>">
				<input type="hidden" name="io_type[<?php echo $list[$i]['it_id']; ?>][0]" value="0">
				<input type="hidden" name="io_id[<?php echo $list[$i]['it_id']; ?>][0]" value="">
				<input type="hidden" name="io_value[<?php echo $list[$i]['it_id']; ?>][0]" value="<?php echo $list[$i]['it_name']; ?>">
				<input type="hidden" name="ct_qty[<?php echo $list[$i]['it_id']; ?>][0]" value="1">
			</td>
			<td class="text-center">
				<a href="./item.php?it_id=<?php echo $list[$i]['it_id']; ?>">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>
				</a>
			</td>
			<td><a href="./item.php?it_id=<?php echo $list[$i]['it_id']; ?>"><?php echo stripslashes($list[$i]['it_name']); ?></a></td>
			<td class="text-center"><?php echo $list[$i]['wi_time']; ?></td>
			<td class="text-center"><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $list[$i]['wi_id']; ?>">삭제</a></td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="5" class="text-center text-muted" height="150">보관함이 비었습니다.</td></tr>
	<?php } ?>
	</tr>
	</tbody>
	</table>
</div>

<p class="text-center">
	<button type="submit" class="btn btn-black btn-sm" onclick="return fwishlist_check(document.fwishlist,'');">장바구니 담기</button>
	<button type="submit" class="btn btn-color btn-sm" onclick="return fwishlist_check(document.fwishlist,'direct_buy');">주문하기</button>
</p>
</form>

<br>

<script>
    function out_cd_check(fld, out_cd) {
        if (out_cd == 'no'){
            alert("옵션이 있습니다.\n\n클릭하여 상세내용페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel'){
            alert("전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    function fwishlist_check(f, act) {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0) {
            alert("하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy") {
            f.sw_direct.value = 1;
        } else {
            f.sw_direct.value = 0;
        }

        return true;
    }
</script>
