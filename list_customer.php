<?php
	include("includes/main_init.php");
	if(!isset($_SESSION['id']))
	{
		header("location:index.php?login");
	}
	
	
	if(isset($_GET['did']))
	{
	 
			$execute=array();
			$exe_find_sr_no=find("first",CUSTOMER_MASTER,"*", "where id=".base64_decode($_GET['did']), $execute);
			$cm_id=$exe_find_sr_no['c_id'];

			$where_clause="where id=".base64_decode($_GET['did']);
			$del=delete(CUSTOMER_MASTER, $where_clause);

			$where_clause1="where c_id='".$cm_id."'";
			$del1=delete(CUSTOMER_STORE, $where_clause1);

			$where_clause2="where c_id='".$cm_id."'";
			$del2=delete(CUSTOMER_INFO, $where_clause2);

			$where_clause3="where c_id='".$cm_id."'";
			$del3=delete(CUSTOMER_ITEM, $where_clause3);
			if($del)
				{
				 $_SESSION['SET_TYPE'] = 'success';
				 $_SESSION['SET_FLASH'] = 'Customer deleted successfully';
				 header('location:list_customer.php');
				 exit;
				}
	}

	if(!isset($_GET['page']))
	{
		unset($_SESSION['search']);
		unset($_SESSION['query']);
	}
	if(isset($_GET['page']) && $_GET['page']=="")
	{
		unset($_SESSION['search']);
		unset($_SESSION['query']);
	}
	if(isset($_POST['search_btn']))
	{
		unset($_GET['page']);
		$_SESSION['search']=trim($_POST['search']);
		$where="where company_name like '%".$_SESSION['search']."%' or c_id like '%".$_SESSION['search']."%'";
		$_SESSION['query']=$where;

	}
	if(isset($_SESSION['query']))
	{
		$where=$_SESSION['query'];
	}
	else
	{
		$where="where 1";
	}
	$where_clause="".$where."";
    $execute=array();
	$exe_find=find("all",CUSTOMER_MASTER,"*", $where_clause, $execute);
	
	//print_r($exe_find);
	$rows=count($exe_find);
	//echo $rows;
	$data=20;
	$num=ceil($rows/$data);
	if(isset($_GET['page']))
	{
		$page=$_GET['page'];
	}
	else
	{
		$page=1;
	}
	$startpage=(($page-1)*$data);

	$where_clause="".$where." limit ".$startpage." , ".$data."";

	// if($page>$num)
	// {

	// 	$where_clause="".$where." limit ".$num." , ".$data."";
	// }
	// if($page<$num)
	// {
	// 	$where_clause="".$where." limit 0 , ".$data."";
	// }
	$fetch_data=find("all", CUSTOMER_MASTER, '*', $where_clause, $execute=array());
	//echo $where_clause;

	
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
<script src="js/validator.js"></script>
<script src="js/screenfull.js"></script>
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
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<script>

function del_pic(id)
{
	var r = confirm("Do you want to delete the Customer?");
	if (r == true) {
		window.location.href="list_customer.php?did="+id;
	}
}
function edit_pic(id)
{
		window.location.href="edit_customer.php?eid="+id;
}


 function btn(n)
  {
	  window.location.href="list_customer.php?page="+n;
  }
  function btn_prev()
  {
	  window.location.href="list_customer.php?page="+<?php echo $page-1?>;
  }
   function btn_next()
  {
	  window.location.href="list_customer.php?page="+<?php echo $page+1?>;
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
 		<div class="banner">
			<form class="navbar-left-right" method="post" data-toggle="validator" role="form">
              <input type="text" placeholder="Search..." name="search" required>
              <input type="submit" value="" name="search_btn" class="fa fa-search">
            </form>
            <div class="clearfix"> </div>
        </div> 
  		<!--banner-->	
		    <!-- <div class="banner">
		   
				<h2>
				<a href="home.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Career</span>
				</h2>
		    </div> -->
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
				<div class="col-md-12 add_sldr">
				<?php 
					if($rows>0)
					{
				?>
					<h4 style="margin-bottom:20px;">Customer List</h4>
					<div class="table-responsive">          
					  <table class="table table-bordered text-center">
					    <thead>
					      <tr>
					      	<th>Sl.No.</th>
					        <th>Customer ID.</th>
					        <th>Customer Name</th>
					        <th>Address</th>
					        <th>VAT</th>
					        <th colspan="2">Action</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php
						$i=1;
						foreach($fetch_data as $qt)
						{
						?>
						<tr>
					      	<td><?php echo $startpage+$i;?></td>
					        <td><?php echo $qt['c_id']?></td>
					        <td><?php echo $qt['company_name']?></td>
					        <td><?php echo $qt['address'];?>&nbsp;,&nbsp;<?php echo $qt['state'];?></td>
					        <td><?php echo $qt['vat']?></td>
					        <td><div class="btn-group">
							  <button type="button" class="btn btn-primary"  onclick="edit_pic('<?php echo base64_encode($qt['id'])?>')">Edit</button>
							  <button type="button" class="btn btn-warning" onclick="del_pic('<?php echo base64_encode($qt['id'])?>')">Delete</button>
							</div></td>
					      </tr>
					<?php $i++; }?>
					      
	
					    </tbody>
					    
					  </table>
					</div>
					<div align="center" style="margin: 10px 0 0;">
					  <?php 
					  if($num>1)
					  {
						  if($page>1) {?>
						  <span><input type="button" class="btn btn-info" value="&laquo" onclick="btn_prev()"/></span>
						  <?php } ?>
						  <?php for($i=1; $i<=$num; $i++){?>
						  <input type="button" class="btn <?php echo ($page==$i)?"btn-danger":"btn-info";?>" value="<?php echo $i?>" onclick="btn(<?php echo $i?>)">
						  <?php } ?>
						  <?php if($page<$num) {?>
						  <span><input type="button" class="btn btn-info" value="&raquo" onclick="btn_next()"/></span>
						  <?php } 
					  }?>
					 </div>
					
					<?php }
					else
					{
						echo "No Data Found";
					}
					?>
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
