<div style="position: relative;padding-top:20px;height: 293px; 
        background-image:url(/img/coco/background.svg);
        background-size: cover;
        background-position-y: -70px;
    ">
    <div style="text-align: center;">
        <img src="/img/coco/search.main.png" alt="Search Bar" width="200px" height="200px"/>
    </div>
    <div style="position: relative;bottom: 32px;text-align:center;">
        <div class="input-group input-group-sm" style="background-color: white;text-align:center;width:340px;margin: 0 auto;">
            <form name="tsearch" method="get" action="shop/search.php" role="form" style="min-height: 30px;">
                <img src="/img/coco/search.png" style="position: absolute;width: 18px;height: 18px;z-index: 10;top: 5px;left: 10px;">
                    <input type="text" name="stx" class="" value="" style="position: relative; top: 3px;border: solid 2.3px white; width:96%; height: 20px;">
            </form>
        </div>
    </div>
</div>

<div style="position: relative;background-color: #e8e8e8;">
    <div style="text-align: center;">
        <span style="color:#4a4a4a;">#오늘의</span> <span style="color: #7283bb">코디</span>
    </div>
    
    <ul style="display: flex; list-style: none; flex-direction: colum; justify-content: space-between; padding-left: 0px; align-items: flex-end;">
        <li class="sub-card">
        </li>
        <li class="main-card">
        </li>
        <li class="sub-card">
        </li>
    </ul>

</div>


<script>
    $('body').attr("style", "background-color:#e8e8e8");
    $('.responsive .at-body .at-container').attr("style", "padding: 0px !important;");
</script>