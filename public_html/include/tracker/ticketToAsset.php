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
class TicketToAsset
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $ticketToAssetId;
var $ticketId;
var $assetId;

var $orderBy;

var $className="TicketToAsset";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->ticketToAssetId = 0;
    $this->ticketId = 0;
    $this->assetId = 0;
    $this->orderBy = "ticketToAssetId asc";

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

	 $query = "Select * from ticketToAsset";
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
	    $this->ticketToAssetId = $this->row['ticketToAssetId'];
	    $this->ticketId = $this->row['ticketId'];
	    $this->assetId = $this->row['assetId'];
	 }
	 else
	 {
	   $this->init();;
	 }
     return($this->ticketToAssetId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "ticketToAssetId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update ticketToAsset set ticketId=$this->ticketId,assetId=$this->assetId where ticketToAssetId = $this->ticketToAssetId";
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
	 $query = "Insert into ticketToAsset (ticketId,assetId) value ($this->ticketId,$this->assetId)";
     $results = mysqli_query($link_cms,$query);
     $this->ticketToAssetId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from ticketToAsset where ticketId=$this->ticketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
