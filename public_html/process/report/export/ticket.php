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
include_once "tracker/user.php";
include_once "tracker/poNumber.php";
include_once "tracker/status.php";
include_once "tracker/queue.php";
include_once "tracker/module.php";
include_once "tracker/priority.php";

$moduleId = $_GET["id"];
$module = new Module($moduleId);
$reportFname = $module->name;
$reportFname = str_replace(" ","_",$reportFname);
$reportData = "";
$reportData = $reportData.'"Ticket Id",';
$reportData = $reportData.'"Subject",';
$reportData = $reportData.'"Queue",';
$reportData = $reportData.'"Creator",';
$reportData = $reportData.'"Owner",';
$reportData = $reportData.'"Requestor",';
$reportData = $reportData.'"Create Date",';
$reportData = $reportData.'"Priority",';
$reportData = $reportData.'"Insurance Repair",';
$reportData = $reportData.'"Repair Cost",';
$reportData = $reportData.'"Insurance Repair Complete",';
$reportData = $reportData.'"Insurance Payment",';
$reportData = $reportData.'"PO Number",';
$reportData = $reportData.'"Due Date",';
$reportData = $reportData.'"Time Estimate",';
$reportData = $reportData.'"Time Worked",';
$reportData = $reportData."\n";

$param = $module->GetParam();
$ticket = new Ticket();
$mm_type = "text/csv";

$ok = $ticket->Get($param);
while ($ok)
{
	$creator = new User($ticket->creatorId);
	$owner = new User($ticket->ownerId);
	$requestor = new User($ticket->requestorId);
	$status = new Status($ticket->statusId);
	$queue = new Queue($ticket->queueId);
	$po = new poNumber($ticket->poNumberId);
	$priority = new Priority($ticket->priorityId);
	$reportData = $reportData.'"'.$ticket->ticketId.'",';
	$reportData = $reportData.'"'.$ticket->subject.'",';
	$reportData = $reportData.'"'.$queue->name.'",';
	$reportData = $reportData.'"'.$creator->fullName.'",';
	$reportData = $reportData.'"'.$owner->fullName.'",';
	$reportData = $reportData.'"'.$requestor->fullName.'",';
	$reportData = $reportData.'"'.$ticket->createDate.'",';
	$reportData = $reportData.'"'.$priority->name.'",';
	$reportData = $reportData.'"'.$ticket->insuranceRepair.'",';
	$reportData = $reportData.'"'.$ticket->repairCost.'",';
	$reportData = $reportData.'"'.$ticket->insuranceRepairComplete.'",';
	$reportData = $reportData.'"'.$ticket->insurancePayment.'",';
	$reportData = $reportData.'"'.$po->poNumber.'",';
	$reportData = $reportData.'"'.$ticket->dueDate.'",';
	$reportData = $reportData.'"'.$ticket->timeEstimate.'",';
	$reportData = $reportData.'"'.$ticket->timeWorked.'",';
	$reportData = $reportData."\n";
	$ok = $ticket->Next();
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: " . $mm_type);
header("Content-Length: " .(string)(sizeof($reportData)) );
header('Content-Disposition: attachment; filename="'.$reportFname.'"');
header("Content-Transfer-Encoding: binary\n");
echo $reportData;

?>
