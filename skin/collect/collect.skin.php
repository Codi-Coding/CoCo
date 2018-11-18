<div style="background-color: #546193; min-height: 126px; padding-top: 10px;">
    <div class="coco-content">
        <span style="color:white;">카테고리</span>
        <div class="coco-side-scroll">
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1020">
                <div class="img">
                    <img src="/img/coco/cate1.png">
                </div>
                <div class="caption">반팔</div>
                </a>
            </span>
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1020">
                <div class="img">
                    <img src="/img/coco/cate5.png">
                </div>
                <div class="caption">긴팔</div>
                </a>
            </span>
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1010">
                <div class="img">
                    <img src="/img/coco/cate2.png">
                </div>
                <div class="caption">셔츠</div>
                </a>
            </span>
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1010">
                <div class="img">
                    <img src="/img/coco/cate2.png">
                </div>
                <div class="caption">바지</div>
                </a>
            </span>
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1020">
                <div class="img">
                    <img src="/img/coco/cate3.png">
                </div>
                <div class="caption">치마</div>
                </a>
            </span>
            <span class="coco-cate">
                <a href="/shop/list.php?ca_id=1020">
                <div class="img">
                    <img src="/img/coco/cate4.png">
                </div>
                <div class="caption">원피스</div>
                </a>
            </span>
            
        </div>
    </div>
</div>

<div class="thick-line"></div>

<div style="padding-top: 10px; margin: 0px 10px;">
    쇼핑몰
    <div style="display: flex; flex-wrap: wrap;">
        <?php 
            while($row = sql_fetch_array($result)){
        ?>  <div class="coco-shop">
                <a href="shop/myshop.php?id=<?php echo($row['pt_id']);?>"><?php echo($row['pt_id']);?></a>
            </div>
           
        <?php
            }
        ?>
    </div>
</div>




<!-- <div class="row">
    <div class="col-xs-3">
        <a class="circle-btn" href="/shop/list.php?ca_id=1020">남성 상의</a>
    </div>
    <div class="col-xs-3">
        <a class="circle-btn" href="/shop/list.php?ca_id=1010">남성 하의</a>
    </div>
    <div class="col-xs-3">
        <a class="circle-btn" href="shop/list.php?ca_id=20">여성 상의</a>
    </div>
    <div class="col-xs-3">
        <a class="circle-btn" href="shop/list.php?ca_id=20">여성 하의</a>
    </div>
</div> -->



<script>
var cssstring = `
    padding: 0px !important;
  `;

    $('#coco-main .at-container').attr("style", cssstring);
</script>