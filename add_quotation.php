<?php
	include("includes/main_init.php");
	if(!isset($_SESSION['id']))
	{
		header("location:index.php?login");
	}



		$yr=date("Y");
		$lst_row=find("first",QUOTATION,"*", "ORDER BY id DESC LIMIT 1", array());
		$div=explode('/',$lst_row['q_id']);
		if ($lst_row && $div[0]==$yr) {
			$no=$div[1]+1;
		}
		else
		{
			$no=1;
		}
		

		$lst_cus=find("first",CUSTOMER_MASTER,"*", "ORDER BY id DESC LIMIT 1", array());
		if ($lst_cus) {
			$d=explode('-',$lst_cus['c_id']);
			$cus_no=$d[1]+1;
		}
		else
		{
			$cus_no=1;
		}
		$cus_id='cus-0'.$cus_no;

		
		

		function super_unique($array,$key)

		{

		   $temp_array = array();

		   foreach ($array as &$v) {

		       if (!isset($temp_array[$v[$key]]))

		       $temp_array[$v[$key]] =& $v;

		   }

		   $array = array_values($temp_array);

		   return $array;



		}

		
	
		if(isset($_POST['save']))
		{
			//print_r($_POST);
			$q_id=$_POST['q_id'];
			$da=new DateTime();
			$date=$da->format('Y-m-d');
			$c_name=$_POST['c_name'];
			$c_phone=$_POST['c_phone'];
			$c_mail=$_POST['c_mail'];
			$c_add=$_POST['c_address'];
			$cus_name=$_POST['cus_name'];
			$cus_store=$_POST['cus_store'];
			$cus_per=$_POST['cus_per'];
			$cus_phone=$_POST['cus_phone'];
			$cus_mail=$_POST['cus_mail'];
			$cus_vat=$_POST['cus_vat'];
			$cus_add=$_POST['cus_add'];
			$cus_state=$_POST['cus_state'];
			$cus_city=$_POST['cus_city'];
			$notes=$_POST['notes'];
			$total=$_POST['total'];
			$delv=$_POST['delv'];
			$dl=$_POST['dl'];
			$vt=$_POST['vt'];
			$vat=$_POST['vat'];
			$grand=$_POST['g_total'];
		
			$item_code=$_POST['code'];
			$price=$_POST['price'];
			$qty=$_POST['qty'];
			$amount=$_POST['amount'];
			$q_type=$_POST['q_type'];

			$fields1="q_id,c_name,c_phone,c_mail,c_address,cus_name,cus_store,cus_per,cus_phone,cus_mail,cus_vat,cus_add,cus_state,cus_city,notes,total_amount,delv_charge,delv_opt,vat_opt,vat,grand_total,date,q_type";
			$values1=":q_id,:c_name,:c_phone,:c_mail,:c_address,:cus_name,:cus_store,:cus_per,:cus_phone,:cus_mail,:cus_vat,:cus_add,:cus_state,:cus_city,:notes,:total_amount,:delv_charge,:delv_opt,:vat_opt,:vat,:grand_total,:date,:q_type";
			$execute1=array(':q_id'=>$q_id,':c_name'=>$c_name,':c_phone'=>$c_phone,':c_mail'=>$c_mail,':c_address'=>$c_add,':cus_name'=>$cus_name,':cus_store'=>$cus_store,':cus_per'=>$cus_per,':cus_phone'=>$cus_phone,':cus_mail'=>$cus_mail,':cus_vat'=>$cus_vat,':cus_add'=>$cus_add,':cus_state'=>$cus_state,':cus_city'=>$cus_city,':notes'=>$notes,':total_amount'=>$total,':delv_charge'=>$delv,':delv_opt'=>$dl,':vat_opt'=>$vt,':vat'=>$vat,':grand_total'=>$grand,':date'=>$date,':q_type'=>$q_type);
			$sv_mchne1=save(QUOTATION, $fields1, $values1, $execute1);

			foreach ($item_code as $key => $item) {
					$fields2="q_id,item_id,price,qty,amount";
					$values2=":q_id,:item_id,:price,:qty,:amount";
					$execute2=array(':q_id'=>$q_id,':item_id'=>$item_code[$key],':price'=>$price[$key],':qty'=>$qty[$key],':amount'=>$amount[$key]);
					$sv_mchne2=save(ITEM_DETAILS, $fields2, $values2, $execute2);
				}
			

			$customer=find("first",CUSTOMER_MASTER,"*", "where company_name ='" .$_POST['cus_name']."'", array());
			if (!$customer) {
				$fields3="c_id,company_name,address,state,city,vat";
				$values3=":c_id,:cus_name,:cus_add,:cus_state,:cus_city,:cus_vat";
				$execute3=array(':c_id'=>$cus_id,':cus_name'=>$cus_name,':cus_add'=>$cus_add,':cus_state'=>$cus_state,':cus_city'=>$cus_city,':cus_vat'=>$cus_vat);
				$sv_mchne3=save(CUSTOMER_MASTER, $fields3, $values3, $execute3);
				if (isset($_POST['cus_store']) && $_POST['cus_store']!='') {
					$fields4="c_id,store_name,store_manager,phone,email,address,state,city,vat";
					$values4=":c_id,:store_name,:store_manager,:store_phone,:store_mail,:store_add,:store_state,:store_city,:store_vat";
					$execute4=array(':c_id'=>$cus_id,':store_name'=>$cus_store,':store_manager'=>$cus_per,':store_phone'=>$cus_phone,':store_mail'=>$cus_mail,':store_add'=>$cus_add,':store_state'=>$cus_state,':store_city'=>$cus_city,':store_vat'=>$cus_vat);
					$sv_mchne4=save(CUSTOMER_STORE, $fields4, $values4, $execute4);
				}
				
			}
			else{

				$store=find("first",CUSTOMER_STORE,"*", "where store_name ='" .$_POST['cus_store']."'", array());
				if(!$store)
				{
					if (isset($_POST['cus_store']) && $_POST['cus_store']!='') {
						$fields4="c_id,store_name,store_manager,phone,email,address,state,city,vat";
						$values4=":c_id,:store_name,:store_manager,:store_phone,:store_mail,:store_add,:store_state,:store_city,:store_vat";
						$execute4=array(':c_id'=>$customer['c_id'],':store_name'=>$cus_store,':store_manager'=>$cus_per,':store_phone'=>$cus_phone,':store_mail'=>$cus_mail,':store_add'=>$cus_add,':store_state'=>$cus_state,':store_city'=>$cus_city,':store_vat'=>$cus_vat);
						$sv_mchne4=save(CUSTOMER_STORE, $fields4, $values4, $execute4);
					}
				}
			}

			

			

			$customer1=find("first",CUSTOMER_MASTER,"*", "where company_name ='" .$_POST['cus_name']."'", array());
			if ($customer1) {
				$cust=$customer1['c_id'];
			}
			else{
				$cust=$cus_id;
			}
			$items=	find("all",CUSTOMER_ITEM,"*", "where c_id ='".$cust."'", array());

			foreach ($item_code as $k => $val) {
					$tmp_item[$k]=array("c_id"=>$cust,"item_no"=>$item_code[$k],"price"=>$price[$k]);
				}
			$items2=$tmp_item;
			$art=array_merge($items2,$items);
			
			$sr=super_unique($art,'item_no');
			$where_clause="where c_id='".$cust."'";
			$del=delete(CUSTOMER_ITEM, $where_clause);
			foreach ($sr as $m => $values) {
				$fields5="c_id,item_no,price";
				$values5=":c_id,:item_no,:price";
				$execute5=array(':c_id'=>$cust,':item_no'=>$values['item_no'],':price'=>$values['price']);
				$sv_mchne5=save(CUSTOMER_ITEM, $fields5, $values5, $execute5);
			}
			if($sv_mchne1)
			{
			 $_SESSION['SET_TYPE'] = 'success';
			 $_SESSION['SET_FLASH'] = 'Quotation saved successfully';
			  header('location:print_page.php?pp='.$q_id);
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
$(document).ready(function(){

	  var date= new Date();
	  var cur=date.toLocaleDateString("en-au",{year:"numeric",month:"numeric",day:"numeric"});
	  $('#date').val(cur);
	$('.inner_code').hide();
	$('#inner_comp').hide();
	$('#inner_cus').hide();
	$('#inner_contact').hide();
	$('#inner_state').hide();
	$('#inner_city').hide();
	$('#inner_cus_store').hide();
})
function comp_inp()
	{
		var comp=$('#c_name').val();
		if(comp=="")
		{
		
			$('#inner_comp').hide();
			$('#c_phone').val('');
			$('#c_mail').val('');
			$('#c_address').html('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{comp:comp},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_comp').hide();
					}
					else
					{
						$('#inner_comp').show();
						$('#inner_comp').html(x);
					}
					
				}
			})
		}
		
	}
