<?php
	include("includes/main_init.php");
	if(!isset($_SESSION['id']))
	{
		header("location:index.php?login");
	}


		$lst_row=find("first",CUSTOMER_MASTER,"*", "ORDER BY id DESC LIMIT 1", array());
		if ($lst_row) {
			$div=explode('-',$lst_row['c_id']);
			$no=$div[1]+1;
		}
		else
		{
			$no=1;
		}

		// $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789';
		// $str = '';
		// $max = strlen($chars) - 1;
		// for ($i=0; $i < 4; $i++)
		// $str .= $chars[rand(0, $max)];

		// $where_clause="where c_id='".$str."'";
		// $execute=array();
		// $exe_find=find("first",CUSTOMER_MASTER,"*", $where_clause, $execute);
		// if($exe_find)
		// {
		// 	header("Refresh:0");
		// }
		
	
		if(isset($_POST['save']))
		{
			//print_r($_POST);
			$c_id=$_POST['c_id'];
			
			$cus_name=$_POST['cus_name'];
			$cus_add=$_POST['cus_add'];
			$cus_state=$_POST['cus_state'];
			$cus_city=$_POST['cus_city'];
			$cus_vat=$_POST['cus_vat'];

			$store_name=$_POST['store_name'];
			$store_manager=$_POST['store_manager'];
			$store_phone=$_POST['store_phone'];
			$store_mail=$_POST['store_mail'];
			$store_add=$_POST['store_add'];
			$store_state=$_POST['store_state'];
			$store_city=$_POST['store_city'];
			$store_vat=$_POST['store_vat'];
			
			$owner_name=$_POST['owner_name'];
			$owner_phone=$_POST['owner_phone'];
			$owner_mail=$_POST['owner_mail'];

			
			
			$department=$_POST['department'];
			$dep_name=$_POST['dep_name'];
			$dep_phone=$_POST['dep_phone'];
			$dep_mail=$_POST['dep_mail'];
		
			$item_code=$_POST['code'];
			$price=$_POST['price'];
			

			$fields1="c_id,company_name,address,state,city,vat";
			$values1=":c_id,:cus_name,:cus_add,:cus_state,:cus_city,:cus_vat";
			$execute1=array(':c_id'=>$c_id,':cus_name'=>$cus_name,':cus_add'=>$cus_add,':cus_state'=>$cus_state,':cus_city'=>$cus_city,':cus_vat'=>$cus_vat);
			$sv_mchne1=save(CUSTOMER_MASTER, $fields1, $values1, $execute1);

			foreach ($store_name as $a=>$store) { 
				$fields2="c_id,store_name,store_manager,phone,email,address,state,city,vat";
				$values2=":c_id,:store_name,:store_manager,:store_phone,:store_mail,:store_add,:store_state,:store_city,:store_vat";
				$execute2=array(':c_id'=>$c_id,':store_name'=>$store_name[$a],':store_manager'=>$store_manager[$a],':store_phone'=>$store_phone[$a],':store_mail'=>$store_mail[$a],':store_add'=>$store_add[$a],':store_state'=>$store_state[$a],':store_city'=>$store_city[$a],':store_vat'=>$store_vat[$a]);
				$sv_mchne2=save(CUSTOMER_STORE, $fields2, $values2, $execute2);
			}

			foreach ($department as $b=>$depart) { 
				$fields3="c_id,department,name,phone,email";
				$values3=":c_id,:department,:dep_name,:dep_phone,:dep_mail";
				$execute3=array(':c_id'=>$c_id,':department'=>$department[$b],':dep_name'=>$dep_name[$b],':dep_phone'=>$dep_phone[$b],':dep_mail'=>$dep_mail[$b]);
				$sv_mchne3=save(CUSTOMER_INFO, $fields3, $values3, $execute3);
			}

			foreach ($owner_name as $k=>$owner) { 
				$fields5="c_id,department,name,phone,email";
				$values5=":c_id,:department,:owner_name,:owner_phone,:owner_mail";
				$execute5=array(':c_id'=>$c_id,':department'=>"owner".($k+1),':owner_name'=>$owner_name[$k],':owner_phone'=>$owner_phone[$k],':owner_mail'=>$owner_mail[$k]);
				$sv_mchne5=save(CUSTOMER_INFO, $fields5, $values5, $execute5);
			}

			foreach ($item_code as $key => $item) {
					$fields6="c_id,item_no,price";
					$values6=":c_id,:item_no,:price";
					$execute6=array(':c_id'=>$c_id,':item_no'=>$item_code[$key],':price'=>$price[$key]);
					$sv_mchne6=save(CUSTOMER_ITEM, $fields6, $values6, $execute6);
				}

		
			if($sv_mchne1)
			{
			 $_SESSION['SET_TYPE'] = 'success';
			 $_SESSION['SET_FLASH'] = 'Customer saved successfully';
			  header('location:add_customer.php');
			  exit;
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
<script>
$(document).ready(function(){

	$('.inner_code').hide();
	$('#inner_state').hide();
	$('#inner_city').hide();
	$('.inner_department').hide();
	$('.inner_store_state').hide();
	$('.inner_store_city').hide();
})

function state_inp()
	{
		var state=$('#cus_state').val();
		if(state=="")
		{
			$('#inner_state').hide();
			$('#cus_city').val('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"autocomplete.php",
				data:{state:state},
				success:function(x)
				{
					if(x=='')
					{
						$('#inner_state').hide();
					}
					else
					{
						$('#inner_state').show();
						$('#inner_state').html(x);
					}
					
				}
			})
		}
		
	}
function fill_state(st)
	{
			$('#cus_state').val(st);
			$('#inner_state').hide();
	}
function city_inp()
	{
		var sta=$('#cus_state').val();
		if(sta=="")
		{
			alert('Please enter a state first!');
			$('#cus_city').val('');
		}
		var city=$('#cus_city').val();
		if(city=="")
		{
			$('#inner_city').hide();
		}
		else
		{
			$.ajax({
				type:"post",
				url:"autocomplete.php",
				data:{city:city,sta:sta},
				success:function(x)
				{
					if(x=='')
					{
						$('#inner_city').hide();
					}
					else
					{
						$('#inner_city').show();
						$('#inner_city').html(x);
					}
					
				}
			})
		}
		
	}
function fill_city(n)
	{
			$('#cus_city').val(n);
			$('#inner_city').hide();
	}
function code_inp(b)
	{
		var code=$('#code_'+b).val();
		if(code=="")
		{
		
			$('#inner_code_'+b).hide();
		}
		else
		{
			$.ajax({
				type:"post",
				url:"autocomplete.php",
				data:{code:code, id:b},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_code_'+b).hide();
						alert("The item code doesn't exist! Please enter a valid item code");
						$('#code_'+b).val('');
					}
					else
					{
						$('#inner_code_'+b).show();
						$('#inner_code_'+b).html(x);
					}
					
				}
			})
		}
		
	}
