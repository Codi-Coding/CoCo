<?php
include_once('./_common.php');

$od_id = isset($od_id) ? preg_replace('/[^A-Za-z0-9\-_]/', '', strip_tags($od_id)) : 0;

if($g5['is_db_trans'] && file_exists($g5['locale_path'].'/include/ml/shop'.'/orderinquiryview.ml.php')) { include_once $g5['locale_path'].'/include/ml/shop'.'/orderinquiryview.ml.php'; return; }

if( isset($_GET['ini_noti']) && !isset($_GET['uid']) ){
    goto_url(G5_SHOP_URL.'/orderinquiry.php');
}

// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

if (!$is_member) {
    if (get_session('ss_orderview_uid') != $_GET['uid'])
        alert(_t("직접 링크로는 주문서 조회가 불가합니다.")."\\n\\n"._t("주문조회 화면을 통하여 조회하시기 바랍니다."), G5_SHOP_URL);
}

$sql = "select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
if($is_member && !$is_admin)
    $sql .= " and mb_id = '{$member['mb_id']}' ";
$od = sql_fetch($sql);
if (!$od['od_id'] || (!$is_member && md5($od['od_id'].$od['od_time'].$od['od_ip']) != get_session('ss_orderview_uid'))) {
    alert(_t("조회하실 주문서가 없습니다."), G5_SHOP_URL);
}

// 결제방법
$settle_case = $od['od_settle_case'];

///goodbuilder
if($settle_case == 'paypal' or $settle_case == 'alipay' or $settle_case == 'anet' or $settle_case == "eximbay") $local_pg = 0;
else $local_pg = 1;

///goodbuilder. pg name
if($local_pg) $pg_name = $settle_case;
else if ($settle_case == 'paypal') $pg_name = "PAYPAL";
else if ($settle_case == 'alipay') $pg_name = "ALIPAY";
else if ($settle_case == 'anet') $pg_name = "Authorize.Net";
else if ($settle_case == 'eximbay') $pg_name = "Eximbay";

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/orderinquiryview.php');
    return;
}

// 테마에 orderinquiryview.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_inquiryview_file = G5_THEME_SHOP_PATH.'/orderinquiryview.php';
    if(is_file($theme_inquiryview_file)) {
        include_once($theme_inquiryview_file);
        return;
        unset($theme_inquiryview_file);
    }
}

$g5['title'] = _t('주문상세내역');
include_once('./_head.php');

// LG 현금영수증 JS
if($od['od_pg'] == 'lg') {
    if($default['de_card_test']) {
    echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    } else {
        echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    }
}
?>

