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
class Ticket
{
var $initialized = 0;

var $creatorId;
var $ownerId;
var $requestorId;
var $statusId;
var $queueId;
var $subject;
var $insurancePayment;
var $insuranceRepair;
var $insuranceRepairComplete;
var $createDate;
var $dueDate;
var $priorityId;
var $timeEstimate;
var $timeWorked;
var $description;
var $repairCost;
var $poNumberId;
var $lastUpdated;
var $organizationId;
var $assetPOId;
var $dateCompleted;
var $billable;
var $duplicateId;

var $results;
var $row;

var $ticketId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Ticket";
  function init()
  {
  	global $now;
    $this->ticketId = 0;
	$this->subject = "";
	$this->creatorId = GetTextFromSession("userId",0,0);
	$this->requestorId = GetTextFromSession("userId",0,0);
	$this->ownerId = GetTextFromSession("userId",0,0);
	$this->queueId = 0;
	$this->statusId = 1;
	$this->insuranceRepair = "";
	$this->insuranceRepairComplete = "";
	$this->insurancePayment = "";
	$this->createDate = $now;
	$this->lastUpdate = $now;
	$this->dueDate ="";
	$this->priorityId = 3;
	$this->timeEstimate =0;
	$this->timeWorked =0;
	$this->repairCost =0;
	$this->poNumberId =0;
	$this->organizationId = 0;
	$this->assetPOId = 0;
	$this->dateCompleted = "";
	$this->description = "";
  $this->billable = 1;
  $this->duplicateId = 0;
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "createDate asc";
  }
  function __construct()
  {
	$a = func_get_args();
    $i = func_num_args();
    if (method_exists($this,$f='__construct'.$i))
    {
    	call_user_func_array(array($this,$f),$a);
    }
    else
    {
    	$this->init();
    }
   // $this->SetOrderBy("subject");
  }
  function __construct0()
  {
    $this->init();
  }

