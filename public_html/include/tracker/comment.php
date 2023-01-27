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
class Comment
{
var $initialized = 0;
var $dbhost;
var $dbcomment;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $commentId;
var $userId;
var $posted;
var $ticketId;
var $assetId;
var $contractId;
var $poNumberId;
var $comment;
var $organizationId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $matchText;
var $matchCnt;
var $start;
var $numRows;

var $className="Comment";
  function init()
  {
    $this->commentId = 0;
	$this->comment = "";
	$this->userId = $_SESSION['userId'];
	$this->posted = "";
	$this->ticketId = 0;
	$this->assetId = 0;
	$this->contractId = 0;
  $this->poNumberId = 0;
	$this->organizationId = 0;
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "posted";
  $this->matchCnt = 0;
	$this->matchText = "";
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
   // $this->SetOrderBy("comment");
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
  function SearchCount($param)
  {

	DebugText($this->className."[SearchCount]");
     global $link_cms;
     global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

     $query = "";
	 DebugText("matchText:".$this->matchText."|");
	 if (strlen($this->matchText))
	 {
	   $query = "select count(*) as numRows from comment";
	   if ($param)
	   {
	     $query = $query . " where ". $param . " and match(comment) against('".$this->matchParam."')";
	   }
	   else
	   {
	     $query = $query . " where match(comment) against('".$this->matchParam."')";
	   }
	 }
	 else
	 {
	   $query = "select count(*) as numRows from comment";
	   if ($param)
	   {
	     $query = $query . " where ". $param;
	   }
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

  function Count($param)
  {
  	DebugText($this->className."[Count]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from comment";
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

  function AddMatchParam($val)
  {
  	global $link_cms;
    if (strlen(trim($val)) == 0)
	{
	  return;
	}
    $this->matchCnt++;
    $weight = 8/$this->matchCnt;
	$val = mysqli_real_escape_string($link_cms,$val);
    //$tmp = "(match(i.title) against('".$val."' )*16) + (match(i.description) against('".$val."')*4) +(match(i.keywords) against('".$val."')*2) as score";
    $tmp = "(match(comment) against('".$val."' )*16) as score";
	if (strlen($this->matchText))
	{
	  $this->matchText = $this->matchText." ".$tmp;
	  $this->matchParam = $val;
	}
	else
	{
	  $this->matchText = $tmp;
	  $this->matchParam = $val;
	}
  }



  function Search($param,$page = 1)
  {
	 DebugText($this->className."[Search]");
	 DebugText("page:".$page);
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $query = "";
	 if (strlen($this->matchText))
	 {
	   $query = "select c.*,".$this->matchText." from comment c where match(c.comment) against('".$this->matchParam."' ) and ".$param." order by score desc,posted desc";
	 }
	 else
	 {
	   $query = "select c.* from comment c  where ".$param;
	 }
	 $this->start = ($page - 1) * $this->perPage;
	 DebugText("****************");
	 DebugText("page:".$page." start:".$this->start);

//	 if (strlen($this->orderBy))
//	 {
//	   $query = $query . " order by ".$this->orderBy;
//	 }
     if ($this->perPage > 0)
	 {
	   $query = $query ." limit ".$this->start.",".$this->perPage;
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
  function Get($param = "")
  {
    DebugText($this->className."[Get]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $this->start = ($this->page-1)*$this->perPage;

    $query = "Select * from comment";
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
	    $this->commentId = $this->row['commentId'];
	    $this->comment = trim(stripslashes($this->row['comment']));
	    $this->userId = $this->row['userId'];
	    $this->posted = trim(stripslashes($this->row['posted']));
	    $this->ticketId = $this->row['ticketId'];
	    $this->assetId = $this->row['assetId'];
	    $this->contractId = $this->row['contractId'];
      $this->poNumberId = $this->row['poNumberId'];
	    $this->organizationId = $this->row['organizationId'];
      $this->comment = str_replace("\n","<br>",$this->comment);
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->commentId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]".$id);
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "commentId = $id";
	 return($this->Get($param));

  }
  function GetByTicketId($ticketId)
  {
	 DebugText($this->className."[GetByTicketId]".$ticketId);
	 if (!is_numeric($ticketId))
	 {
	   return;
	 }
   if (!$ticketId)
   {
     return;
   }
  	$param = AddEscapedParam("","ticketId",$ticketId);
  	return($this->Get($param));
  }
  function GetByAssetId($assetId)
  {
    DebugText($this->className."[GetByAssetId]".$assetId);
	  if (!is_numeric($assetId))
	  {
	    return;
	  }
    if (!$assetId)
    {
      return;
    }
  	$param = AddEscapedParam("","assetId",$assetId);
  	return($this->Get($param));
  }
  function GetByContractId($contractId)
  {
    DebugText($this->className."[GetByContractId]".$contractId);
	  if (!is_numeric($contractId))
	  {
      return;
	  }
    if (!$contractId)
    {
      return;
    }
    $param = AddEscapedParam("","contractId",$contractId);
  	return($this->Get($param));
  }
  function GetByPoNumberId($poNumberId)
  {
    DebugText($this->className."[GetByPoNumberId]".$poNumberId);
    if (!is_numeric($poNumberId))
    {
      return;
    }
    if (!$poNumberId)
    {
      return;
    }
    $param = AddEscapedParam("","poNumberId",$poNumberId);
    return($this->Get($param));

  }

  function Insert()
  {
	 DebugText($this->className."[Insert]");
   global $link_cms;
   global $database_cms;
   global $now;
   mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
   $this->posted  = $now;
	 $comment = trim(mysqli_real_escape_string($link_cms,$this->comment));
	 $posted = trim(mysqli_real_escape_string($link_cms,$this->posted));
	 $query = "Insert into comment (comment,posted,userId,ticketId,assetId,contractId,poNumberId,organizationId) value ('$comment','$posted',$this->userId,$this->ticketId,$this->assetId,$this->contractId,$this->poNumberId,$this->organizationId)";
   $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->commentId = mysqli_insert_id($link_cms);
  }
  function Import()
  {
    DebugText($this->className."[Insert]");
    global $link_cms;
    global $database_cms;
    global $now;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $comment = trim(mysqli_real_escape_string($link_cms,$this->comment));
	  $posted = trim(mysqli_real_escape_string($link_cms,$this->posted));
	  $query = "Insert into comment (comment,posted,userId,ticketId,assetId,contractId) value ('$comment','$posted',$this->userId,$this->ticketId,$this->assetId,$this->contractId)";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
	  $this->commentId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	$this->Insert();
  }
}
?>
