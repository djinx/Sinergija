<?php
session_start ();

?>
<!DOCTYPE html>
<html>
<head>

<title>Chat</title>
<link type="text/css" rel="stylesheet" href="../public/css/style.css" />
</head>
<body>
<div id="wrapper">
		<div id="menu">
			<p class="welcome">
			<b><?php echo $_SESSION['username']['Nadimak']; ?></b>
			</p>
			<p class="logout">
				<a id="exit" href="#">Exit Chat</a>
			</p>
			<div style="clear: both"></div>
		</div>
		<div id="chatbox"><?php
		if (file_exists ( "log.html") && filesize ( "log.html") > 0) {
			$handle = fopen ( "log.html", "r" );
			$contents = fread ( $handle, filesize ( "log.html" ) );
			fclose ( $handle );
			
			echo $contents;
		}
		?></div>

		<form name="message" action="">
			<input name="usermsg" type="text" id="usermsg" size="63" /> <input
				name="submitmsg" type="submit" id="submitmsg" value="Send" />
		</form>
	</div>
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});

//jQuery Document
$(document).ready(function(){
	//Ukoliko korisnik želi da napusti sesiju
	$("#exit").click(function(){
		var exit = confirm("Da li želite da napustite ćaskanje");
		if(exit==true){
			window.close();
		}		
	});
});

//Ukoliko korisnik šalje poruku
$("#submitmsg").click(function(){
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		loadLog;
	return false;
});

function loadLog(){		
	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Visina skrola pre zahteva
	$.ajax({
		url: "log.html",
		cache: false,
		success: function(html){		
			$("#chatbox").html(html); //Ubacimo chatbox	
			
			//Auto-scroll			
			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Visina skrola posle zahteva
			if(newscrollHeight > oldscrollHeight){
				$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Postavimo se na dno diva
			}				
	  	},
	});
}

setInterval (loadLog, 2500);
</script>

</body>
</html>