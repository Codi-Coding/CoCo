<?php
if (!defined('G5_USE_CONTENTS') || !G5_USE_CONTENTS) return;

$menu['menu600'] = array (
    array('600000', '컨텐츠몰관리', G5_ADMIN_URL.'/contents_admin/', 'contents_config'),
    array('600100', '컨텐츠몰설정', G5_ADMIN_URL.'/contents_admin/configform.php', 'ccf_config'),
    array('600200', '주문내역', G5_ADMIN_URL.'/contents_admin/orderlist.php', 'ccf_order', 1),
    array('600250', '캐시충전내역', G5_ADMIN_URL.'/contents_admin/cashlist.php', 'ccf_cash', 1),
    array('600260', '캐시사용내역', G5_ADMIN_URL.'/contents_admin/cashhistory.php', 'ccf_cash_history', 1),
    array('600300', '분류관리', G5_ADMIN_URL.'/contents_admin/categorylist.php', 'ccf_cate'),
    array('600400', '상품관리', G5_ADMIN_URL.'/contents_admin/itemlist.php', 'ccf_item'),
    array('600410', '상품문의', G5_ADMIN_URL.'/contents_admin/itemqalist.php', 'ccf_item_qna'),
    array('600420', '상품사용후기', G5_ADMIN_URL.'/contents_admin/itemuselist.php', 'ccf_item_use'),
    array('600430', '상품유형관리', G5_ADMIN_URL.'/contents_admin/itemtypelist.php', 'ccf_item_type'),
    array('600500', '쿠폰관리', G5_ADMIN_URL.'/contents_admin/couponlist.php', 'ccf_coupon', 1),
    array('600600', '매출현황', G5_ADMIN_URL.'/contents_admin/sale1.php', 'ccf_sale'),
    array('600610', '판매순위', G5_ADMIN_URL.'/contents_admin/itemsellrank.php', 'ccf_sellrank'),
    array('600620', '이벤트관리', G5_ADMIN_URL.'/contents_admin/itemevent.php', 'ccf_event', 1),
    array('600630', '이벤트일괄처리', G5_ADMIN_URL.'/contents_admin/itemeventlist.php', 'ccf_event2', 1),
    array('600700', '배너관리', G5_ADMIN_URL.'/contents_admin/bannerlist.php', 'ccf_banner'),
    array('600800', '보관함현황', G5_ADMIN_URL.'/contents_admin/wishlist.php', 'ccf_wish')
);
?>