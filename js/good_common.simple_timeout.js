// 굿빌더
var Menu;
var TO;

function showGlobalSub(num, total) {
	for(var i=0;i<total;i++) {
 		if(i == num) {
			Menu = document.getElementById('mainSub'+i);
			Menu.style.display='block';
			TO = setTimeout("Menu.style.display=\'none\';",2000);
		}
		else
			document.getElementById('mainSub'+i).style.display='none';
 	}
}