function fill_code(name,z)
	{
			$('#code_'+z).val(name);
			$('#inner_code_'+z).hide();
			$.ajax({
				type:"post",
				url:"detail_ajax.php",
				data:{name:name},
				success:function(x)
				{
					//alert(x);
					var str=x;
					var img=str.split("\n")[0];
					var desc=str.split("\n")[1];
					var price=str.split("\n")[2];
					//alert(desc);
					$('#img_'+z).html(img);
					$('#desc_'+z).html(desc);
					$('#price_'+z).val(price);
				}
			})
	}




function store_state_inp(d)
	{
		var store_st=$('#store_state_'+d).val();
		if(store_st=="")
		{
			$('#inner_store_state_'+d).hide();
			$('#store_state_'+d).val('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"autocomplete.php",
				data:{store_st:store_st, id:d},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_store_state_'+d).hide();
					}
					else
					{
						$('#inner_store_state_'+d).show();
						$('#inner_store_state_'+d).html(x);
					}
					
				}
			})
		}
		
	}
function fill_store_state(st,i)
	{
			$('#store_state_'+i).val(st);
			$('#inner_store_state_'+i).hide();
	}
function store_city_inp(e)
	{
		var st=$('#store_state_'+e).val();
		if(st=="")
		{
			alert('Please enter a state first!');
			$('#store_city_'+e).val('');
		}
		var store_city=$('#store_city_'+e).val();
		if(store_city=="")
		{
			$('#inner_store_city_'+e).hide();
		}
		else
		{
			$.ajax({
				type:"post",
				url:"autocomplete.php",
				data:{store_city:store_city,st:st,id:e},
				success:function(x)
				{
					if(x=='')
					{
						$('#inner_store_city_'+e).hide();
					}
					else
					{
						$('#inner_store_city_'+e).show();
						$('#inner_store_city_'+e).html(x);
					}
					
				}
			})
		}
		
	}
