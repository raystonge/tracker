<?php
include_once "tracker/userGroup.php";
class UserToGroup
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $userToGroupId;
var $userId;
var $userGroupId;

var $orderBy;

var $className="UserToGroup";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->userToGroupId = 0;
    $this->userId = 0;
    $this->userGroupId = 0;
    $this->orderBy = "userToGroupId asc";  	
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

	 $query = "Select * from userToGroup";
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
	    $this->userToGroupId = $this->row['userToGroupId'];
	    $this->userId = $this->row['userId'];
	    $this->userGroupId = $this->row['userGroupId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->userToGroupId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userToGroupId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update userToGroup set userId=$this->userId,userGroupId=$this->userGroupId where userToGroupId = $this->userToGroupId";
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
	 $query = "Insert into userToGroup (userId,userGroupId) value ($this->userId,$this->userGroupId)";
     $results = mysqli_query($link_cms,$query);
     $this->userToGroupId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from userToGroup where userId=$this->userId";
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
	 $query = "Delete from userToGroup where $param";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  
  function IsMember($userId,$group)
  {
  	$userGroup = new UserGroup();
  	$param = AddEscapedParam("","name",$group);
  	$userGroup->Get($param);
  	$userToGroup = new UserToGroup();
  	$param = "userId=".$userId." and userGroupId=".$userGroup->userGroupId;
  	return $userToGroup->Get($param);
  }
}
?>