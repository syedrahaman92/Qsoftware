<?PHP
include_once 'dbconnection.php';
$link = Db_Connect();
include_once 'common_function.php';
include('smtp/class.phpmailer.php');
include('smtp/class.smtp.php');
include_once 'CsrfToken.php';
function generate_password($length = 20){
  $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';
  $str = '';
  $max = strlen($chars) - 1;
  for ($i=0; $i < $length; $i++)
    $str .= $chars[rand(0, $max)];

  return $str;
}
if (get_magic_quotes_gpc()) {

function stripslashes_gpc(&$value)
{
$value = stripslashes($value);
}
array_walk_recursive($_GET, 'stripslashes_gpc');

array_walk_recursive($_POST, 'stripslashes_gpc');

array_walk_recursive($_COOKIE, 'stripslashes_gpc');

array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}

session_start();

if(!isset($_SESSION['lang_id']))
{
	$_SESSION['lang_id']=2;
}

?>