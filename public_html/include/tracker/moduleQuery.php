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
class ModuleQuery
{
var $initialized = 0;
var $dbhost;
var $dbfieldToTest;
var $dbuser;
var $dbpass;
var $dblink;

var $results;
var $row;

var $moduleQueryId;
var $fieldToTest;
var $fieldTest;
var $testValue;
var $moduleId;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;

var $className="ModuleQuery";
  function init()
  {
    $this->moduleQueryId = 0;
	$this->fieldToTest = "";
	$this->moduleId = 0;
	$this->page = 1;
	$this->start = 0;
	$this->perPage = 0;
	$this->orderBy = "fieldToTest";
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
   // $this->SetOrderBy("fieldToTest");
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
  	$query = "select count(*) as numRows from moduleQuery";
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

	 $query = "Select * from moduleQuery";
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

	 $query = "Select * from moduleQuery";
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
	 	DebugText("row->fieldTest:".$this->row['fieldTest']);
	    $this->moduleQueryId = $this->row['moduleQueryId'];
	    $this->fieldToTest = trim(stripslashes($this->row['fieldToTest']));
	    $this->fieldTest = trim(stripslashes($this->row['fieldTest']));
	    $this->testValue = trim(stripslashes($this->row['testValue']));
	    $this->moduleId = $this->row['moduleId'];
	 }
	 else
	 {
	   $this->init();
	 }
	 DebugText("this->fieldTest:".$this->fieldTest);
     return($this->moduleQueryId);
  }
  function GetById($id)
  {
	 DebugText($this->className."[GetById]");
	 if (!is_numeric($id))
	 {
	   return;
	 }
	 $param = "moduleQueryId = $id";
	 return($this->Get($param));

  }
  function Update()
  {
	 DebugText($this->className."[Update]");
     global $link_cms;
     global $database_cms;
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
     $fieldToTest = prepForDB("moduleQuery","fieldToTest",$this->fieldToTest);
     $fieldTest = prepForDB("moduleQuery","fieldTest",$this->fieldTest);
     $testValue = prepForDB("moduleQuery","testValue",$this->testValue);
	 $query = "Update moduleQuery set fieldToTest='$fieldToTest',fieldTest='$fieldTest', testValue='$testValue', moduleId=$this->moduleId where moduleQueryId = $this->moduleQueryId";
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
     $fieldToTest = prepForDB("moduleQuery","fieldToTest",$this->fieldToTest);
     $fieldTest = prepForDB("moduleQuery","fieldTest",$this->fieldTest);
     $testValue = prepForDB("moduleQuery","testValue",$this->testValue);
	 $query = "Insert into moduleQuery (fieldToTest,fieldTest,testValue,moduleId) value ('$fieldToTest','$fieldTest','$testValue',$this->moduleId)";
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->moduleQueryId = mysqli_insert_id($link_cms);
  }
  function Persist()
  {
  	if ($this->moduleQueryId)
  	{
  		$this->Update();
  	}
  	else
  	{
  		$this->Insert();
  	}
  	return ($this->moduleQueryId);
  }

  function Reset($moduleId)
  {
	 DebugText($this->className."[Reset($moduleId)]");
     global $link_cms;
     global $database_cms;
     if (!isNumeric($moduleId))
     {
     	exit;
     }
     mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
	 $query = "Delete from moduleQuery where moduleId=".$moduleId;
     $results = mysqli_query($link_cms,$query);
	 DebugText($query);
	 DebugText("Error:".mysqli_error($link_cms));
	 $this->moduleQueryId = mysqli_insert_id($link_cms);
  }

}
?>
