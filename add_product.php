<?php
	include("includes/main_init.php");
	if(!isset($_SESSION['id']))
	{
		header("location:index.php?login");
	}
		
	
		if(isset($_POST['save']))
		{
			$execute=array();
			$exe_find_pic=find("first",ITEM,"*", "where code='".$_POST['p_code']."'", $execute);
			if (!$exe_find_pic) 
			{
				$p_code=$_POST['p_code'];
				$p_desc=$_POST['p_desc'];
				$p_price=$_POST['p_price'];
				$imagepath='item_img/';
				if(isset($_FILES['img']['name']) && ($_FILES['img']['name'])!='')
				{
					$image_nm=explode('.',$_FILES['img']['name']);
					$image_ext_upper=strtoupper($image_nm[1]);
					$image_fullname=$image_nm[0].'.'.$image_ext_upper;
					$randimage=rand().$image_fullname;
					$uploadfile=$imagepath.basename($randimage);
					move_uploaded_file($_FILES['img']['tmp_name'],$uploadfile);
					
				}
				
				
				$fields1="code,image,description,price";
				$values1=":code,:image,:description,:price";
				$execute1=array(':code'=>$p_code,':image'=>$randimage,':description'=>$p_desc,':price'=>$p_price);
				$sv_mchne=save(ITEM, $fields1, $values1, $execute1);
		
				if($sv_mchne)
				{
				 $_SESSION['SET_TYPE'] = 'success';
				 $_SESSION['SET_FLASH'] = 'Product added successfully';
				  header('location:list_product.php');
				  exit;
				}
			}
			else
			{
				$_SESSION['SET_TYPE'] = 'error';
				$_SESSION['SET_FLASH'] = 'Product code already exist!';
			}
				
			
		}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dashboard||Quotation</title>
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
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
<!-- <script src="js/validator.js"></script> -->
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

		function PreviewImage() {
			document.getElementById("uploadPreview").style.display='block';
			var oFReader = new FileReader();
			var img=oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

			oFReader.onload = function (oFREvent) {
			document.getElementById("uploadPreview").src = oFREvent.target.result;
			};
		};

	</script>
<script>

function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }

function pr_sav()
{
	var img =document.getElementById("uploadImage").files[0];
	if (!img.type.match('image.*')) {
		alert("Please upload an image file!");
		return false;
	}
	var img_size=img.size/1024/1024;
	if(img_size>1)
	{
		alert("Please upload an image lesser than 1mb.");
		return false;
	}
}
</script>
<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
</head>
<body>
<div id="wrapper">

         <?php 
		include('side_bar.php');
		?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		    <!-- <div class="banner">
		   
				<h2>
				<a href="home.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Add Quotation</span>
				</h2>
		    </div> -->
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			<div class="col-md-12 add_sldr" id="print_div">
				<div class="col-md-12 list_sldr inner_sldr">
					<h3 style="margin-bottom:20px;">Add Product</h3>
					  <form id="sldr" method="post" enctype="multipart/form-data" autocomplete="off" data-toggle="validator" role="form">
						
					  <div class="col-md-12">
					  	  <h4 style="margin-bottom:20px;">Product Details</h4>
					  	  <div class="col-md-6">
						  	  <div class="form-group">
						  	  	<label>Product Code</label>
								<input type="text" class="form-control" id="p_code" name="p_code" placeholder="Product Code"  required>
							  </div>
					  	  	  
						  	  <div class="form-group" >
						  	  	<label>Product Description</label>
								<input type="text" class="form-control" id="p_desc" name="p_desc" placeholder="Description"  required>
					
							  </div>
							  <div class="form-group">
							  	<label>Price</label>
								<input type="text" class="form-control" id="p_price" name="p_price" placeholder="Price" onkeypress="return isNumberKey(event)"  required>

							  </div>
							  <div class="form-group">
								<label>Product Image</label><br>
							    <span class="btn btn-default btn-file">
								<img id="uploadPreview" style="width: 100px; height: 100px; border-radius:10px; margin: 0 auto; display: none;" />
							    <input id="uploadImage" type="file" name="img" onchange="PreviewImage();" required/>
								</span>
								<br><!-- <span style="color: red">Please upload a file 350px * 250px</span> -->
							  </div>
					  	  </div> 
					  </div>
					  <div class="clearfix"></div>
				
						<button type="submit" class="btn btn-primary" name="save" style="margin-top: 10px;" onclick="return pr_sav()">Submit</button>
					</form>
				</div>
				
			</div>
		</div>
		<!--//content-->


	 
		<!---->
<div class="copy">
             <p> &copy; 2017 All Rights Reserved | Design & Develop by <a href="http://www.thinkingtechsolutions.com/" target="_blank">ThinkingTech Solutions</a> </p>
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