<!-- 주문상세내역 시작 { -->
<div id="sod_fin">

    <div id="sod_fin_no"><?php echo _t('주문번호'); ?> <strong><?php echo $od_id; ?></strong></div>

    <section id="sod_fin_list">
        <h2><?php echo _t('주문하신 상품'); ?></h2>

        <?php
        $st_count1 = $st_count2 = 0;
        $custom_cancel = false;

        $sql = " select it_id, it_name, ct_send_cost, it_sc_type
                    from {$g5['g5_shop_cart_table']}
                    where od_id = '$od_id'
                    group by it_id
                    order by ct_id ";
        $result = sql_query($sql);
        ?>
        <div class="tbl_head02 tbl_wrap">
            <table>
            <thead>
            <tr>
                <th scope="col" rowspan="2"><?php echo _t('이미지'); ?></th>
                <th scope="col" colspan="7" id="th_itname"><?php echo _t('상품명'); ?></th>
            </tr>
            <tr>
                <th scope="col" id="th_itopt"><?php echo _t('옵션명'); ?></th>
                <th scope="col" id="th_itqty"><?php echo _t('수량'); ?></th>
                <th scope="col" id="th_itprice"><?php echo _t('판매가'); ?></th>
                <th scope="col" id="th_itsum"><?php echo _t('소계'); ?></th>
                <th scope="col" id="th_itpt"><?php echo _t('포인트'); ?></th>
                <th scope="col" id="th_itpt"><?php echo _t('배송비'); ?></th>
                <th scope="col" id="th_itst"><?php echo _t('상태'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0; $row=sql_fetch_array($result); $i++) {
                $image = get_it_image($row['it_id'], 70, 70);

                $sql = " select ct_id, it_name, ct_option, ct_qty, ct_price, ct_point, ct_status, io_type, io_price
                            from {$g5['g5_shop_cart_table']}
                            where od_id = '$od_id'
                              and it_id = '{$row['it_id']}'
                            order by io_type asc, ct_id asc ";
                $res = sql_query($sql);
                $rowspan = sql_num_rows($res) + 1;

                // 합계금액 계산
                $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                SUM(ct_qty) as qty
                            from {$g5['g5_shop_cart_table']}
                            where it_id = '{$row['it_id']}'
                              and od_id = '$od_id' ";
                $sum = sql_fetch($sql);

                // 배송비
                switch($row['ct_send_cost'])
                {
                    case 1:
                        $ct_send_cost = _t('착불');
                        break;
                    case 2:
                        $ct_send_cost = _t('무료');
                        break;
                    default:
                        $ct_send_cost = _t('선불');
                        break;
                }

                // 조건부무료
                if($row['it_sc_type'] == 2) {
                    $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

                    if($sendcost == 0)
                        $ct_send_cost = _t('무료');
                }

                for($k=0; $opt=sql_fetch_array($res); $k++) {
                    if($opt['io_type'])
                        $opt_price = $opt['io_price'];
                    else
                        $opt_price = $opt['ct_price'] + $opt['io_price'];

                    $sell_price = $opt_price * $opt['ct_qty'];
                    $point = $opt['ct_point'] * $opt['ct_qty'];

                    if($k == 0) {
            ?>
            <tr>
                <td rowspan="<?php echo $rowspan; ?>" class="td_imgsmall"><?php echo $image; ?></td>
                <td headers="th_itname" colspan="6"><a href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo _t($row['it_name']); ?></a></td>
            </tr>
            <?php } ?>
            <tr>
                <td headers="th_itopt"><?php echo get_text(_t($opt['ct_option'])); ?></td>
                <td headers="th_itqty" class="td_mngsmall"><?php echo number_format($opt['ct_qty']); ?></td>
                <td headers="th_itprice" class="td_numbig"><?php echo number_format(_cc($opt_price), $g5['decimal_point']); ?></td>
                <td headers="th_itsum" class="td_numbig"><?php echo number_format(_cc($sell_price), $g5['decimal_point']); ?></td>
                <td headers="th_itpt" class="td_num"><?php echo number_format($point); ?></td>
                <td headers="th_itpt" class="td_dvr"><?php echo number_format(_cc($ct_send_cost), $g5['decimal_point']); ?></td>
                <td headers="th_itst" class="td_mngsmall"><?php echo _t($opt['ct_status']); ?></td>
            </tr>
            <?php
                    $tot_point       += $point;

                    $st_count1++;
                    if($opt['ct_status'] == '주문')
                        $st_count2++;
                }
            }

            // 주문 상품의 상태가 모두 주문이면 고객 취소 가능
            if($st_count1 > 0 && $st_count1 == $st_count2)
                $custom_cancel = true;
            ?>
            </tbody>
            </table>
        </div>

        <div id="sod_sts_wrap">
            <span class="sound_only"><?php echo _t('상품 상태 설명'); ?></span>
            <button type="button" id="sod_sts_explan_open" class="btn_frmline"><?php echo _t('상태설명보기'); ?></button>
            <div id="sod_sts_explan">
                <dl id="sod_fin_legend">
                    <dt><?php echo _t('주문'); ?></dt>
                    <dd><?php echo _t('주문이 접수되었습니다.'); ?></dd>
                    <dt><?php echo _t('입금'); ?></dt>
                    <dd><?php echo _t('입금(결제)이 완료 되었습니다.'); ?></dd>
                    <dt><?php echo _t('준비'); ?></dt>
                    <dd><?php echo _t('상품 준비 중입니다.'); ?></dd>
                    <dt><?php echo _t('배송'); ?></dt>
                    <dd><?php echo _t('상품 배송 중입니다.'); ?></dd>
                    <dt><?php echo _t('완료'); ?></dt>
                    <dd><?php echo _t('상품 배송이 완료 되었습니다.'); ?></dd>
                </dl>
                <button type="button" id="sod_sts_explan_close" class="btn_frmline"><?php echo _t('상태설명닫기'); ?></button>
            </div>
        </div>

        <?php
        // 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
        $tot_price = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2']
                        - $od['od_cart_coupon'] - $od['od_coupon'] - $od['od_send_coupon']
                        - $od['od_cancel_price'];
        ?>

        <dl id="sod_bsk_tot">
            <dt class="sod_bsk_dvr"><?php echo _t('주문총액'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format(_cc($od['od_cart_price']), $g5['decimal_point']); ?> <?php echo _t('원'); ?></strong></dd>

            <?php if($od['od_cart_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('개별상품 쿠폰할인'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format($od['od_cart_coupon']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <?php if($od['od_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('주문금액 쿠폰할인'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format($od['od_coupon']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_send_cost'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('배송비'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format(_cc($od['od_send_cost']), $g5['decimal_point']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <?php if($od['od_send_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('배송비 쿠폰할인'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format($od['od_send_coupon']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_send_cost2'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('추가배송비'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format(_cc($od['od_send_cost2']), $g5['decimal_point']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_cancel_price'] > 0) { ?>
            <dt class="sod_bsk_dvr"><?php echo _t('취소금액'); ?></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo number_format(_cc($od['od_cancel_price']), $g5['decimal_point']); ?> <?php echo _t('원'); ?></strong></dd>
            <?php } ?>

            <dt class="sod_bsk_cnt"><?php echo _t('총계'); ?></dt>
            <dd class="sod_bsk_cnt"><strong><?php echo number_format(_cc($tot_price), $g5['decimal_point']); ?> <?php echo _t('원'); ?></strong></dd>

            <dt class="sod_bsk_point"><?php echo _t('포인트'); ?></dt>
            <dd class="sod_bsk_point"><strong><?php echo number_format($tot_point); ?> <?php echo _t('점'); ?></strong></dd>
        </dl>
    </section>

    <div id="sod_fin_view">
        <h2><?php echo _t('결제/배송 정보'); ?></h2>
        <?php
        $receipt_price  = $od['od_receipt_price']
                        + $od['od_receipt_point'];
        $cancel_price   = $od['od_cancel_price'];

        $misu = true;
        $misu_price = $tot_price - $receipt_price - $cancel_price;

        if ($misu_price == 0 && ($od['od_cart_price'] > $od['od_cancel_price'])) {
            $wanbul = " ("._t("완불").")";
            $misu = false; // 미수금 없음
        }
        else
        {
            $wanbul = display_price($receipt_price);
        }

        // 결제정보처리
        if($od['od_receipt_price'] > 0)
            $od_receipt_price = display_price($od['od_receipt_price']);
        else
            $od_receipt_price = _t('아직 입금되지 않았거나 입금정보를 입력하지 못하였습니다.');

        $app_no_subj = '';
        $disp_bank = true;
        $disp_receipt = false;
        if($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == 'KAKAOPAY' || is_inicis_order_pay($od['od_settle_case']) ) {
            $app_no_subj = _t('승인번호');
            $app_no = $od['od_app_no'];
            $disp_bank = false;
            $disp_receipt = true;
        } else if($od['od_settle_case'] == '간편결제') {
            $app_no_subj = _t('승인번호');
            $app_no = $od['od_app_no'];
            $disp_bank = false;
            switch($od['od_pg']) {
                case 'lg':
                    $easy_pay_name = 'PAYNOW';
                    break;
                case 'inicis':
                    $easy_pay_name = 'KPAY';
                    break;
                case 'kcp':
                    $easy_pay_name = 'PAYCO';
                    break;
                default:
                    break;
            }
        } else if($od['od_settle_case'] == '휴대폰') {
            $app_no_subj = _t('휴대폰번호');
            $app_no = $od['od_bank_account'];
            $disp_bank = false;
            $disp_receipt = true;
        } else if($od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
            $app_no_subj = _t('거래번호');
            $app_no = $od['od_tno'];
        } else if(!$local_pg) { ///goodbuilder
            $disp_bank = false;
        }
        ?>

        <section id="sod_fin_pay">
            <h3><?php echo _t('결제정보'); ?></h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row"><?php echo _t('주문번호'); ?></th>
                    <td><?php echo $od_id; ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('주문일시'); ?></th>
                    <td><?php echo $od['od_time']; ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('결제방식'); ?></th>
                    <!--<td><?php echo ($easy_pay_name ? $easy_pay_name.'('._t($od['od_settle_case']).')' : _t(check_pay_name_replace($od['od_settle_case'])) ); ?></td>-->
                    <td><?php echo ($easy_pay_name ? $easy_pay_name.'('._t($pg_name).')' : _t($pg_name)); ///goodbuilder ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('결제금액'); ?></th>
                    <td><?php echo $od_receipt_price; ?></td>
                </tr>
                <?php
                if($od['od_receipt_price'] > 0)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('결제일시'); ?></th>
                    <td><?php echo $od['od_receipt_time']; ?></td>
                </tr>
                <?php
                }

                // 승인번호, 휴대폰번호, 거래번호
                if($app_no_subj)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo $app_no_subj; ?></th>
                    <td><?php echo $app_no; ?></td>
                </tr>
                <?php
                }

                // 계좌정보
                if($disp_bank)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('입금자명'); ?></th>
                    <td><?php echo get_text($od['od_deposit_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('입금계좌'); ?></th>
                    <td><?php echo get_text($od['od_bank_account']); ?></td>
                </tr>
                <?php
                }

                if($disp_receipt) {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('영수증'); ?></th>
                    <td>
                        <?php
                        if($od['od_settle_case'] == '휴대폰')
                        {
                            if($od['od_pg'] == 'lg') {
                                require_once G5_SHOP_PATH.'/settle_lg.inc.php';
                                $LGD_TID      = $od['od_tno'];
                                $LGD_MERTKEY  = $config['cf_lg_mert_key'];
                                $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                                $hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
                            } else if($od['od_pg'] == 'inicis') {
                                $hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
                            } else {
                                $hp_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
                            }
                        ?>
                        <a href="javascript:;" onclick="<?php echo $hp_receipt_script; ?>"><?php echo _t('영수증 출력'); ?></a>
                        <?php
                        }

                        if($od['od_settle_case'] == '신용카드' || is_inicis_order_pay($od['od_settle_case']) )
                        {
                            if($od['od_pg'] == 'lg') {
                                require_once G5_SHOP_PATH.'/settle_lg.inc.php';
                                $LGD_TID      = $od['od_tno'];
                                $LGD_MERTKEY  = $config['cf_lg_mert_key'];
                                $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                                $card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
                            } else if($od['od_pg'] == 'inicis') {
                                $card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
                            } else {
                                $card_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
                            }
                        ?>
                        <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>">영수증 출력</a>
                        <?php
                        }

                        if($od['od_settle_case'] == 'KAKAOPAY')
                        {
                            $card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
                        ?>
                        <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>"><?php echo _t('영수증 출력'); ?></a>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
                }

                if ($od['od_receipt_point'] > 0)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('포인트사용'); ?></th>
                    <td><?php echo display_point($od['od_receipt_point']); ?></td>
                </tr>

                <?php
                }

                if ($od['od_refund_price'] > 0)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('환불 금액'); ?></th>
                    <td><?php echo display_price($od['od_refund_price']); ?></td>
                </tr>
                <?php
                }

                // 현금영수증 발급을 사용하는 경우에만
                if ($default['de_taxsave_use']) {
                    // 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
                    if ($misu_price == 0 && $od['od_receipt_price'] && ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '계좌이체' || $od['od_settle_case'] == '가상계좌')) {
                ?>
                <tr>
                    <th scope="row">현금영수증</th>
                    <td>
                    <?php
                    if ($od['od_cash'])
                    {
                        if($od['od_pg'] == 'lg') {
                            require_once G5_SHOP_PATH.'/settle_lg.inc.php';

                            switch($od['od_settle_case']) {
                                case '계좌이체':
                                    $trade_type = 'BANK';
                                    break;
                                case '가상계좌':
                                    $trade_type = 'CAS';
                                    break;
                                default:
                                    $trade_type = 'CR';
                                    break;
                            }
                            $cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
                        } else if($od['od_pg'] == 'inicis') {
                            $cash = unserialize($od['od_cash_info']);
                            $cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
                        } else {
                            require_once G5_SHOP_PATH.'/settle_kcp.inc.php';

                            $cash = unserialize($od['od_cash_info']);
                            $cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
                        }
                    ?>
                        <a href="javascript:;" onclick="<?php echo $cash_receipt_script; ?>" class="btn_frmline"><?php echo _t('현금영수증 확인하기'); ?></a>
                    <?php
                    }
                    else
                    {
                    ?>
                        <a href="javascript:;" onclick="window.open('<?php echo G5_SHOP_URL; ?>/taxsave.php?od_id=<?php echo $od_id; ?>', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');" class="btn_frmline"><?php echo _t('현금영수증을 발급하시려면 클릭하십시오.'); ?></a>
                    <?php } ?>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_orderer">
            <h3><?php echo _t('주문하신 분'); ?></h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row"><?php echo _t('이 름'); ?></th>
                    <td><?php echo get_text($od['od_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('전화번호'); ?></th>
                    <td><?php echo get_text($od['od_tel']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('핸드폰'); ?></th>
                    <td><?php echo get_text($od['od_hp']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('주 소'); ?></th>
                    <td><?php echo get_text(sprintf("(%s%s)", $od['od_zip1'], $od['od_zip2']).' '.print_address($od['od_addr1'], $od['od_addr2'], $od['od_addr3'], $od['od_addr_jibeon'])); ?></td>
                </tr>
                <tr>
                    <th scope="row">E-mail</th>
                    <td><?php echo get_text($od['od_email']); ?></td>
                </tr>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_receiver">
            <h3><?php echo _t('받으시는 분'); ?></h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row"><?php echo _t('이 름'); ?></th>
                    <td><?php echo get_text($od['od_b_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('전화번호'); ?></th>
                    <td><?php echo get_text($od['od_b_tel']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('핸드폰'); ?></th>
                    <td><?php echo get_text($od['od_b_hp']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('주 소'); ?></th>
                    <td><?php echo get_text(sprintf("(%s%s)", $od['od_b_zip1'], $od['od_b_zip2']).' '.print_address($od['od_b_addr1'], $od['od_b_addr2'], $od['od_b_addr3'], $od['od_b_addr_jibeon'])); ?></td>
                </tr>
                <?php
                // 희망배송일을 사용한다면
                if ($default['de_hope_date_use'])
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('희망배송일'); ?></th>
                    <td><?php echo substr($od['od_hope_date'],0,10).' ('.get_yoil($od['od_hope_date']).')' ;?></td>
                </tr>
                <?php }
                if ($od['od_memo'])
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('전하실 말씀'); ?></th>
                    <td><?php echo conv_content($od['od_memo'], 0); ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_dvr">
            <h3><?php echo _t('배송정보'); ?></h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <?php
                if ($od['od_invoice'] && $od['od_delivery_company'])
                {
                ?>
                <tr>
                    <th scope="row"><?php echo _t('배송회사'); ?></th>
                    <td><?php echo $od['od_delivery_company']; ?> <?php echo get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice'], 'dvr_link'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('운송장번호'); ?></th>
                    <td><?php echo $od['od_invoice']; ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo _t('배송일시'); ?></th>
                    <td><?php echo $od['od_invoice_time']; ?></td>
                </tr>
                <?php
                }
                else
                {
                ?>
                <tr>
                    <td class="empty_table"><?php echo _t('아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.'); ?></td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
            </div>
        </section>
    </div>

    <section id="sod_fin_tot">
        <h2><?php echo _t('결제합계'); ?></h2>

        <ul>
            <li>
                <?php echo _t('총 구매액'); ?>
                <strong><?php echo display_price($tot_price); ?></strong>
            </li>
            <?php
            if ($misu_price > 0) {
            echo '<li>';
            echo _t('미결제액').PHP_EOL;
            echo '<strong>'.display_price($misu_price).'</strong>';
            echo '</li>';
            }
            ?>
            <li id="alrdy">
                <?php echo _t('결제액'); ?>
                <strong><?php echo $wanbul; ?></strong>
            </li>
        </ul>
    </section>

    <section id="sod_fin_cancel">
        <h2><?php echo _t('주문취소'); ?></h2>
        <?php
        // 취소한 내역이 없다면
        if ($cancel_price == 0) {
            if ($custom_cancel) {
        ?>
        <?php if ((!$local_pg) && $misu_price > 0) { ///goodbuilder ?>
        <button type="button" onclick="document.getElementById('sod_fin_cancelfrm').style.display='block';" style="float:left;"><?php echo _t('주문 취소하기'); ?></button>
        <?php } else { ?>
        <button type="button" onclick="document.getElementById('sod_fin_cancelfrm').style.display='block';"><?php echo _t('주문 취소하기'); ?></button>
        <?php } ?>

        <div id="sod_fin_cancelfrm">
            <form method="post" action="./orderinquirycancel.php" onsubmit="return fcancel_check(this);">
            <input type="hidden" name="od_id"  value="<?php echo $od['od_id']; ?>">
            <input type="hidden" name="token"  value="<?php echo $token; ?>">

            <label for="cancel_memo"><?php echo _t('취소사유'); ?></label>
            <input type="text" name="cancel_memo" id="cancel_memo" required class="frm_input required" size="40" maxlength="100">
            <input type="submit" value="<?php echo _t('확인'); ?>" class="btn_frmline">

            </form>
        </div>
        <?php
            }
        } else {
        ?>
        <p><?php echo _t('주문 취소, 반품, 품절된 내역이 있습니다.'); ?></p>
        <?php } ?>
    </section>

    <?php if ($od['od_settle_case'] == '가상계좌' && $od['od_misu'] > 0 && $default['de_card_test'] && $is_admin && $od['od_pg'] == 'kcp') {
    preg_match("/\s{1}([^\s]+)\s?/", $od['od_bank_account'], $matchs);
    $deposit_no = trim($matchs[1]);
    ?>
    <p><?php echo _t('관리자가 가상계좌 테스트를 한 경우에만 보입니다.'); ?></p>
    <div class="tbl_frm01 tbl_wrap">
        <form method="post" action="http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti_Proc.jsp" target="_blank">
        <table>
        <caption><?php echo _t('모의입금처리'); ?></caption>
        <colgroup>
            <col class="grid_3">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="col"><label for="e_trade_no"><?php echo _t('KCP 거래번호'); ?></label></th>
            <td><input type="text" name="e_trade_no" value="<?php echo $od['od_tno']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="deposit_no"><?php echo _t('입금계좌'); ?></label></th>
            <td><input type="text" name="deposit_no" value="<?php echo $deposit_no; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="req_name"><?php echo _t('입금자명'); ?></label></th>
            <td><input type="text" name="req_name" value="<?php echo $od['od_deposit_name']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="noti_url"><?php echo _t('입금통보 URL'); ?></label></th>
            <td><input type="text" name="noti_url" value="<?php echo G5_SHOP_URL; ?>/settle_kcp_common.php"></td>
        </tr>
        </tbody>
        </table>
        <div id="sod_fin_test" class="btn_confirm">
            <input type="submit" value="<?php echo _t('입금통보 테스트'); ?>" class="btn_submit">
        </div>
        </form>
    </div>
    <?php } ?>

    <?php
        ///goodbuilder. local pg가 아닌 경우
        if ((!$local_pg) && $misu_price > 0) {
            if(file_exists(G5_SHOP_PATH.'/'.$od['od_settle_case'].'/settle_'.$od['od_settle_case'].'.inc.php'))
                require_once G5_SHOP_PATH.'/'.$od['od_settle_case'].'/settle_'.$od['od_settle_case'].'.inc.php';
            else 
                echo '<center><font color=#ff0000>(* '.$pg_name.' '._t('연동 모듈이 설치되어 있지 않습니다.').')</font></center>';
        }
    ?>

</div>
<!-- } 주문상세내역 끝 -->

<script>
$(function() {
    $("#sod_sts_explan_open").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        if($explan.is(":visible")) {
            $explan.slideUp(200);
            $("#sod_sts_explan_open").text("<?php echo _t('상태설명보기'); ?>");
        } else {
            $explan.slideDown(200);
            $("#sod_sts_explan_open").text("<?php echo _t('상태설명닫기'); ?>");
        }
    });

    $("#sod_sts_explan_close").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        $explan.slideUp(200);
        $("#sod_sts_explan_open").text("<?php echo _t('상태설명보기'); ?>");
    });
});

function fcancel_check(f)
{
    if(!confirm("<?php echo _t('주문을 정말 취소하시겠습니까?'); ?>"))
        return false;

    var memo = f.cancel_memo.value;
    if(memo == "") {
        alert("<?php echo _t('취소사유를 입력해 주십시오.'); ?>");
        return false;
    }

    return true;
}
</script>

<?php
include_once('./_tail.php');
?>
