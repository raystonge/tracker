<?php
include_once "tracker/set.php";
include_once "tracker/userGroup.php";
include_once "tracker/userToGroup.php";
class Module
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $moduleId;
var $name;
var $description;
var $query;
var $userId;
var $admin;
var $moduleType;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Module";
  function init()
  {
    $this->moduleId = 0;
	$this->name = "";
	$this->description = "";
	$this->query = "";
	$this->moduleType = "";
	$this->userId = 0;
	$this->admin = 0;
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "name";
  }
  function __construct()
  {
	$a = func_get_args();
    $i = func_num_args();
    if (method_exists($this,$f='__construct'.$i))
    {
    	call_user_func_array(array($this,$f),$a);
    }
    else
    {
    	$this->init();
    }
   // $this->SetOrderBy("name");
  }
  function __construct0()
  {
    $this->init();
  }

  function __construct1($id)
  {
  	$this->init();
    $this->GetById($id);
  }
  function SetOrderBy($orderBy)
  {
  	$this->orderBy = $orderBy;
  }
  function SetLimit($limit)
  {
  	$this->limit = $limit;
  }
  function SetPage($page)
  {
  	DebugText($this->className."[SetPage($page)]");
  	$this->page = $page;
  	DebugText("Setting Page:".$this->page);
  }
  function SetPerPage($perPage)
  {
  	DebugText($this->className."[SetPerPage($perPage)]");
  	$this->perPage = $perPage;
  	DebugText("Setting perPage:".$this->perPage);
  }
  function Count($param)
  {
  	DebugText($this->className."[Count]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from module";
  	if (strlen($param))
  	{
  		$query = $query." where ".$param;
  	}
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	$numRows = 0;
  	if ($row = mysqli_fetch_array($results))
  	{
  		$numRows = $row['numRows'];
  	}
  	return($numRows);
  }

  function Search($param)
  {
	 DebugText($this->className."[Search]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $this->start = ($this->page-1)*$this->perPage;
     DebugText("start:".$this->start);
     DebugText("page:".$this->page);
     DebugText("perPage:".$this->perPage);

	 $query = "Select * from module";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
  	 if (strlen($this->orderBy))
	 {
	   $query = $query . " order by ".$this->orderBy;
	 }
	 if ($this->limit > 0)
	 {
	 	$query = $query . " limit ".$this->limit;
	 }
	 if ($this->perPage > 0)
	 {
	 	$query = $query ." limit ".$this->start.",".$this->perPage;
	 }
	 $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }
  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $this->start = ($this->page-1)*$this->perPage;

	 $query = "Select * from module";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
  	 if (strlen($this->orderBy))
	 {
	   $query = $query . " order by ".$this->orderBy;
	 }
	 if ($this->limit > 0)
	 {
	 	$query = $query . " limit ".$this->limit;
	 }

	 $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }

  function GetMyVisible()
  {
  	$userId = $_SESSION['userId'];
  	$userGroup = new UserGroup();
  	$param = "name='Admin'";
  	$userGroup->Get($param);
  	$param = "userId=".$userId." and userGroupId=".$userGroup->userGroupId;
  	$userToUserGroup = new UserToGroup();
  	$isAdmin = $userToUserGroup->Get($param);
  	$param = "userId in (0,".$userId.")";

  	if (!$isAdmin)
  	{
  		$param = AddParam($param,"admin=0");
  	}
  	return($this->Get($param));
  }

  function GetMy()
  {
  	$userId = $_SESSION['userId'];
  	$userGroup = new UserGroup();
  	$param = "name='Admin'";
  	$userGroup->Get($param);
  	$param = "userId=".$userId." and userGroupId=".$userGroup->userGroupId;
  	$userToUserGroup = new UserToGroup();
  	$isAdmin = $userToUserGroup->Get($param);
  	$param = "userId in (0,".$userId.")";

  	return($this->Get($param));
  }
  function Next()
  {
	 DebugText($this->className."[Next]");
	 if ($this->row = mysqli_fetch_array($this->results))
	 {
	    $this->moduleId = $this->row['moduleId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->description = trim(stripslashes($this->row['description']));
	    $this->query = trim(stripslashes($this->row['query']));
	    $this->userId = $this->row['userId'];
	    $this->admin = $this->row['admin'];
	    $this->moduleType = trim(stripslashes($this->row['moduleType']));
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->moduleId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById($id)]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "moduleId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $name = prepForDB("module","name",$this->name);
	 $desc = prepForDB("module","name",$this->description);
	 $queryStr = prepForDB("module","name",$this->query);
	 $moduleType = prepForDB("module","name",$this->moduleType);
	 $query = "Update module set name='$name',userId=$this->userId,admin=$this->admin,description='$desc',query='$queryStr',moduleType='$moduleType' where moduleId = $this->moduleId";
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
	 $name = prepForDB("module","name",$this->name);
	 $desc = prepForDB("module","name",$this->description);
	 $queryStr = prepForDB("module","name",$this->query);
	 $moduleType = prepForDB("module","name",$this->moduleType);
	 $query = "Insert into module (name,description,query,userId,admin,moduleType) value ('$name','$desc','$queryStr',$this->userId,$this->admin,'$moduleType')";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->moduleId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->moduleId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function GetParam()
  {
  	global $today;
  	DebugText("GetParam:".$this->query);
  	$overDueDate = date('Y-m-d', strtotime($today. ' + 3 day'));
  	$userId = $_SESSION['userId'];
  	$param = $this->query;
  	$param = str_replace("[currentUser]",$userId,$param);
  	$param = str_replace("[overDueDate]","'$overDueDate'",$param);
  	$param = str_replace("[today]","'$today'",$param);
    $myOrgs = GetMyOrganizations();
    $param = str_replace("[myOrganizations]",$myOrgs,$param);
  	$pos = strpos($param,"[numDays_");
  	if (!($pos === false))
  	{
  		DebugText("pos:".$pos);
  		$pos1 = strpos($param,"]",$pos);
  		$sub = substr($param,$pos,$pos1-$pos+1);
  		$numDays = str_replace("[numDays_","",$sub);
  		$numDays = str_replace("]","",$numDays);
  		$numDays = " + ".$numDays." day";
  		$newDate = "'".date('Y-m-d', strtotime($today. $numDays))."'";
  		$param = str_replace($sub,$newDate,$param);
  	}
  	return $param;

  }
}
?>
