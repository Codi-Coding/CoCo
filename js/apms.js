
// Name Layer
if (typeof(SIDEVIEW_JS) == 'undefined') { // 한번만 실행

	if (typeof g5_is_member == 'undefined')
        alert(aslang[0]);
    if (typeof g5_bbs_url == 'undefined')
        alert(aslang[1]);

    var SIDEVIEW_JS = true;

    // 아래의 소스코드는 daum.net 카페의 자바스크립트를 참고하였습니다.
    // 회원이름 클릭시 회원정보등을 보여주는 레이어
    function insertHead(name, text, evt) 
    {
        var idx = this.heads.length;
        var row = new SideViewRow(-idx, name, text, evt);
        this.heads[idx] = row;
        return row;
    }

    function insertTail(name, evt) 
    {
        var idx = this.tails.length;
        var row = new SideViewRow(idx, name, evt);
        this.tails[idx] = row;
        return row;
    }

    function SideViewRow(idx, name, onclickEvent) 
    {
        this.idx = idx;
        this.name = name;
        this.onclickEvent = onclickEvent;
        this.renderRow = renderRow;
        
        this.isVisible = true;
        this.isDim = false;
    }

    function renderRow() 
    {
        if (!this.isVisible)
            return "";
        
        var str = "<tr><td id='sideViewRow_"+this.name+"'>"+this.onclickEvent+"</td></tr>";
        return str;
    }

    function showSideView(curObj, mb_id, name, email, homepage) 
    {
        var sideView = new SideView('nameContextMenu', curObj, mb_id, name, email, homepage);
        sideView.showLayer();
    }

    function SideView(targetObj, curObj, mb_id, name, email, homepage) 
    {
        this.targetObj = targetObj;
        this.curObj = curObj;
        this.mb_id = mb_id;
        name = name.replace(/…/g,"");
        this.name = name;
        this.email = email;
        this.homepage = homepage;
        this.showLayer = showLayer;
        this.makeNameContextMenus = makeNameContextMenus;
        this.heads = new Array();
        this.insertHead = insertHead;
        this.tails = new Array();
        this.insertTail = insertTail;
        this.getRow = getRow;
        this.hideRow = hideRow;		
        this.dimRow = dimRow;
    
        // 회원이라면 // (비회원의 경우 검색 없음)
        if (g5_is_member) {
            // 자기소개
            if (mb_id) 
                this.insertTail("info", "<a href=\""+g5_bbs_url+"/profile.php?mb_id="+mb_id+"\" onclick=\"win_profile(this.href); return false;\">"+aslang[2]+"</a>");
            // 홈페이지
            if (homepage) 
                this.insertTail("homepage", "<a href=\""+homepage+"\" target=\"_blank\">"+aslang[3]+"</a>");
			// 쪽지보내기
            if (mb_id) 
                // 불여우 자바스크립트창이 뜨는 오류를 수정
                this.insertTail("memo", "<a href=\""+g5_bbs_url+"/memo_form.php?me_recv_mb_id="+mb_id+"\" onclick=\"win_memo(this.href); return false;\">"+aslang[4]+"</a>");
            // 메일보내기
            if (email) 
                this.insertTail("mail", "<a href=\""+g5_bbs_url+"/formmail.php?mb_id="+mb_id+"&name="+encodeURI(name)+"&email="+email+"\" onclick=\"win_email(this.href); return false;\">"+aslang[5]+"</a>");
        }

		var pim_target = '';
		if(g5_pim) {
			pim_target = ' target="_blank"';
		}
		// 게시판테이블 아이디가 넘어왔을 경우
        if (g5_bo_table) {
            if (mb_id) { // 회원일 경우 아이디로 검색
                this.insertTail("mb_id", "<a href=\""+g5_bbs_url+"/board.php?bo_table="+g5_bo_table+"&sca="+g5_sca+"&sfl=mb_id,1&stx="+mb_id+"\""+pim_target+">"+aslang[6]+"</a>");
                this.insertTail("mb_cid", "<a href=\""+g5_bbs_url+"/board.php?bo_table="+g5_bo_table+"&sca="+g5_sca+"&sfl=mb_id,0&stx="+mb_id+"\""+pim_target+">"+aslang[7]+"</a>");
			} else { // 비회원일 경우 이름으로 검색
                this.insertTail("name", "<a href=\""+g5_bbs_url+"/board.php?bo_table="+g5_bo_table+"&sca="+g5_sca+"&sfl=wr_name,1&stx="+name+"\""+pim_target+">"+aslang[6]+"</a>");
                this.insertTail("cname", "<a href=\""+g5_bbs_url+"/board.php?bo_table="+g5_bo_table+"&sca="+g5_sca+"&sfl=wr_name,0&stx="+name+"\""+pim_target+">"+aslang[7]+"</a>");
			}
		}
        if (mb_id)
            this.insertTail("new", "<a href=\""+g5_bbs_url+"/new.php?mb_id="+mb_id+"\""+pim_target+">"+aslang[8]+"</a>");

        // 최고관리자일 경우
        if (g5_is_admin == "super") {
            // 포인트내역과 1:1문의
            if (mb_id) {
                this.insertTail("qna", "<a href=\""+g5_bbs_url+"/qalist.php?qmb="+mb_id+"\">"+aslang[40]+"</a>");
				this.insertTail("point", "<a href=\""+g5_admin_url+"/point_list.php?sfl=mb_id&stx="+mb_id+"\" target=\"_blank\">"+aslang[9]+"</a>");
                this.insertTail("modify", "<a href=\""+g5_admin_url+"/member_form.php?w=u&mb_id="+mb_id+"\" target=\"_blank\">"+aslang[10]+"</a>");
			}
		}
    }

    function showLayer() {
        clickAreaCheck = true;
        var oSideViewLayer = document.getElementById(this.targetObj);
        var oBody = document.body;
            
        if (oSideViewLayer == null) {
            oSideViewLayer = document.createElement("DIV");
            oSideViewLayer.id = this.targetObj;
            oSideViewLayer.style.position = 'absolute';
            oBody.appendChild(oSideViewLayer);
        }
        oSideViewLayer.innerHTML = this.makeNameContextMenus();
        
        if (getAbsoluteTop(this.curObj) + this.curObj.offsetHeight + oSideViewLayer.scrollHeight + 5 > oBody.scrollHeight)
            oSideViewLayer.style.top = (getAbsoluteTop(this.curObj) - oSideViewLayer.scrollHeight) + 'px';
        else
            oSideViewLayer.style.top = (getAbsoluteTop(this.curObj) + this.curObj.offsetHeight) + 'px';

        oSideViewLayer.style.left = (getAbsoluteLeft(this.curObj) - this.curObj.offsetWidth + 14) + 'px';

        divDisplay(this.targetObj, 'block');

        selectBoxHidden(this.targetObj);
    }

    function getAbsoluteTop(oNode) {
        var oCurrentNode=oNode;
        var iTop=0;
        while(oCurrentNode.tagName!="BODY") {
            iTop+=oCurrentNode.offsetTop - oCurrentNode.scrollTop;
            oCurrentNode=oCurrentNode.offsetParent;
        }
        return iTop;
    }

    function getAbsoluteLeft(oNode) {
        var oCurrentNode=oNode;
        var iLeft=0;
        iLeft+=oCurrentNode.offsetWidth;
        while(oCurrentNode.tagName!="BODY") {
            iLeft+=oCurrentNode.offsetLeft;
            oCurrentNode=oCurrentNode.offsetParent;
        }
        return iLeft;
    }


    function makeNameContextMenus() {
        var str = "<table class='mbLayer'>";
        
        var i=0;
        for (i=this.heads.length - 1; i >= 0; i--)
            str += this.heads[i].renderRow();
       
        var j=0;
        for (j=0; j < this.tails.length; j++)
            str += this.tails[j].renderRow();
        
        str += "</table>";
        return str;
    }

    function getRow(name) {
        var i = 0;
        var row = null;
        for (i=0; i<this.heads.length; ++i) 
        {
            row = this.heads[i];
            if (row.name == name) return row;
        }

        for (i=0; i<this.tails.length; ++i) 
        {
            row = this.tails[i];
            if (row.name == name) return row;
        }
        return row;
    }

    function hideRow(name) {
        var row = this.getRow(name);
        if (row != null)
            row.isVisible = false;
    }

    function dimRow(name) {
        var row = this.getRow(name);
        if (row != null)
            row.isDim = true;
    }
    // Internet Explorer에서 셀렉트박스와 레이어가 겹칠시 레이어가 셀렉트 박스 뒤로 숨는 현상을 해결하는 함수
    // 레이어가 셀렉트 박스를 침범하면 셀렉트 박스를 hidden 시킴
    // <div id=LayerID style="display:none; position:absolute;" onpropertychange="selectBoxHidden('LayerID')">
    function selectBoxHidden(layer_id) {
        //var ly = eval(layer_id);
        var ly = document.getElementById(layer_id);

        // 레이어 좌표
        var ly_left   = ly.offsetLeft;
        var ly_top    = ly.offsetTop;
        var ly_right  = ly.offsetLeft + ly.offsetWidth;
        var ly_bottom = ly.offsetTop + ly.offsetHeight;

        // 셀렉트박스의 좌표
        var el;

        for (i=0; i<document.forms.length; i++) {
            for (k=0; k<document.forms[i].length; k++) {
                el = document.forms[i].elements[k];    
                if (el.type == "select-one") {
                    var el_left = el_top = 0;
                    var obj = el;
                    if (obj.offsetParent) {
                        while (obj.offsetParent) {
                            el_left += obj.offsetLeft;
                            el_top  += obj.offsetTop;
                            obj = obj.offsetParent;
                        }
                    }
                    el_left   += el.clientLeft;
                    el_top    += el.clientTop;
                    el_right  = el_left + el.clientWidth;
                    el_bottom = el_top + el.clientHeight;

                    // 좌표를 따져 레이어가 셀렉트 박스를 침범했으면 셀렉트 박스를 hidden 시킴
                    if ( (el_left >= ly_left && el_top >= ly_top && el_left <= ly_right && el_top <= ly_bottom) || 
                         (el_right >= ly_left && el_right <= ly_right && el_top >= ly_top && el_top <= ly_bottom) ||
                         (el_left >= ly_left && el_bottom >= ly_top && el_right <= ly_right && el_bottom <= ly_bottom) ||
                         (el_left >= ly_left && el_left <= ly_right && el_bottom >= ly_top && el_bottom <= ly_bottom) ||
                         (el_top <= ly_bottom && el_left <= ly_left && el_right >= ly_right)
                        )
                        el.style.visibility = 'hidden';
                }
            }
        }
    }

    // 감추어진 셀렉트 박스를 모두 보이게 함
    function selectBoxVisible() {
        for (i=0; i<document.forms.length; i++) {
            for (k=0; k<document.forms[i].length; k++) {
                el = document.forms[i].elements[k];    
                if (el.type == "select-one" && el.style.visibility == 'hidden')
                    el.style.visibility = 'visible';
            }
        }
    }

    function divDisplay(id, act) {
        selectBoxVisible();

        document.getElementById(id).style.display = act;
    }

    function hideSideView() {
        if (document.getElementById("nameContextMenu"))
            divDisplay ("nameContextMenu", 'none');
    }

    var clickAreaCheck = false;
    document.onclick = function() {
        if (!clickAreaCheck) 
            hideSideView();
        else 
            clickAreaCheck = false;
    }
}

