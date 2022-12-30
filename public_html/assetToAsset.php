<?php
class AssetToAsset
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetToAssetId;
var $assetId1;
var $assetId2;
var $serialNumber;
var $numRows;

var $orderBy;

var $className="AssetToAsset";
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
    $this->assetToAssetId = 0;
    $this->assetId1 = 0;
    $this->assetId2 = 0;
    $this->serialNumber = "";
    $this->numRows = 0;
    $this->orderBy = "assetToAssetId asc";
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

	 $query = "Select * from assetToAsset";
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
	    $this->assetToAssetId = $this->row['assetToAssetId'];
	    $this->assetId1 = $this->row['assetId1'];
	    $this->assetId2 = $this->row['assetId2'];
	    $this->serialNumber = trim(stripslashes($this->row['serialNumber']));
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("serialNumber:".$this->serialNumber);
	 DebugText("assetToAssetId:".$this->assetToAssetId);
   return($this->assetToAssetId);
  }


  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetToAssetId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $serialNumber = prepForDB("assetToAsset","serialNumber",$this->serialNumber);
	 $query = "Update assetToAsset set assetId1=$this->assetId1,assetId2=$this->assetId2, serialNumber='$serialNumber' where assetToAssetId = $this->assetToAssetId";
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
     $serialNumber = prepForDB("assetToAsset","serialNumber",$this->serialNumber);
	 $query = "Insert into assetToAsset (assetId1,assetId2,serialNumber) value ($this->assetId1,$this->assetId2,'$serialNumber')";
     $results = mysqli_query($link_cms,$query);
     $this->assetToAssetId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToAsset where assetId1=$this->assetId1";
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
	 $query = "Delete from assetToAsset where assetToAssetId=$this->assetToAssetId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function LicensesInUse($assetId)
  {
	 DebugText($this->className."[LicensesInUse($assetId)]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$param = AddEscapedParam("","assetId1",$assetId);
  	$query = "select count(*) as numRows from assetToAsset";
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
  function AssetAssigned($assetId)
  {
    DebugText($this->className."[AssetAssigned($assetId)]");
    $param1 = AddEscapedParam("","assetId1",$assetId);
    $param2 = AddEscapedParam("","assetId2",$assetId);
    $param = $param1." or ".$param2;
    return ($this->Get($param));
  }
}
?>
