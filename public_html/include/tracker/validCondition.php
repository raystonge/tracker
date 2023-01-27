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
class ValidCondition
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $validConditionId;
var $currentAssetConditionId;
var $assetConditionId;

var $orderBy;

var $className="ValidCondition";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->validConditionId = 0;
    $this->currentAssetConditionId = 0;
    $this->assetConditionId = 0;
    $this->orderBy = "validConditionId asc";
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

	  $query = "Select * from validCondition";
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
      $this->validConditionId = $this->row['validConditionId'];
	    $this->currentAssetConditionId = $this->row['currentAssetConditionId'];
	    $this->assetConditionId = $this->row['assetConditionId'];
	  }
	  else
	  {
      $this->init();
	  }
    return($this->validConditionId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "validConditionId = $id";
	 return($this->Get($param));

  }
  function GetForCurrentCondition($assetConditionId)
  {
	 DebugText($this->className."[GetForCurrentCondition]");
	 if (!is_numeric($assetConditionId))
	 {
	   return;
	 }
	 $param = "currentAssetConditionId = $assetConditionId";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update validCondition set currentAssetConditionId=$this->currentAssetConditionId,assetConditionId=$this->assetConditionId where validConditionId = $this->validConditionId";
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
	   $query = "Insert into validCondition (currentAssetConditionId,assetConditionId) value ($this->currentAssetConditionId,$this->assetConditionId)";
     $results = mysqli_query($link_cms,$query);
     $this->validConditionId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
    DebugText($this->className."[Reset]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from validCondition where currentAssetConditionId=$this->currentAssetConditionId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