function fill_comp(name)
	{
			$('#c_name').val(name);
			$('#inner_comp').hide();
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{comp_name:name},
				success:function(x)
				{
					var str=x;
					var phone=str.split("\n")[0];
					var mail=str.split("\n")[1];
					var address=str.split("\n\n")[1];
					$('#c_phone').val(phone);
					$('#c_mail').val(mail);
					$('#c_address').html(address);
				}
			})
	}
function cus_inp()
	{
		var cus=$('#cus_name').val();
		if(cus=="")
		{
		
			$('#inner_cus').hide();
			$('#cus_store').val('');
			$('#cus_phone').val('');
			$('#cus_per').val('');
			$('#cus_mail').val('');
			$('#cus_vat').val('');
			$('#cus_add').html('');
			$('#cus_state').val('');
			$('#cus_city').val('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{cus:cus},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_cus').hide();
					}
					else
					{
						$('#inner_cus').show();
						$('#inner_cus').html(x);
					}
					
				}
			})
		}
		
	}
function fill_cus(n)
	{
			$('#cus_name').val(n);
			$('#inner_cus').hide();
			$('#cus_store').val('');
			$('#cus_phone').val('');
			$('#cus_per').val('');
			$('#cus_mail').val('');
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{cus_name:n},
				success:function(x)
				{
					//alert(x);
					var str=x;
					var state=str.split("\n")[0];
					var city=str.split("\n")[1];
					var vat=str.split("\n")[2];
					var add=str.split("\n\n")[1];
			
					$('#cus_vat').val(vat);
					$('#cus_add').html(add);
					$('#cus_state').val(state);
					$('#cus_city').val(city);
				}
			})
	}

