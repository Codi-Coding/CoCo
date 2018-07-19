<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="tbox-head">
	<span class="red">01.</span> 반품기한
</div>
<div class="tbox-body">
	<ul>
		<li>단순 변심인 경우 : <span class="blue"><b>상품 수령 후 7일 이내</b></span> 신청</li>
		<li>상품 불량/오배송인 경우 : 상품 수령 후 3개월 이내, 혹은 그 사실을 알게 된 이후 30일 이내 반품 신청 가능</li>
	</ul>
</div>

<div class="tbox-head no-line">
	<span class="red">02.</span> 반품 배송비
</div>
<div class="tbox-body">
	<table class="table">
	<caption>반품 배송비</caption>
	<thead>
	<tr>
		<th>반품사유</th>
		<th>반품 배송비 부담자</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<th>단순변심</th>
		<td>
			고객 부담이며, 최초 배송비를 포함해 왕복 배송비가 발생합니다. 
			또한, 도서/산간지역이거나 설치 상품을 반품하는 경우에는 배송비가 추가될 수 있습니다.
		</td>
	</tr>
	<tr>
		<th><nobr>상품의 불량 또는 오배송</nobr></th>
		<td>
			고객 부담이 아닙니다.
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="tbox-head no-line">
	<span class="red">03.</span> 배송상태에 따른 환불안내
</div>
<div class="tbox-body">
	<table class="table">
	<caption>환불안내</caption>
	<tbody>
	<tr>
		<th>진행 상태</th>
		<td>결제완료</td>
		<td>상품준비중</td>
		<td>배송지시/배송중/배송완료</td>
	</tr>
	<tr>
		<th>어떤 상태</th>
		<td>주문 내역 확인 전</td>
		<td>상품 발송 준비 중</td>
		<td>상품이 택배사로 이미 발송 됨</td>
	</tr>
	<tr>
		<th>환불</th>
		<td>즉시환불</td>
		<td>구매취소 의사전달 → 발송중지 → 환불</td>
		<td>반품회수 → 반품상품 확인 → 환불</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="tbox-head">
	<span class="red">04.</span> 취소방법
</div>
<div class="tbox-body">
	<ul>
		<li>결제완료 또는 배송상품은 <a href="<?php echo $at_href['secret'];?>"><b>1:1 문의</b></a>에 취소신청해 주셔야 합니다.</li>
		<li>특정 상품의 경우 취소 수수료가 부과될 수 있습니다.</li>
	</ul>
</div>

<div class="tbox-head no-line">
	<span class="red">05.</span> 환불시점
</div>
<div class="tbox-body">
	<table class="table">
	<caption>환불시점</caption>
	<thead>
	<tr>
		<th>결제수단</th>
		<th>환불시점</th>
		<th>환불방법</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<th>신용카드</th>
		<td>취소완료 후, 3~5일 내 카드사 승인취소(영업일 기준)</td>
		<td>신용카드 승인취소</td>
	</tr>
	<tr>
		<th>계좌이체</th>
		<td>
			실시간 계좌이체 또는 무통장입금<br>
			취소완료 후, 입력하신 환불계좌로 1~2일 내 환불금액 입금(영업일 기준)
		</td>
		<td>계좌입금</td>
	</tr>
	<tr>
		<th>휴대폰 결제</th>
		<td>
			당일 구매내역 취소시 취소 완료 후, 6시간 이내 승인취소<br>
			전월 구매내역 취소시 취소 완료 후, 1~2일 내 환불계좌로 입금(영업일 기준)
		</td>
		<td>
			당일취소 : 휴대폰 결제 승인취소<br>
			익월취소 : 계좌입금
		</td>
	</tr>
	<tr>
		<th>포인트</th>
		<td>
			취소 완료 후, 당일 포인트 적립
		</td>
		<td>
			환불 포인트 적립
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="tbox-head">
	<span class="red">06.</span> 취소반품 불가 사유
</div>
<div class="tbox-body">
	<ul>
		<li>단순변심으로 인한 반품 시, 배송 완료 후 7일이 지나면 취소/반품 신청이 접수되지 않습니다.</li>
		<li>주문/제작 상품의 경우, 상품의 제작이 이미 진행된 경우에는 취소가 불가합니다.</li>
		<li>구성품을 분실하였거나 취급 부주의로 인한 파손/고장/오염된 경우에는 취소/반품이 제한됩니다.</li>
		<li>제조사의 사정 (신모델 출시 등) 및 부품 가격변동 등에 의해 가격이 변동될 수 있으며, 이로 인한 반품 및 가격보상은 불가합니다. </li>
		<li>뷰티 상품 이용 시 트러블(알러지, 붉은 반점, 가려움, 따가움)이 발생하는 경우 진료 확인서 및 소견서 등을 증빙하면 환불이 가능하지만 이 경우, 제반 비용은 고객님께서 부담하셔야 합니다.</li>
		<li>각 상품별로 아래와 같은 사유로 취소/반품이 제한 될 수 있습니다.</li>
	</ul>

	<br>

	<table class="table">
		<caption>환불불가</caption>
		<thead>
			<tr>
				<th>상품군</th>
				<th>취소/반품 불가사유</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>의류/잡화/수입명품</th>
				<td>상품의 택(TAG) 제거/라벨 및 상품 훼손으로 상품의 가치가 현저히 감소된 경우</td>
			</tr>
			<tr>
				<th>계절상품/식품/화장품</th>
				<td>고객님의 사용, 시간경과, 일부 소비에 의하여 상품의 가치가 현저히 감소한 경우</td>
			</tr>
			<tr>
				<th>가전/설치상품</th>
				<td>전자제품 특성 상, 정품 스티커가 제거되었거나 설치 또는 사용 이후에 단순변심인 경우, 액정화면이 부착된 상품의 전원을 켠 경우 (상품불량으로 인한 교환/반품은 AS센터의 불량 판정을 받아야 합니다.)</td>
			</tr>
			<tr>
				<th>자동차용품</th>
				<td>상품을 개봉하여 장착한 이후 단순변심의 경우</td>
			</tr>
			<tr>
				<th>CD/DVD/GAME/BOOK등</th>
				<td>복제가 가능한 상품의 포장 등을 훼손한 경우</td>
			</tr>
			<tr>
				<th><nobr>내비게이션, OS시리얼이 적힌 PMP</nobr></th>
				<td>상품의 시리얼 넘버 유출로 내장된 소프트웨어의 가치가 감소한 경우</td>
			</tr>
			<tr>
				<th>노트북, 테스크탑 PC 등</th>
				<td>홀로그램 등을 분리, 분실, 훼손하여 상품의 가치가 현저히 감소하여 재판매가 불가할 경우</td>
			</tr>
		</tbody>
	</table>
</div>
