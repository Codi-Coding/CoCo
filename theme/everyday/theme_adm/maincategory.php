<?php
include_once('_common.php');

$g5['title'] = '상단 카테고리설정';
include_once('./head.php');
?>

<form name="fcategory" id="fcategory" method="post" enctype="multipart/form-data" action="./maincategoryupdate.php">
<div class="btn_confirm"><input type="submit" value="저장" class="btn_save"></div>
<div class="con_left basic_cate">
    <div class="con_wr">
        <h2>기본 카테고리</h2>
        <?php include('./category.inc.php'); ?>
    </div>
</div>

<div class="con_right add_cate">
    <div class="con_wr">
        <h2>메인카테고리</h2>
        <p>최대 9개 등록가능합니다</p>
        <ul>
        <?php
        $save_file = G5_DATA_PATH.'/cache/theme/everyday/maincategory.php';
        if(is_file($save_file))
            include($save_file);

        if(!empty($maincategory)) {
            foreach($maincategory as $key=>$val) {
                $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '$key' ";
                $row = sql_fetch($sql);
                if(!$row['ca_id'])
                    continue;
        ?>
            <li>
                <div class="add_cate_info">
                    <input type="hidden" name="ca_id[]" value="<?php echo $key; ?>">
                    <input type="checkbox" name="ca_chk[]" value="1"> <?php echo get_text($row['ca_name']); ?>
                </div>
            </li>
        <?php
            }
        } else {
        ?>
            <li class="empty_li">등록된 카테고리가 없습니다.</li>
        <?php } ?>
        </ul>
        <div class="btn_edit"><button type="button" class="btn_4 cate_del">선택삭제</button></div>
    </div>
</div>
</form>

<script>
$(function(){
    $(document).on("click", ".btn_open", function() {
        $(this).next(".file_add").toggle();
    });

    $(".category_add").on("click", function() {
        var $this   = $(this);
        var ca_id   = $this.data("ca");
        var ca_name = $this.data("name");
        var li_cont = '<li>';
        li_cont += '<div class="add_cate_info"><input type="hidden" name="ca_id[]" value="'+ca_id+'"><input type="checkbox" name="ca_chk[]" value="1"> '+ca_name+'</div>';
        li_cont += '</li>';

        var $ul = $(".add_cate ul");
        var $li = $(".add_cate ul li").not(".empty_li");
        var dup = false;
        var max = 9;

        if($li.size() > 0) {
            if($li.size() >= max) {
                alert("더 이상 카테고리를 추가할 수 없습니다.");
                return false;
            }

            $li.each(function() {
                if($(this).find("input[name='ca_id[]']").val() == ca_id) {
                    dup = true;
                    return false;
                }
            });

            if(dup) {
                alert("이미 추가하신 카테고리입니다.");
                return false;
            }
        }

        if($(".add_cate ul li.empty_li").size() == 1)
            $(".add_cate ul li.empty_li").remove();

        $ul.append(li_cont);
    });

    $(".cate_del").on("click", function() {
        var $li  = $(".add_cate ul li");
        var $chk = $li.find("input[name='ca_chk[]']:checked");

        if($chk.size() < 1) {
            alert("삭제하실 카테고리를 하나 이상 선택해 주십시오.");
            return false;
        }

        $chk.each(function() {
            $(this).closest("li").remove();
        });

        if($(".add_cate ul li").size() == 0) {
            $(".add_cate ul").html('<li class="empty_li">등록된 카테고리가 없습니다.</li>');
        }
    });
});
</script>

<?php
include_once('./tail.php');
?>