<?php
//
//  Tracker - Version 1.12.0
//
//  v1.12.0
//   - added showUsable field
//  v1.8.2
//   - added Delete function
//
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
class AssetCondition
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetConditionId;
var $name;
var $showAll;
var $showUseable;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="AssetCondition";
  function init()
  {
    $this->assetConditionId = 0;
	$this->name = "";
    $this->showAll = 1;
	$this->showUseable = 1;
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
  	$query = "select count(*) as numRows from assetCondition";
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

	 $query = "Select * from assetCondition";
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

	  $query = "Select * from assetCondition";
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
	    $this->assetConditionId = $this->row['assetConditionId'];
	    $this->name = trim(stripslashes($this->row['name']));
		$this->showAll = $this->row['showAll'];
		$this->showUseable = $this->row['showUseable'];
	  }
	  else
	  {
	    $this->init();
	  }
    return($this->assetConditionId);
  }
  function GetById($id)
  {
    DebugText($this->className."[GetById]");
	  if (!is_numeric($id))
	  {
	    return;
	  }
	  $param = "assetConditionId = $id";
	  return($this->Get($param));
  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	$name = trim(mysqli_real_escape_string($link_cms,$this->name));
    $showAll = $this->showAll;
	$showUsable = $this->showUsable;

	$query = "Update assetCondition set name='$name', showAll=$showAll,showUsable=$showUsable where assetConditionId = $this->assetConditionId";
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
    $showAll = $this->showAll;
	$showUsable = $this->showUsable;
	$query = "Insert into assetCondition (name,showAll,showUable) value ('$name',$showAll,$showUseable)";
    $results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
	$this->assetConditionId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->assetConditionId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function Delete()
  {
    DebugText($this->className."[Delete]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    if (!$this->assetConditionId)
    {
      return(0);
    }
    $query = "Delete from assetCondition where assetConditionId=$this->assetConditionId";
    $results = mysqli_query($link_cms,$query);
    DebugText($query);
    DebugText("Error:".mysqli_error($link_cms));
    return(1);
  }
}
?>
