<?php
include("includes/main_init.php");

if(isset($_POST['comp']))
{
$code=find("all",QUOTATION,"DISTINCT c_name", "where c_name like'" .$_POST['comp']."%'", array());
foreach ($code as $key => $item) { ?>
    <div onclick="fill_comp('<?php echo $item['c_name'];?>')" style="cursor:pointer;"><?php echo $item['c_name'];?></div>
<?php }
}

if(isset($_POST['comp_name']))
{
$com_det=find("first",QUOTATION,"*", "where c_name ='" .$_POST['comp_name']."'", array());
echo $com_det['c_phone'];
echo "\n";
echo $com_det['c_mail'];
echo "\n";
echo "\n";
echo $com_det['c_address'];
}

if(isset($_POST['cus']))
{
$cus=find("all",CUSTOMER_MASTER,"*", "where company_name like'" .$_POST['cus']."%'", array());
foreach ($cus as $key => $item) { ?>
    <div onclick="fill_cus('<?php echo $item['company_name'];?>')" style="cursor:pointer;"><?php echo $item['company_name'];?></div>
<?php }
}

if(isset($_POST['cus_name']))
{
$com_det=find("first",CUSTOMER_MASTER,"*", "where company_name ='" .$_POST['cus_name']."'", array());
echo $com_det['state'];
echo "\n";
echo $com_det['city'];
echo "\n";
echo $com_det['vat'];
echo "\n";
echo "\n";
echo $com_det['address'];
}

if(isset($_POST['cusinfo']))
{
	$comp_name=find("first",CUSTOMER_MASTER,"*", "where company_name ='" .$_POST['cusinfo']."'", array());
	if (isset($_POST['cont']) && $_POST['cont']!='') 
	{
		$cont=find("all",CUSTOMER_INFO,"*", "where c_id='" .$comp_name['c_id']."' and name like '".$_POST['cont']."%'", array());
		foreach ($cont as $key => $item) { ?>
		    <div onclick="fill_contact('<?php echo $item['name'];?>')" style="cursor:pointer;"><?php echo $item['name'];?></div>
		<?php }
	}
	else
	{
		$cont=find("all",CUSTOMER_INFO,"*", "where c_id='" .$comp_name['c_id']."'", array());
		foreach ($cont as $key => $item) { ?>
		    <div onclick="fill_contact('<?php echo $item['name'];?>')" style="cursor:pointer;"><?php echo $item['name'];?></div>
		<?php }
	}
}

if(isset($_POST['contact']))
{
$com_det=find("first",CUSTOMER_INFO,"*", "where name ='" .$_POST['contact']."'", array());
echo $com_det['phone'];
echo "\n";
echo $com_det['email'];
}


if(isset($_POST['cus_nm']))
{
	$comp_name=find("first",CUSTOMER_MASTER,"*", "where company_name ='" .$_POST['cus_nm']."'", array());
	if (isset($_POST['str']) && $_POST['str']!='') 
	{
		$str=find("all",CUSTOMER_STORE,"*", "where c_id='" .$comp_name['c_id']."' and store_name like '".$_POST['str']."%'", array());
		foreach ($str as $key => $item) { ?>
		    <div onclick="fill_cus_store('<?php echo $item['store_name'];?>')" style="cursor:pointer;"><?php echo $item['store_name'];?></div>
		<?php }
	}
	else
	{
		$str=find("all",CUSTOMER_STORE,"*", "where c_id='" .$comp_name['c_id']."'", array());
		foreach ($str as $key => $item) { ?>
		    <div onclick="fill_cus_store('<?php echo $item['store_name'];?>')" style="cursor:pointer;"><?php echo $item['store_name'];?></div>
		<?php }
	}
}


if(isset($_POST['store_nm']))
{
$store_det=find("first",CUSTOMER_STORE,"*", "where store_name ='" .$_POST['store_nm']."'", array());
echo $store_det['store_manager'];
echo "\n";
echo $store_det['phone'];
echo "\n";
echo $store_det['email'];
echo "\n";
echo $store_det['state'];
echo "\n";
echo $store_det['city'];
echo "\n";
echo $store_det['vat'];
echo "\n";
echo "\n";
echo $store_det['address'];
}
?>