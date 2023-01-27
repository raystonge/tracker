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
include_once "tracker/userToGroup.php";
include_once "tracker/set.php";
class Permission
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $permissionId;
var $name;
var $developer;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Permission";
  function init()
  {
    $this->permissionId = 0;
	$this->name = "";
	$this->developer = 0;
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
  	$query = "select count(*) as numRows from permission";
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

	 $query = "Select * from permission";
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

	 $query = "Select * from permission";
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

  function Next()
  {
	 DebugText($this->className."[Next]");
	 if ($this->row = mysqli_fetch_array($this->results))
	 {
	    $this->permissionId = $this->row['permissionId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->developer = $this->row['developer'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->permissionId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "permissionId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $name = trim(mysqli_real_escape_string($link_cms,$this->name));
	 $query = "Update permission set name='$name',developer=$this->developer where permissionId = $this->permissionId";
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
	 $name = trim(mysqli_real_escape_string($link_cms,$this->name));
	 $query = "Insert into permission (name,developer) value ('$name',$this->developer)";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->permissionId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->permissionId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  	return ($this->permissionId);
  }
  function hasPermission($action,$organizationId=0,$userId=0)
  {

  	DebugText($this->className."[hasPermission($action,$organizationId,$userId)]");
  //	return(1);
  	if ($userId == 0)
  	{
  		DebugText("need to use session value");
  		if (isset($_SESSION['userId']))
  		{
  			$userId = $_SESSION['userId'];
  			DebugText("getting session userId:".$userId);
  		}
  	}
  	global $link_cms;
  	global $database_cms;
  	global $checkDeveloper;

  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$param = AddEscapedParam("","name",$action);
  	$this->Get($param);
  	$this->name=$action;
  	$this->Persist();
  	DebugText("Action:".$action);
  	DebugText("Edit Position:".strpos($action,"Edit"));
  	if (strpos($action,"Edit") > 0)
  	{
  		$newAction = str_ireplace("Edit", "View", $action);
  		DebugText("newAction:".$newAction);
  		$param = AddEscapedParam("","name",$newAction);
  		$this->Get($param);
  		$this->name=$newAction;
  		$this->Persist();
  	}
  	if (!isset($_SESSION['userId']))
  	{
  		return(0);
  	}
  	$query = "Select * from permission p inner join userGroupToPermission ugp on p.permissionId=ugp.permissionId";
  	$param = AddEscapedParam("","p.name",$action);
  	if ($checkDeveloper)
  	{
  		$param = "(".$param . " or (p.name='Developer' ))";
  	}
  	$useSessionInfo = 0;
  	if (isset($_SESSION['userGroups']) && ($userId == $_SESSION['userId']) )
  	{
  		if ($_SESSION['userGroups'] != 0)
  		{
  			$useSessionInfo = 1;
  		}

  	}
  	DebugText("useSessionInfo:".$useSessionInfo);
  	if ($useSessionInfo)
  	{
  		$param = $param." and ugp.userGroupId in (".$_SESSION['userGroups'].")";
  	}
  	else
  	{
  		$userToGroup = new UserToGroup();
  		$userGroups = new Set(",");
  		$ok = $userToGroup->Get("userId=".$userId);
  		while($ok)
  		{
  			$userGroups->Add($userToGroup->userGroupId);
  			$ok = $userToGroup->Next();
  		}
  		if (strlen($userGroups->data)==0)
  		{
  			$userGroups->Add(0);
  		}
  		if ($userId == $_SESSION['userId'])
  		{
  			$_SESSION['userGroups'] = $userGroups->data;
  		}
  		$param = $param." and ugp.userGroupId in (".$userGroups->data.")";

  	}

  	if ($organizationId)
  	{
  		$param = $param." and ugp.organizationId=".$organizationId;
  	}

  	$query = $query." where ".$param;
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	//DebugText("numrows:".mysqli_num_rows($results));
  	if (mysqli_num_rows($results))
  	{
  		return (1);
  	}
  	$query = "Select * from permission p inner join userToPermission up on p.permissionId=up.permissionId";
  	$param = AddEscapedParam("","p.name",$action);
  	$param = AddEscapedParam($param,"up.userId",$userId);
  	if ($checkDeveloper)
  	{
  		$param = "(".$param . " or p.name='Developer'and up.userId=".$_SESSION['userId'].")";

  	}
  	$query = $query." where ".$param;
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	DebugText("numrows:".mysqli_num_rows($results));
  	if (mysqli_num_rows($results))
  	{
  		return (1);
  	}

  	return (0);

  }

}
?>
