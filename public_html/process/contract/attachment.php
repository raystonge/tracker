<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<?php
include_once "globals.php";
include_once "tracker/contract.php";
include_once "tracker/attachment.php";
include_once "tracker/mimeType.php";
ProperAccessValidate();
$contractId = GetTextField('contractId',0);
$contract = new Contract($contractId);
if (!$contract->contractId)
{
	exit;
}
$attachment = new Attachment();
$mimeType = new MimeType();
$contractId = $contract->contractId;
$isURL = 0;
if (isset($_POST['addUrl']))
{
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
	if (strlen($link))
	{
		$numErrors++;
		$errMsg = $errMsg."<li>No Link specified</li>";
	}
	if ($numErrors == 0)
	{
		$param = AddEscapedParam("","originalName",$originalName);
		$param = AddParam($param,"contractId=".$contractId);
		$attachment->Get($param);
		$attachment->mimeTypeId = $mimeType->mimeTypeId;
		$attachment->originalName = $linkName;
		$attachment->contractId = $contractId;
		$attachment->url = $link;
		$attachemnt->Persist();
		$historyVal = "Added Link: ".$linkName;
		array_push($historyArray,$historyVal);
	}
	else
	{
		$html = "<ul>".$errMsg."</ul>" ;
		$_SESSION['formErrors'] = $html;
		$_SESSION['contractLinkName'] = $linkName;
		$_SESSION['contractLink'] = $link;
		DebugPause("/attachmentContract/".$contractId."/");
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
$param = AddParam($param,"contractId=".$contractId);
$attachment->Get($param);
$attachment->mimeTypeId = $mimeType->mimeTypeId;
$uploadPath = $sitePath."/attachments/contract";
if (is_uploaded_file($fname))
{
	$uploadDir = $uploadPath."/".$contractId;
	@mkdir($uploadDir,0777,true);
	$uploadfile = $uploadPath."/". $contractId."/".$originalName;
	if (move_uploaded_file($fname, $uploadfile))
	{
		$attachment->contractId = $contractId;
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
			$history->contractId = $ticket->contractId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
			$historyVal = array_pop($historyArray);
		}

DebugPause("/contractAttachment/$contractId/");
?>
