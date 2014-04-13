<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Designtree</title>
<link rel="stylesheet" href="/public/admin/css/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="/public/admin/js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="/public/admin/js/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="/public/admin/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="index.html"><img src="/public/admin/img/shared/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->

	<div id="loginbox">
	        {% if info %} <p style="font-size:14px; font-weight: bold; text-align: center; margin-bottom: 15px;">{{ info }}</p> {% endif %}
	<!--  start login-inner -->
        <form id="login-inner" action="" method="POST">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Login</th>
                        <td><input type="text" name="login" placeholder="Nazwa użytkownika" class="login-inp" /></td>
		</tr>
		<tr>
			<th>Hasło</th>
                        <td><input type="password" name="password" value="" placeholder="Hasło"  class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
                        <td><input type="submit" value="zaloguj" class="submit-login"  /></td>
		</tr>
		</table>
	</form>
 	<!--  end login-inner -->
	<div class="clear"></div>
	
 </div>
 <!--  end loginbox -->
 
</div>
<!-- End: login-holder -->
</body>
</html>