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

	$headers[] = 'From: '.$sendersEmail;
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
function SendMail($to,$subject,$message)
{
	global $sendEmails;
	global $sendersEmail;	
	DebugText("SendMail($to,,$subject,$message)");
	if (!$sendEmails)
	{
		return;
	}
	$headers[] = 'From: '.$sendersEmail;
	echo $to."\n";
	echo $message."\n";
	return;
	if (mail($to,$subject,$message,implode("\r\n", $headers)))
	{
		DebugText("mail send successfully to ".$to);
	}
	else
	{
	   DebugText("mail send failed to ".$to);
	}
}
?>
