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
class AssetToSpec
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetToSpecId;
var $assetId;
var $specId;
var $specValue;
var $numRows;

var $orderBy;

var $className="AssetToSpec";
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
  function init()
  {
    $this->assetToSpecId = 0;
    $this->assetId = 0;
    $this->specId = 0;
    $this->specValue = "";
    $this->numRows = 0;
    $this->orderBy = "assetToSpecId asc";
  }


  function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }
  function Get($param = "")
  {
    DebugText($this->className."[Get]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  $query = "Select * from assetToSpec";
	  if ($param)
	  {
      $query = $query . " where ". $param;
	  }
	  $query = $query . " order by ".$this->orderBy;
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
     DebugText("Getting Next record");
	    $this->assetToSpecId = $this->row['assetToSpecId'];
	    $this->assetId = $this->row['assetId'];
	    $this->specId = $this->row['specId'];
	    $this->specValue = trim(stripslashes($this->row['specValue']));
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("specValue:".$this->specValue);
	 DebugText("assetToSpecId:".$this->assetToSpecId);
   return($this->assetToSpecId);
  }


  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetToSpecId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $specValue = prepForDB("assetToSpec","specValue",$this->specValue);
	  $query = "Update assetToSpec set assetId=$this->assetId,specId=$this->specId, specValue='$specValue' where assetToSpecId = $this->assetToSpecId";
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
    $specValue = prepForDB("assetToSpec","specValue",$this->specValue);
	  $query = "Insert into assetToSpec (assetId,specId,specValue) value ($this->assetId,$this->specId,'$specValue')";
    $results = mysqli_query($link_cms,$query);
    $this->assetToSpecId = mysqli_insert_id($link_cms);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Persist()
  {
    DebugText($this->className."[Persist]");
    if ($this->assetToSpecId)
    {
      $this->Update();
    }
    else {
      $this->Insert();
    }
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToSpec where assetId=$this->assetId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete()
  {
	 DebugText($this->className."[Delete]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToSpec where assetToSpecId=$this->assetToSpecId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function LicensesInUse($assetId)
  {
	 DebugText($this->className."[LicensesInUse($assetId)]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$param = AddEscapedParam("","assetId",$assetId);
  	$query = "select count(*) as numRows from assetToSpec";
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
  function AssetAssigned($assetId)
  {
    DebugText($this->className."[AssetAssigned($assetId)]");
    $param1 = AddEscapedParam("","assetId",$assetId);
    $param2 = AddEscapedParam("","specId",$assetId);
    $param = $param1." or ".$param2;
    return ($this->Get($param));
  }
}
?>