function cus_store_inp()
	{
		var cus_name=$('#cus_name').val();
		var str=$('#cus_store').val();
		if(cus_name=="")
		{
		
			$('#inner_cus_store').hide();
			$('#cus_phone').val('');
			$('#cus_mail').val('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{str:str,cus_nm:cus_name},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_cus_store').hide();
					}
					else
					{
						$('#inner_cus_store').show();
						$('#inner_cus_store').html(x);
					}
					
				}
			})
		}
		
	}
function fill_cus_store(n)
	{
			$('#cus_store').val(n);
			$('#inner_cus_store').hide();
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{store_nm:n},
				success:function(x)
				{
					//alert(x);
					var str=x;
					var manager=str.split("\n")[0];
					var phone=str.split("\n")[1];
					var email=str.split("\n")[2];
					var state=str.split("\n")[3];
					var city=str.split("\n")[4];
					var vat=str.split("\n")[5];
					var address=str.split("\n\n")[1];

					$('#cus_per').val(manager);
					
					$('#cus_phone').val(phone);
					
					$('#cus_mail').val(email);
					$('#cus_state').val(state);
					
					$('#cus_city').val(city);
					
					$('#cus_vat').val(vat);
					$('#cus_add').html(address);
					
					

			
				}
			})
	}

function contact_inp()
	{
		var cus_name=$('#cus_name').val();
		var cont=$('#cus_per').val();
		if(cus_name=="")
		{
		
			$('#inner_contact').hide();
			$('#cus_phone').val('');
			$('#cus_mail').val('');
		}
		else
		{
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{cont:cont,cusinfo:cus_name},
				success:function(x)
				{
					//alert(x);
					if(x=='')
					{
						$('#inner_contact').hide();
					}
					else
					{
						$('#inner_contact').show();
						$('#inner_contact').html(x);
					}
					
				}
			})
		}
		
	}
