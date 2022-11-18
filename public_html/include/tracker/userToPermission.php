<?php
class UserToPermission
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $userToPermissionId;
var $userId;
var $permissionId;

var $orderBy;

var $className="UserToPermission";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->userToPermissionId = 0;
    $this->userId = 0;
    $this->permissionId = 0;
    $this->orderBy = "userToPermissionId asc";
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

	 $query = "Select * from userToPermission";
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
	    $this->userToPermissionId = $this->row['userToPermissionId'];
	    $this->userId = $this->row['userId'];
	    $this->permissionId = $this->row['permissionId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->userToPermissionId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userToPermissionId = $id";
	 return($this->Get($param));

  }

  function Insert()
  {
	 DebugText($this->className."[Insert]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Insert into userToPermission (userId,permissionId) value ($this->userId,$this->permissionId)";
     $results = mysqli_query($link_cms,$query);
     $this->userToPermissionId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from userToPermission where userId=$this->userId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>