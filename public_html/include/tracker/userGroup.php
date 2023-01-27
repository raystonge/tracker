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
class UserGroup
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $userGroupId;
var $name;
var $admin;
var $developer;
var $assignee;
var $organizationId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="UserGroup";

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
    $this->SetOrderBy("name");
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
    $this->userGroupId = 0;
	$this->name = "";
	$this->admin = 0;
	$this->developer = 0;
	$this->assignee = 0;
	$this->organizationId = 0;
    $this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "name asc";
  }
  function Count($param)
  {
	 DebugText($this->className."[Count]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "select count(*) as numRows from userGroup";
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
  	$query = "Select * from userGroup ";
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

  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from userGroup";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
	 if (strlen($this->orderBy))
	 {
	 	$query = $query. " order by ".$this->orderBy;
	 }
	// $query = $query . " order by userGroupId asc";
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
	    $this->userGroupId = $this->row['userGroupId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->admin = $this->row['admin'];
	    $this->developer = $this->row['developer'];
	    $this->assignee = $this->row['assignee'];
	    $this->organizationId = $this->row['organizationId'];
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("returning:".$this->userGroupId);
     return($this->userGroupId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "userGroupId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $name = prepForDB("userGroup","name",$this->name);
	 $query = "Update userGroup set name='$name', admin=$this->admin,developer=$this->developer, assignee=$this->assignee, organizationId = $this->organizationId where userGroupId = $this->userGroupId";
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
	 $name = prepForDB("userGroup","name",$this->name);
	 $query = "Insert into userGroup (name,admin,developer,assignee,organizationId) value ('$name',$this->admin,$this->developer,$this->assignee,$this->organizationId)";
     $results = mysqli_query($link_cms,$query);
     $this->userGroupId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete()
  {
	 DebugText($this->className."[Delete]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "delete from userGroup where userGroupId=".$this->userGroupId;
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }

}
?>
