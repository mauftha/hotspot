<?php
error_reporting(0);
require_once('radius.class.php');

?>
<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Captive Portal Login Page</title>
  <style>
	  #content,.login,.login-card a,.login-card h1,.login-help{text-align:center}body,html{margin:0;padding:0;width:100%;height:100%;display:table}#content{font-family:'Source Sans Pro',sans-serif;background:url(https://www.wika-beton.co.id/uploads/slider2.jpg) center center no-repeat fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;display:table-cell;vertical-align:middle}.login-card{padding:40px;width:274px;background-color:#F7F7F7;margin:0 auto 10px;border-radius:2px;box-shadow:0 2px 2px rgba(0,0,0,.3);overflow:hidden}.login-card h1{font-weight:400;font-size:2.3em;color:#1383c6}.login-card h1 span{color:#f26721}.login-card img{width:70%;height:70%}.login-card input[type=submit]{width:100%;display:block;margin-bottom:10px;position:relative}.login-card input[type=text],input[type=password]{height:44px;font-size:16px;width:100%;margin-bottom:10px;-webkit-appearance:none;background:#fff;border:1px solid #d9d9d9;border-top:1px solid silver;padding:0 8px;box-sizing:border-box;-moz-box-sizing:border-box}.login-card input[type=text]:hover,input[type=password]:hover{border:1px solid #b9b9b9;border-top:1px solid #a0a0a0;-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);box-shadow:inset 0 1px 2px rgba(0,0,0,.1)}.login{font-size:14px;font-family:Arial,sans-serif;font-weight:700;height:36px;padding:0 8px}.login-submit{-webkit-appearance:none;-moz-appearance:none;appearance:none;border:0;color:#fff;text-shadow:0 1px rgba(0,0,0,.1);background-color:#4d90fe}.login-submit:disabled{opacity:.6}.login-submit:hover{border:0;text-shadow:0 1px rgba(0,0,0,.3);background-color:#357ae8}.login-card a{text-decoration:none;color:#222;font-weight:400;display:inline-block;opacity:.6;transition:opacity ease .5s}.login-card a:hover{opacity:1}.login-help{width:100%;font-size:12px}.list{list-style-type:none;padding:0}.list__item{margin:0 0 .7rem;padding:0}label{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;text-align:left;font-size:14px;}input[type=checkbox]{-webkit-box-flex:0;-webkit-flex:none;-ms-flex:none;flex:none;margin-right:10px;float:left}@media screen and (max-width:450px){.login-card{width:70%!important}.login-card img{width:30%;height:30%}}
  </style>
</head>

<body>
        <?php
        if ((isset($_POST['user'])) && ('' != trim($_POST['user'])))
        {
            $radius = new Radius('10.3.2.80', 'wowkeren');

            $radius->SetNasIpAddress('10.3.2.80'); // Needed for some devices, and not auto_detected if PHP not runned through a web server
            // Enable Debug Mode for the demonstration
           // $radius->SetDebugMode(TRUE);

            if ($radius->AccessRequest($_POST['user'], $_POST['pass']))
            {
                echo "<strong>Authentication accepted.</strong>";
                header('Location: http://captive.apple.com/');
            }
            else
            {
                echo "<strong>Authentication rejected.</strong>";
            }
            echo "<br />";

            echo "<br /><strong>GetReadableReceivedAttributes</strong><br />";
            echo $radius->GetReadableReceivedAttributes();

            echo "<br />";
            echo "<a href=\"".$_SERVER['PHP_SELF']."\">Reload authentication form</a>";
        }
        else
        {
            ?>
            <div id="content">
	<div class="login-card">
		<img src="https://www.wika-beton.co.id/img/logo-wikabeton-warna.png"/><br>
 		<h4>Welcome To Wika Beton Hotspot</h4>
	  <form name="login_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="user" value="user" placeholder="User" id="auth_user">
		<input type="password" name="pass" value="pass" placeholder="Password" id="auth_pass">
		  <div class="login-help">
			<ul class="list">
				<li class="list__item">
				  <label class="label--checkbox">
					  <input type="checkbox" class="checkbox" onchange="document.getElementById('login').disabled = !this.checked;">
					  <span>I agree with the <a target="_blank" rel="noopener" href="http://www.termslicences.com/example.pdf">terms & licences</a></span>
				  </label>
				</li>
			</ul>
		  </div>
		<input name="redirurl" type="hidden" value="$PORTAL_REDIRURL$">
		<input type="submit" name="submit"  class="login login-submit" value="Login" id="login" disabled>
	  </form>
	</div>
</div>
            
            <?php
        }
        ?>
    </body>
<html>
