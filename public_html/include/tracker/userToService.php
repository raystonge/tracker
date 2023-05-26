<?php
//
//  Tracker - Version 1.9.0
//
//  v1.9.0
//   - added a Delete and Persit function
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
//  See the License for the specific language governing services and
//  limitations under the License.
//
?>
<?php
class UserToService
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $userToServiceId;
var $userId;
var $serviceId;
var $adminAccess;


var $orderBy;

var $className="UserToService";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->userToServiceId = 0;
    $this->userId = 0;
    $this->serviceId = 0;
    $this->adminAccess = 0;
    $this->orderBy = "userToServiceId asc";
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

	 $query = "Select * from userToService";
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
	    $this->userToServiceId = $this->row['userToServiceId'];
	    $this->userId = $this->row['userId'];
	    $this->serviceId = $this->row['serviceId'];
      $this->adminAccess = $this->row['adminAccess'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->userToServiceId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userToServiceId = $id";
	 return($this->Get($param));

  }
  function Persist()
  {
    if (!$this->userToServiceId)
    {
      return($this->Insert());
    }
    return ($this->userToServiceId);
  }

  function Insert()
  {
    DebugText($this->className."[Insert]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Insert into userToService (userId,serviceId,adminAccess) value ($this->userId,$this->serviceId,$this->adminAccess)";
    $results = mysqli_query($link_cms,$query);
    $this->userToServiceId = mysqli_insert_id($link_cms);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
    DebugText($this->className."[Reset]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from userToService where userId=$this->userId";
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
	  $query = "Delete from userToService where userToServiceId=$this->userToServiceId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
