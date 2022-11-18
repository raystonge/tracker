<?php
include_once "tracker/history.php";


class Asset
{
var $initialized = 0;


var $results;
var $row;

var $assetId;
var $name;
var $serialNumber;
var $macAddress;
var $assetConditionId;
var $assetTypeId;
var $buildingId;
var $buildingLocation;
var $employeeName;
var $make;
var $model;
var $modelNumber;
var $assetTag;
var $vendor;
var $aquireDate;
var $creatorId;
var $createDate;
var $warrantyDate;
var $expireDate;
var $numOfLicenses;
var $organizationId;
var $purchasePrice;
var $sold;
var $soldPrice;
var $soldDate;
var $soldTo;
var $adminUser;
var $adminPassword;
var $taxable;
var $ewastedDate;
var $leased;
var $startingBuildingIdPP;


var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Asset";
function init()
{
  global $today;
  global $now;
  global $oneYear;
  $this->assetId = 0;
	$this->name = "";
	$this->macAddress= "";
	$this->serialNumber ="";
	$this->assetConditionId = 0;
	$this->assetTypeId = 0;
	$this->buildingId = 0;
	$this->poNumberId = "";
	$this->aquireDate = $today;
	$this->vendor = "";
	$this->buildingLocation = "";
	$this->employeeName = "";
	$this->make = "";
	$this->model = "";
	$this->modelNumber = "";
	$this->assetTag = "";
	$this->creatorId = 0;
	$this->createDate=$now;
	$this->warrantyDate = $oneYear;
	$this->expireDate = "";
	$this->numOfLicenses = "";
	$this->organizationId = 0;
  $this->purchasePrice = "";
  $this->sold = 0;
  $this->soldPrice = "";
  $this->soldDate = "";
  $this->soldTo = "";
  $this->adminUser = "";
  $this->adminPassword = "";
  $this->taxable = 0;
  $this->ewastedDate = "";
  $this->leased = 0;
  $this->startingBuildingIdPP = 0;

	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "name";
	DebugText("this->warrantyDate:".$this->warrantyDate);
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
  	$query = "select count(*) as numRows from asset";
  	if (strlen($param))
  	{
  		$query = $query." where ".$param;
  	}
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
  	$this->numRows = 0;
  	if ($row = mysqli_fetch_array($results))
  	{
  		$this->numRows = $row['numRows'];
  	}
  	DebugText("numRows:".$this->numRows);
  	return($this->numRows);
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

	  $query = "Select *,decode(adminUser,'tracker') as decodeAdminUser, decode(adminPassword,'tracker') as decodeAdminPassword from asset";
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

	 $query = "Select *,decode(adminUser,'tracker') as decodeAdminUser, decode(adminPassword,'tracker') as decodeAdminPassword from asset";
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
	    $this->assetId = $this->row['assetId'];
	    $this->poNumberId = $this->row['poNumberId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->serialNumber = trim(stripslashes($this->row['serialNumber']));
	    $this->macAddress = trim(stripslashes($this->row['macAddress']));
	    $this->buildingLocation = trim(stripslashes($this->row['buildingLocation']));
	    $this->make = trim(stripslashes($this->row['make']));
	    $this->model = trim(stripslashes($this->row['model']));
	    $this->modelNumber = trim(stripslashes($this->row['modelNumber']));
	    $this->assetTag = trim(stripslashes($this->row['assetTag']));
	    $this->vendor = trim(stripslashes($this->row['vendor']));
	    $this->aquireDate = trim(stripslashes($this->row['aquireDate']));
	    $this->aquireDate = substr($this->aquireDate,0,10);
	    $this->createDate = trim(stripslashes($this->row['createDate']));
	    $this->createDate = substr($this->createDate,0,10);
	    $this->warrantyDate = trim(stripslashes($this->row['warrantyDate']));
	    $this->warrantyDate = substr($this->warrantyDate,0,10);
	    if ($this->warrantyDate == "0000-00-00")
	    {
	    	$this->warrantyDate = "";
	    }
	    $this->expireDate = trim(stripslashes($this->row['expireDate']));
	    $this->expireDate = substr($this->expireDate,0,10);
	    if ($this->expireDate == "0000-00-00")
	    {
	    	$this->expireDate = "";
	    }
	    $this->numOfLicenses = $this->row['numOfLicenses'];
	    if (!$this->numOfLicenses)
	    {
	    	$this->numOfLicenses = "";
	    }
	    $this->employeeName = trim(stripslashes($this->row['employeeName']));
	    $this->assetConditionId = $this->row['assetConditionId'];
	    $this->assetTypeId = $this->row['assetTypeId'];
	    $this->buildingId = $this->row['buildingId'];
	    $this->creatorId = $this->row['creatorId'];
	    $this->organizationId = $this->row['organizationId'];
      $this->purchasePrice = trim(stripslashes($this->row['purchasePrice']));
      $this->sold = $this->row['sold'];
      $this->soldDate = trim(stripslashes($this->row['soldDate']));
	    $this->soldDate = substr($this->soldDate,0,10);
	    if ($this->soldDate == "0000-00-00")
	    {
	    	$this->soldDate = "";
	    }
      $this->soldPrice = trim(stripslashes($this->row['soldPrice']));
      $this->soldTo = trim(stripslashes($this->row['soldTo']));
      $this->adminUser = trim(stripslashes($this->row['decodeAdminUser']));
      $this->adminPassword = trim(stripslashes($this->row['decodeAdminPassword']));
      $this->taxable = $this->row['taxable'];
      $this->ewastedDate = trim(stripslashes($this->row['ewastedDate']));
      $this->ewastedDate = substr($this->ewastedDate,0,10);
      if ($this->ewastedDate == "0000-00-00")
      {
        $this->ewastedDate = "";
      }
      $this->leased = $this->row['leased'];
      if (!strlen($this->leased))
      {
        $this->leased = 0;
      }
      $this->startingBuildingIdPP = fixFlag($this->row['startingBuildingIdPP']);
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("returning($this->assetId)");
	 DebugText("serial:".$this->serialNumber);
   return($this->assetId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
    DebugText($this->className."[Update]");
	  if (!$this->assetId)
	  {
      DebugText("assetId is not set");
	 	  return(0);
	  }
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $name = prepForDB("asset","name",$this->name);
    if (!strlen($this->numOfLicenses))
    {
      $this->numOfLicenses = 0;
    }
    $this->FormatMakeModel();
	  $serialNumber = prepForDB("asset","serialNumber",$this->serialNumber);
	  $macAddress = prepForDB("asset","macAddress",$this->FormatMacAddress($this->macAddress));
	  $employeeName = prepForDB("asset","employeeName",$this->employeeName);
	  $make = prepForDB("asset","make",$this->make);
	  $model = prepForDB("asset","model",$this->model);
	  $modelNumber = prepForDB("asset","modelNumber",$this->modelNumber);
	  $vendor = prepForDB("asset","vendor",$this->vendor);
	  $assetTag = prepForDB("asset","assetTag",$this->assetTag);
	  $buildingLocation = prepForDB("asset","buildingLocation",$this->buildingLocation);
	  $poNumberId = prepForDB("asset","poNumberId",$this->poNumberId);
	  $aquireDate = prepForDB("asset","aquireDate",$this->aquireDate);
	  $warrantyDate = prepForDB("asset","warrantyDate",$this->warrantyDate);
	  $expireDate = prepForDB("asset","expireDate",$this->expireDate);
    $soldDate = prepForDB("asset","soldDate",$this->soldDate);
    $soldPrice = prepForDB("asset","soldPrice",$this->soldPrice);
    $soldTo = prepForDB("asset","soldTo",$this->soldTo);
    $purchasePrice = prepForDB("asset","purchasePrice",$this->purchasePrice);
    $adminUser = prepForDB("asset","adminUser", $this->adminUser);
    $adminPassword = prepForDB("asset","adminPassword", $this->adminPassword);
    $taxable = prepForDB("asset", "taxable", $this->taxable);
    $sold = prepForDB("asset", "sold", $this->sold);
    $expireDate = prepForDB("asset","expireDate",$this->expireDate);
    $ewastedDate = prepForDB("asset","ewastedDate",$this->ewastedDate);

    $query = "Update asset set name='$name',numOfLicenses=$this->numOfLicenses,buildingLocation='$buildingLocation',poNumberId='$poNumberId',assetTag = '$assetTag', employeeName='$employeeName', assetConditionId=$this->assetConditionId,assetTypeId=$this->assetTypeId,buildingId=$this->buildingId,macAddress='$macAddress',serialNumber='$serialNumber',assetConditionId=$this->assetConditionId,make='$make',model='$model',modelNumber='$modelNumber',vendor='$vendor',aquireDate='$aquireDate',warrantyDate='$warrantyDate',expireDate='$expireDate',organizationId=$this->organizationId, adminUser=encode('$adminUser','tracker'),adminPassword=encode('$adminPassword','tracker'), taxable=$taxable,purchasePrice='$purchasePrice',sold=$sold,soldPrice='$soldPrice',soldDate='$soldDate',soldTo='$soldTo', expireDate='$expireDate', leased=$this->leased, ewasteDate='$ewastedDate' where assetId = $this->assetId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
    DebugText("Error:".mysqli_error($link_cms));
    return ($this->assetId);
  }
  function Insert()
  {
    DebugText($this->className."[Insert]");
    global $link_cms;
    global $database_cms;
    global $today;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $name = prepForDB("asset","name",$this->name);
    if (!strlen($this->numOfLicenses))
    {
     	$this->numOfLicenses = 0;
    }
    $this->FormatMakeModel();
	  $serialNumber = prepForDB("asset","serialNumber",$this->serialNumber);
	  $macAddress = prepForDB("asset","macAddress",$this->FormatMacAddress($this->macAddress));
	  $employeeName = prepForDB("asset","employeeName",$this->employeeName);
	  $make = prepForDB("asset","make",$this->make);
	  $model = prepForDB("asset","model",$this->model);
	  $modelNumber = prepForDB("asset","modelNumber",$this->modelNumber);
	  $vendor = prepForDB("asset","vendor",$this->vendor);

	  $buildingLocation = prepForDB("asset","buildingLocation",$this->buildingLocation);
	  $poNumberId = prepForDB("asset","poNumberId",$this->poNumberId);
	  $aquireDate = trim(mysqli_real_escape_string($link_cms,$this->aquireDate));
	  $warrantyDate = prepForDB("asset","warrantyDate",$this->warrantyDate);
	  $expireDate = prepForDB("asset","expireDate",$this->expireDate);
	  $this->createDate = $today;
	  $this->creatorId = $_SESSION['userId'];
	  $assetTag = "";
    $soldDate = prepForDB("asset","expireDate",$this->soldDate);
    $soldPrice = prepForDB("asset","expireDate",$this->soldPrice);
    $soldTo = prepForDB("asset","expireDate",$this->soldTo);
    $purchasePrice = prepForDB("asset","expireDate",$this->purchasePrice);
    $adminUser = prepForDB("asset","adminUser", $this->adminUser);
    $adminPassword = prepForDB("asset","adminPassword", $this->adminPassword);
    $this->startingBuildingIdPP = $this->buildingId;

	  $query = "Insert into asset (name,serialNumber,macAddress,buildingId,assetTypeId,assetConditionId,employeeName,make,model,modelNumber,vendor,aquireDate,creatorId,createDate,assetTag,poNumberId,buildingLocation,warrantyDate,numOfLicenses,expireDate,organizationId,purchasePrice,sold,soldPrice,soldDate,soldTo,adminUser,adminPassword,taxable,leased,startingBuildingIdPP) value ('$name','$serialNumber','$macAddress',$this->buildingId,$this->assetTypeId,$this->assetConditionId,'$employeeName','$make','$model','$modelNumber','$vendor','$aquireDate',$this->creatorId,'$today','$assetTag','$poNumberId','$buildingLocation','$warrantyDate',$this->numOfLicenses,'$expireDate',$this->organizationId,'$purchasePrice',$this->sold,'$soldPrice','$soldDate','$soldTo','$adminUser','$adminPassword',$this->taxable,$this->leased,$this->startingBuildingIdPP)";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
	  $this->assetId = mysqli_insert_id($link_cms);
	  return $this->assetId;
  }
  function Persist()
  {
  	if ($this->assetId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  }
  function FormatMacAddress($mac)
  {
    return $mac;
  	$new = "";
  	$mac = strtoupper($mac);
    if (ereg('^[0-9A-F]+$',$mac))
    {
      // they entered it all at once, e.g. 123456ABCDEF

      while (strlen($mac) > 0)
      {
        $sub = substr($mac,0,2);
        $new .= $sub.':';
        $mac = substr($mac,2,strlen($mac));
      }

      // chop off trailing colon
      $new = substr($new,0,strlen($new)-1);
    }
    else
    {
      // we'll assume they entered it with some kind of separator
      $new = ereg_replace('[^A-F0-9]',':',$mac);
    }
    return $new;
  }
  function IsValid($mac)
  {
  	return (preg_match('/([a-fA-F0-9]{2}[-:]){5}[0-9A-Fa-f]{2}|([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4}/', $mac) == 1);
  }
  function PrepJumboEditor()
  {
    $this->poNumberId = "--do_not_change--";
	  $this->vendor = "--do_not_change--";
	  $this->buildingLocation = "--do_not_change--";
	  $this->employeeName = "--do_not_change--";
	  $this->make = "--do_not_change--";
	  $this->model = "--do_not_change--";
	  $this->modelNumber = "--do_not_change--";
  }
  function FormatMakeModel()
  {
    $model = $this->model;
  	$make = $this->make;
	  $tmpMake = strtolower($make);
	  $tmpMake = preg_replace("/[^A-Za-z0-9 ]/", '', $tmpMake);
	  $tmpModel = strtolower($model);
	  $tmpModel = preg_replace("/[^A-Za-z0-9 ]/", '', $tmpModel);
	switch ($tmpMake)
	{
		case "americom" : $make = "Ameri.com";
		                  break;
		case "apple" : $make = "Apple";
		                  break;
		case "ibm" : $make = "IBM";
		                  break;
		case "dell" : $make = "Dell";
		                  break;
		case "epson" : $make = "Epson";
		                  break;
		case "ricoh" : $make = "Ricoh";
		                  break;
		case "nec" : $make = "NEC";
		                  break;
		case "micron" : $make = "Micron";
		                  break;
		case "lexmark" : $make = "Lexmark";
		                  break;
		case "hp" : $make = "HP";
		                  break;
		case "infocus" : $make = "Infocus";
		                  break;
		case "brother" : $make = "Brother";
		                  break;
		case "acer" : $make = "Acer";
		                  break;
		case "dattech" : $make = "DatTech";
		                  break;
		case "toshiba" : $make = "Toshiba";
		                  break;
		case "umax" : $make = "Umax";
		                  break;
		case "gateway" : $make = "Gateway";
		                  break;
		case "hp compaq" : $make = "HP";
		                   $model = "Compaq";
		                  break;
		case "daewoo" : $make = "Daewoo";
		                  break;
		case "dsr" : $make = "DSR";
		                  break;
		case "whitebox custom build" : $make = "Whitebox";
		                               $model = "Custom Build";
		                  break;
		case "oki" : $make = "Oki";
		                  break;
		case "asus" : $make = "Asus";
		                  break;
		case "sony" : $make = "Sony";
		                  break;
		case "toshiba e452" : $make = "Toshiba";
		                      $model = "E-452";
		                  break;
		case "toshiba e523t" : $make = "Toshiba";
		                       $model = "E-523T";
		                  break;
		case "toshiba" : $make = "Toshiba";
		                  break;
		case "xerox" : $make = "Xerox";
		                  break;
		case "canon" : $make = "Canon";
		                  break;
		case "gestenter" : $make = "Gestenter";
		                  break;
		case "cisco" : $make = "cisco";
		                  break;
		case "gcc" : $make = "GCC";
		                  break;
		case "benq" : $make = "BenQ";
		                  break;
		case "samsung" : $make = "Samsung";
		                  break;
		case "savin" : $make = "Savin";
		                  break;
		case "toshiba e353" : $make = "Toshiba";
		                       $model = "E-353";
		                  break;
		case "toshiba e603t" : $make = "Toshiba";
		                       $model = "E-603T";
		                  break;
		case "toshiba e723" : $make = "Toshiba";
		                       $model = "E-723";
		                  break;
		case "toshiba e450" : $make = "Toshiba";
		                       $model = "E-450";
		                  break;
		case "toshiba e520" : $make = "Toshiba";
		                       $model = "E-520";
		                  break;
		case "toshiba e453" : $make = "Toshiba";
		                       $model = "E-453";
		                  break;
	}
	switch($tmpModel)
	{
		case "macbook" : $model = "Macbook";
		                 break;
		case "ibook g3" : $model = "iBook G3";
		                  break;
		case "ibook g4" : $model = "iBook G4";
		                  break;
		case "ibook" : $model = "iBook";
		                  break;
		case "optiplex" : $model = "Optiplex";
		                  break;
		case "laserjet" : $model = "LaserJet";
		                  break;
		case "laserjet 1100" : $model = "LaserJet 1100";
		                  break;
		case "airport base station":
		case "airport" : $model = "Airport";
		                  break;
		case "emac" : $model = "eMac";
		                  break;
		case "imac" : $model = "iMac";
		                  break;
		case "ipad" : $model = "iPad";
		                  break;

	}

	$this->make = $make;
	$this->model = $model;
	DebugText("Model:".$this->model);
	DebugText("tmpModel:".$tmpModel);
	$this->model = str_replace("laserjet","LaserJet",$tmpModel);
	$this->model = str_replace("jetdirect","JetDirect",$tmpModel);
	$this->model = str_replace("optiplex","Optiplex",$tmpModel);
	$this->model = str_replace("inspiron","Inspiron",$tmpModel);
	$this->model = str_replace("dimension","Dimension",$tmpModel);
	$this->model = str_replace("compaq","Compaq",$tmpModel);
	$this->model = str_replace("powermac","PowerMac",$this->model);
	$this->model = str_replace(" g3"," G3",$tmpModel);
	$this->model = str_replace(" g4"," G4",$tmpModel);
	$this->model = str_replace("micro tower"," MicroTower",$tmpModel);
	$this->model = str_replace("microtower"," MicroTower",$tmpModel);
	$this->model = str_replace("procurve"," ProCurve",$tmpModel);
	$this->model = str_replace("pro curve"," ProCurve",$tmpModel);
	$this->model = str_replace("perfection"," Perfection",$tmpModel);
	$this->model = str_replace("scanjet"," ScanJet",$tmpModel);
	$this->model = str_replace("xps"," XPS",$tmpModel);
	DebugText("Model:".$this->model);

  }
  function doQuery($query = "")
  {
    DebugText($this->className."[doQuery]");
    if (!strlen($query))
    {
      return;
    }
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

    $this->results = mysqli_query($link_cms,$query);
    DebugText($query);
    DebugText("Error:".mysqli_error($link_cms));
    return($this->Next());
  }
  function execQuery($query = "")
  {
    DebugText($this->className."[execQuery]");
    if (!strlen($query))
    {
      return;
    }
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected

    $this->results = mysqli_query($link_cms,$query);
    DebugText($query);
    DebugText("Error:".mysqli_error($link_cms));
    return;
  }
  function isEwasted()
  {
    if (($this->assetConditionId == 5) || ($this->assetConditionId == 8))
    {
      return 1;
    }
    return 0;
  }
  function Dispose()
  {
    global $currentUser;
    $this->assetConditionId = 8;
    $this->ewastedDate = Today();
    $this->Update();
    $history = new History();
    $history->userId = $currentUser->userId;
    $history->actionDate = Now();
    $history->action = "Asset has been disposed";
    $history->assetId = $this->assetId;
    $history->Insert();
  }
}
?>
