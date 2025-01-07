<?php
//
//  Tracker - Version 1.11.0
//
//  -v1.11.0
//     -adding a level to reduce the amout of debug text
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

class MonitorMessages
{
var $initialized = 0;


var $results;
var $row;

var $monitorMessagesId;
var $userId;
var $msg;
var $monitorServerId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className = "MonitorMessages";

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
  	$this->monitorMessagesId = 0;
  	$this->userId = 0;
  	$this->msg ="";
  	$this->monitorServerId =0;
	  $this->page = 1;
	  $this->start = 0;
	  $this->perPage = 0;
  }
  function doQuery($query)
  {
    DebugText($this->className."[doQuery]",5);
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $this->results = mysqli_query($link_cms,$query);
    DebugText($query,5);
    DebugText("Error:".mysqli_error($link_cms),5);
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
    DebugText($this->className."[SetPage($page)]",3);
    $this->page = $page;
    DebugText("Setting Page:".$this->page,3);
  }
  function SetPerPage($perPage)
  {
    DebugText($this->className."[SetPerPage($perPage)]",3);
    $this->perPage = $perPage;
    DebugText("Setting perPage:".$this->perPage,3);
  }

  function GetById($id)
  {
     DebugText($this->className."[GetById]",3);
	   return ($this->GetMonitorMessagesByID($id));
  }
  function GetMonitorMessagesByID($id)
  {
    global $link_cms;
    global $database_cms;
    DebugText($this->className."[GetMonitorMessagesByID]",3);
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $query = "Select * from monitorMessages where monitorMessagesId=$id";
    $this->results = mysqli_query($link_cms,$query);
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
	  return($this->Next());
  }
  function GetByUserId($userId,$monitorServerId)
  {
    global $link_cms;
    global $database_cms;
    DebugText($this->className."[GetMonitorMessagesByID]",3);
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $param = AddEscapedParam("","userId",$userId);
    $param = AddEscapedParam($param,"monitorServerId",$monitorServerId);
    $query = "Select * from monitorMessages where ".$param;
    $this->results = mysqli_query($link_cms,$query);
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
	  return($this->Next());
  }
  function Get($param = "")
  {
    global $link_cms;
    global $database_cms;
    DebugText($this->className."[Get]",3);
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  $query = "Select * from monitorMessages";
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
	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
	  return($this->Next());
  }
  
  
  function Next()
  {
    DebugText($this->className."[Next]");
	  if ($this->row = mysqli_fetch_array($this->results))
	  {
	    $this->monitorMessagesId = $this->row['monitorMessagesId'];
		  DebugText("Found id:".$this->monitorMessagesId,3);
	    $this->msg = trim(stripslashes($this->row['msg']));
		  $this->userId = trim(stripslashes($this->row['userId']));
		  $this->monitorServerId = $this->row['monitorServerId'];
		}
	  else
	  {
	    DebugText("record not found",3);
	    $this->init();
 	  }
	  DebugText("monitorMessagesId:".$this->monitorMessagesId,3);
    return($this->monitorMessagesId);
  }
  function Insert()
  {
    DebugText($this->className."[Insert]",3);
    global $link_cms;
    global $database_cms;
	  global $now;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  $userId =prepForDB("monitorMessages","userId",trim($this->userId));
	  $monitorServerId = prepForDB("monitorMessages","monitorServerId",trim($this->monitorServerId));
	  $msg = prepForDB("monitorMessages","msg",trim($this->msg));

	  $query = "insert into monitorMessages (userId,msg,monitorServerId) Values ('$userId','$msg','$monitorServerId')";
    $results = mysqli_query($link_cms,$query);
	  $this->monitorMessagesId = mysqli_insert_id($link_cms);


	  DebugText($query,3);
	  DebugText("Error:".mysqli_error($link_cms),3);
 }
  function Update()
  {
    global $link_cms;
    global $database_cms;
  	DebugText($this->className."[Update]");
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  $userId =prepForDB("monitorMessages","userId",trim($this->userId));
	  $monitorServerId = prepForDB("monitorMessages","monitorServerId",trim($this->monitorServerId));
	  $msg = prepForDB("monitorMessages","msg",trim($this->msg));

	  $query = "update monitorMessages set userId='$userId',msg='$msg', monitorServerId='$monitorServerId' where monitorMessagesId=$this->monitorMessagesId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));

  }
  function Persist()
  {
  	if ($this->monitorMessagesId)
  	{
  		return ($this->Update());
  	}
  	else
  	{
  		return $this->Insert();
  	}
  }

  function Delete()
  {
    global $link_cms;
    global $database_cms;
	  DebugText($this->className."[Delete]");
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	  if ($this->monitorMessagesId <= 0)
	  {
      DebugText("monitorMessagesId <= 0($this->monitorMessagesId)");
	  }
	  $query = "delete from monitorMessages where monitorMessagesId=$this->monitorMessagesId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }



function clearEmailMessage($monitorServerId)
{
  global $link_cms;
  global $database_cms;
  DebugText($this->className."[clearEmailMessage]");
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected 
  $param = AddEscapedParam("","monitorServerId",$monitorServerId);
  $query = "update monitorMessages set msg= null where ".$param;
  $results = mysqli_query($link_cms,$query);
  DebugText($query);
  DebugText("Error:".mysqli_error($link_cms)); 
}


}
?>