  function __construct1($id)
  {
  	$this->init();
    $this->GetById($id);
  }
  function SetOrderBy($orderBy)
  {
  	$this->orderBy = $orderBy;
  }
  function SetLimit($limit)
  {
  	$this->limit = $limit;
  }
  function SetPage($page)
  {
  	DebugText($this->className."[SetPage($page)]");
  	$this->page = $page;
  	DebugText("Setting Page:".$this->page);
  }
  function SetPerPage($perPage)
  {
  	DebugText($this->className."[SetPerPage($perPage)]");
  	$this->perPage = $perPage;
  	DebugText("Setting perPage:".$this->perPage);
  }
  function ItemsInQueue($queueId)
  {
  	DebugText($this->className."[ItemsInQueue]");
  	global $link_cms;
  	global $database_cms;
  	$param = "";
  	$param = AddEscapedParam($param,"queueId",$queueId);
  	$param = AddParam($param,"statusId not in (4,6)");
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from ticket";
  	if (strlen($param))
  	{
  		$query = $query." where ".$param;
  	}
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	$numRows = 0;
  	if ($row = mysqli_fetch_array($results))
  	{
  		$numRows = $row['numRows'];
  	}
  	return($numRows);

  }
  function Count($param)
  {
  	DebugText($this->className."[Count]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from ticket";
  	if (strlen($param))
  	{
  		$query = $query." where ".$param;
  	}
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	$numRows = 0;
  	if ($row = mysqli_fetch_array($results))
  	{
  		$numRows = $row['numRows'];
  	}
  	return($numRows);
  }

  function Search($param)
  {
	 DebugText($this->className."[Search]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     if (!isnumeric($this->page))
     {
     	$this->page = 1;
     }
     $this->start = ($this->page-1)*$this->perPage;
     DebugText("start:".$this->start);
     DebugText("page:".$this->page);
     DebugText("perPage:".$this->perPage);

	 $query = "Select * from ticket";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
  	 if (strlen($this->orderBy))
	 {
	   $query = $query . " order by ".$this->orderBy;
	 }
	 if ($this->limit > 0)
	 {
	 	$query = $query . " limit ".$this->limit;
	 }
	 if ($this->perPage > 0)
	 {
	 	$query = $query ." limit ".$this->start.",".$this->perPage;
	 }
	 $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }
  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $this->start = ($this->page-1)*$this->perPage;

	 $query = "Select * from ticket";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
  	 if (strlen($this->orderBy))
	 {
	   $query = $query . " order by ".$this->orderBy;
	 }
	 if ($this->limit > 0)
	 {
	 	$query = $query . " limit ".$this->limit;
	 }

	 $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }

  function Next()
  {
	 DebugText($this->className."[Next]");
	 if ($this->row = mysqli_fetch_array($this->results))
	 {
	    $this->ticketId = $this->row['ticketId'];
	    $this->subject = trim(stripslashes($this->row['subject']));
	    $this->description = trim(stripslashes($this->row['description']));
	    $this->queueId = $this->row['queueId'];
	    $this->ownerId = $this->row['ownerId'];
	    $this->requestorId = $this->row['requestorId'];
	    $this->statusId = $this->row['statusId'];
	    $this->priorityId = $this->row['priorityId'];
	    $this->creatorId = $this->row['creatorId'];
	    $this->insurancePayment = $this->row['insurancePayment'];
	    $this->insuranceRepair = $this->row['insuranceRepair'];
	    $this->insuranceRepairComplete = $this->row['insuranceRepairComplete'];
	    $this->repairCost = $this->row['repairCost'];
	    $this->createDate = $this->row['createDate'];
	    $this->lastUpdated = $this->row['lastUpdated'];
	    $this->poNumberId = $this->row['poNumberId'];
	    $this->timeWorked = $this->row['timeWorked'];
	    $this->timeEstimate = $this->row['timeEstimate'];
      $this->billable = $this->row['billable'];
      $this->duplicateId = $this->row['duplicateId'];
      if (strlen($this->duplicateId) == 0)
      {
        $this->duplicateId = 0;
      }
      if (!strlen($this->billable))
      {
        $this->billable = 0;
      }
	    $this->dueDate = $this->row['dueDate'];
	    if ($this->dueDate == "0000-00-00")
	    {
	    	$this->dueDate = "";
	    }
	    if ($this->insurancePayment == "0000-00-00")
	    {
	    	$this->insurancePayment = "";
	    }
	    if ($this->insuranceRepairComplete == "0000-00-00")
	    {
	    	$this->insuranceRepairComplete = "";
	    }
	    $this->dateCompleted = $this->row['dateCompleted'];
	    if ($this->dateCompleted == "0000-00-00")
	    {
	        $this->dateCompleted = "";
	    }
	    $this->organizationId = $this->row['organizationId'];
	    $this->assetPOId = $this->row['assetPOId'];
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("return($this->ticketId)");
     return($this->ticketId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "ticketId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     global $now;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     DebugText("timeWorked:".$this->timeWorked);
     $subject = prepForDB("ticket","subject",$this->subject);
     $poNumberId = $this->poNumberId;
     $repairCost = prepForDB("ticket","repairCost",$this->repairCost);
     $timeEstimate = prepForDB("ticket","timeEstimate",$this->timeEstimate);
     $timeWorked = prepForDB("ticket","timeWorked",$this->timeWorked);
     $dueDate = prepForDB("ticket","dueDate",$this->dueDate);
     $insurancePayment = prepForDB("ticket","insurancePayment",$this->insurancePayment);
     $insuranceRepairComplete = prepForDB("ticket","insuranceRepairComplete",$this->insuranceRepairComplete);
     $assetPOId = prepForDB("ticket", "assetPOId", $this->assetPOId);
     $dateCompleted = prepForDB("ticket","dateCompleted",$this->dateCompleted);

	 $this->createDate = $now;
	 $lastUpdated = $now;
	 $query = "Update ticket set subject='$subject',dueDate='$dueDate',ownerId=$this->ownerId,requestorId=$this->requestorId,statusId=$this->statusId,queueId=$this->queueId,insurancePayment='$insurancePayment',insuranceRepair='$this->insuranceRepair',insuranceRepairComplete='$insuranceRepairComplete',priorityId=$this->priorityId,timeEstimate='$timeEstimate',timeWorked='$timeWorked',repairCost='$repairCost',poNumberId='$poNumberId',lastUpdated='$lastUpdated', organizationId=$this->organizationId, assetPOId=$assetPOId, dateCompleted='$dateCompleted', billable=$this->billable, duplicateId=$this->duplicateId where ticketId = $this->ticketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Insert()
  {
	 DebugText($this->className."[Insert]");
     global $link_cms;
     global $database_cms;
     global $now;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $subject = prepForDB("ticket","subject",$this->subject);
     $dueDate = prepForDB("ticket","dueDate",$this->dueDate);
     $description = prepForDB("ticket","description",$this->description);
     $timeEstimate = prepForDB("ticket", "timeEstimate", $this->timeEstimate);
     $timeWorked = prepForDB("ticket",'timeWorked', $this->timeWorked);
     $repairCost = prepForDB("ticket", "repairCost", $this->repairCost);
     $insurancePayment = prepForDB("ticket", "insurancePayment", $this->insurancePayment);
     $insuranceRepairComplete = prepForDB("ticket","insuranceRepairComplete", $this->insuranceRepairComplete);
     $insuranceRepair = prepForDB("ticket","insuranceRepair",$this->insuranceRepair);
     $assetPOId = prepForDB("ticket", "assetPOId", $this->assetPOId);
     $dateCompleted = prepForDB("ticket","dateCompleted",$this->dateCompleted);

     $poNumberId = $this->poNumberId;
	 $this->createDate = $now;
	 $createDate = $now;
	 $lastUpdated = $now;
   DebugText("timeWorked:".$timeWorked);
   DebugText("timeEstimate:".$timeEstimate);
	 $query = "Insert into ticket (subject,creatorId,ownerId,requestorId,statusId,queueId,createDate,priorityId,poNumberId,insurancePayment,insuranceRepair,insuranceRepairComplete,lastUpdated,organizationId,dueDate,description,timeEstimate,timeWorked,repairCost,assetPOId, dateCompleted,billable, duplicateId) value ('$subject',$this->creatorId,$this->ownerId,$this->requestorId,$this->statusId,$this->queueId,'$createDate',$this->priorityId,$this->poNumberId,'$insurancePayment','$insuranceRepair','$insuranceRepairComplete','$lastUpdated',$this->organizationId,'$dueDate','$description','$timeEstimate',$timeWorked,'$repairCost','$assetPOId', '$dateCompleted',$this->billable,$this->duplicateId)";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->ticketId = mysqli_insert_id($link_cms);
	 DebugText("insert ticketId:".$this->ticketId);
  }
  function Persist()
  {
  	if ($this->ticketId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function Import()
  {
	 DebugText($this->className."[Import]");
     global $link_cms;
     global $database_cms;
     global $now;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $subject = prepForDB("ticket","subject",$this->subject);
     $poNumberId = $this->poNumberId;
     $repairCost = prepForDB("ticket","repairCost",$this->repairCost);
     $timeEstimate = prepForDB("ticket","timeEstimate",$this->timeEstimate);
     $timeWorked = prepForDB("ticket","timeWorked",$this->timeWorked);
     $dueDate = prepForDB("ticket","dueDate",$this->dueDate);
	 $lastUpdated = $now;
	 $createDate = $this->createDate;
	 $query = "Insert into ticket (ticketId,subject,creatorId,ownerId,requestorId,statusId,queueId,createDate,priorityId,poNumberId,insurancePayment,insuranceRepair,insuranceRepairComplete,lastUpdated) value ($this->ticketId,'$subject',$this->creatorId,$this->ownerId,$this->requestorId,$this->statusId,$this->queueId,'$createDate',$this->priorityId,'$poNumberId','$this->insurancePayment','$this->insuranceRepair','$this->insuranceRepairComplete','$lastUpdated') on duplicate key update   subject='$subject',dueDate='$dueDate',ownerId=$this->ownerId,requestorId=$this->requestorId,statusId=$this->statusId,queueId=$this->queueId,insurancePayment='$this->insurancePayment',insuranceRepair='$this->insuranceRepair',insuranceRepairComplete='$this->insuranceRepairComplete',dueDate='$dueDate',priorityId=$this->priorityId,timeEstimate='$timeEstimate',timeWorked='$timeWorked',repairCost='$repairCost',poNumberId='$poNumberId',lastUpdated='$lastUpdated' ";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->ticketId = mysqli_insert_id($link_cms);
	 DebugText("insert ticketId:".$this->ticketId);
  }


  function PrepJumboEditor()
  {
	$this->subject =  "--do_not_change--";
	$this->requestorId =  "--do_not_change--";
	$this->ownerId =  "--do_not_change--";
	$this->queueId =  "--do_not_change--";
	$this->statusId =  "--do_not_change--";
	$this->priorityId = "--do_not_change--";
	$this->poNumberId = "--do_not_change--";
  }
}
?>
