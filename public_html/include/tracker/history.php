<?php
class History
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;


var $results;
var $row;

var $historyId;
var $actionDate;
var $userId;
var $ticketId;
var $assetId;
var $contractId;
var $poNumberId;
var $action;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;


var $className="History";

  function __construct()
  {
  	$this->init();
  }
  function init()
  {
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $this->initialized = 1;
    $this->historyId = 0;
    $this->userId=0;
    $this->ticketId=0;
    $this->contractId = 0;
    $this->poNumberId = 0;
    $this->assetId = 0;
    $this->orderBy = "actionDate asc, historyId desc";
	return;
  }
  function SetOrderBy($orderBy)
  {
  	DebugText($this->className."[SetOrderBy($orderBy)]");
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
  	$query = "select count(*) as numRows from history";
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
  	DebugText("orderBy:".$this->orderBy);

  	$query = "Select * from history ";
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
  	echo $query."<br>";
  	$this->results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	return($this->Next());
  }
  function GetById($id)
  {
  	DebugText($this->className."[GetById]");
    $param = "historyId = ".$id;
	return($this->Get($param));
  }
  function GetForTicket($ticketId)
  {
  	DebugText($this->className."[GetForTicket]");
  	$this->SetOrderBy("actionDate asc, historyId asc");
  	$param = "ticketId = ".$ticketId;
  	return($this->Get($param));

  }
  function GetForAsset($assetId)
  {
  	DebugText($this->className."[GetForAsset]");
  	$this->SetOrderBy("actionDate asc, historyId asc");
  	$param = "assetId = ".$assetId;
  	return($this->Get($param));

  }  
  function GetForContract($contractId)
  {
  	DebugText($this->className."[GetForContract]");
  	$this->SetOrderBy("actionDate asc, historyId asc");
  	$param = "contractId = ".$contractId;
  	return($this->Get($param));

  }  
  function GetForpoNumber($poNumberId)
  {
  	DebugText($this->className."[GetForpoNumber]");
  	$this->SetOrderBy("actionDate asc, historyId asc");
  	$param = "poNumberId = ".$poNumberId;
  	return($this->Get($param));

  }  

  function Get($param = "")
  {
     global $link_cms;
     global $database_cms;
  	 DebugText($this->className."[Get]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     if (!$this->initialized)
       $this->init();
	 $query = "Select * from history";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
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
	    $this->historyId = $this->row['historyId'];
	    $this->actionDate = trim(stripslashes($this->row['actionDate']));
		$this->userId = $this->row['userId'];
		$this->ticketId = trim(stripslashes($this->row['ticketId']));
		$this->assetId = trim(stripslashes($this->row['assetId']));
		$this->contractId = trim(stripslashes($this->row['contractId']));
		$this->poNumberId = trim(stripslashes($this->row['poNumberId']));
		$this->action = trim(stripslashes($this->row['action']));
	 }
	 else
	 {
	   $this->init();
	 }
	 return($this->historyId);
  }
  function Insert()
  {
     global $link_cms;
     global $database_cms;
	 global $now;
	 global $ticketId;
  	 DebugText($this->className."[Insert]");
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     if (!$this->initialized)
       $this->init();
	 $action = mysqli_real_escape_string($link_cms,trim($this->action));
	 $query = "Insert into history (actionDate,userId,ticketId,assetId,action,contractId,poNumberId) values ('$now',$this->userId,$this->ticketId,$this->assetId,'$action',$this->contractId,$this->poNumberId)";
	 //$query = $query . " order by userName";
     $results = mysqli_query($link_cms,$query);
     $this->historyId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 return;
  }
}
?>