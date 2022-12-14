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
	 DebugText($this->className."[Get]");
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
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }
  function Next()
  {
	 DebugText($this->className."[Next]");
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
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userToOrganizationId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update userToOrganization set userId=$this->userId,organizationId=$this->organizationId where userToOrganizationId = $this->userToOrganizationId";
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
	 $query = "Insert into userToOrganization (userId,organizationId) value ($this->userId,$this->organizationId)";
     $results = mysqli_query($link_cms,$query);
     $this->userToOrganizationId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from userToOrganization where userId=$this->userId";
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
	 $query = "Delete from userToOrganization where $param";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
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