function apms_print(url) {

	if(!url) url = g5_purl;

	if (url.indexOf('?') > 0) {
		url	= url + '&pim=1&ipwm=1';
	} else {
		url	= url + '?pim=1&ipwm=1';
	}
	window.open(url, 'print', "width=760,height=720,scrollbars=1");
	return false;
}

function apms_form(id, url) {
	window.open(url, id, "width=810,height=680,scrollbars=1");
	return false;
}

function apms_page(id, url, opt) {
	$("#" + id).load(url, function() {
	    if(typeof is_SyntaxHighlighter != 'undefined'){
			SyntaxHighlighter.highlight();
		}
	});

	if(typeof(window["comment_box"]) == "function"){
		switch(id) {
			case 'itemcomment'	: comment_box('', 'c'); break;
			case 'viewcomment'	: comment_box('', 'c'); break;
		}
		document.getElementById("btn_submit").disabled = false;
	}

	if(opt) {
	   $('html, body').animate({
			scrollTop: $("#" + id).offset().top - 100
		}, 500);
	}
}

function apms_emoticon(fid, sid) {

	if(!fid) fid = 'wr_content';

	var url = g5_bbs_url + '/emoticon.php?fid=' + fid;

	if(sid) {
		url = url + '&sid=' + sid;
	}

	window.open(url, "emoticon", "width=600,height=600,scrollbars=1");
	return false;
}

