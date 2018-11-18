<div style="
        position: relative;
        padding-top: 5px;
        height: 359px;
        background-image:url(/img/coco/background.svg);
        background-size: cover;
        background-position-y: -35px;
    
    ">
    <div style="text-align: center;">
        <div style="z-index: 2;position: relative;top: 164px;">
            <span style="color: #242424;font-size: 12px;font-family: KoPubDotumBold;">원하는 옷을 검색해보세요!</span> <br/>
            <span style="color: #919191;font-size: 11px;">#가을 #코트 #셔츠</span>
        </div>
        <img src="/img/coco/search.main.png" alt="Search Bar" width="200px" height="200px"/>
        
    </div>
    <div style="position: relative;bottom: 32px;text-align:center;">
        <div class="main-searchbar">
            <form name="tsearch" method="get" action="shop/search.php" role="form" style="min-height: 30px;">
                <img src="/img/coco/search.png" style="position: absolute;width: 18px;height: 18px;z-index: 10;top: 5px;left: 5%;">
                    <input type="text" name="stx" class="" value="" style="position: relative; top: 3px;border: solid 2.3px white; width:96%; height: 20px;">
            </form>
        </div>
    </div>
</div>

<div style="position: relative;background-color: #e8e8e8;">
    <div style="text-align: center;">
        <span style="color:#4a4a4a; font-family:KoPubDotumBold;">#오늘의</span> <span style="color: #7283bb">코디</span>
    </div>
    
    <ul style="display: flex; list-style: none; justify-content: space-evenly;; padding-left: 0px; align-items: flex-end;">
        <li class="sub-card">
            <img src="/res/test/today/1d9d8ae528455687a0fa47e98ad1bda7.png"/>
        </li>
        <li class="main-card">
            <img src="/res/test/today/a6a51dc8781f26e91363fbbfd87591b9.png"/>
        </li>
        <li class="sub-card">
            <img src="/res/test/today/a6c8a780301b68bc198057fd2e9e9f9d.png"/>
        </li>
    </ul>

</div>


<script>
    $('body').attr("style", "background-color:#e8e8e8");
    $('.responsive .at-body .at-container').attr("style", "padding: 0px !important;");
</script>