<?php
/*
 * Created on Feb 3, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php 
include "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/queue.php";
include_once "tracker/status.php";
include_once "tracker/comment.php";
include_once "tracker/attachment.php";
include_once "tracker/mimeType.php";
include_once "tracker/user.php";
include_once "tracker/ticketCC.php";
include_once "tracker/poNumber.php";
set_time_limit(60000);
$hostname_rt = "localhost";
$database_rt = "rtdb";
$username_rt = "root";
$password_rt = "";
DebugText("hostname_rt:".$hostname_rt);
DebugText("database_rt:".$database_rt);
$link_rt = @mysqli_connect($hostname_rt, $username_rt, $password_rt);// or trigger_error(mysqli_error(),E_USER_ERROR);

$query = "Select * from Tickets where type='ticket' and id>7093";
mysqli_select_db($link_rt,$database_rt);
$results = mysqli_query($link_rt,$query);
while ($row = mysqli_fetch_array($results))
{
	$ticket = new Ticket();
	$ticket->ticketId = $row['id'];
	$ticket->subject = stripcslashes($row['Subject']);
	$ticket->queueId = GetQueue($row['Queue']);
	$ticket->statusId = GetStatus($row['Status']);
	$ticket->createDate = $row['Created'];
	DebugText("compute creator");
	$ticket->creatorId = GetUser($row['Creator']);
	DebugText("compute owner");
	$ticket->ownerId = GetUser($row['Owner']);
	if ($ticket->statusId)
	{
		$ticket->Import();
	}
	AddComments($ticket->ticketId,$row['id']);
	AddAttachments($ticket->ticketId,$row['id']);
	AddCC($ticket->ticketId,$row['id']);
	$ticket->repairCost = GetCustomField($row['id'],6,"Content","");
	$ticket->insuranceRepair = GetCustomField($row['id'],5,"Content","No");
	$ticket->insuranceRepairComplete = GetCustomField($row['id'],3,"Created","");
	$ticket->insurancePayment = GetCustomField($row['id'],2,"Created","");
	$po = GetCustomField($row['id'],7,"Content","");
	if (strlen($po))
	{
		$poNumber = new poNumber();
		$param = AddEscapedParam("","poNumber",$po);
		if (!$poNumber->Get($param))
		{
			$poNumber->poNumber = $po;
			$poNumber->poDate = GetCustomField($row['id'],7,"Created",$today);
			$poNumber->poType = "Ticket";
			$poNumber->Insert();
		}
		$ticket->poNumberId = $poNumber->poNumberId;
	}
	$ticket->Update();
}
function GetCustomField($ticketId,$field,$col,$default)
{
	global $link_rt;
	global $database_rt;
	$user = new User();
	DebugText("GetCustomField($ticketId,$field,$col,$default)");
	$query = "SELECT * FROM rtdb.ObjectCustomFieldValues where ObjectType='RT::Ticket' and ObjectId=".$ticketId." and CustomField=".$field." order by Created";
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	DebugText($query);
	$val = $default;
	while ($row = mysqli_fetch_array($results))
	{
		$val = $row[$col];
	}
	DebugText("returning:".$val);
	return $val;
}
function AddCC($ticketId,$id)
{
	global $link_rt;
	global $database_rt;
	$user = new User();
	DebugText("AddCC($ticketId,$id)");
	$query = "Select * from Transactions where ObjectId=".$id. " and Type in ('Create','Correspond') order by Created";
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_rt));
	
	while ($row = mysqli_fetch_array($results))
	{
		$ticketCC = new TicketCC();
		$ticketCC->ticketId = $ticketId;
		$ticketCC->userId = GetUser($row['NewValue']);
		$user = new User($ticketCC->userId);
		if ($user->active && $user->userId)
		{
			$ticketCC->Insert();
		}
	}
	
}
function AddAttachments($ticketId,$id)
{
	global $link_rt;
	global $database_rt;
	global $sitePath;
	$user = new User();
	DebugText("AddAttachments($ticketId,$id)");
	$query = "Select * from Transactions where ObjectId=".$id. " and Type in ('Create','Correspond') order by Created";
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_rt));
	
	while ($row = mysqli_fetch_array($results))
	{
		$attachmentQuery = "select * from Attachments where TransactionId=".$row['id']." and (ContentType like 'image%' or ContentType like 'application%')";
		$attachmentResults = mysqli_query($link_rt,$attachmentQuery);
		if ($attachmentRow = mysqli_fetch_array($attachmentResults))
		{
			$mimeType = new MimeType();	
			$param = AddEscapedParam("","mimeType",$attachmentRow['ContentType']);
			if (!$mimeType->Get($param))
			{
				$mimeType->mimeType = $attachmentRow['ContentType'];
				$mimeType->name = $attachmentRow['ContentType'];
				$mimeType->handler = "default";
				$mimeType->Insert();
			}
			
			$attachment = new Attachment();
			$attachment->ticketId = $ticketId;
			$attachment->userId = GetUser($attachmentRow['Creator']);
			$attachment->mimeTypeId = $mimeType->mimeTypeId;
			$attachment->originalName = $attachmentRow['Filename'];
			$attachment->Insert();
			$uploadPath = $sitePath."/attachments/ticket";
			$uploadDir = $uploadPath."/".$ticketId;
			@mkdir($uploadDir,0777,true);
			$uploadfile = $uploadPath."/". $ticketId."/".$attachmentRow['Filename'];
			if ($fp = fopen($uploadfile,"wb"))
			{
				fwrite($fp,$attachmentRow['Content']);
				fclose($fp);
			}
		}
	}
}
function AddComments($ticketId,$id)
{
	global $link_rt;
	global $database_rt;
	DebugText("AddComments($ticketId,$id)");
	$user = new User();
	$query = "Select * from Transactions where ObjectId=".$id. " and Type in ('Create','Correspond') order by Created";
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_rt));
	
	while ($row = mysqli_fetch_array($results))
	{
		$attachmentQuery = "select * from Attachments where TransactionId=".$row['id']." and ContentType in ('text/plain','text/html')";
		$attachmentResults = mysqli_query($link_rt,$attachmentQuery);
		DebugText($attachmentQuery);
		DebugText("Error:".mysqli_error($link_rt));
		if ($attachmentRow = mysqli_fetch_array($attachmentResults))
		{
			$comment = new Comment();
			$comment->ticketId = $ticketId;
			$comment->userId = GetUser($attachmentRow['Creator']);
			if (strlen($attachmentRow['Content']))
			{
				$comment->comment = $attachmentRow['Content'];
			}
			else
			{
				if (strlen($attachmentRow['Subject']))
				{
					$comment->comment = $attachmentRow['Subject'];
				}
			}
			DebugText("comment:".$comment->comment);
			$comment->posted = $attachmentRow['Created'];
			$comment->Import();
		}
	}
	DebugText("AddComents Done");
}
function GetUser($id)
{
	global $link_rt;
	global $database_rt;
	$user = new User();
	if (!is_numeric($id))
	{
		return (0);
	}
	$query = "Select * from Users where  id=".$id;
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_rt));
	
	if ($row = mysqli_fetch_array($results))
	{
		$at = "@";
		$email = stripcslashes(trim($row['EmailAddress']));
		$pos = strpos($email,$at);
		if ($pos === false)
		{
			$pos = strpos($row['Name'],$at);
		}
		$startOfEmail = substr($email,0,$pos);
		if (strlen($startOfEmail))
		{
		$param = AddEscapedLikeParam("","email",$startOfEmail);
		DebugText($param);
		if ($user->Get($param))
		{
			return ($user->userId);
		}
		$user->fullName = $row['Name'];
		$user->email = $email;
		$user->active = 0;
		$user->password = "P@\$\$W0rd";
		$user->Insert();
		}
	}
	if ($id == 0)
	{
		$id = 2;
	}
	
	return $user->userId;
}
function GetQueue($id)
{
	global $link_rt;
	global $database_rt;
	$user = new User();
	$query = "Select * from Queues where  id=".$id;
	mysqli_select_db($link_rt,$database_rt);
	$results = mysqli_query($link_rt,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_rt));
	
	if ($row = mysqli_fetch_array($results))
	{
	
	   $queue = new Queue();-
	   $param = AddEscapedParam("","name",$row['Name']);
	   if (!$queue->Get($param))
	   {
		$queue->name = $row['Name'];
		$queue->Insert();
	   }
	}
	return $queue->queueId;
}
function GetStatus($statusName)
{
	$id = 0;
	switch ($statusName)
	{
		case "new" : $id = 1;
		        break;
		case "resolved" : $id = 4;
		        break;
		case "stalled" : $id = 6;
		        break;
		case "open" : $id = 2;
		        break;
		        
	}
	DebugText("status:".$statusName.":".$id);
	return ($id);
}
DebugOutput();
?>