<?php
/*
 * Created on Oct 29, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/attachment.php";
include_once "tracker/mimeType.php";
ProperAccessValidate();
$ticketId = GetTextField('ticketId',0);
$ticket = new Ticket($ticketId);
if (!$ticket->ticketId)
{
	exit;
}
$attachment = new Attachment();
$mimeType = new MimeType();
$ticketId = $ticket->ticketId;
$isURL = 0;
if (isset($_POST['addUrl']))
{
	DebugText("Have URL");
	$param = "mimeType='url'";
	if (!$mimeType->Get($param))
	{
		$mimeType->mimeType = "url";
		$mimeType->name = "url";
		$mimeType->handler = "browser";
		$mimeType->Insert();
	}
	$linkName = GetTextField('linkName');
	$link = GetTextField('link');
	$html = "";
	$numErrors = 0;
	$errMsg = "";
	if (strlen($linkName) == 0)
	{
		$numErrors++;
		$errMsg = $errMsg."<li>No name for link</li>";
	}
	if (strlen($link)==0)
	{
		$numErrors++;
		$errMsg = $errMsg."<li>No Link specified</li>";
	}
	DebugText("$numErrors URL:".$numErrors);
	if ($numErrors == 0)
	{
		$param = AddEscapedParam("","originalName",$linkName);
		$param = AddParam($param,"ticketId=".$ticketId);
		$attachment->Get($param);
		$attachment->mimeTypeId = $mimeType->mimeTypeId;
		$attachment->originalName = $linkName;
		$attachment->ticketId = $ticketId;
		$attachment->url = $link;
		$attachment->Persist();
		$historyVal = "Added Link: ".$linkName;
		array_push($historyArray,$historyVal);
	}
	else
	{
		DebugText("we got errors URL");
		$html = "<ul>".$errMsg."</ul>" ;
		$_SESSION['formErrors'] = $html;
		$_SESSION['ticketLinkName'] = $linkName;
		$_SESSION['ticketLink'] = $link;
		DebugPause("/ticketAttachment/".$ticketId."/");
		exit;
	}
}
else
{
$fname = $_FILES['attachment']['tmp_name'];
$originalName = $_FILES['attachment']['name'];
$mime = $_FILES['attachment']['type'];
$param = AddEscapedParam("","mimeType",$mime);
if (!$mimeType->Get($param))
{
	$mimeType->mimeType = $mime;
	$mimeType->name = $mime;
	$mimeType->handler = "default";
	$mimeType->Insert();
}
$param = AddEscapedParam("","originalName",$originalName);
$param = AddParam($param,"ticketId=".$ticketId);
$attachment->Get($param);
$attachment->mimeTypeId = $mimeType->mimeTypeId;
$uploadPath = $sitePath."/attachments/ticket";
if (is_uploaded_file($fname))
{
	$uploadDir = $uploadPath."/".$ticketId;
	@mkdir($uploadDir,0777,true);
	$uploadfile = $uploadPath."/". $ticketId."/".$originalName;
	if (move_uploaded_file($fname, $uploadfile))
	{
		$attachment->ticketId = $ticketId;
		$attachment->originalName = $originalName;
		$attachment->Persist();
		$historyVal = "Added Attachment: ".$originalName;
		array_push($historyArray,$historyVal);

		DebugText("file moved");
	}
	else
	{
		DebugText("file move failed");
	}

}
}
  		$historyVal = array_pop($historyArray);
		DebugText("sizeof History:".sizeof($historyArray));
		while (strlen($historyVal))
		{
			DebugText("historyVal:".$historyVal);
			$history = new History();
			$history->ticketId = $ticket->ticketId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
			$historyVal = array_pop($historyArray);
		}

DebugPause("/ticketAttachment/$ticketId/");
?>
