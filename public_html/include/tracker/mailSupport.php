<?php
/*
 * Created on Dec 2, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/set.php";

function TicketNotice($to,$cc,$subject,$message,$link,$historyArray,$requestor="")
{
	global $sendEmails;
	global $sendersEmail;
	$message = $message."\r\n\r\n".$link;
	DebugText("TicketNotice($to,$cc,$subject,$message,$link,historyArray,$requestor)");
	if (!$sendEmails)
	{
		return;
	}
	DebugText("sendersEmail:".$sendersEmail);
	DebugText("to:".$to);
	DebugText("cc:".$cc);
/*
	$headers = 'From: systems@villagesoup.com' . "\r\n" ;
	$headers = $headers.'"CC: '.$cc.'"'.
    'Reply-To: systems@villagesoup.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	DebugText("headers:".$headers);
	$headers[] = 'MIME-Version: 1.0';
*/

//	$headers[] = 'Content-type: text/html; charset=iso-8859-1';

	// Additional headers
//	$headers[] = 'To:'.$to;
	$headers[] = 'From: '.$sendersEmail;
	//$headers[] = 'Cc: '.$cc;
//	print_r($headers);
//	$headers[] = 'Bcc: birthdaycheck@example.com';
//	return;
	//if (mail($to,$subject,$message,$headers))
    $addresses = new Set(",");
	$addresses->data = $cc;
	$addresses->Add($to);
	if (strlen($requestor))
	{
	    $addresses->Add($requestor);
	}
	DebugText("addresses:".$addresses->data);
	$addList = explode(",",$addresses->data);
	$numAddr = sizeof($addList);
	for ($i = 0; $i < $numAddr; $i++)
	{
		$to = $addList[$i];

 	  if (mail($to,$subject,$message,implode("\r\n", $headers)))
	  {
		  DebugText("mail send successfully to ".$to);
	  }
	  else
	  {
		 DebugText("mail send failed to ".$to);
	  }
	}

}
?>
