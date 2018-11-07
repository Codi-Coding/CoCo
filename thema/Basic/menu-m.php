<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<ul id="coco-top-nav" style="display:flex; justify-content: space-between;">
    <li class="nav-button">
        <a href="/search.php">
            <div>
                <img src="/img/coco/1.png" alt="search page"/>
                <span class="caption">검색</span>
            </div>
        </a>
    </li>
    <li class="nav-button">
        <a href="/recommend.php">
            <div>
                <img src="/img/coco/2.png" alt="search page"/>
                <span class="caption">컨셉/추천</span>
            </div>
        </a>
        
    </li>
    <li class="nav-button">
        <a href="/collect.php">
            <div>
                <img src="/img/coco/3.png" alt="search page"/>
                <span class="caption">모아보기</span>
            </div>
        </a>
        
    </li>
    <li class="nav-button">
        <a href="/fittingroom.php">
            <div>
                <img src="/img/coco/4.png" alt="search page"/>
                <span class="caption">피팅룸</span>
            </div>
        </a>

    </li>
    <li class="nav-button">
        <a href="/more.php">
            <div>
                <img src="/img/coco/5.png" alt="search page"/>
                <span class="caption">더보기</span>
            </div>
        </a>

    </li>
</ul>

<div style="width: 100%; height: 3px; background-color: #6875b0;">
</div>

<script>
    $(function(){
        var index = localStorage.getItem("cocoActiveNav") || 0;

        $('.nav-button').click(function(){
            index = $(".nav-button" ).index( this );
		    localStorage.setItem("cocoActiveNav", index);
        })

        $('#coco-top-nav li').eq(index).addClass("coco-active");
    });


    
</script>