<!-- <div class="row">
    <div class="col-xs-2">
        <a class="circle-btn" href="/shop/list.php?ca_id=1020">남성 상의</a>
    </div>
    <div class="col-xs-2">
        <a class="circle-btn" href="/shop/list.php?ca_id=1010">남성 하의</a>
    </div>
    <div class="col-xs-2">
        <a class="circle-btn" href="shop/list.php?ca_id=20">여성 상의</a>
    </div>
    <div class="col-xs-2">
        <a class="circle-btn" href="/shop/list.php?ca_id=20">여성 하의</a>
    </div>
    <div class="col-xs-2">
        <a class="circle-btn" href="/shop/list.php?ca_id=1010">남성 상의</a>
    </div>
    <div class="col-xs-2">
        <a class="circle-btn" href="/shop/list.php?ca_id=1010">남성 상의</a>
    </div>
</div> -->

<div class="row">
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
</div>

<hr/>

<?php 
    while($row = sql_fetch_array($result)){
?>
        <a href="shop/myshop.php?id=<?php echo($row['pt_id']);?>"><?php echo($row['pt_id']);?>님의 shop</a>
<?php
    }

?>