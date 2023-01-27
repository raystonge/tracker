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
class AssetToContract
{
var $initialized = 0;
var $dbhost;
var $dbname;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $assetToContractId;
var $assetId;
var $contractId;

var $orderBy;

var $className="AssetToContract";
  function __construct()
  {
  	$this->init();
  }
  function init()
  {
    $this->assetToContractId = 0;
    $this->assetId = 0;
    $this->contractId = 0;
    $this->orderBy = "assetToContractId asc";
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

	 $query = "Select * from assetToContract";
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
	    $this->assetToContractId = $this->row['assetToContractId'];
	    $this->assetId = $this->row['assetId'];
	    $this->contractId = $this->row['contractId'];
	 }
	 else
	 {
	   $this->init();
	 }
     return($this->assetToContractId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "assetToContractId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Update assetToContract set assetId=$this->assetId,contractId=$this->contractId where assetToContractId = $this->assetToContractId";
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
	 $query = "Insert into assetToContract (assetId,contractId) value ($this->assetId,$this->contractId)";
     $results = mysqli_query($link_cms,$query);
     $this->assetToContractId = mysqli_insert_id($link_cms);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
  function Persist()
  {
  	if ($this->assetToContractId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  	return($this->assetToContractId);
  }
  function Reset()
  {
	 DebugText($this->className."[Reset]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from assetToContract where assetId=$this->assetId";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
  }
}
?>
