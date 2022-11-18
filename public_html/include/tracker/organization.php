<?php
class Organization
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $organizationId;
var $name;
var $domain;
var $assetPrefix;
var $queueId;
var $defaultAssigneeId;
var $billable;
var $showAllUsers;
var $active;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Organization";
  function init()
  {
    $this->organizationId = 0;
	  $this->name = "";
	  $this->domain = "";
	  $this->assetPrefix = "";
	  $this->queueId = 0;
	  $this->defaultAssigneeId = 0;
    $this->billable = 0;
    $this->showAllUsers = 0;
    $this->active = 1;
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
  	$query = "select count(*) as numRows from organization";
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

	 $query = "Select * from organization";
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

	 $query = "Select * from organization";
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
	    $this->organizationId = $this->row['organizationId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->assetPrefix = trim(stripslashes($this->row['assetPrefix']));
	    $this->defaultAssigneeId = $this->row['defaultAssigneeId'];
      $this->billable = $this->row['billable'];
      $this->showAllUsers = $this->row['showAllUsers'];
      $this->active = $this->row['active'];
      if (!strlen($this->billable))
      {
        $this->billable = 0;
      }
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->organizationId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "organizationId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$name = prepForDB("organization","name",$this->name);
	  $assetPrefix = prepForDB("organization","assetPrefix",$this->assetPrefix);
	  $query = "Update organization set name='$name', assetPrefix='$assetPrefix', defaultAssigneeId = $this->defaultAssigneeId,billable = $this->billable,showAllUsers=$this->showAllUsers,active=$this->active where organizationId = $this->organizationId";
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
	  $name = prepForDB("organization","name",$this->name);
  	$assetPrefix = prepForDB("organization","assetPrefix",$this->assetPrefix);
	  $query = "Insert into organization (name,assetPrefix,defaultAssigneeId,billable,showAllUsers,active) value ('$name','$assetPrefix',$this->defaultAssigneeId,$this->billable,$this->showAllUsers,$this->active)";
    $results = mysqli_query($link_cms,$query);
  	DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
	  $this->organizationId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->organizationId)
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
