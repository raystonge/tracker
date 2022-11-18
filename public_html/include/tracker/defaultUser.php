<?php
class DefaultUser
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $defaultUserId;
var $userId;
var $queueId;
var $userType;

var $orderBy;

var $className="DefaultUser";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->defaultUserId = 0;
    $this->userType = "";
    $this->userId = 0;
    $this->queueId = 0;
    $this->orderBy = "defaultUserId asc";
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

	 $query = "Select * from defaultUser";
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
	    $this->defaultUserId = $this->row['defaultUserId'];
	    $this->userId = $this->row['userId'];
	    $this->queueId = $this->row['queueId'];
	    $this->userType = stripslashes(trim($this->row['userType']));
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->defaultUserId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "defaultUserId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $userType = trim(mysqli_real_escape_string($link_cms,$this->userType));
	 $query = "Update defaultUser set userId=$this->userId,queueId=$this->queueId where defaultUserId = $this->defaultUserId";
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
     $userType = trim(mysqli_real_escape_string($link_cms,$this->userType));
	 $query = "Insert into defaultUser (userType,userId,queueId) value ('$userType',$this->userId,$this->queueId)";
     $results = mysqli_query($link_cms,$query);
     $this->defaultUserId = mysqli_insert_id($link_cms);
     
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset($queueId)
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from defaultUser where queueId=$queueId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>