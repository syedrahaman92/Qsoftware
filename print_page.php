<?php

	include("includes/main_init.php");

	if(!isset($_SESSION['id']))

	{

		header("location:index.php?login");

	}

	

		$execute=array();

		$exe_find=find("first",QUOTATION,"*", "where q_id='".$_GET['pp']."'", $execute);

		$qt_id=$exe_find['q_id'];

		$date_fetch=$exe_find['date'];

		$change_date=new DateTime($date_fetch);

		$date=$change_date->format('d/m/Y');

		// $execute1=array();

		// $exe_find1=find("first",ITEM,"*", "where q_id=".$qt_id, $execute);



		$execute2=array();

		$exe_find2=find("all",ITEM_DETAILS,"*", "where q_id='".$qt_id."'", $execute);

		

		

		$row=count($exe_find2);

			

	



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



    function print_view()

    {

   	var prtContent = document.getElementById("print_div");

	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

	WinPrint.document.write(prtContent.innerHTML);

	WinPrint.document.close();

	WinPrint.focus();

	WinPrint.print();

	WinPrint.close();

    }



</script>

<script>







</script>

<!--skycons-icons-->

<script src="js/skycons.js"></script>

<!--//skycons-icons-->



<style type="text/css">

	



	/*tr:nth-child(even) {

	    background-color: #dddddd;

	}*/

</style>



</head>

<body>

<div id="wrapper">





        <div>

       <div>

 

  		

		<div>

			<div id="print_div" style="width: 100%; padding: 0px 15px;">

				<div style="width: 90%; padding: 0 20px; border:1px solid #7f8c8d; margin: 0 auto;">

					<h3 style="margin:0; text-align: center"><?php echo $exe_find['q_type']?></h3>

					  <form id="sldr" method="post" enctype="multipart/form-data" autocomplete="off">

					  	<div style="width: 100%; margin:0; border-bottom: 1px solid #7f8c8d;">

					  		<div style="width: 50%; float: left;">

					  		<h4 style="margin:0;">Company info</h4>

						  	  <div class="col-md-6">

									<p style="margin:0;"><?php echo $exe_find['c_name']?></p>

									<p style="margin:0;"><?php echo $exe_find['c_phone']?></p>

									<p style="margin:0;"><?php echo $exe_find['c_mail']?></p>

									<p style="margin:0;"><?php echo $exe_find['c_address']?></p>

						  	  </div>

							</div>

							<div style="width: 50%; float: right; text-align: right;margin:0;">

								<h4 style="margin:0;">Quotation ID- &nbsp;<?php echo $exe_find['q_id']?></h4>

					  			<h4 style="margin:0;">Date- &nbsp;<?php echo $date?></h4>

							</div>

							<div style="clear: both;"></div>

						</div>

						<div style="width: 100%; margin:5px 0;border-bottom: 1px solid #7f8c8d;">

						  <div style="width: 50%; float: left;">

						  	  <h4 style="margin:0;">Customer info</h4>

						  	  <div class="col-md-12">

						  	  	<p style="margin:0;"><label>Company:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_name']?></p>

						  	  	<p style="margin:0;"><label>Store:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_store']?></p>

								<p style="margin:0;"><label>Contact Person:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_per']?></p>

								<p style="margin:0;"><label>Phone:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_phone']?></p>

								<p style="margin:0;"><label>Email:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_mail']?></p>

								<p style="margin:0;"><label>Address:&nbsp;&nbsp;&nbsp;</label><?php echo $exe_find['cus_add']?>;&nbsp;<?php echo $exe_find['cus_city']?>;&nbsp;<?php echo $exe_find['cus_state']?></p>

						  	  </div>

						  </div>

						  <div style="clear: both;"></div>

					  </div>

					  <div style="width: 100%; margin: 5px 0;">

					  	<h4 style="margin:0;">We are pleased to quote as follows:</h4>

					  	<div style="margin: 5px 0;">          

						  <table border="1px" style="border-collapse: collapse; width: 100%;">

						    <thead style="background: #f5f5f5;">

						      <tr>

						      	<th style="padding: 8px">#</th>

						        <th style="padding: 8px">Code</th>

						        <th style="padding: 8px">Photo</th>

						        <th style="padding: 8px">Description</th>

						        <th style="padding: 8px">Price</th>

						        <th style="padding: 8px">Qty.(PCS)</th>

						        <th style="padding: 8px">Amount</th>

						      </tr>

						    </thead>

						    <tbody>

						   <?php foreach ($exe_find2 as $key => $det) {

							$execute1=array();

							$exe_find1=find("first",ITEM,"*", "where code='".$det['item_id']."'", $execute);

							?>

		

						      <tr>

						      	<td style="padding: 2px 8px"><?php echo $key+1;?></td>

						        <td style="padding: 2px 8px"><?php echo $det['item_id'];?></td>

						        <td style="padding: 2px 8px"><img src="item_img/<?php echo $exe_find1['image'];?>" width="70px" height="50px"></td>

						        <td style="padding: 2px 8px"><?php echo $exe_find1['description'];?></td>

						        <td style="padding: 2px 8px"><?php echo $det['price'];?></td>

						        <td style="padding: 2px 8px"><?php echo $det['qty'];?></td>

						        <td style="padding: 2px 8px"><?php echo $det['amount'];?></td>

						      </tr>

						      <?php } ?>

						    	<tr>

							      	<td colspan="6" style="text-align: right; padding: 5px 8px;">Total</td>

							        <td style="padding: 2px 8px"><?php echo $exe_find['total_amount']?></td>

						    	</tr>

						    	<tr>

							      	<td colspan="6" style="text-align: right; padding: 5px 8px;">Delivery Charges(<?php echo $exe_find['delv_opt']=='i'?'With VAT':'Without VAT';?>)</td>

							      	

							        <td style="padding: 2px 8px"><?php echo $exe_find['delv_charge']?></td>

						    	</tr>

						    	<tr>

							      	<td colspan="6" style="text-align: right; padding: 5px 8px;">VAT/CST(<?php if($exe_find['vat_opt']=='h'){echo '14.5%';} else if($exe_find['vat_opt']=='m'){ echo '5%';} else echo '2%';?>)</td>

							        <td style="padding: 2px 8px"><?php echo $exe_find['vat']?></td>

						    	</tr>

						    	<tr>

							      	<td colspan="6" style="text-align: right; padding: 5px 8px;">Grand Total</td>

							        <td style="padding: 2px 8px"><?php echo $exe_find['grand_total']?></td>

						    	</tr>

						    </tbody>

						    

						  </table>

						</div>

					  	</div>

					  	<div style="width: 96%; margin: 5px 0; border: 1px solid #7f8c8d; padding: 2px 10px;">

					  	  <h4 style="margin:0;padding: 0;">Notes</h4>

		

					  	  <div style="width: 100%;margin: 0px; padding: 0px 10px;">

							<p><?php echo $exe_find['notes']?></p>

						  </div>

						</div>

						<span onclick="print_view()" style="cursor: pointer;"><img src="images/print.png"></span>

					</form>

				</div>

				

			</div>

		</div>

		<!--//content-->





	 

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

