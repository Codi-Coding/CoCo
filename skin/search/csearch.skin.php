<div style="
    position:relative;
    top:174px;
">
    <form name="tsearch" method="get" action="shop/search.php" role="form" class="form">
        <div class="input-group input-group-sm">
            <input type="text" name="stx" class="form-control input-sm" value="">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
            </span>
        </div>
    </form>
</div>

<script>
    var cssstring = `background : url(/img/coco/search_main.jpg);
    background-color: #95a4df;
    margin-top:5px;
    background-position: center top;
    background-repeat: no-repeat;
	background-size: cover;
	overflow: hidden;
	height: 550px;
	height: 597px;
	height: 630px;
	height: 640px;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  `;

    $('div .at-container').attr("style", cssstring);
    $('#thema_wrapper').css("background-color", "#95a4df")
</script>