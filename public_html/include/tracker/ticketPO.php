<?php
//
//  Tracker - Version 1.9.0
//
//  v1.9.0
//   - added Count function
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
class TicketPO
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $ticketPOId;
var $ticketId;
var $poNumberId;

var $page;
var $limit;
var $perPage;
var $start;
var $numRows;
var $orderBy;

var $className="TicketPO";
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
  function init()
  {
    $this->ticketPOId = 0;
    $this->ticketId = 0;
    $this->poNumberId = 0;

    $this->page = 1;
    $this->start = 0;
    $this->perPage = 0;
    $this->numRows = 0;
    $this->orderBy = "ticketPOId asc";
  }
  function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }
  function GetById($id)
  {
   DebugText($this->className."[GetById]");
   if (!is_numeric($id))
   {
     return;
   }
   $param = "ticketPOId = $id";
   return($this->Get($param));

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
  function Search($param)
  {
	 DebugText($this->className."[Search]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     if (!isnumeric($this->page))
     {
     	$this->page = 1;
     }
     $this->start = ($this->page-1)*$this->perPage;
     DebugText("start:".$this->start);
     DebugText("page:".$this->page);
     DebugText("perPage:".$this->perPage);

	 $query = "Select * from ticketPO";
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
  function Count($param)
  {
    DebugText($this->className."[Count]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $query = "select count(*) as numRows from ticketPO";
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
    $this->numRows = $numRows;
    return($numRows);
  }
  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from ticketPO";
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
	    $this->ticketPOId = $this->row['ticketPOId'];
	    $this->ticketId = $this->row['ticketId'];
	    $this->poNumberId = $this->row['poNumberId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->ticketPOId);
  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update ticketPO set ticketId=$this->ticketId,poNumberId=$this->poNumberId where ticketPOId = $this->ticketPOId";
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
	 $query = "Insert into ticketPO (ticketId,poNumberId) value ($this->ticketId,$this->poNumberId)";
     $results = mysqli_query($link_cms,$query);
     $this->ticketPOId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Persist()
  {
  	if ($this->ticketPOId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  	return($this->ticketPOId);
  }
  function Reset()
  {
    DebugText($this->className."[Reset]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from ticketPO where ticketId=$this->ticketId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete($ticketPOId)
  {
    global $link_cms;
    global $database_cms;
    DebugText($this->className."[Delete($ticketPOId)]");
    if ($ticketPOId)
    {
      mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	  $query = "Delete from ticketPO where ticketPOId=$ticketPOId";
      $results = mysqli_query($link_cms,$query);
  	  DebugText($query);
  	  DebugText("Error:".mysqli_error($link_cms));
    }
  }
}
?>
