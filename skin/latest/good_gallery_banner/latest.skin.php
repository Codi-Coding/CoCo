<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$data_path = G5_URL."/data/file/$bo_table";
if(gettype($options) == 'string') $options = explode('|', $options);
$img_width  = $options[0];
$img_height = $options[1];
$slide_control_height = $options[2];
if(!$img_width) $img_width = 740;
if(!$img_height) $img_height = 214;
if(!$slide_control_height) $slide_control_height = 40; /// default
$num_top_pos = $img_height - $slide_control_height;
?>
<style>
.slidecontainer {
	WIDTH: <?php echo $img_width?>px;
	HEIGHT: <?php echo $img_height?>px
}
.slidecontainer A IMG {
	WIDTH: <?php echo $img_width?>px;
	HEIGHT: <?php echo $img_height?>px
}
.slidecontainer IMG {
	BORDER-BOTTOM-STYLE: none;
	BORDER-RIGHT-STYLE: none;
	BORDER-TOP-STYLE: none;
	BORDER-LEFT-STYLE: none
}
.td_f A IMG {
	PADDING-BOTTOM: 0px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	PADDING-RIGHT: 0px;
	PADDING-TOP: 0px
}
.num {
	POSITION: relative;
	/*WIDTH: 90px;*/
	FLOAT: right;
	TOP: <?php echo $num_top_pos?>px; 
	RIGHT: 15px
}
.num LI {
	TEXT-ALIGN: center;
	LINE-HEIGHT: 15px;
	LIST-STYLE-TYPE: none;
	MARGIN: 1px;
	WIDTH: 15px;
	FONT-FAMILY: Arial;
	BACKGROUND: url(<?php echo $latest_skin_url?>/images/flashbutton.gif) no-repeat -15px 0px;
	FLOAT: left;
	HEIGHT: 15px;
	COLOR: #86a2b8;
	FONT-SIZE: 12px;
	CURSOR: pointer
}
.num LI.on {
	LINE-HEIGHT: 15px;
	WIDTH: 15px;
	BACKGROUND: url(<?php echo $latest_skin_url?>/images/flashbutton.gif) no-repeat;
	HEIGHT: 15px;
	COLOR: #ffffff
}
</style>
<SCRIPT type=text/javascript>
var $ = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
};

var Extend = function(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
	return destination;
}

var CurrentStyle = function(element){
	return element.currentStyle || document.defaultView.getComputedStyle(element, null);
}

var Bind = function(object, fun) {
	var args = Array.prototype.slice.call(arguments).slice(2);
	return function() {
		return fun.apply(object, args.concat(Array.prototype.slice.call(arguments)));
	}
}

var Tween = {
	Quart: {
		easeOut: function(t,b,c,d){
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		}
	},
	Back: {
		easeOut: function(t,b,c,d,s){
			if (s == undefined) s = 1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		}
	},
	Bounce: {
		easeOut: function(t,b,c,d){
			if ((t/=d) < (1/2.75)) {
				return c*(7.5625*t*t) + b;
			} else if (t < (2/2.75)) {
				return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
			} else if (t < (2.5/2.75)) {
				return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
			} else {
				return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
			}
		}
	}
}



