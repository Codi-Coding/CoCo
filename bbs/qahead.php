<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) { /// qaconfig가 config에 포함될 때까지
    if(!(defined('G5_IS_ADMIN') && G5_IS_ADMIN)) {
        $qaconfig['qa_skin'] = $config['cf_qa_skin'];
        $qaconfig['qa_mobile_skin'] = $config['cf_mobile_qa_skin']; /// qa_mobile_skin 명칭 혼동, 유의
    }
}

$qa_skin_path = get_skin_path('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
$qa_skin_url  = get_skin_url('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));

if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once('./_head.php');
    echo conv_content($qaconfig['qa_mobile_content_head'], 1);
} else {
    if($qaconfig['qa_include_head'] && is_include_path_check($qaconfig['qa_include_head']))
        @include ($qaconfig['qa_include_head']);
    else
        include ('./_head.php');
    echo conv_content($qaconfig['qa_content_head'], 1);
}
?>
