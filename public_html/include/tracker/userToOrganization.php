<?php
//
//  Tracker - Version 1.11.0
//
//  -v1.11.0
//     -adding a level to reduce the amout of debug text
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
class UserToOrganization
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

var $userToOrganizationId;
var $userId;
var $organizationId;

var $orderBy;

var $className="UserToOrganization";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->userToOrganizationId = 0;
    $this->userId = 0;
    $this->organizationId = 0;
    $this->numRows = 0;
    $this->orderBy = "userToOrganizationId asc";
  }
  function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }
  function Get($param = "")
  {
     DebugText($this->className."[Get]",3);
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  $query = "Select * from userToOrganization";
	  if ($param)
	  {
	    $query = $query . " where ". $param;
	  }
	  $query = $query . " order by ".$this->orderBy;
    $this->results = mysqli_query($link_cms,$query);
    $this->numRows = mysqli_num_rows($this->results);
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
	  return($this->Next());
  }
  function Next()
  {
    DebugText($this->className."[Next]",3);
	  if ($this->row = mysqli_fetch_array($this->results))
	  {
	     $this->userToOrganizationId = $this->row['userToOrganizationId'];
	     $this->userId = $this->row['userId'];
	     $this->organizationId = $this->row['organizationId'];
	  }
	  else
	  {
	    $this->init();
	  }
   return($this->userToOrganizationId);
  }
  function GetById($id)
  {
     DebugText($this->className."[GetById]",3);
	   if (!is_numeric($id))
	   {
	     return;
	   }
	   $param = "userToOrganizationId = $id";
	   return($this->Get($param));
  }
  function Update()
  {
     DebugText($this->className."[Update]",3);
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	   $query = "Update userToOrganization set userId=$this->userId,organizationId=$this->organizationId where userToOrganizationId = $this->userToOrganizationId";
     $results = mysqli_query($link_cms,$query);
	   DebugText($query,3);
	   DebugText("Error:".mysqli_error($link_cms),3);
  }
  function Insert()
  {
     DebugText($this->className."[Insert]",3);
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	   $query = "Insert into userToOrganization (userId,organizationId) value ($this->userId,$this->organizationId)";
     $results = mysqli_query($link_cms,$query);
     $this->userToOrganizationId = mysqli_insert_id($link_cms);
	   DebugText($query,3);
	   DebugText("Error:".mysqli_error($link_cms),3);
  }
  function Reset()
  {
    DebugText($this->className."[Reset]",3);
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from userToOrganization where userId=$this->userId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
  }
  function Delete($param)
  {
    DebugText($this->className."[Delete($param)]",3);
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from userToOrganization where $param";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
  }

  function IsMember($userId,$group)
  {
  	$userGroup = new UserGroup();
  	$param = AddEscapedParam("","name",$group);
  	$userGroup->Get($param);
  	$userToOrganization = new UserToOrganization();
  	$param = "userId=".$userId." and organizationId=".$userGroup->organizationId;
  	return $userToOrganization->Get($param);
  }
}
?>
