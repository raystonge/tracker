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
include_once "tracker/userGroup.php";
class SpecToAssetType
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;
var $numRows;

var $specToAssetTypeId;
var $specId;
var $assetTypeId;
var $displayOrder;

var $orderBy;

var $className="SpecToAssetType";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->specToAssetTypeId = 0;
    $this->specId = 0;
    $this->assetTypeId = 0;
    $this->displayOrder = 0;
    $this->numRows = 0;
    $this->orderBy = "specToAssetTypeId asc";
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

	  $query = "Select * from specToAssetType";
	  if ($param)
	  {
	    $query = $query . " where ". $param;
	  }
	  $query = $query . " order by ".$this->orderBy;
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
	    $this->specToAssetTypeId = $this->row['specToAssetTypeId'];
	    $this->specId = $this->row['specId'];
	    $this->assetTypeId = $this->row['assetTypeId'];
      $this->displayOrder = $this->row['displayOrder'];
	  }
	  else
	  {
	    $this->init();
	  }
    return($this->specToAssetTypeId);
  }
  function GetById($id)
  {
    DebugText($this->className."[GetById]");
	  if (!is_numeric($id))
	  {
	    return;
	  }
	  $param = "specToAssetTypeId = $id";
	  return($this->Get($param));
  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Update specToAssetType set specId=$this->specId,assetTypeId=$this->assetTypeId, displayOrder=$this->displayOrder where specToAssetTypeId = $this->specToAssetTypeId";
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
	  $query = "Insert into specToAssetType (specId,assetTypeId,displayOrder) value ($this->specId,$this->assetTypeId,$this->displayOrder)";
    $results = mysqli_query($link_cms,$query);
    $this->specToAssetTypeId = mysqli_insert_id($link_cms);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
    DebugText($this->className."[Reset]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from specToAssetType where specId=$this->specId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete($param)
  {
    DebugText($this->className."[Delete($param)]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from specToAssetType where $param";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
