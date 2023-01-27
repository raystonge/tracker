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
class AssetToTicket
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetToTicketId;
var $assetId;
var $ticketId;
var $numRows;

var $orderBy;

var $className="AssetToTicket";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->assetToTicketId = 0;
    $this->assetId = 0;
    $this->ticketId = 0;
    $this->numRows = 0;
    $this->orderBy = "assetToTicketId asc";
  }
  function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }

  function Count($param)
  {
    DebugText($this->className."[Count]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $query = "select count(*) as numRows from assetToTicket";
    if (strlen($param))
    {
      $query = $query." where ".$param;
    }
    $results = mysqli_query($link_cms,$query);
    DebugText($query);
    DebugText("Error:".mysqli_error($link_cms));
    $this->numRows = 0;
    if ($row = mysqli_fetch_array($results))
    {
      $this->numRows = $row['numRows'];
    }
    DebugText("numRows:".$this->numRows);
    return($this->numRows);
  }
  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from assetToTicket";
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
	    $this->assetToTicketId = $this->row['assetToTicketId'];
	    $this->assetId = $this->row['assetId'];
	    $this->ticketId = $this->row['ticketId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->assetToTicketId);
  }
  function GetByTicket($id)
  {
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "ticketId = $id";
	 return($this->Get($param));

  }
  function GetByAsset($id)
  {
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetId = $id";
	 return($this->Get($param));

  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetToTicketId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update assetToTicket set assetId=$this->assetId,ticketId=$this->ticketId where assetToTicketId = $this->assetToTicketId";
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
	 $query = "Insert into assetToTicket (assetId,ticketId) value ($this->assetId,$this->ticketId)";
     $results = mysqli_query($link_cms,$query);
     $this->assetToTicketId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete()
  {
	 DebugText($this->className."[Delete]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToTicket where assetToTicketId=$this->assetToTicketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToTicket where assetId=$this->assetId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
