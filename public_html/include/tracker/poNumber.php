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
class poNumber
{
var $initialized = 0;
var $dbhost;
var $dbpoNumber;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $poNumberId;
var $poNumber;
var $description;
var $poDate;
var $poType;
var $organizationId;
var $cost;
var $reconciled;
var $reconciledUserId;
var $reconciledDateTime;
var $receivedDate;
var $receivedUserId;
var $vendorOrderID;
var $vendor;
var $receivedd;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="poNumber";
  function init()
  {
  	global $today;
    $this->poNumberId = 0;
  	$this->poNumber = "";
	  $this->description = "";
  	$this->poDate = $today;
	  $this->poType = "";
	  $this->organizationId = 0;
  	$this->reconciled = 0;
	  $this->reconciledUserId = 0;
  	$this->reconciledDateTime = "";
	  $this->receivedDate = "";
  	$this->receivedUserId = 0;
    $this->cost = 0;
    $this->vendorOrderID = "";
    $this->vendor;
    $this->received = 0;

  	$this->page = 1;
  	$this->start = 0;
	  $this->perPage = 0;
	  $this->orderBy = "poNumber";
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
   // $this->SetOrderBy("poNumber");
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
  function Count($param)
  {
  	DebugText($this->className."[Count]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from poNumber";
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
     $this->start = ($this->page-1)*$this->perPage;
     DebugText("start:".$this->start);
     DebugText("page:".$this->page);
     DebugText("perPage:".$this->perPage);

	 $query = "Select * from poNumber";
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

	 $query = "Select * from poNumber";
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
	    $this->poNumberId = $this->row['poNumberId'];
	    $this->poNumber = trim(stripslashes($this->row['poNumber']));
	    $this->description = trim(stripslashes($this->row['description']));
	    $this->poDate = trim(stripslashes($this->row['poDate']));
	    $this->poType = trim(stripslashes($this->row['poType']));
	    $this->organizationId = $this->row['organizationId'];
	    $this->reconciled = $this->row['reconciled'];
	    $this->reconciledUserId = $this->row['reconciledUserId'];
      $this->cost = $this->row['cost'];
      $this->vendor = trim(stripslashes($this->row['vendor']));
      $this->vendorOrderID = trim(stripslashes($this->row['vendorOrderID']));
	    $this->reconciledDateTime = trim(stripslashes($this->row['reconciledDateTime']));
	    if ($this->reconciledDateTime == "0000-00-00 00:00:00")
	    {
	    	$this->reconciledDateTime = "";
	    }
	    $this->receivedDate = trim(stripslashes($this->row['receivedDate']));
	    if ($this->receivedDate == "0000-00-00 00:00:00")
	    {
	        $this->receivedDate = "";
	    }
	    $this->receivedDate = trim(str_replace("00:00:00", "", $this->receivedDate));
	    $this->receivedUserId = $this->row['receivedUserId'];
      $this->received = $this->row['received'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->poNumberId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "poNumberId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	   DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	   $poNumber = prepForDB("poNumber","poNumber",$this->poNumber);
	   $desc = prepForDB("poNumber","description",$this->description);
	   DebugText("***************");
	   DebugText("poDate before prep".$this->poDate);
     $poDate = prepForDB("poNumber","poDate",$this->poDate);
     DebugText("receivedDate Before:".$this->receivedDate);
     $poReceivedDate = prepForDB("poNumber", "receivedDate", $this->receivedDate);

     DebugText("poDate after prep:".$poDate);
     DebugText("poReceivedDate:".$poReceivedDate);
     DebugText("cost:".$this->cost);
    	// $poType = prepForDB("poNumber","poType",$this->poType);
  	 $poType = prepForDB("poNumber","poType",$this->poType);
     $vendorOrderID = prepForDB("poNumber","vendorOrderID",$this->vendorOrderID);
     $vendor = prepForDB("poNumber","vendor",$this->vendor);
	   $query = "Update poNumber set poNumber='$poNumber', description='$desc',poDate='$poDate', poType='$poType',organizationId=$this->organizationId,cost='$this->cost', receivedDate='$poReceivedDate', receivedUserId = $this->receivedUserId, vendorOrderID='$vendorOrderID', vendor='$vendor', received=$this->received, reconciled=$this->reconciled, reconciledUserId=$this->reconciledUserId,reconciledDateTime='$this->reconciledDateTime' where poNumberId = $this->poNumberId";
     $results = mysqli_query($link_cms,$query);
	   DebugText($query);
	   DebugText("Error:".mysqli_error($link_cms));
  }
  function Insert()
  {
	 DebugText($this->className."[Insert]");
   global $link_cms;
   global $database_cms;
   mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
   $poNumber = prepForDB("poNumber","poNumber",$this->poNumber);
	 $desc = prepForDB("poNumber","description",$this->description);
   DebugText("poDate before prep:".$this->poDate);
	 $poDate = prepForDB("poNumber","poDate",$this->poDate);
   DebugText("poDate after prep:".$poDate);
	 $poType = prepForDB("poNumber","poType",$this->poType);
   $vendorOrderID = prepForDB("poNumber","vendorOrderID",$this->vendorOrderID);
   $vendor = prepForDB("poNumber","vendor",$this->vendor);
   DebugText("cost:".$this->cost);
	 $reconciledDateTime = prepForDB("poNumber","reconciledDateTime",$this->reconciledDateTime);
	 $query = "Insert into poNumber (poNumber,description,poDate,poType,organizationId,reconciled,reconciledUserId,reconciledDateTime,cost,vendorOrderID,vendor,received) value ('$poNumber','$desc','$poDate','$poType',$this->organizationId,$this->reconciled,$this->reconciledUserId,'$reconciledDateTime','$this->cost','vendorOrderID','$vendor',$this->received)";
   $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->poNumberId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->poNumberId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function Reconcile()
  {
  	DebugText($this->className."[Reconcile]");
  	global $link_cms;
  	global $database_cms;
  	global $currentUser;

  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$now = Now();
  	$query = "update poNumber set reconciled=1,reconciledUserId=$currentUser->userId, reconciledDateTime='$now' where poNumberId=$this->poNumberId";
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));

  }
  function Received()
  {
      DebugText($this->className."[Received]");
      global $link_cms;
      global $database_cms;
      global $currentUser;
      $today = Today();

      mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
      $now = Now();
      $query = "update poNumber set received =1, receivedUserId=$currentUser->userId, receivedDate='$today' where poNumberId=$this->poNumberId";
      $results = mysqli_query($link_cms,$query);
      DebugText($query);
      DebugText("Error:".mysqli_error($link_cms));

  }

}
?>
