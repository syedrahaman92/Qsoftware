<?php
	include("includes/main_init.php");
	if(!isset($_SESSION['id']))
	{
		header("location:index.php?login");
	}
	if(isset($_POST['pr_save']))
	{
		$execute_for_exist=array(':username'=>trim($_POST['user']),':email'=>trim($_POST['mail']),':id'=> $_SESSION['id']);
        $exechk_for_exist=find("first",ADMIN, "id", "where user_name =:username and email =:email and id!=:id", $execute_for_exist);
		if(empty($exechk_for_exist))
		{
			if($_POST['pwd']!='')
				{
					$set_value="user_name=:username,password=:password,email=:email,phone=:phone,address=:address";
					$where_clause="where id =:id";
					$execute=array(':id'=> $_SESSION['id'] ,':username'=>trim($_POST['user']),':password'=>md5($_POST['pwd']),':email'=>trim($_POST['mail']),':phone'=>trim($_POST['phone']),':address'=>trim($_POST['add']));
					$update_qry=update(ADMIN, $set_value, $where_clause, $execute);
					
					
					
					 $mail_body = "Dear ".$_SESSION['user'].",<br/><br/>You have successfully updated your admin account access details. Following describe the new account access details.<br/><br/><b>Username:</b> ".$_POST['user']."<br/><b>Password:</b> ".$_POST['pwd']."<br/><br/>Regards,<br/>Administrator,<br/>Syed Rahaman";

					//@Send_HTML_Mail($_POST['mail'], 'syed.tts0@gmail.com', '', 'Your updated account access details', $mail_body);
				
					//mail($_POST['mail'], 'Your updated account access details', $mail_body);

					
					$_SESSION['SET_TYPE'] = 'success';
					$_SESSION['SET_FLASH'] = 'Account details updated successfully';
				}
				else
				{
					$set_value="user_name=:username,email=:email,phone=:phone,address=:address";
					$where_clause="where id =:id";
					$execute=array(':id'=> $_SESSION['id'] ,':username'=>trim($_POST['user']),':email'=>trim($_POST['mail']),':phone'=>trim($_POST['phone']),':address'=>trim($_POST['add']));
					$update_qry=update(ADMIN, $set_value, $where_clause, $execute);
					
					$_SESSION['SET_TYPE'] = 'success';
					$_SESSION['SET_FLASH'] = 'Account details updated successfully';
				}
				$_SESSION['user']=$_POST['user'];
	    }
		else
		{
		  $_SESSION['SET_TYPE'] = 'error';
	      $_SESSION['SET_FLASH'] = 'Username or Email id already exists';
		}
	 }

	$execute=array(':id'=>($_SESSION['id']));
    $fetch=find("first",ADMIN,"*", "where id=:id", $execute);
	
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Dashboard||Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Minimal Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.notifyBar.js"></script>
<link rel="stylesheet" href="css/notifyBar.css" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.validationEngine-en.js"></script>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css">

<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
		</script>
		<script type="text/javascript">
		 $(document).ready(function() 
			{
				$("#admin_form").validationEngine()
			});
		</script>
<!----->


<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
</head>
<body>
<div id="wrapper">

<!----->
        <?php 
		include('side_bar.php');
		?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		   <!--  <div class="banner">
		   
				<h2>
				<a href="home.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Dashboard</span>
				</h2>
		    </div> -->
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
			<div class="col-md-6">
				<div class="content-top-1">
					
						 <form method="post" id="admin_form">
						  <div class="form-group">
							<label for="name">User Name:</label>
							<input type="text" class="form-control validate[required]" id="name" name="user" value="<?php echo $fetch['user_name']?>">
						  </div>
						  <div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" class="form-control" id="pwd" name="pwd">
						  </div>
						  <div class="form-group">
							  <label for="mail">Email:</label>
							  <input type="text" class="form-control validate[required]" id="mail" name="mail" value="<?php echo $fetch['email']?>">
							</div>
						  <div class="form-group">
							<label for="text">Phone No.:</label>
							<input type="text" class="form-control validate[required]" id="phone" name="phone" value="<?php echo $fetch['phone']?>">
						  </div>
						   <div class="form-group">
								  <label for="comment">Address:</label>
								  <textarea class="form-control validate[required]" id="comment" name="add"><?php echo $fetch['address']?></textarea>
							</div>
						  <button type="submit" class="btn btn-primary" name="pr_save">Save</button>
						</form>	
						
				</div>
			</div>
			
		<div class="clearfix"> </div>
		<!---->


	 
		<!---->
<div class="copy">
             <p> &copy; Design & Develop by <a href="https://github.com/syedrahaman92/" target="_blank">Syed Rahaman</a> </p>
	    </div>
		</div>
		<div class="clearfix"> </div>
       </div>
     </div>
<!---->
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
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
