<?php
include("includes/main_init.php");

if(isset($_POST['code']))
{
$code=find("all",ITEM,"*", "where code like'" .$_POST['code']."%'", array());
$id=$_POST['id'];
foreach ($code as $key => $item) { ?>
    <div onclick="fill_code('<?php echo $item['code'];?>',<?php echo $id;?>)" style="cursor:pointer;"><?php echo $item['code'];?></div>
<?php }
}

if(isset($_POST['state']))
{
$states=find("all",GEO_LOCATION,"*", "where location_type='STATE' and name like'".$_POST['state']."%'", array());
foreach ($states as $key => $st) { ?>
    <div onclick="fill_state('<?php echo $st['name'];?>')" style="cursor:pointer;"><?php echo $st['name'];?></div>
<?php }
}

if(isset($_POST['city']) && isset($_POST['sta']))
{
$state_name=find("first",GEO_LOCATION,"*", "where name='".$_POST['sta']."'", array());
if($state_name)
{
	$city=find("all",GEO_LOCATION,"*", "where parent_id='".$state_name['id']."' and name like'".$_POST['city']."%'", array());
	foreach ($city as $key => $ct) { ?>
    <div onclick="fill_city('<?php echo $ct['name'];?>')" style="cursor:pointer;"><?php echo $ct['name'];?></div>
<?php }
}

}




if(isset($_POST['store_st']))
{
	$id=$_POST['id'];
$states=find("all",GEO_LOCATION,"*", "where location_type='STATE' and name like'".$_POST['store_st']."%'", array());
foreach ($states as $key => $st) { ?>
    <div onclick="fill_store_state('<?php echo $st['name'];?>',<?php echo $id; ?>)" style="cursor:pointer;"><?php echo $st['name'];?></div>
<?php }
}

if(isset($_POST['store_city']) && isset($_POST['st']))
{
	$id=$_POST['id'];
$state_name=find("first",GEO_LOCATION,"*", "where name='".$_POST['st']."'", array());
if($state_name)
{
	$city=find("all",GEO_LOCATION,"*", "where parent_id='".$state_name['id']."' and name like'".$_POST['store_city']."%'", array());
	foreach ($city as $key => $ct) { ?>
    <div onclick="fill_store_city('<?php echo $ct['name'];?>', <?php echo $id;?>)" style="cursor:pointer;"><?php echo $ct['name'];?></div>
<?php }
}

}

?>