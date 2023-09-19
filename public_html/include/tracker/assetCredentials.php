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
class AssetCredentials
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $AssetCredentialsId;
var $assetId;
var $userName;
var $password;

var $orderBy;

var $className="AssetCredentials";
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
    $this->assetCredentialsId = 0;
    $this->assetId = 0;
    $this->userName = "";
    $this->password = "";
    $this->orderBy = "assetCredentialsId asc";
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

	 $query = "Select * from assetCredentials";
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
	    $this->assetCredentialsId = $this->row['assetCredentialsId'];
	    $this->assetId = $this->row['assetId'];
	    $this->userName = trim(stripslashes($this->row['userName']));
	    $this->password = trim(stripslashes($this->row['password']));
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->assetCredentialsId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetCredentialsId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
    DebugText($this->className."[Update]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
    $userName = prepForDB("assetCredentials", "userName", $this->userName);
    $password = prepForDB("assetCredentials", "password", $this->password);
	  $query = "Update assetCredentials set assetId=$this->assetId,userName='$userName', password='$password' where assetCredentialsId = $this->assetCredentialsId";
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
    $userName = prepForDB("assetCredentials", "userName", $this->userName);
    $password = prepForDB("assetCredentials", "password", $this->password);
	  $query = "Insert into assetCredentials (assetId,userName,password) value ($this->assetId,'$userName','$password')";
    $results = mysqli_query($link_cms,$query);
    $this->assetCredentialsId = mysqli_insert_id($link_cms);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Persist()
  {
  	if ($this->assetCredentialsId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  	return($this->assetCredentialsId);
  }
  function Reset()
  {
    DebugText($this->className."[Reset]");
    global $link_cms;
    global $database_cms;
    mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	  $query = "Delete from assetCredentials where assetCredentialsId=$this->assetCredentialsId";
    $results = mysqli_query($link_cms,$query);
	  DebugText($query);
	  DebugText("Error:".mysqli_error($link_cms));
  }
  function Delete()
  {
    DebugText($this->className."[Delete]");
    $this->Reset();
  }
}
?>
