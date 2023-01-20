<?php
class Contract
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $buildingId;
var $name;
var $address1;
var $address2;
var $city;
var $state;
var $zipCode;
var $phone;
var $fax;
var $email;
var $contactName;
var $contactEmail;
var $contactPhone;
var $supportEmail;
var $supportPhone;
var $contractNumber;
var $expireDate;
var $poNumberId;
var $organizationId;
var $isLease;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="Contract";
  function init()
  {
    $this->contractId = 0;
	$this->name = "";
	$this->address1 = "";
	$this->address2 = "";
	$this->city = "";
	$this->state = "";
	$this->zipCode = "";
	$this->phone = "";
	$this->fax = "";
	$this->email = "";
	$this->contactName = "";
	$this->contactPhone = "";
	$this->contactEmail = "";
	$this->supportName = "";
	$this->supportPhone = "";
	$this->supportEmail = "";
	$this->contractNumber = "";
	$this->expireDate = "";
	$this->poNumberId = 0;
	$this->organizationId = 0;
  $this->isLease = 0;
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
  	$query = "select count(*) as numRows from contract";
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

	 $query = "Select * from contract";
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

	 $query = "Select * from contract";
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
	    $this->contractId = $this->row['contractId'];
	    $this->name = trim(stripslashes($this->row['name']));
	    $this->address1 = trim(stripslashes($this->row['address1']));
	    $this->address2 = trim(stripslashes($this->row['address2']));
	    $this->city = trim(stripslashes($this->row['city']));
	    $this->state = trim(stripslashes($this->row['state']));
	    $this->phone = trim(stripslashes($this->row['phone']));
	    $this->fax = trim(stripslashes($this->row['fax']));
	    $this->email = trim(stripslashes($this->row['email']));
	    $this->contactName = trim(stripslashes($this->row['contactName']));
	    $this->contactPhone = trim(stripslashes($this->row['contactPhone']));
	    $this->contactEmail = trim(stripslashes($this->row['contactEmail']));
	    $this->supportName = trim(stripslashes($this->row['supportName']));
	    $this->supportPhone = trim(stripslashes($this->row['supportPhone']));
	    $this->supportEmail = trim(stripslashes($this->row['supportEmail']));
	    $this->contractNumber = trim(stripslashes($this->row['contractNumber']));
	    $this->expireDate = trim(stripslashes($this->row['expireDate']));
	    $this->poNumberId = $this->row['poNumberId'];
	    $this->organizationId = $this->row['organizationId'];
      $this->isLease = $this->row['isLease'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->contractId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "contractId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $name = trim(mysqli_real_escape_string($link_cms,$this->name));
	 $address1 = trim(mysqli_real_escape_string($link_cms,$this->address1));
	 $address2 = trim(mysqli_real_escape_string($link_cms,$this->address2));
	 $city = trim(mysqli_real_escape_string($link_cms,$this->city));
	 $state = trim(mysqli_real_escape_string($link_cms,$this->state));
	 $zipCode = trim(mysqli_real_escape_string($link_cms,$this->zipCode));
	 $phone = trim(mysqli_real_escape_string($link_cms,$this->phone));
	 $email = trim(mysqli_real_escape_string($link_cms,$this->email));
	 $fax = trim(mysqli_real_escape_string($link_cms,$this->fax));
	 $contactName = trim(mysqli_real_escape_string($link_cms,$this->contactName));
	 $contactPhone = trim(mysqli_real_escape_string($link_cms,$this->contactPhone));
	 $contactEmail = trim(mysqli_real_escape_string($link_cms,$this->contactEmail));
	 $supportName = trim(mysqli_real_escape_string($link_cms,$this->supportName));
	 $supportPhone = trim(mysqli_real_escape_string($link_cms,$this->supportPhone));
	 $supportEmail = trim(mysqli_real_escape_string($link_cms,$this->supportEmail));
	 $contractNumber = trim(mysqli_real_escape_string($link_cms,$this->contractNumber));
	 $expireDate = trim(mysqli_real_escape_string($link_cms,$this->expireDate));
	 $query = "Update contract set name='$name',address1='$address1',address2='$address2',city='$city',state='$state',zipCode='$zipCode', phone='$phone',fax='$fax',email='$email',contactName='$contactName',contactEmail='$contactEmail', contactPhone='$contactPhone',supportName='$supportName',supportEmail='$supportEmail',supportPhone='$supportPhone',expireDate ='$expireDate', poNumberId=$this->poNumberId,contractNumber='$contractNumber', organizationId=$this->organizationId, isLease=$this->isLease where contractId = $this->contractId";
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
	 $name = trim(mysqli_real_escape_string($link_cms,$this->name));
	 $address1 = trim(mysqli_real_escape_string($link_cms,$this->address1));
	 $address2 = trim(mysqli_real_escape_string($link_cms,$this->address2));
	 $city = trim(mysqli_real_escape_string($link_cms,$this->city));
	 $state = trim(mysqli_real_escape_string($link_cms,$this->state));
	 $zipCode = trim(mysqli_real_escape_string($link_cms,$this->zipCode));
	 $phone = trim(mysqli_real_escape_string($link_cms,$this->phone));
	 $email = trim(mysqli_real_escape_string($link_cms,$this->email));
	 $fax = trim(mysqli_real_escape_string($link_cms,$this->fax));
	 $contactName = trim(mysqli_real_escape_string($link_cms,$this->contactName));
	 $contactPhone = trim(mysqli_real_escape_string($link_cms,$this->contactPhone));
	 $contactEmail = trim(mysqli_real_escape_string($link_cms,$this->contactEmail));
	 $supportName = trim(mysqli_real_escape_string($link_cms,$this->supportName));
	 $supportPhone = trim(mysqli_real_escape_string($link_cms,$this->supportPhone));
	 $supportEmail = trim(mysqli_real_escape_string($link_cms,$this->supportEmail));
	 $contractNumber = trim(mysqli_real_escape_string($link_cms,$this->contractNumber));
	 $expireDate = trim(mysqli_real_escape_string($link_cms,$this->expireDate));
	 $query = "Insert into contract (name,address1,address2,city,state,zipCode,phone,fax,email,contactName,contactPhone,contactEmail,supportName,supportPhone,supportEmail,expireDate,poNumberId,contractNumber,organizationId,isLease) value ('$name','$address1','$address2','$city','$state','$zipCode','$phone','$fax','$email','$contactName','$contactPhone','$contactEmail','$supportName','$supportPhone','$supportEmail','$expireDate',$this->poNumberId,'$contractNumber',$this->organizationId,$this->isLease)";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->contractId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->contractId)
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
