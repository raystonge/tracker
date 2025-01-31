<?php
//
//  Tracker - Version 1.11.0
//
//  -v1.11.0
//     -adding a level to reduce the amout of debug text
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
class Control
{
	var $initialized = 0;
	var $dbhost;
	var $dbname;
	var $dbuser;
	var $dbpass;
	var $dblink;
	var $result;
	var $row;
	var $controlId;
	var $section;
	var $key;
	var $datatype;
	var $valueInt;
	var $valueChar;
	var $description;
	var $developer;

var $orderBy;
var $limit;
var $page;
var $perPage;
var $start;
var $numRows;
var $className="Control";

	function __construct()
	{
		$a = func_get_args();
		$i = func_num_args();
		if (method_exists($this, $f = '__construct' . $i))
		{
			call_user_func_array(array (
				$this,
				$f
			), $a);
		} else
		{
			$this->init();
		}

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
		$this->controlId = 0;
		$this->valueInt = 0;
		$this->section = "";
		$this->key = "";
		$this->valueChar = "";
		$this->datatype="integer";
		$this->developer = 0;
		$this->orderBy = "sectionValue,keyValue";
		$this->page = 1;
		$this->start = 0;
		$this->perPage = 0;
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
  	DebugText($this->className."[SetPerPage($perPage)]",3);
  	$this->perPage = $perPage;
  	DebugText("Setting perPage:".$this->perPage,3);
  }
  function Count($param)
  {
  	DebugText($this->className."[Count]",3);
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  	$query = "select count(*) as numRows from control";
  	if (strlen($param))
  	{
  		$query = $query." where ".$param;
  	}
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query,3);
  	DebugText("Error:".mysqli_error($link_cms),3);
  	$numRows = 0;
  	if ($row = mysqli_fetch_array($results))
  	{
  		$numRows = $row['numRows'];
  	}
  	return($numRows);
  }
	function Get($param = "")
	{
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$this->start = ($this->page-1)*$this->perPage;

		$query = "Select * from control";
		$param = trim($param);
		if (strlen($param))
		{
			$query = $query . " where " . $param;
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
		$this->result = mysqli_query($link_cms,$query);
		DebugText($query,3);
		DebugText("Error:" . mysqli_error($link_cms),3);
		return ($this->Next());
	}
	function GetId($id)
	{
		$query = "controlId=$id";
		return ($this->Get($query));
	}
	function GetById($id)
	{
		if (!is_numeric($id))
		{
			$this->controlId = 0;
			return 0;
		}
		$query = "controlId=$id";
		return ($this->Get($query));
	}
	function GetSection($section)
	{
		global $link_cms;
		$section = trim(mysqli_real_escape_string($link_cms,$section));
		$query = "sectionValue='$section'";
		return ($this->Get($query));
	}
	function GetSectionKey($section, $key)
	{
		global $link_cms;
		$section = trim(mysqli_real_escape_string($link_cms,$section));
		$key = trim(mysqli_real_escape_string($link_cms,$key));
		$query = "sectionValue='$section' and keyValue='$key'";
		return ($this->Get($query));
	}

	function Next()
	{
		if ($this->row = mysqli_fetch_array($this->result))
		{
			$this->controlId = $this->row['controlId'];
			$this->section = stripslashes(trim($this->row['sectionValue']));
			$this->key = stripslashes(trim($this->row['keyValue']));
			$this->valueInt = $this->row['valueInt'];
			$this->valueChar = stripslashes(trim($this->row['valueChar']));
			$this->datatype = trim($this->row['datatype']);
			$this->description = stripslashes(trim($this->row['description']));
			$this->developer = $this->row['developer'];
		} else
		{
			/*
			$this->controlId = 0;
			$this->section = "";
			$this->key = "";
			$this->valueInt = 0;
			$this->valueChar = "";
			*/
			$this->init();
		}
		DebugText("datatype:".$this->datatype,3);
		return ($this->controlId);
	}
	function Update()
	{
		global $link_cms;
		global $database_cms;

		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$section = trim(mysqli_real_escape_string($link_cms,$this->section));
		$key = trim(mysqli_real_escape_string($link_cms,$this->key));
		$valueChar = trim(mysqli_real_escape_string($link_cms,$this->valueChar));
		$datatype = trim(mysqli_real_escape_string($link_cms,$this->datatype));
		$query = "Update control set sectionValue='$section',keyValue='$key',valueInt = $this->valueInt, valueChar='$valueChar',datatype='$datatype',developer=$this->developer where controlId=$this->controlId";
		echo $query."<br>";
		$result = mysqli_query($link_cms,$query);
		DebugText($query,3);
		DebugText("Error:" . mysqli_error($link_cms),3);

	}
	function UpdateControl()
	{
		global $link_cms;
		global $database_cms;

		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$section = trim(mysqli_real_escape_string($link_cms,$this->section));
		$key = trim(mysqli_real_escape_string($link_cms,$this->key));
		$datatype = trim(mysqli_real_escape_string($link_cms,$this->datatype));
		$description = trim(mysqli_real_escape_string($link_cms,$this->description));
		$valueChar = trim(mysqli_real_escape_string($link_cms,$this->valueChar));
		$valueInt = trim(mysqli_real_escape_string($link_cms,$this->valueInt));
		$query = "Update control set sectionValue='$section', keyValue='$key',valueChar='$valueChar', valueInt='$valueInt', description='$description',datatype='$datatype', developer=$this->developer where controlId=$this->controlId";

		$result = mysqli_query($link_cms,$query);
		DebugText($query,3);
		DebugText("Error:" . mysqli_error($link_cms),3);
	}
	function Insert()
	{
		global $link_cms;
		global $database_cms;
		DebugText("Insert",3);
		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$section = trim(mysqli_real_escape_string($link_cms,$this->section));
		$key = trim(mysqli_real_escape_string($link_cms,$this->key));
		$datatype = trim(mysqli_real_escape_string($link_cms,$this->datatype));
		$description = trim(mysqli_real_escape_string($link_cms,$this->description));
		$valueChar = trim(mysqli_real_escape_string($link_cms,$this->valueChar));
		$query = "insert into control (sectionValue,keyValue,description,datatype,developer,valueChar,valueInt) values ('$section','$key','$description','$datatype',$this->developer,'$valueChar',$this->valueInt)";
		$result = mysqli_query($link_cms,$query);
		$this->controlId = mysqli_insert_id($link_cms);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function Delete()
	{
		global $link_cms;
		global $database_cms;
		DebugText("Delete",3);
		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$query = "delete from control where controlId=" . $this->controlId;
		$result = mysqli_query($link_cms,$query);
		DebugText($query,3);
		DebugText("Error:" . mysqli_error($link_cms),3);
	}
	function doQuery($query)
	{
		global $link_cms;
		global $database_cms;
		DebugText("doQuery",3);
		mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected
		$result = mysqli_query($link_cms,$query);
		DebugText($query,3);
		DebugText("Error:" . mysqli_error($link_cms),3);
	}
	function Persist()
	{
		if ($this->controlId)
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
