<?php
//connect a database
include('config.php');
function Db_Connect()
{
	global $db;
	if(DATABASE_NAME=='')
	{
		return '';
	}
	else
	{
		$page_name = basename($_SERVER['PHP_SELF']);
		if($page_name == "menu.php" || $page_name == "load_page_ajax1.php" || $page_name == "menu_2.php" || $page_name == "load_page_ajax2.php") {
			$options_common = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::ATTR_PERSISTENT => true
			);
			$db = new PDO("mysql:dbname=".DATABASE_NAME."; host=".SERVER_NAME."", USER_NAME, PASSWORD, $options_common);
			return $db;
		} else {
			$db = new PDO("mysql:dbname=".DATABASE_NAME."; host=".SERVER_NAME."",USER_NAME,PASSWORD);
			return $db;
		}
	}
}
?>