function fill_contact(n)
	{
			$('#cus_per').val(n);
			$('#inner_contact').hide();
			$.ajax({
				type:"post",
				url:"company_ajax.php",
				data:{contact:n},
				success:function(x)
				{
					//alert(x);
					var str=x;
					var phone=str.split("\n")[0];
					var email=str.split("\n")[1];
					
					$('#cus_phone').val(phone);
					
					$('#cus_mail').val(email);
			
				}
			})
	}
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
var count=1;
function AddRow()
{	
	var markup = "<tr><td><input type='checkbox' name='record'></td><td style='position:relative;'><input type='text' id='code_"+count+"' name='code[]' class='tbl_inp' onkeyup='code_inp("+count+")' required><div class='col-sm-12 inner_code' id='inner_code_"+count+"' style='background-color: white; position: absolute; z-index:1000; box-shadow: 5px 5px 5px 5px; padding: 10px;'></div></td><td id='img_"+count+"'></td><td id='desc_"+count+"'></td><td><input type='text' id='price_"+count+"' name='price[]' class='tbl_inp' onkeyup='prc_inp("+count+")' onkeypress='return isNumberKey(event)' maxlength='15' required></td><td><input type='text' id='qty_"+count+"' name='qty[]'  class='tbl_inp' onkeyup='prc_inp("+count+")' onkeypress='return isNumberKey(event)' maxlength='15' required></td><td><input type='text' id='amount_"+count+"' name='amount[]' class='tbl_inp amount' readonly></td></tr>";
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

    var sum=0;
	$('.amount').each(function() {
	    var total=this.value;
	    sum +=  parseFloat(total);
	});
	var total=sum.toFixed(2);
	 $('#total').val(total);

	var total=$('#total').val();
	var delv=$('#delv').val();
	 if(document.getElementById('h').checked)
	{
		var vat_per=14.5;
	}
	else if (document.getElementById('m').checked) 
	{
		var vat_per=5;
	}
	else  if (document.getElementById('l').checked) 
	{
		var vat_per=2;
	}

	if(document.getElementById('inc').checked)
	{
		var sum=parseFloat(total)+parseFloat(delv);
		var vat=(sum*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		 var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	else if (document.getElementById('exc').checked) 
	{
		var vat=(total*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		  var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
}
function prc_inp(a)
{
	var price=0;
	var qty=1;
	price=$('#price_'+a).val();
	if ($('#qty_'+a).val()!="") 
	{
		qty=$('#qty_'+a).val();
	}
	amount=(price*qty).toFixed(2);
	$('#amount_'+a).val(amount);
	
	var sum=0;
	$('.amount').each(function() {
	    var total=this.value;
	    sum +=  parseFloat(total);
	});
	var total=sum.toFixed(2);
	 $('#total').val(total);

	 var total=$('#total').val();
	var delv=$('#delv').val();
	 if(document.getElementById('h').checked)
	{
		var vat_per=14.5;
	}
	else if (document.getElementById('m').checked) 
	{
		var vat_per=5;
	}
	else  if (document.getElementById('l').checked) 
	{
		var vat_per=2;
	}

	if(document.getElementById('inc').checked)
	{
		var sum=parseFloat(total)+parseFloat(delv);
		var vat=(sum*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		 var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	else if (document.getElementById('exc').checked) 
	{
		var vat=(total*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		  var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
}

$(document).ready(function(){
	$('#h').attr('checked','checked');
	$('#inc').attr('checked','checked');
	$('#delv').val(0);
})
function vat_cal()
{	
	var total=$('#total').val();
	var delv=$('#delv').val();
	if(document.getElementById('h').checked)
	{
		var vat_per=14.5;
	}
	else if (document.getElementById('m').checked) 
	{
		var vat_per=5;
	}
	else  if (document.getElementById('l').checked) 
	{
		var vat_per=2;
	}

	if(document.getElementById('inc').checked)
	{
		var sum=parseFloat(total)+parseFloat(delv);
		var vat=(sum*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		 var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	else if (document.getElementById('exc').checked) 
	{
		var vat=(total*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		  var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	
}
function delv_charge()
{
	var total=$('#total').val();
	var delv=$('#delv').val();
	if(document.getElementById('h').checked)
	{
		var vat_per=14.5;
	}
	else if (document.getElementById('m').checked) 
	{
		var vat_per=5;
	}
	else  if (document.getElementById('l').checked) 
	{
		var vat_per=2;
	}

	if(document.getElementById('inc').checked)
	{
		var sum=parseFloat(total)+parseFloat(delv);
		var vat=(sum*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		 var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	else if (document.getElementById('exc').checked) 
	{
		var vat=(total*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		  var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	
}

function delv_cal()
{
	var total=$('#total').val();
	var delv=$('#delv').val();
	if(document.getElementById('h').checked)
	{
		var vat_per=14.5;
	}
	else if (document.getElementById('m').checked) 
	{
		var vat_per=5;
	}
	else  if (document.getElementById('l').checked) 
	{
		var vat_per=2;
	}

	if(document.getElementById('inc').checked)
	{
		var sum=parseFloat(total)+parseFloat(delv);
		var vat=(sum*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		 var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
	else if (document.getElementById('exc').checked) 
	{
		var vat=(total*(vat_per/100)).toFixed(2);
		 $('#vat').val(vat);
		  var v=parseFloat(total)+parseFloat(vat)+parseFloat(delv);
		 var gtotal=(v).toFixed(2);
		 $('#g_total').val(gtotal);
	}
}


function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
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
					<h3 style="margin-bottom:20px;">Add Quotation</h3>
					  <form id="sldr" method="post" enctype="multipart/form-data" autocomplete="off" data-toggle="validator" role="form">
					  	<div class="col-md-12">
					  		<div class="col-md-6 form-group form-inline">
					  			<label>Quotation ID-</label>
								<input type="text" class="form-control" id="q_id" name="q_id" value="<?php echo $yr;?>/0<?php echo $no;?>" readonly style="border:none;">
							</div>
							<div class="col-md-6 form-group form-inline">
					  			<label>Date-</label>
								<input type="text" class="form-control" id="date" name="date" readonly style="border:none;">
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
					  		<div class="col-md-6 form-group form-inline">
					  			<label>Quotation Type-</label>
								 <select lass="form-control" id="q_type" name="q_type"  style="border:none;">
								  <option value="QUOTATION">QUOTATION</option>
								  <option value="PERFORMA">PERFORMA</option>
								</select> 
							</div>
						</div>
						<div class="clearfix"></div>
					  <div class="col-md-6">
					  	  <h4 style="margin-bottom:20px;">Company info</h4>
					  	  <div class="col-md-6">
						  	  <div class="form-group">
								<input type="text" class="form-control" id="c_name" name="c_name" placeholder="Company Name" onkeyup="comp_inp()" required>
								<div class="col-sm-12" id="inner_comp" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							   <div class="form-group">
								<input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone" onkeypress="return isNumberKey(event)" maxlength="15" required>
							  </div>
							  <div class="form-group">
								<input type="email" class="form-control" id="c_mail" name="c_mail" placeholder="Email" required>
							  </div>	
							  
					  	  </div>
					  	  <div class="col-md-6">
						  	 <div class="form-group">
								<textarea class="form-control" id="c_address" name="c_address" placeholder="Address" style="height: 130px;" required></textarea>
							  </div>
					  	  </div> 
					  </div>
					  <div class="col-md-6">
					  	  <h4 style="margin-bottom:20px; float:left">Customer info</h4>
					  	  <!-- <h5 style="float: right"><a href="add_customer.php">Add New Customer</a></h5> -->
					  	  <div class="clearfix"></div>
					  	  <div class="col-md-6">
						  	  <div class="form-group">
								<input type="text" class="form-control" id="cus_name" name="cus_name" placeholder="Company" onkeyup="cus_inp()" required>
								<div class="col-sm-12" id="inner_cus" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="cus_store" name="cus_store" placeholder="Store Name" onclick="cus_store_inp()" onkeyup="cus_store_inp()">
								<div class="col-sm-12" id="inner_cus_store" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="cus_per" name="cus_per" placeholder="Contact Person" onclick="contact_inp()" onkeyup="contact_inp()" required>
								<div class="col-sm-12" id="inner_contact" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div>
							  </div>
							  <div class="form-group">
								<input type="text" class="form-control" id="cus_phone" name="cus_phone" placeholder="Phone" onkeypress="return isNumberKey(event)" maxlength="15" required>
							  </div>
							  <div class="form-group">
								<input type="email" class="form-control" id="cus_mail" name="cus_mail" placeholder="Email" required>
							  </div>	
					  	  </div>
					  	  <div class="col-md-6">
					  	  	  <div class="form-group">
								<textarea class="form-control" id="cus_add" name="cus_add" placeholder="Address" style="height: 82px;" required></textarea>
							  </div>
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
					  	<h4 style="margin-bottom:20px;"></h4>
					  	<div class="table-responsive">          
						  <table class="table table-bordered">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Code</th>
						        <th>Photo</th>
						        <th>Description</th>
						        <th>Price</th>
						        <th>Qty.(PCS)</th>
						        <th>Amount</th>
						      </tr>
						    </thead>
						    <tbody class="tb1">
						      <tr>
						      	<td><input type="checkbox" name="record"></td>
						        <td style="position:relative"><input type="text" name="code[]" id="code_0" class="tbl_inp" onkeyup="code_inp(0)" required><div class="col-sm-12 inner_code" id="inner_code_0" style="background-color: white; position: absolute;z-index:1000;box-shadow: 5px 5px 5px 5px; padding: 10px;"></div></td>
						        <td id="img_0"></td>
						        <td id="desc_0"></td>
						        <td><input type="text" name="price[]" id="price_0" class="tbl_inp" onkeyup="prc_inp(0)" onkeypress="return isNumberKey(event)" maxlength="15" required></td>
						        <td><input type="text" name="qty[]" id="qty_0" class="tbl_inp" onkeyup="prc_inp(0)" onkeypress="return isNumberKey(event)" maxlength="15" required></td>
						        <td><input type="text" name="amount[]" id="amount_0" class="tbl_inp amount" readonly></td>
						      </tr>
						    </tbody>
						    <tbody>
						    	<tr>
							      	<td colspan="6">Total</td>
							        <td><input type="text" name="total" id="total" class="tbl_inp" readonly></td>
						    	</tr>
						    	<tr>
							      	<td colspan="4">Delivery Charges</td>
							      	<td><input type="radio" name="dl" id="inc" value="i" onclick="delv_cal()">With Vat</td>
							      	<td><input type="radio" name="dl" id="exc" value="e" onclick="delv_cal()">Without Vat</td>
							        <td><input type="text" name="delv" id="delv" class="tbl_inp" onkeyup="delv_charge()" onkeypress="return isNumberKey(event)" maxlength="15" required></td>
						    	</tr>
						    	<tr>
							      	<td colspan="3">VAT/CST</td>
							      	<td><input type="radio" name="vt" id="h" value="h" onclick="vat_cal()">(14.5%)</td>
							      	<td><input type="radio" name="vt" id="m" value="m" onclick="vat_cal()">(5%)</td>
							      	<td><input type="radio" name="vt" id="l" value="l" onclick="vat_cal()">(2%)</td>
							        <td><input type="text" name="vat" id="vat" class="tbl_inp" readonly></td>
						    	</tr>
						    	<tr>
							      	<td colspan="6">Grand Total</td>
							        <td><input type="text" name="g_total" id="g_total" class="tbl_inp" readonly></td>
						    	</tr>
						    </tbody>
						    
						  </table>
						</div>
						<div class="btn-group">
						  <button type="button" class="btn btn-primary" onclick="AddRow()">Add Row</button>
						  <button type="button" class="btn btn-primary" onclick="DelRow()">Delete Row</button>
						</div>
					  	</div>
					  	<div class="col-md-12">
					  	  <h4 style="margin:20px 0;">Notes</h4>
		
					  	  <div class="form-group">
							<textarea class="form-control" id="comment" name='notes'></textarea>
							  <script>
								 CKEDITOR.replace( 'notes' );
								 </script>
						  </div>
						</div>
						<button type="submit" class="btn btn-primary" name="save">Submit</button>
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
