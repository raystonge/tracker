<?php
//
//  Tracker - Version 1.3.0
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

include_once "tracker/user.php";
include_once "tracker/ticket.php";
include_once "tracker/status.php";
include_once "tracker/queue.php";
$host = "http://tracker.villagesoup.com";
$user = new User();

$ok = $user->Get("active = 1");
while ($ok)
{
  $param = "statusId not in (4,6)";
  $param = AddEscapedParam($param,"ownerId",$user->userId);
  $param = $param." and dueDate<='".$today."' and dueDate !='0000-00-00'";
  $ticket = new Ticket();
  $hasTickets = $ticket->Get($param);
  $msg = "  <table id='myTickets' class='tablesorter' width='100%'>
                <tr>
                  <th>Ticket</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Requestor</th>
                  <th>Queue</th>
                  <th>Last Updated</th>
                </tr>\n";
  $hasOverDueTickets = 0;
  while ($hasTickets)
  {
    $status = new Status($ticket->statusId);
    $queue = new Queue($ticket->queueId);
    $requestor = new User($ticket->requestorId);
    $msg = $msg."<tr  class='mritem'>
                        <td>
                          <a href='$host/ticketEdit/$ticket->ticketId'>$ticket->ticketId</a>
                        </td>
                        <td>$ticket->subject</td>
                        <td>$status->name</td>
                        <td>$requestor->fullName</td>
                        <td>$queue->name</td>
                        <td>$ticket->lastUpdated</td>
                       </tr>\n";
    $hasOverDueTickets = 1;
    $hasTickets = $ticket->Next();
  }
  $msg = $msg."</table>";
  if ($hasOverDueTickets)
  {
    echo $msg;
    $headers = 'From: '.$sendersEmail. "\r\n";;
    $to = $user->email;
    $subject = "Testing: Priority Tickets";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    if (mail($to,$subject,$msg,$headers))
	  {
		  DebugText("mail send successfully to ".$to);
	  }
	  else
	  {
		 DebugText("mail send failed to ".$to);
	  }
  }
  $ok = $user->Next();
}
?>
