<?php
class TicketDependencies
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $ticketDependenciesId;
var $blockId;
var $dependsId;

var $orderBy;

var $className="ticketDependencies";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->ticketDependenciesId = 0;
    $this->blockId = 0;
    $this->dependsId = 0;
    $this->orderBy = "ticketDependenciesId asc";
  	
  }
  function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }
  function Get($param = "")
  {
	 DebugText($this->className."[Get]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

	 $query = "Select * from ticketDependencies";
	 if ($param)
	 {
	   $query = $query . " where ". $param;
	 }
	 $query = $query . " order by ".$this->orderBy;
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
	    $this->ticketDependenciesId = $this->row['ticketDependenciesId'];
	    $this->blockId = $this->row['blockId'];
	    $this->dependsId = $this->row['dependsId'];
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("ticketDependenciesId:".$this->ticketDependenciesId);
     return($this->ticketDependenciesId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "ticketDependenciesId = $id";
	 return($this->Get($param));

  }
  function GetByBlockId($id)
  {
	 DebugText($this->className."[GetByBlockId]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "blockId = $id";
	 return($this->Get($param));

  }
  function GetByDependsId($id)
  {
	 DebugText($this->className."[GetByDependsId]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "dependsId = $id";
	 return($this->Get($param));

  }

  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update ticketDependencies set blockId=$this->blockId,dependsId=$this->dependsId where ticketDependenciesId = $this->ticketDependenciesId";
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
	 $query = "Insert into ticketDependencies (blockId,dependsId) value ($this->blockId,$this->dependsId)";
     $results = mysqli_query($link_cms,$query);
     $this->ticketDependenciesId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function ResetDepends($ticketId)
  {
	 DebugText($this->className."[ResetDepends]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from ticketDependencies where blockId=$ticketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function ResetBlocks($ticketId)
  {
	 DebugText($this->className."[ResetBlocks]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from ticketDependencies where dependsId=$ticketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete()
  {
	 DebugText($this->className."[Delete]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from ticketDependencies where ticketDependenciesId=".$this->ticketDependenciesId;
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }

}
?>