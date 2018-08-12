<?php
include("includes/main_init.php");

if(isset($_POST['name']))
{
$row=find("first",ITEM,"*", "where code='" .$_POST['name']."'", array());

?>
    <img src="item_img/<?php echo $row['image'];?>" width="70px" height="50px">
	<div><?php echo $row['description'];?></div>
	<?php 
	echo $row['price'];
}
?>