function fill_store_city(n,k)
	{
			$('#store_city_'+k).val(n);
			$('#inner_store_city_'+k).hide();
	}


var count=1;
function AddRow()
{	
	var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='text' id='code_"+count+"' name='code[]' class='tbl_inp' onkeyup='code_inp("+count+")' required><div class='col-sm-12 inner_code' id='inner_code_"+count+"' style='background-color: white; position: absolute; z-index:1000; box-shadow: 5px 5px 5px 5px; padding: 10px; width:250px;'></div></td><td id='img_"+count+"'></td><td id='desc_"+count+"'></td><td><input type='text' id='price_"+count+"' name='price[]' class='tbl_inp' onkeyup='prc_inp("+count+")' onkeypress='return isNumberKey(event)' maxlength='15' required></td></tr>";
            $("table .tb1").append(markup);
            count++;
            $('.inner_code').hide();
}
function DelRow()
{
	$("table tbody").find('input[name="record"]').each(function(){
    	if($(this).is(":checked")){
            $(this).parents("tr").remove();
        }
    });

}

var store_count=1;
function AddStoreRow()
{	
	var store_markup = "<tr><td><input type='checkbox' name='store_row'></td><td><input type='text' name='store_name[]'' id='store_name_"+store_count+"' class='tbl_inp'  required></td><td><input type='text' name='store_manager[]'' id='store_manager_"+store_count+"' class='tbl_inp'  required></td><td><input type='text' name='store_phone[]'' id='store_phone_"+store_count+"' class='tbl_inp' onkeypress='return isNumberKey(event)' maxlength='15'  required></td><td><input type='text' name='store_mail[]'' id='store_mail_"+store_count+"' class='tbl_inp'  required></td><td><textarea name='store_add[]'' id='store_add_"+store_count+"' class='tbl_inp'  required></textarea></td><td><input type='text' name='store_state[]'' id='store_state_"+store_count+"' class='tbl_inp' onkeyup='store_state_inp("+store_count+")'  required><div class='col-sm-12 inner_store_state' id='inner_store_state_"+store_count+"' style='background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;'></div></td><td><input type='text' name='store_city[]'' id='store_city_"+store_count+"' class='tbl_inp' onkeyup='store_city_inp("+store_count+")'  required><div class='col-sm-12 inner_store_city' id='inner_store_city_"+store_count+"' style='background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;'></div></td><td><input type='text' name='store_vat[]'' id='store_vat_"+store_count+"' class='tbl_inp'  required></td></tr>";
            $("table .store_tb").append(store_markup);
            store_count++;
            $('.inner_store_state').hide();
            $('.inner_store_city').hide();
}
function DelStoreRow()
{
	$("table tbody").find('input[name="store_row"]').each(function(){
    	if($(this).is(":checked")){
            $(this).parents("tr").remove();
        }
    });

}

var depart_count=1;
function AddDepartRow()
{	
	var depart_markup = "<tr><td><input type='checkbox' name='depart_row'></td><td><input type='text' id='department_"+depart_count+"' name='department[]' class='tbl_inp' onkeypress='department_inp("+depart_count+")' required><div class='col-sm-12 inner_department' id='inner_department_"+depart_count+"' style='background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px; width: 250px;'></div></td><td><input type='text' name='dep_name[]'' id='dep_name_"+depart_count+"' class='tbl_inp'  required></td><td><input type='text' name='dep_phone[]'' id='dep_phone_"+depart_count+"' class='tbl_inp' onkeypress='return isNumberKey(event)' maxlength='15' required></td><td><input type='text' name='dep_mail[]'' id='dep_mail_"+depart_count+"' class='tbl_inp'  required></td></tr>";
            $("table .depart_tb").append(depart_markup);
            depart_count++;
            $('.inner_department').hide();
}
function DelDepartRow()
{
	$("table tbody").find('input[name="depart_row"]').each(function(){
    	if($(this).is(":checked")){
            $(this).parents("tr").remove();
        }
    });

}