function apms_delete(id, href, url) {
	if (confirm(aslang[11])) {
		$.post(href, { js: "on" }, function(data) {
			str = data.substr(0, 2);
			data = data.replace(str,'');
			if(str == "1|") {
				if(data) alert(data);
				return false;
			} else {
				if(data) alert(data);
				apms_page(id, url); 
			}
		});
	}
}

function apms_comment(id) {
	var str;
	var c_url;
	if(id == 'viewcomment') {
		c_url = './write_comment_update.page.php';
	} else {
		c_url = './itemcommentupdate.php';
	}
	var f = document.getElementById("fviewcomment");
	var url = document.getElementById("comment_url").value;
	if (fviewcomment_submit(f)) {
		$.ajax({
			url : c_url,
			type : 'POST',
			cache : false,
			data : $("#fviewcomment").serialize() + "&js=on",
			dataType : "html",
			success : function(data) {
				str = data.substr(0, 2);
				data = data.replace(str,'');
				if(str == "1|") {
					if(data) alert(data);
					return false;
				} else {
					apms_page(id, url);
					document.getElementById("btn_submit").disabled = false;
					document.getElementById('wr_content').value = "";
				}
			},
			error : function(data) {
				alert(aslang[12]);
				return false;
			}
		});
	}
}

function apms_good(bo_table, wr_id, act, id, wc_id) {
	var href;

	if(wr_id && wc_id) {
		href = './good.comment.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&good=' + act + '&wc_id=' + wc_id;
	} else {
		if(wr_id) {
			href = './good.apms.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&good=' + act;
		} else {
			href = './good.php?it_id=' + bo_table + '&good=' + act;
		}
	}

	$.post(href, { js: "on" }, function(data) {
		if(data.error) {
			alert(data.error);
			return false;
		} else if(data.success) {
			alert(data.success);
			$("#"+id).text(number_format(String(data.count)));
		}
	}, "json");
}

