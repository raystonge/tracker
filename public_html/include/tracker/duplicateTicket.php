<?php
class DuplicateTicket
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $duplicateTicketId;
var $duplicateOfId;
var $ticketId;
var $numRows;

var $orderBy;

var $className="DuplicateTicket";
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
    $this->duplicateTicketId = 0;
    $this->duplicateOfId = 0;
    $this->ticketId = 0;
    $this->numRows = 0;
    $this->orderBy = "duplicateTicketId asc";
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

	 $query = "Select * from duplicateTicket";
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
     DebugText("Getting Next record");
	    $this->duplicateTicketId = $this->row['duplicateTicketId'];
	    $this->duplicateOfId = $this->row['duplicateOfId'];
	    $this->ticketId = $this->row['ticketId'];
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("duplicateTicketId:".$this->duplicateTicketId);
   return($this->duplicateTicketId);
  }


  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "duplicateTicketId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update duplicateTicket set duplicateOfId=$this->duplicateOfId,ticketId=$this->ticketId where duplicateTicketId = $this->duplicateTicketId";
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
 	   $query = "Insert into duplicateTicket (duplicateOfId,ticketId) value ($this->duplicateOfId,$this->ticketId)";
     $results = mysqli_query($link_cms,$query);
     $this->duplicateTicketId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from duplicateTicket where duplicateOfId=$this->duplicateOfId";
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
	 $query = "Delete from duplicateTicket where duplicateTicketId=$this->duplicateTicketId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Persist()
  {
    if ($this->duplicateTicketId)
    {
      $this->Update();
    }
    else {
      $this->Insert();
    }
  }
}
?>
