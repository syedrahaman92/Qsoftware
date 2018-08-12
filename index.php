<?php
include("includes/main_init.php");

if(isset($_SESSION['id']))
	{
		header("location:home.php");
	}
if(isset($_GET['logout']))
	{
		$_SESSION['SET_TYPE'] = 'success';
	    $_SESSION['SET_FLASH'] = 'You have logged out successfully';
	}
else if(isset($_GET['login']))
    {
		$_SESSION['SET_TYPE'] = 'error';
	    $_SESSION['SET_FLASH'] = 'You have to loggin for view this page';
	}
if(isset($_POST['login']))
	{
        
		$execute=array(':username'=>($_POST['user']),':password'=>(md5($_POST['pwd'])));
        $chk_for_login=find("first",ADMIN, "*", "where user_name =:username  and password =:password ", $execute);
		if($chk_for_login)
		{
			$_SESSION['user']=$chk_for_login['user_name'];
			$_SESSION['email']=$chk_for_login['email'];
			$_SESSION['id']=$chk_for_login['id'];
			if(isset($_SESSION['admin_last_page']))
			{
				echo '<script>window.location.href="'.$_SESSION['admin_last_page'].'"</script>';
			}
			else
			{
				echo '<script>window.location.href="list_quotation.php"</script>';
			}			
		}
		else
		{			
			$_SESSION['SET_TYPE'] = 'error';
	        $_SESSION['SET_FLASH'] = 'Invalid username or password';
		}
	}

	if(isset($_POST['rec_mail']) && $_POST['rec_mail']!='' && isset($_POST['recover']))
	{
		
		$where_forgot_password_check = "WHERE email=:email_address";
		$execute_forgot_password_check = array(':email_address'=> trim($_POST['rec_mail']));
		if($find_forgot_password_check = find("first", ADMIN, "*", $where_forgot_password_check, $execute_forgot_password_check))
		{
			$new_password = generate_password(8);
			$set_value_forgot_password = "id=:id, password=:password";
			$execute_forgot_password = array(':id'=>$find_forgot_password_check['id'], ':password' => MD5($new_password));
			$where_clause_forgot_password = "WHERE id=:id";
			$update_forgot_password = update(ADMIN, $set_value_forgot_password, $where_clause_forgot_password, $execute_forgot_password);
			if($update_forgot_password)
			{
			

				$mail_body = "Dear ".$find_forgot_password_check['username'].",<br/><br/>You have successfully reset your admin account access details. Following describe the new account access details. You can update these access details once you get login to your account.<br/><br/><b>Username:</b> ".$find_forgot_password_check['username']."<br/><b>Password:</b> ".$new_password."<br/><br/>Regards,<br/>Administrator,<br/>ThinkingTech Solutions";
			
				@Send_HTML_Mail($_POST['email_address'], 'noreply@mcgees.ch', '', 'Your updated account access details', $mail_body);
				
				$_SESSION['SET_TYPE'] = 'success';
				$_SESSION['SET_FLASH'] = 'Your password have been reset successfully. Please check your email.';
			}
		}
		else
		{
			$_SESSION['SET_TYPE'] = 'error';
	        $_SESSION['SET_FLASH'] = 'This Email Address is not available within our database. Please enter correct email address.';
		}
	}
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>login</title>
        <link rel="stylesheet" href="css/style_login.css">
		<link href="css/font-awesome.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/notifyBar.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.notifyBar.js"></script>
		<script src="js/validator.js"></script>

		<script type="text/javascript">
		 $(document).ready(function() 
			{
				$("#login_form").validationEngine({scroll:true})
			});
		</script>
	<script>
		 $("#login-button").click(function(event){
		 event.preventDefault();
	 
		 $('form').fadeOut(500);
		 $('.wrapper').addClass('form-success');
	});
	</script>
	<script>
	$(document).ready(function(){
		 $("#to-recover").click(function(){
	 
		 $('#recov').show();
		 $('#log_main').hide();
	});
	});
	</script>
  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<div id="log_main">
			<h1>Welcome</h1>
			<?php if(isset($_GET['logoutPass'])){ ?><p class="text-muted" style="color:green; font-size:15px;">See u Soon !! You have Successfully Loggout</p><?php } ?>
			<?php if(isset($_GET['loginFail'])){ ?><p class="text-muted" style="color:red; font-size:15px;">Sorry!! You have Enter Wrong User Name and Pssword.</p><?php } ?>
			<?php if(isset($_GET['errorPass'])){ ?><p class="text-muted" style="color:red; font-size:15px;">Sorry!! You Can't Access the page. Please Login First</p><?php } ?>
			<form action="" method="post" id="login_form" data-toggle="validator" role="form">
				<input type="text"  placeholder="Username" name="user" required>
				<input type="password" placeholder="Password" name="pwd" required>
				<button type="submit" id="login-button" name="login">Login</button>
				<!-- <div style="margin-top:10px"><a href="javascript:void(0)" id="to-recover" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a></div> -->
			</form>
		</div>
		<div id="recov" style="display:none;">
		<h1>Recover Password</h1>
		<p>Please enter your valid email address to regenerate your password.</p>
		  <form id="recoverform" method="post">
			<input type="text" class="validate[required]" placeholder="Email" name="rec_mail">
			<button type="submit" name="recover">Send</button>
		  </form>
	  </div>
		<h4>&copy 2017 ThinkingTech Solutions</h4>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
  </body>
</html>
<?php 
	if(isset($_SESSION['SET_FLASH']))
	{
		if($_SESSION['SET_TYPE']=='success')
		{
			echo "<script type='text/javascript'>showSuccess('".$_SESSION['SET_FLASH']."');</script>";
		}
		else if($_SESSION['SET_TYPE']=='error')
		{
			echo "<script type='text/javascript'>showError('".$_SESSION['SET_FLASH']."');</script>";
		}
	}

	//destroy session flash message
	//if(isset($_REQUEST['m']) && $_REQUEST['m']=='E')
	//{
		unset($_SESSION['SET_FLASH']);
		unset($_SESSION['SET_TYPE']);
	//}
?>