function apms_like(mb_id, act, id) {
	var href = g5_bbs_url + '/like.php?id=' + mb_id + '&act=' + act;
	$.post(href, { js: "on" }, function(data) {
		if(data.error) {
			alert(data.error);
			return false;
		} else if(data.success) {
			alert(data.success);
			$("#"+id).text(number_format(String(data.count)));
		}
	}, "json");
}

function apms_shingo(bo_table, wr_id, act) {
	var str;

	if(act == "lock") {
		str = aslang[13];
	} else if(act == "unlock") {
		str = aslang[14];
	} else {
		str = aslang[15];
		act = "";
	}

	var href = './shingo.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&act=' + act;

	if (confirm(str)) {
		$.post(href, { js: "on" }, function(data) {
			if(data.msg) {
				alert(data.msg);
				return false;
			}
		}, "json");
	}
}

// SNS
function apms_sns(id, url) {
	switch(id) {
		case 'facebook'		: window.open(url, "win_facebook", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'twitter'		: window.open(url, "win_twitter", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'googleplus'	: window.open(url, "win_googleplus", "menubar=0,resizable=1,width=600,height=600"); break;
		case 'naverband'	: window.open(url, "win_naverband", "menubar=0,resizable=1,width=410,height=540"); break;
		case 'naver'		: window.open(url, "win_naver", "menubar=0,resizable=1,width=450,height=540"); break;
		case 'kakaostory'	: window.open(url, "win_kakaostory", "menubar=0,resizable=1,width=500,height=500"); break;
		case 'tumblr'		: window.open(url, "win_tumblr", "menubar=0,resizable=1,width=540,height=600"); break;
		case 'pinterest'	: window.open(url, "win_pinterest", "menubar=0,resizable=1,width=800,height=500"); break;
	}
    return false;
}

// Response
function apms_response(mb_id, id, win, page, read) {

	var href = g5_bbs_url + '/response.php?mb_id=' + mb_id + '&id=' + id + '&win=' + win + '&page=' + page + '&read=' + read;

	document.location.href = href;

	return false;
}

function apms_textarea(id, mode) {
	var textarea_height = $('#'+id).height();
	if(mode == 'down') {
		$('#'+id).height(textarea_height + 50);
	} else if(mode == 'up') {
		if(textarea_height - 50 > 50) {
			$('#'+id).height(textarea_height - 50);
		}
	} else {
		$('#'+id).height(mode);
	}
}

function owl_random(owlSelector){
	owlSelector.children().sort(function(){
		return Math.round(Math.random()) - 0.5;
	}).each(function(){
		$(this).appendTo(owlSelector);
	});
}

var apms_leave = function(href) {
    if(confirm(aslang[16])) {
        document.location.href = href;
	}
	return false;
}

var apms_image = function(href) {
	var new_win = window.open(href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
    new_win.focus();
	return false;
}

$(function(){
	$(".remember-me").click(function(){
		if($(this).is(":checked")) {
			if(!confirm(aslang[17])) {
				$(this).attr("checked", false);
				return false;
			}
		}
    });

	$('.leave-me').click(function() {
		apms_leave(this.href);
		return false;
    });

	$("a.item_image").click(function() {
		apms_image(this.href);
		return false;
	});

	$(".go-top").click(function() {
	   $('html, body').animate({ scrollTop: 0 }, 500);
	   return false;
	});

	$(".widget-setup").click(function() {
		var wset = $('.btn-wset');
		if(wset.is(":visible")){
			wset.hide();
		} else {
			wset.show();
		}
		return false;
	});

	// Tabs
	$('.nav-tabs[data-toggle="tab-hover"] > li > a').hover( function(){
		$(this).tab('show');
	});

	// Toggles
	$('.at-toggle .panel-heading a').on('click', function () {
		var clicked_toggle = $(this);

		if(clicked_toggle.hasClass('active')) {
			clicked_toggle.parents('.at-toggle').find('.panel-heading a').removeClass('active');
		} else {
			clicked_toggle.parents('.at-toggle').find('.panel-heading a').removeClass('active');
			clicked_toggle.addClass('active');
		}
	});
});
