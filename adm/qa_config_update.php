<?php
$sub_menu = "300500";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$error_msg = '';

if( $qa_include_head ){
    $purl = parse_url($qa_include_head);
    $file = $purl['path'];
    if (!preg_match("/\.(php|htm['l']?)$/i", $file)) {
        alert('��� ���� ����� Ȯ���ڴ� php, html �� ����մϴ�.');
    }
}

if( $qa_include_tail ){
    $purl = parse_url($qa_include_tail);
    $file = $purl['path'];
    if (!preg_match("/\.(php|htm['l']?)$/i", $file)) {
        alert('�ϴ� ���� ����� Ȯ���ڴ� php, html �� ����մϴ�.');
    }
}

if( $qa_include_head && ! is_include_path_check($qa_include_head, 1) ){
    $qa_include_head = '';
    $error_msg = '/data/file/ �Ǵ� /data/editor/ ���Ե� ���ڸ� ��� ���� ��ο� ���Խ�ų�� �����ϴ�.';
}

if( $qa_include_tail && ! is_include_path_check($qa_include_tail, 1) ){
    $qa_include_tail = '';
    $error_msg = '/data/file/ �Ǵ� /data/editor/ ���Ե� ���ڸ� �ϴ� ���� ��ο� ���Խ�ų�� �����ϴ�.';
}

$sql = " update {$g5['qa_config_table']}
            set qa_title                = '{$_POST['qa_title']}',
                qa_category             = '{$_POST['qa_category']}',
                qa_skin                 = '{$_POST['qa_skin']}',
                qa_mobile_skin          = '{$_POST['qa_mobile_skin']}',
                qa_use_email            = '{$_POST['qa_use_email']}',
                qa_req_email            = '{$_POST['qa_req_email']}',
                qa_use_hp               = '{$_POST['qa_use_hp']}',
                qa_req_hp               = '{$_POST['qa_req_hp']}',
                qa_use_sms              = '{$_POST['qa_use_sms']}',
                qa_send_number          = '{$_POST['qa_send_number']}',
                qa_admin_hp             = '{$_POST['qa_admin_hp']}',
                qa_admin_email          = '{$_POST['qa_admin_email']}',
                qa_use_editor           = '{$_POST['qa_use_editor']}',
                qa_subject_len          = '{$_POST['qa_subject_len']}',
                qa_mobile_subject_len   = '{$_POST['qa_mobile_subject_len']}',
                qa_page_rows            = '{$_POST['qa_page_rows']}',
                qa_mobile_page_rows     = '{$_POST['qa_mobile_page_rows']}',
                qa_image_width          = '{$_POST['qa_image_width']}',
                qa_upload_size          = '{$_POST['qa_upload_size']}',
                qa_insert_content       = '{$_POST['qa_insert_content']}',
                qa_include_head         = '{$qa_include_head}',
                qa_include_tail         = '{$qa_include_tail}',
                qa_content_head         = '{$_POST['qa_content_head']}',
                qa_content_tail         = '{$_POST['qa_content_tail']}',
                qa_mobile_content_head  = '{$_POST['qa_mobile_content_head']}',
                qa_mobile_content_tail  = '{$_POST['qa_mobile_content_tail']}',
                qa_1_subj               = '{$_POST['qa_1_subj']}',
                qa_2_subj               = '{$_POST['qa_2_subj']}',
                qa_3_subj               = '{$_POST['qa_3_subj']}',
                qa_4_subj               = '{$_POST['qa_4_subj']}',
                qa_5_subj               = '{$_POST['qa_5_subj']}',
                qa_1                    = '{$_POST['qa_1']}',
                qa_2                    = '{$_POST['qa_2']}',
                qa_3                    = '{$_POST['qa_3']}',
                qa_4                    = '{$_POST['qa_4']}',
                qa_5                    = '{$_POST['qa_5']}',
                as_admin                = '{$_POST['as_admin']}',
                as_editor               = '{$_POST['as_editor']}',
                as_mobile_editor        = '{$_POST['as_mobile_editor']}' ";
sql_query($sql);

if($error_msg){
    alert($error_msg, './qa_config.php');
} else {
    goto_url('./qa_config.php');
}
?>