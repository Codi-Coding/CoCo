<?php
$sub_menu = "300900";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$token = get_token();

if(!sql_query(" DESCRIBE {$g5['opage_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['opage_table']}` (
                  `op_id` varchar(20) NOT NULL DEFAULT '',
                  `gr_id` varchar(255) NOT NULL DEFAULT '',
                  `subject` varchar(255) NOT NULL DEFAULT '',
                  `mobile_subject` varchar(255) NOT NULL DEFAULT '',
                  `read_level` tinyint(4) NOT NULL DEFAULT '0',
                  `content_include` varchar(255) NOT NULL DEFAULT '',
                  `mobile_content_include` varchar(255) NOT NULL DEFAULT '',
                  `include_head` varchar(255) NOT NULL DEFAULT '',
                  `include_tail` varchar(255) NOT NULL DEFAULT '',
                  PRIMARY KEY (`op_id`)
                  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);

}

$g5['title'] = "외부페이지관리";
include_once('./admin.head.php');

$sql_common = " from {$g5['opage_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by op_id limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
    <span>전체 내용 <?php echo $total_count; ?>건</span>
</div>

<div class="btn_add01 btn_add">
    <a href="./opage_form.php">외부페이지 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">제목</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_id"><?php echo $row['op_id']; ?></td>
        <td><?php echo htmlspecialchars2($row['subject']); ?></td>
        <td class="td_mng">
            <a href="./opage_form.php?w=u&amp;op_id=<?php echo $row['op_id']; ?>"><span class="sound_only"><?php echo htmlspecialchars2($row['subject']); ?> </span>수정</a>
            <a href="<?php echo G5_BBS_URL; ?>/opage.php?op_id=<?php echo $row['op_id']; ?>"><span class="sound_only"><?php echo htmlspecialchars2($row['subject']); ?> </span> 보기</a>
            <a href="./opage_form_update.php?w=d&amp;op_id=<?php echo $row['op_id']; ?>" onclick="return delete_confirm();"><span class="sound_only"><?php echo htmlspecialchars2($row['subject']); ?> </span>삭제</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="3" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once('./admin.tail.php');
?>
