/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
var slider=new Array();
slider[1]=new Object();
slider[1].min=1;
slider[1].max=40;
slider[1].val=0;
slider[1].onchange=updateresults;

var lastUpdate;

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function setBoxValue(val, box) {
    var b=document.getElementById('output'+box);
	
	b.value=val;
}
function updateresults(val, box) {
	var xmlhttp;
	val=Math.round(val);
	console.log(val);
	if (window.XMLHttpRequest)
		{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
	else if (window.ActiveXObject)
		{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	else
		{
		alert("Your browser does not support XMLHTTP!");
		}
	var url="ajaxzoomreturn.php";
	url=url+"?zoom="+val;
	xmlhttp.onreadystatechange=function()
	{
	if(xmlhttp.readyState==4)
	  {
		if(xmlhttp.status == 200) {
			var htmlval = xmlhttp.responseXML ;
			document.getElementById("results").innerHTML = xmlhttp.responseText;
		}
	  }
	}
	
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function useHttpResponse(){
	var state = xmlhttp.readyState;
	if (state == 4) {
		if(xmlhttp.status == 200) {
			var htmlval = http.responseXML ;
			document.getElementById("results").innerHTML = "Here";
		}
	} else {
		document.getElementById("results").innerHTML = "Please wait just a moment";
	}
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

