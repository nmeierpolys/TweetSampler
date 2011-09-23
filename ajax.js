
	
	var selectedID = 0;
	
	document.getElementsByClassName = function(cl) {
		var retnode = [];
		var myclass = new RegExp('\\b'+cl+'\\b');
		var elem = this.getElementsByTagName('*');
		for (var i = 0; i < elem.length; i++) {
			var classes = elem[i].className;
			if (myclass.test(classes)) retnode.push(elem[i]);
		}
		return retnode;
	};
		
	function highlight(obj) {
		var mycl = 'select';
		
		var myclass = new RegExp('\\b'+mycl+'\\b');
		var elem = document.getElementsByClassName('selectssss');
		for (var i = 0; i < elem.length; i++) {
			var classes = elem[i].className;
			elem[i].className = "tweet";
		}
		console.debug(obj.cells[0].id);
		obj.cells[0].className = "selectsssssss";
		markTweetRead(obj.cells[0].id);
	};

	function lengthchange(obj)
	{
		var newremaining = 140 - obj.value.length;
		document.getElementById("remaining").innerHTML=newremaining;
		
	};
	function removeElementById(obj) 
	{
		tweetid = document.getElementById(obj.cells[0].id).parentNode;
		if (tweetid.parentNode && tweetid.parentNode.removeChild(tweetid)) 
		{
			tweetid.parentNode.removeChild(tweetid);
		}
	};
	
	function encodeMyHtml() {
    	 encodedHtml = escape(encodeHtml.htmlToEncode.value);
    	 encodedHtml = encodedHtml.replace(/\//g,"%2F");
    	 encodedHtml = encodedHtml.replace(/\?/g,"%3F");
    	 encodedHtml = encodedHtml.replace(/=/g,"%3D");
    	 encodedHtml = encodedHtml.replace(/&/g,"%26");
    	 encodedHtml = encodedHtml.replace(/@/g,"%40");
    	 encodeHtml.htmlEncoded.value = encodedHtml;
  	};
	
	function submitPost()
	{
	var xmlhttp;
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
	tweettext = escape(document.getElementById("tweettext").value);
	var url="index.php?act=ajaxupdatestatus";
	url=url+"&text="+tweettext;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	console.log("AJAX (url): ", url);
	document.getElementById("tweettext").value = "";
	document.getElementById("remaining").innerHTML = "140";
	document.getElementById("aftersubmit").innerHTML = unescape(tweettext) + "<br><a href='http://twitter.com/nmeierpolys'>Feed</a><br><br>";
	};
	
	function markTweetRead(tweetid)
	{
	var xmlhttp;
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
		
	var url="index.php?act=readtweet";
	url=url+"&id="+tweetid;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	console.log("AJAX (url): ", url);
	};