function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }


function department_inp(b)
	{
		var availableTags = [
      "Account",
      "Purchase"
    ];
    $( "#department_"+b).autocomplete({
      source: availableTags
    });
		
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
					<h3 style="margin-bottom:20px;">Add Customer</h3>
					  <form id="sldr" method="post" enctype="multipart/form-data" autocomplete="off" data-toggle="validator" role="form">
						
				  		<div class="col-md-6 form-group form-inline">
							<div class="form-group">
							<label>Customer ID</label>
							<input type="text" class="form-control" id="c_id" name="c_id" placeholder="Company ID" value="cus-0<?php echo $no;?>" readonly>
						  </div>
						</div>
					
					  <div class="clearfix"></div>
					  <div class="col-md-12">
					  	  <h4 style="margin-bottom:20px;">Company Info</h4>
					  	  <div class="col-md-6">
						  	  <div class="form-group">
								<input type="text" class="form-control" id="cus_name" name="cus_name" placeholder="Company Name"  required>
							  </div>
							  <div class="form-group">
								<textarea class="form-control" id="cus_add" name="cus_add" placeholder="Head Office Address" style="height: 85px;" required></textarea>
							  </div>	
					  	  </div>
					  	  <div class="col-md-6">
					  	  	  
						  	  <div class="form-group" style="position:relative">
								<input type="text" class="form-control" id="cus_state" name="cus_state" placeholder="State" onkeyup="state_inp()" required>
								<div class="col-sm-12" id="inner_state" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							  <div class="form-group" style="position:relative">
								<input type="text" class="form-control" id="cus_city" name="cus_city" placeholder="City" onkeyup="city_inp()" required>
								<div class="col-sm-12" id="inner_city" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="cus_vat" name="cus_vat" placeholder="VAT/CST" required>
							  </div>
					  	  </div> 
					  </div>
					  <div class="clearfix"></div>
					  
					  	<div class="col-md-12">
					  		 <h4 style="margin-bottom:20px;">Owner Details</h4>
					  	  <div class="col-md-4">
						  	  <div class="form-group">
								<input type="text" class="form-control" id="owner_name1" name="owner_name[]" placeholder="Owner 1 Name" required>
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="owner_phone1" name="owner_phone[]" placeholder="Owner 1 Phone" onkeypress="return isNumberKey(event)" maxlength="15" required>
							  </div>
							  <div class="form-group">
								<input type="email" class="form-control" id="owner_mail1" name="owner_mail[]" placeholder="Owner 1 Email" required>
							  </div>
					  	  </div>
					  	  <div class="col-md-4">
				  	  		  <div class="form-group">
								<input type="text" class="form-control" id="owner_name2" name="owner_name[]" placeholder="Owner 2 Name">
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="owner_phone2" name="owner_phone[]" placeholder="Owner 2 Phone" onkeypress="return isNumberKey(event)" maxlength="15">
							  </div>
							  <div class="form-group">
								<input type="email" class="form-control" id="owner_mail2" name="owner_mail[]" placeholder="Owner 2 Email">
							  </div>
					  	  </div> 
					  	  <div class="col-md-4">
				  	  		  <div class="form-group">
								<input type="text" class="form-control" id="owner_name3" name="owner_name[]" placeholder="Owner 3 Name">
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="owner_phone3" name="owner_phone[]" placeholder="Owner 3 Phone" onkeypress="return isNumberKey(event)" maxlength="15">
							  </div>
							  <div class="form-group">
								<input type="email" class="form-control" id="owner_mail3" name="owner_mail[]" placeholder="Owner 3 Email">
							  </div>
					  	  </div> 
					  	</div>
					  	<div class="clearfix"></div>
					  	
						<div class="col-md-12">
					  	  <h4 style="margin:20px 0;">Contact Details</h4>
					  	  <div class="table-responsive">          
						  <table class="table table-bordered">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Department</th>
						        <th>Name</th>
						        <th>Phone</th>
						        <th>Email</th>
						      </tr>
						    </thead>
						    <tbody class="depart_tb">
						      <tr>
						      	<td><input type="checkbox" name="depart_row"></td>
						        <td>
							        <input type="text" name="department[]" id="department_0" class="tbl_inp" onkeypress="department_inp(0)" required>
							        <div class="col-sm-12 inner_department" id="inner_department_0" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px; width: 250px;"></div>
						        </td>
						        <td><input type="text" name="dep_name[]" id="dep_name_0" class="tbl_inp"  required></td>
						        <td><input type="text" name="dep_phone[]" id="dep_phone_0" class="tbl_inp" onkeypress="return isNumberKey(event)" maxlength="15"  required></td>
						        <td><input type="text" name="dep_mail[]" id="dep_mail_0" class="tbl_inp"  required></td>
						      </tr>
						    </tbody>
						  </table>
						</div>
						<div class="btn-group">
						  <button type="button" class="btn btn-primary" onclick="AddDepartRow()">Add Row</button>
						  <button type="button" class="btn btn-danger" onclick="DelDepartRow()">Delete Row</button>
						</div>
					  </div>
					  <div class="clearfix"></div>
					   <div class="col-md-12">
					  	  <h4  style="margin:20px 0;">Store Details</h4>
					  	  <div class="table-responsive">          
						  <table class="table table-bordered">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Store Name</th>
						        <th>Manager Name</th>
						        <th>Phone</th>
						        <th>Email</th>
						        <th>Address</th>
						        <th>State</th>
						        <th>City</th>
						        <th>VAT</th>
						      </tr>
						    </thead>
						    <tbody class="store_tb">
						      <tr>
						      	<td><input type="checkbox" name="store_row"></td>
						        <td><input type="text" name="store_name[]" id="store_name_0" class="tbl_inp"  required></td>
						        <td><input type="text" name="store_manager[]" id="store_manager_0" class="tbl_inp"  required></td>
						        <td><input type="text" name="store_phone[]" id="store_phone_0" class="tbl_inp" onkeypress="return isNumberKey(event)" maxlength="15" required></td>
						        <td><input type="text" name="store_mail[]" id="store_mail_0" class="tbl_inp"  required></td>
						        <td><textarea name="store_add[]" id="store_add_0" class="tbl_inp"  required></textarea></td>
						        <td><input type="text" name="store_state[]" id="store_state_0" class="tbl_inp"  onkeyup="store_state_inp(0)" required>
								<div class="col-sm-12 inner_store_state" id="inner_store_state_0" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div></td>
						        <td><input type="text" name="store_city[]" id="store_city_0" class="tbl_inp"  onkeyup="store_city_inp(0)" required>
								<div class="col-sm-12 inner_store_city" id="inner_store_city_0" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div></td>
								<td><input type="text" name="store_vat[]" id="store_vat_0" class="tbl_inp"  required></td>
						      </tr>
						    </tbody>
						  </table>
						</div>
						<div class="btn-group">
						  <button type="button" class="btn btn-primary" onclick="AddStoreRow()">Add Row</button>
						  <button type="button" class="btn btn-danger" onclick="DelStoreRow()">Delete Row</button>
						</div>
					  </div>
					  <div class="clearfix"></div>
					  <div class="col-md-12">
					  	<h4 style="margin:20px 0;">Items Requirement</h4>
					  	<div class="table-responsive">          
						  <table class="table table-bordered">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Item Code</th>
						        <th>Photo</th>
						        <th>Description</th>
						        <th>Price</th>
						      </tr>
						    </thead>
						    <tbody class="tb1">
						      <tr>
						      	<td><input type="checkbox" name="record"></td>
						        <td><input type="text" name="code[]" id="code_0" class="tbl_inp" onkeyup="code_inp(0)" required><div class="col-sm-12 inner_code" id="inner_code_0" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px; width: 250px;"></div></td>
						        <td id="img_0"></td>
						        <td id="desc_0"></td>
						        <td><input type="text" name="price[]" id="price_0" class="tbl_inp" onkeypress="return isNumberKey(event)" maxlength="15" required></td>
						      </tr>
						    </tbody>
						  </table>
						</div>
						<div class="btn-group">
						  <button type="button" class="btn btn-primary" onclick="AddRow()">Add Row</button>
						  <button type="button" class="btn btn-danger" onclick="DelRow()">Delete Row</button>
						</div>
					  	</div>
				
						<button type="submit" class="btn btn-primary" name="save" style="margin-top: 10px;">Submit</button>
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
