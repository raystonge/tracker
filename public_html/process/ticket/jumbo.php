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
include_once "tracker/ticket.php";
include_once "tracker/mailSupport.php";
include_once "tracker/history.php";
$param = "";
ProperAccessValidate();
$tickets = new Set(",");
  $searchQueueId = GetTextField("searchQueueId",0);
  $searchPriorityId = GetTextField("searchPriorityId",0);
  $searchOwnerId = GetTextField("searchOwnerId",0);
  $searchRequestorId = GetTextField("searchRequestorId",0);
  $searchStatusId = GetTextField("searchStatusId",0);

  $ticket = new Ticket();
  $param = "";
  if ($searchQueueId)
  {
  	$param = AddEscapedParam($param,"queueId",$searchQueueId);
  }

  if ($searchPriorityId)
  {
  	$param = AddEscapedParam($param,"priorityId",$searchPriorityId);
  }
  if ($searchRequestorId)
  {
  	$param = AddEscapedParam($param,"requestorId",$searchRequestorId);
  }
  if ($searchOwnerId)
  {
  	$param = AddEscapedParam($param,"ownerId",$searchOwnerId);
  }
  if ($searchStatusId)
  {
  	if ($searchStatusId == -1)
  	{
  		$param = AddParam($param,"statusId <> 4");
  	}
  	else
  	{
  		$param = AddEscapedParam($param,"statusId",$searchStatusId);
  	}
  }
$ok = $ticket->Get($param);
while ($ok)
{
	$field = "ticket".$ticket->ticketId;
	if (isset($_POST[$field]))
	{

		$tickets->Add($ticket->ticketId);
	}
	$ok = $ticket->Next();
}
$_SESSION['ticketJumbo'] = $tickets->data;
DebugPause("/ticketJumbo/");
?>
