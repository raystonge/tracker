<?php
//
//  Tracker - Version 1.11.1
//
//  v1.11.1
//   - fixed typo in code
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
class TimeWorked
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $timeWorkedId;
var $timeWorked;
var $dateWorked;
var $ticketId;
var $commentId;
var $userId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="TimeWorked";
  function init()
  {
    $this->timeWorkedId = 0;
	  $this->amtWorked = 0;
	  $this->ticketId = 0;
    $this->userId = 0;
	  $this->commentId = 0;
    $this->dateWorked = Today();
	  $this->page = 1;
	  $this->start = 0;
	  $this->perPage = 0;
	  $this->orderBy = "dateWorked";
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
  	$query = "select count(*) as numRows from timeWorked";
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

	  $query = "Select * from timeWorked";
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

	  $query = "Select * from timeWorked";
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
	    $this->timeWorkedId = $this->row['timeWorkedId'];
	    $this->amtWorked = $this->row['amountWorked'];
	    $this->dateWorked = trim(stripslashes($this->row['dateWorked']));
	    $this->commentId = $this->row['commentId'];
      $this->ticketId = $this->row['ticketId'];
      $this->userId = $this->row['userId'];
	  }
	  else
	  {
	    $this->init();
	  }
    return($this->timeWorkedId);
  }
  function GetById($id)
  {
    DebugText($this->className."[GetById]");
	  if (!is_numeric($id))
	  {
	    return;
	  }
	  $param = "timeWorkedId = $id";
	  return($this->Get($param));
  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$dateWorked = prepForDB("timeWorked","dateWorked",$this->dateWorked);
	  //$assetPrefix = prepForDB("timeWorked","assetPrefix",$this->assetPrefix);
	  $query = "Update timeWorked set amountWorked=$this->amtWorked, ticketId=$this->ticketId, commentId = $this->commentId, dateWorked = '$dateWorked', userID = $this->userId where timeWorkedId = $this->timeWorkedId";
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
	  $dateWorked = prepForDB("timeWorked","dateWorked",$this->dateWorked);
    $amtWorked = $this->amtWorked;
	  $query = "Insert into timeWorked (amountWorked,ticketId,dateWorked,commentId,userId) value
                                      ($amtWorked,$this->ticketId,'$dateWorked',$this->commentId,$this->userId)";
    $results = mysqli_query($link_cms,$query);
  	DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
	  $this->timeWorkedId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->timeWorkedId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
}
?>
