// 굿빌더
var Menu;
var TO;

function showGlobalSub(num, total) {
	clearTimeout(TO);
	for(var i=0;i<total;i++) {
 		if(i == num)
			document.getElementById('mainSub'+i).style.display='block';
		else
			document.getElementById('mainSub'+i).style.display='none';
 	}
}

function hideGlobalSub(e, num) {
        Menu = document.getElementById('mainSub'+num);
	if(Menu) TO = setTimeout("Menu.style.display=\'none\';",500);
}
