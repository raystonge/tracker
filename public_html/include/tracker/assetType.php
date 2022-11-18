<?php
class AssetType
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetTypeId;
var $name;
var $monitor;
var $hasMacAddress;
var $requireMacAddress;
var $hasContract;
var $organizationId;
var $monitorType;
var $hasAccessory;
var $isAccessory;
var $hasUserPassword;
var $hasConstantMonitorDown;
var $hasUserCredentials;
var $hasSpecs;
var $enforceCost;
var $personalProperty;
var $depreciationSchedule;
var $noSerialNumber;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="AssetType";
  function init()
  {
    $this->assetTypeId = 0;
	  $this->name = "";
	  $this->monitor = 0;
	  $this->hasMacAddress = 0;
	  $this->requireMacAddress = 0;
	  $this->hasContract = 0;
	  $this->page = 1;
	  $this->start = 0;
	  $this->perPage = 0;
	  $this->orderBy = "name";
	  $this->organizationId = 0;
	  $this->monitorType = "";
	  $this->hasAccessory = 0;
	  $this->isAccessory = 0;
    $this->hasUserPassword = 0;
    $this->hasConstantMonitorDown = 0;
    $this->hasUserCredentials  =0;
    $this->hasSpecs = 0;
    $this->enforceCost = 0;
    $this->personalProperty = 0;
    $this->depreciationSchedule = 0;
    $this->noSerialNumber = 0;
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
  	$query = "select count(*) as numRows from assetType";
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

	 $query = "Select * from assetType";
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

    $query = "Select * from assetType";
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
	    $this->assetTypeId = $this->row['assetTypeId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->monitor = $this->row['monitor'];
	    $this->hasMacAddress = fixFlag($this->row['hasMacAddress']);
	    $this->requireMacAddress = fixFlag($this->row['requireMacAddress']);
	    $this->hasContract = fixFlag($this->row['hasContract']);
	    DebugText("organizationId:".$this->row['organizationId']);
	    $this->organizationId = $this->row['organizationId'];
	    $this->monitorType = trim(stripslashes($this->row['monitorType']));
	    $this->hasAccessory = fixFlag($this->row['hasAccessory']);
	    $this->isAccessory = fixFlag($this->row['isAccessory']);
	    $this->hasUserPassword = fixFlag($this->row['hasUserPassword']);
	    $this->hasConstantMonitorDown = fixFlag($this->row['hasConstantMonitorDown']);
	    $this->hasUserCredentials = fixFlag($this->row['hasUserCredentials']);
      $this->hasSpecs = fixFlag($this->row['hasSpecs']);
      $this->enforceCost = fixFlag($this->row['enforceCost']);
      $this->personalProperty = fixFlag($this->row['personalProperty']);
      $this->depreciationSchedule = fixFlag($this->row['depreciationSchedule']);
      $this->noSerialNumber = fixFlag($this->row['noSerialNumber']);
      if (!strlen($this->noSerialNumber))
      {
        $this->noSerialNumber = 0;
      }
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->assetTypeId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetTypeId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	   $name = prepForDB("assetType", "name", $this->name);
	   $monitorType = prepForDB("assetType", "monitorType", $this->monitorType);
	   $query = "Update assetType set name='$name',hasContract=$this->hasContract,requireMacAddress=$this->requireMacAddress,monitor=$this->monitor,hasMacAddress = $this->hasMacAddress, organizationId = $this->organizationId, monitorType ='$monitorType', hasAccessory=$this->hasAccessory,isAccessory=$this->isAccessory,hasUserPassword=$this->hasUserPassword, hasConstantMonitorDown=$this->hasConstantMonitorDown, hasUserCredentials=$this->hasUserCredentials, hasSpecs=$this->hasSpecs, enforceCost=$this->enforceCost, personalProperty=$this->personalProperty, depreciationSchedule=$this->depreciationSchedule,noSerialNumber=$this->noSerialNumber where assetTypeId = $this->assetTypeId";
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
     $name = prepForDB("assetType", "name", $this->name);
     $monitorType = prepForDB("assetType", "monitorType", $this->monitorType);
     $query = "Insert into assetType (name,monitor,hasMacAddress,requireMacAddress,hasContract,organizationId,monitorType,hasAccessory,isAccessory,hasUserPassword,hasConstantMonitorDown,hasUserCredentials,hasSpecs,enforceCost,personalProperty,depreciationSchedule,noSerialNumber) value ('$name',$this->monitor,$this->hasMacAddress,$this->requireMacAddress,$this->hasContract,$this->organizationId,'$monitorType',$this->hasAccessory,$this->isAccessory,$this->hasUserPassword,$this->hasConstantMonitorDown, $this->hasUserCredentials, $this->hasSpecs,$this->enforceCost,$this->personalProperty,$this->depreciationSchedule,$this->noSerialNumber)";
     $results = mysqli_query($link_cms,$query);
     DebugText($query);
     DebugText("Error:".mysqli_error($link_cms));
     $this->assetTypeId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->assetTypeId)
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
	   $query = "Delete from assetType where assetTypeId=".$this->assetTypeId;
     $results = mysqli_query($link_cms,$query);
	   DebugText($query);
	   DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
