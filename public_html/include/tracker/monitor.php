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
class Monitor
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $monitorId;
var $assetId;
var $ipAddress;
var $state;
var $fqdn;
var $stateChangeDateTime;
var $active;
var $monitorURL;
var $pingAddress;
var $smsNotice;
var $name;
var $whine;
var $monitorType;
var $statusChange;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Monitor";
  function init()
  {
    $this->monitorId = 0;
	$this->assetId = 0;
	$this->ipAddress = "";
	$this->state = 0;
	$this->stateChangeDateTime = "";
	$this->fqdn = "";
	$this->active = 1;
	$this->monitorURL = "";
	$this->pingAddress = "";
	$this->smsNotice = 0;
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "monitorId";
	$this->numRows = 0;
	$this->name = "";
	$this->whine = 0;
	$this->monitorType="";
	$this->statusChange = 0;
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
   // $this->SetOrderBy("name");
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
  	$query = "select count(*) as numRows from monitor";
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

	 $query = "Select * from monitor";
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
	 $this->numRows = mysqli_num_rows ($this->results);
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

	 $query = "Select * from monitor";
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
	 $this->numRows = mysqli_num_rows($this->results);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }

  function Next()
  {
	 DebugText($this->className."[Next]");
	 if ($this->row = mysqli_fetch_array($this->results))
	 {
	    $this->monitorId = $this->row['monitorId'];
	    $this->ipAddress = trim(stripslashes($this->row['ipAddress']));
	    $this->fqdn = trim(stripslashes($this->row['fqdn']));
	    $this->assetId = $this->row['assetId'];
	    $this->state = $this->row['state'];
	    $this->active = $this->row['active'];
	    $this->stateChangeDateTime = $this->row['stateChangeDateTime'];
	    $this->monitorURL = trim(stripslashes($this->row['monitorURL']));
	    $this->pingAddress = trim(stripslashes($this->row['pingAddress']));
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->smsNotice = $this->row['smsNotice'];
	    $this->monitorType = trim(stripslashes($this->row['monitorType']));
	    $this->whine = $this->row['whine'];
		$this->statusChange = $this->row['statusChange'];
	    if (!strlen($this->whine))
	    {
	        $this->whine = 0;
	    }
	    DebugText("whine:".$this->whine);

	 }
	 else
	 {
	   $this->init();
	 }
     return($this->monitorId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById](".$id.")");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "monitorId = $id";
	 return($this->Get($param));

  }
  function UpdateStatus()
  {
	 DebugText($this->className."[UpdateStatus]");
     global $link_cms;
     global $database_cms;
     global $now;
	 $query = "Update monitor set state=$this->state, stateChangeDateTime='$now', statusChange=1 where monitorId = $this->monitorId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function ResetStatus()
  {
	DebugText($this->className."[ResetStatus]");
	global $link_cms;
	global $database_cms;
	global $now;
	$query = "Update monitor set statusChange=0";
	$results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));

  }

  function ResetStateForWhine()
  {
	DebugText($this->className."[ResetStateForWhine]");
	global $link_cms;
	global $database_cms;
	global $now;
	$query = "Update monitor set statusChange=0";
	$results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
  }

  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $ipAddress = prepForDB("monitor", "ipAddress", $this->ipAddress);
	 $fqdn = prepForDB("monitor", "fqdn", $this->fqdn);
     $monitorURL = prepForDB("monitor", "monitorURL", $this->monitorURL);
     $pingAddress = prepForDB("monitor", "pingAddress", $this->pingAddress);
     $smsNotice = prepForDB("monitor", "smsNotice", $this->smsNotice);
     $name = prepForDB("monitor", "name", $this->name);
     $whine = prepForDB("monitor", "whine", $this->whine);
     $monitorType = prepForDB("monitor", "monitorType", $this->monitorType);
	 $query = "Update monitor set ipAddress='$ipAddress',active=$this->active, fqdn='$fqdn',assetId=$this->assetId, monitorURL='$monitorURL', pingAddress='$pingAddress', smsNotice=$smsNotice, name='$name', whine=$whine, monitorType='$monitorType', statusChange=$this->statusChange where monitorId = $this->monitorId";
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
	 $ipAddress = prepForDB("monitor", "ipAddress", $this->ipAddress);
	 $fqdn = prepForDB("monitor", "fqdn", $this->fqdn);
	 $monitorURL = prepForDB("monitor", "monitorURL", $this->monitorURL);
     $pingAddress = prepForDB("monitor", "pingAddress", $this->pingAddress);
     $name = prepForDB("monitor", "name", $this->name);
     $whine = prepForDB("monitor", "whine", $this->whine);
     $monitorType = prepForDB("monitor", "monitorType", $this->monitorType);
	 $query = "Insert into monitor (ipAddress,fqdn,assetId,active,monitorURL,pingAddress,smsNotice,name,whine,monitorType,statusChange) value ('$ipAddress','$fqdn',$this->assetId,$this->active,'$monitorURL','$pingAddress',$this->smsNotice,'$name',$whine,'$monitorType','$this->statusChange')";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->monitorId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->monitorId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function doSelectQuery($query)
  {
	 DebugText($this->className."[doSelectQuery]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $this->results = mysqli_query($link_cms,$query);
	 $this->numRows = mysqli_num_rows($this->results);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());

  }
}
?>
