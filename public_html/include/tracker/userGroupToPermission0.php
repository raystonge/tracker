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
class UserGroupToPermission
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $userGroupToPermissionId;
var $permissionId;
var $userGroupId;
var $organizationId;

var $orderBy;

var $className="UserGroupToPermission";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->userGroupToPermissionId = 0;
    $this->userGroupId = 0;
    $this->permissionId = 0;
    $this->organizationId = 0;
    $this->orderBy = "userGroupToPermissionId asc";
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

	 $query = "Select * from userGroupToPermission";
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
	    $this->userGroupToPermissionId = $this->row['userGroupToPermissionId'];
	    $this->userGroupId = $this->row['userGroupId'];
	    $this->permissionId = $this->row['permissionId'];
	    $this->organizationId = $this->row['organizationId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->userGroupToPermissionId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userGroupToPermissionId = $id";
	 return($this->Get($param));

  }

  function Insert()
  {
	 DebugText($this->className."[Insert]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Insert into userGroupToPermission (permissionId,userGroupId,organizationId) value ($this->permissionId,$this->userGroupId,$this->organizationId)";
     $results = mysqli_query($link_cms,$query);
     $this->userGroupToPermissionId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from userGroupToPermission where userGroupId=$this->userGroupId";
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
	 $query = "Delete from userGroupToPermission where $param";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