var SlideTrans = function(slidecontainer, slider, count, options) {
	this._slider = $(slider);
	this._slidecontainer = $(slidecontainer);
	this._timer = null;
	this._count = Math.abs(count);
	this._target = 0;
	this._t = this._b = this._c = 0;
	
	this.Index = 0;
	
	this.SetOptions(options);
	
	this.Auto = !!this.options.Auto;
	this.Duration = Math.abs(this.options.Duration);
	this.Time = Math.abs(this.options.Time);
	this.Pause = Math.abs(this.options.Pause);
	this.Tween = this.options.Tween;
	this.onStart = this.options.onStart;
	this.onFinish = this.options.onFinish;
	
	var bVertical = !!this.options.Vertical;
	this._css = bVertical ? "top" : "left";
	

	var p = CurrentStyle(this._slidecontainer).position;
	p == "relative" || p == "absolute" || (this._slidecontainer.style.position = "relative");
	this._slidecontainer.style.overflow = "hidden";
	this._slider.style.position = "absolute";
	
	this.Change = this.options.Change ? this.options.Change :
		this._slider[bVertical ? "offsetHeight" : "offsetWidth"] / this._count;
};
SlideTrans.prototype = {

  SetOptions: function(options) {
	this.options = {
		Vertical:	true,
		Auto:		true,
		Change:		0,
		Duration:	50,
		Time:		10,
		Pause:		4000,
		onStart:	function(){},
		onFinish:	function(){},
		Tween:		Tween.Quart.easeOut
	};
	Extend(this.options, options || {});
  },

  Run: function(index) {

	index == undefined && (index = this.Index);
	index < 0 && (index = this._count - 1) || index >= this._count && (index = 0);

	this._target = -Math.abs(this.Change) * (this.Index = index);
	this._t = 0;
	this._b = parseInt(CurrentStyle(this._slider)[this.options.Vertical ? "top" : "left"]);
	this._c = this._target - this._b;
	
	this.onStart();
	this.Move();
  },

  Move: function() {
	clearTimeout(this._timer);

	if (this._c && this._t < this.Duration) {
		this.MoveTo(Math.round(this.Tween(this._t++, this._b, this._c, this.Duration)));
		this._timer = setTimeout(Bind(this, this.Move), this.Time);
	}else{
		this.MoveTo(this._target);
		this.Auto && (this._timer = setTimeout(Bind(this, this.Next), this.Pause));
	}
  },

  MoveTo: function(i) {
	this._slider.style[this._css] = i + "px";
  },

  Next: function() {
	this.Run(++this.Index);
  },

  Previous: function() {
	this.Run(--this.Index);
  },

  Stop: function() {
	clearTimeout(this._timer); this.MoveTo(this._target);
  }
};
</SCRIPT>
<DIV id=idContainer2 class=slidecontainer>
<TABLE id=idSlider2 border=0 cellSpacing=0 cellPadding=0>
  <TBODY>
  <TR>
  <?php for ($i=0; $i<count($list); $i++) {
	$slides_img =  "$data_path/".urlencode($list[$i][file][0][file]);
	//$link = $list[$i]['href'];
	$link_01 = $list[$i][wr_link1];
	?>
	   <TD class=td_f><A href="<?php echo $link_01?>"><IMG src="<?php echo $slides_img?>"></A></TD>
	
	<?php } ?>

   </TR></TBODY></TABLE>
<UL id=idNum class=num></UL>
</DIV>

<SCRIPT>
	var forEach = function(array, callback, thisObject){
		if(array.forEach){
			array.forEach(callback, thisObject);
		}else{
			for (var i = 0, len = array.length; i < len; i++) { callback.call(thisObject, array[i], i, array); }
		}
	}
	
	///var st = new SlideTrans("idContainer2", "idSlider2", <?php echo $rows?>, { Vertical: false }); //// 이미지 숫자
	var st = new SlideTrans("idContainer2", "idSlider2", <?php echo count($list)?>, { Vertical: false }); //// 이미지 숫자
	
	var nums = [];

	for(var i = 0, n = st._count - 1; i <= n;){
		(nums[i] = $("idNum").appendChild(document.createElement("li"))).innerHTML = ++i;
	}
	
	forEach(nums, function(o, i){
		o.onmouseover = function(){ o.className = "on"; st.Auto = false; st.Run(i); }
		o.onmouseout = function(){ o.className = ""; st.Auto = true; st.Run(); }
	})
	

	st.onStart = function(){
		forEach(nums, function(o, i){ o.className = st.Index == i ? "on" : ""; })
	}
	st.Run();
</SCRIPT>
