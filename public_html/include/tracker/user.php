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
include_once "tracker/userGroup.php";
include_once "tracker/userToGroup.php";
include_once "tracker/set.php";
class User
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;
var $User_Admin = 10;
var $User_Candidate = 5;
var $User_Developer = 15;


var $results;
var $row;

var $userId;
var $password;
var $email;
var $fullName;
var $initials;
var $lastLogin;
var $active = 1;
var $emailMessage;
var $snsTopic;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className = "User";

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
  function init()
  {
  	$this->userId = 0;
  	$this->password = "";
  	$this->email ="";
  	$this->fullName ="";
    $this->lastLogin="";
    $this->initials="";
    $this->active = 1;
    $this->emailMessage = "";
    $this->snsTopic = "";
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
  }
  function doQuery($query)
  {
      DebugText($this->className."[doQuery]");
      global $link_cms;
      global $database_cms;
      mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
      $this->results = mysqli_query($link_cms,$query);
      DebugText($query);
      DebugText("Error:".mysqli_error($link_cms));
      return($this->Next());
  }
  function Count($param)
  {
	 DebugText($this->className."[Count]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "select count(*) as numRows from users";
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
  	global $link_cms;
  	global $database_cms;
  	DebugText($this->className."[Get]");
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$this->start = ($this->page-1)*$this->perPage;
  	DebugText("start:".$this->start);
  	DebugText("page:".$this->page);
  	DebugText("perPage:".$this->perPage);
  	$query = "Select * from users ";
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

  function GetById($id)
  {
     DebugText($this->className."[GetById]");
	 return ($this->GetUserByID($id));
  }
  function GetUserByID($id)
  {
     global $link_cms;
     global $database_cms;
     DebugText($this->className."[GetUserByID]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from users where userId=$id";
     $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());

  }
  function GetUserByName($userName)
  {
     global $link_cms;
     global $database_cms;
     DebugText($this->className."[GetUserByName]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from users where email='".mysqli_real_escape_string($link_cms,$userName)."'";
     $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }
  function Get($param = "")
  {
     global $link_cms;
     global $database_cms;
     DebugText($this->className."[Get]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from users";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
	 if (strlen($this->orderBy))
	 {
	   $query = $query . " order by ".$this->orderBy;
	 }
   $this->results = mysqli_query($link_cms,$query);
   $this->numRows = mysqli_num_rows($this->results);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return($this->Next());
  }
  function Login($name,$pwd)
  {
     global $link_cms;
     global $database_cms;
	 global $now;
     DebugText($this->className."[Login]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from users where email='".mysqli_real_escape_string($link_cms,$name)."' and password='".md5($pwd)."' and active=1";
     $this->results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 if (!$this->Next())
	 {
	   return(0);
	 }
	 $this->lastLogin = $now;
	 $this->Update();
	 $this->addHistory("Logged in");
	 return($this->userId);
  }
  function GetRequestors($param)
  {
     global $link_cms;
     global $database_cms;
     global $now;
     DebugText($this->className."[GetRequestors]");
     mysqli_select_db($link_cms,$database_cms);   // Reselect to make sure db is selected
     $query = "select distinct u.userId from users u  inner join userToOrganization uto on u.userId=uto.userId";
     if ($param)
     {
       $query = $query . " where  ".$param;
     }
     if (strlen($this->orderBy))
     {
       $query = $query . " order by ".$this->orderBy;
     }
     $this->results = mysqli_query($link_cms,$query);
     $this->numRows = mysqli_num_rows($this->results);
     DebugText($query);
     DebugText("Error:".mysqli_error($link_cms));
     return($this->Next());

  }
  function GetAssignees($param)
  {
     global $link_cms;
     global $database_cms;
     global $now;
     DebugText($this->className."[GetAssignees]");
     mysqli_select_db($link_cms,$database_cms);   // Reselect to make sure db is selected
     $groups = new Set(",");
     $userGroup = new UserGroup();
     $ok = $userGroup->Get("assignee=1");
     while ($ok)
     {
       $groups->Add($userGroup->userGroupId);
       DebugText("assignee Group:".$userGroup->userGroupId);
       $ok = $userGroup->Next();
     }
     if (strlen($groups->data) == 0)
     {
       $groups->Add("0");
     }
     $query = "select * from users u inner join userToGroup utg on u.userId=utg.userId inner join userToOrganization uto on u.userId=uto.userId";
     if ($param)
     {
       $query = $query . " where  u.active=1 and utg.userGroupId in ($groups->data) and ".$param;
     }
     else
     {
       $query = $query .  " where u.active=1 and utg.userGroupId in ($groups->data)";

     }
     $userList = new Set(",");
     $this->results = mysqli_query($link_cms,$query);
     DebugText($query);
     DebugText("Error:".mysqli_error($link_cms));

     while ($this->Next())
     {
       $userList->Add($this->userId);
     }
     $query = "Select * from users where userId in (".$userList->data.")";
     if (strlen($this->orderBy))
     {
       $query = $query . " order by ".$this->orderBy;
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
	    $this->userId = $this->row['userId'];
		DebugText("Found id:".$this->userId);
	    $this->email = trim(stripslashes($this->row['email']));
		//$this->password = trim(stripslashes($this->row['password']));
		$this->fullName = trim(stripslashes($this->row['fullName']));
		$this->lastLogin = $this->row['lastLogin'];
		$this->initials = trim(stripslashes($this->row['initials']));
	    $this->active = $this->row['active'];
	    $this->emailMessage = trim(stripslashes($this->row['emailMessage']));
	    $this->snsTopic = trim(stripslashes($this->row['snsTopic']));
	 }
	 else
	 {
	   DebugText("record not found");
	   $this->init();
 	 }
	 DebugText("userId:".$this->userId);
     return($this->userId);
  }
  function Insert()
  {
     DebugText($this->className."[Insert]");
     global $link_cms;
     global $database_cms;
	 global $now;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $password =prepForDB("users","password",trim($this->password));
	 $fullName = prepForDB("users","fullName",trim($this->fullName));
	 $email = prepForDB("users","email",trim($this->email));
	 $initials = prepForDB("users","initials",trim($this->initials));
	 $snsTopic = prepForDB("users", "snsTopic", trim($this->snsTopic));

	 $query = "insert into users (fullName,email,lastLogin,active,initials,snsTopic) Values ('$fullName','$email','$now',$this->active,'$initials','$snsTopic')";
     $results = mysqli_query($link_cms,$query);
	 $this->userId = mysqli_insert_id($link_cms);
	 if (strlen($this->password))
	 {
	 	$this->SetPassword();
	 }

	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
 }
  function Update()
  {
     global $link_cms;
     global $database_cms;
  	 DebugText($this->className."[Update]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $fullName = prepForDB("users","fullName",trim($this->fullName));
	 $email = prepForDB("users","email",trim($this->email));
	 $initials = prepForDB("users","initials",trim($this->initials));
	 $emailMessage = prepForDB("users","emailMessage",$this->emailMessage);
	 $snsTopic = prepForDB("users", "snsTopic", trim($this->snsTopic));

	 $query = "update users set fullName='$fullName',email='$email', lastLogin='$this->lastLogin',  active=$this->active,initials='$initials',emailMessage='$emailMessage', snsTopic='$snsTopic' where userId=$this->userId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 if (strlen($this->password))
	 {
	 	$this->SetPassword();
	 }

  }
  function Persist()
  {
  	if ($this->userId)
  	{
  		return ($this->Update());
  	}
  	else
  	{
  		return $this->Insert();
  	}
  }
  function SetPassword()
  {
     global $link_cms;
     global $database_cms;
  	 DebugText($this->className."[SetPassword]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 //$password =prepForDB("users","password",trim($this->password));
	 DebugText("password before encrypt:".$this->password);
	 $password = md5(trim($this->password));
	 DebugText("password after encrypt:".$password);

	 $query = "update users set password='$password' where userId=$this->userId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));

  }
  function Delete()
  {
     global $link_cms;
     global $database_cms;
	 DebugText($this->className."[Delete]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 if ($this->userId <= 0)
	 {
	   DebugText("userId <= 0($this->userId)");
	 }
	 $query = "delete from users where userId=$this->userId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function addHistory($action)
  {
    $history = new History();

	$history->userId = $this->userId;

	$history->action = $action;
	$history->Insert();
  }
}
?>
