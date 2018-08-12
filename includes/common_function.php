<?php
	
	function find($type, $table, $value='*', $where_clause, $execute=array())
{
	global $db;

	if($where_clause)
	{
		  $sql = "SELECT ".$value." FROM ".$table." ".$where_clause."";
		 
	}
	else
	{
		$sql = "SELECT ".$value." FROM ".$table;
	}
	//echo $sql;
	$prepare_sql = $db->prepare($sql);
	$prepare_sql->execute($execute);
	if($prepare_sql->errorCode() == 0) {
		if($type == 'first')
		{
			//fetch single record from database
			$result = $prepare_sql->fetch();
		}
		else if($type == 'all')
		{
			//fetch multiple record from database
			$result = $prepare_sql->fetchAll();
		}
		return $result;
	} else {
		$errors = $prepare_sql->errorInfo();
		echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';
		die();
	}
}
   
/*
* insert record into database
* @param string table name
* @param string fields
* @param string values
* @return resulting array
*/
function save($table, $fields, $values, $execute)
{
	global $db;
	$result = false;
    $sql = "INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";
	$prepare_sql = $db->prepare($sql);
	$prepare_sql->execute($execute);

	/*$errors = $prepare_sql->errorInfo();
	echo '<pre>';
	print_r($errors[2]);
	echo '</pre>';*/
	$result = $db->lastInsertId();
	return $result;
}


/*
* update record into database
* @param string table name
* @param string set fields
* @param string where conditions
* @return true or false
*/
function update($table, $set_value, $where_clause, $execute)
{
	global $db;

	$sql = "UPDATE ".$table." SET ".$set_value." ".$where_clause."";

	//echo $sql;
	$prepare_sql = $db->prepare($sql);
	if($prepare_sql->errorCode() == 0) {
		$prepare_sql->execute($execute);
		$errors = $prepare_sql->errorInfo();
		/*echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';*/
		return true;
	} else {
		$errors = $prepare_sql->errorInfo();
		/*echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';
		die();*/
		return false;
	}
}


/*
* delete record from database
* @param string table name
* @param string where conditions
* @return true or false
*/
function delete($table, $where_clause)
{
	global $db;

	$sql = "DELETE FROM ".$table." ".$where_clause."";
	$prepare_sql = $db->prepare($sql);
	$prepare_sql->execute();

	return true;
}


	/*function Send_HTML_Mail($mail_to, $mail_from, $mailcc, $mail_subject, $mail_body)
	{
		$mail_From_Name = $mail_from;
		if($mail_from == DOMAIN_NAME)
		{			
            $mail_From_Name = DOMAIN_NAME;
		}
		$mail_Headers  = "MIME-Version: 1.0\n";
		$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//$mail_Headers .= "To: ${mail_To}\n";
		$mail_Headers .= "From:${mail_From_Name}\n";
		if($mailcc != '')
		{
			$mail_Headers .= "Cc: ${mail_CC}\n";
		}
		if(mail($mail_to, $mail_subject, $mail_body, $mail_Headers))
		{			
			return true;
		}
		else
		{        	
			return false;
		}
	}*/
	function Send_HTML_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body)
	{
		$mail=new PHPMailer();
		$mail->CharSet = 'UTF-8';
		

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host="mail.example.net"; // specify main and backup server or localhost
		$mail->SMTPAuth=true; // turn on SMTP authentication
		$mail->Username="noreply@example.net"; // SMTP username
		$mail->Password="******"; // SMTP password
		//It should be same as that of the SMTP user
		$mail->From=$mail->Username; //Default From email same as smtp user
		$mail->FromName=$mail_From;
		if(stripos($mail_To, ','))
		{
			$emailArr=explode(',',$mail_To);
			foreach($emailArr AS $emailVal) {
			$mail->AddAddress($emailVal, ""); //Email address where you wish to receive/collect those emails.
			}
		}else
		{
			$mail->AddAddress($mail_To, "");
		}
		
		if($mail_CC!='') {
		$emailCcArr = explode(',',$mail_CC);
			foreach($emailCcArr AS $emailVal) 
			{
			$mail->AddCC($mail_CC, "");
			}
		}
		//earthtechnology10@gmail.com
		$mail_BCC ='';
		if($mail_BCC!='') {
		$emailBccArr = explode(',',$mail_BCC);
			foreach($emailBccArr AS $emailVal)
			{
			$mail->AddBCC($emailVal, ""); //Email address where you wish to receive/collect those emails.
			}
		}
		$mail->WordWrap=100; // set word wrap to 50 characters
		$mail->IsHTML(true); // set email format to HTML
		$mail->Subject=$mail_subject;
		$message=$mail_Body;
		$mail->Body=$message;

		$mail->Send();
	}

    /* Mail Attachment */

	
	function logout()
	{
		if(count($_SESSION))
		{
			foreach($_SESSION AS $key=>$value)
			{
				session_unset($_SESSION[$key]);
			}
			//header("Location: ".DOMAIN_NAME.'index.php');
			session_destroy();
		}
	}
	
	function redirect($url){
		echo "<script>window.location.href='".$url."'</script>";
	}

?>