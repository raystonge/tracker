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
function getTableInfo($table)
{
	DebugText("getTableInfo($table)");
	global $link_cms;
  global $database_cms;
	mysqli_select_db($link_cms,$database_cms);
	$query = "show columns from ".$table;
	$results = mysqli_query($link_cms,$query);
	if (mysqli_num_rows($results) > 0)
  {
  	while ($row = mysqli_fetch_assoc($results))
    {
    	$field = $table."-".$row['Field'];
			$_SESSION[$field] = $row['Type'];
		}
	}
}
function getFieldSize($table,$field)
{
	DebugText("getFieldSize($table,$field)",3);
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType);
	if (strpos($fieldType,"varchar") >= 0)
	{
		$fieldSize = str_replace("varchar(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldSize);
		DebugText("fieldSize:".$fieldSize,3);
		return $fieldSize;
	}
	return (0);
}
function checkField($table,$field,$data)
{
	DebugText("checkField($table,$field,$data)",3);
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType,3);
	DebugText("data:".$data,3);
	DebugText("pos:".strpos($fieldType,"int"),3);
	//if (strpos($fieldType,"int") >=0)
	if (IsFieldInt($table, $field))
	{
		DebugText("looks like an int",3);
		if (ctype_digit($data))
		{
			return($data);
		}
		else
		{
			return (0);
		}
	}
	DebugText("data:".$data,3);
	DebugText("fieldType:".$fieldType,3);
	if ($fieldType == "date")
	{
		$data = substr($data,0,10);
		$data = str_replace("/", "-", $data);
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data))
		{
			DebugText("returning formated date:".$data,3);
			return ($data);
		}
		else
		{
			DebugText("returning all zero date",3);
			return ("0000-00-00");
		}
	}
	if ($fieldType == "datetime")
	{
		//$data = substr($data,0,10);
		$data = str_replace("/", "-", $data);
		//if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data))
		if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',$data))
		{
			DebugText("returning formated date:".$data,3);
			return ($data);
		}
		else
		{
			DebugText("returning all zero date",3);
			return ("0000-00-00 00:00:00");
		}
	}
	if (strpos($fieldType,"varchar"))
	{
		$fieldSize = str_replace("varchar(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldType);
		if (strlen($data)> $fieldSize)
		{
			return (substr($data,0,$fieldSize));
		}
		else
		{
			return ($data);
		}
	}
	return ($data);
}
function prepForDB($table,$field,$data)
{
	global $link_cms;
	$data = trim($data);
	DebugText("prepForDB($table,$field,$data)",3);
	if (IsFieldVarChar($table,$field))
	{
		Debugtext("Field is varchar",3);
		$data = checkField($table,$field,$data);
		$data = mysqli_real_escape_string($link_cms,trim($data));
	}
  DebugText("data:".$data,3);
	if (IsFieldInt($table,$field))
	{
		DebugText("Field is int",3);
		$data = checkField($table,$field,$data);
	}
  DebugText("data:".$data,3);
	if (IsFieldDate($table,$field))
	{
		DebugText("Field is Date",3);
		$data = checkField($table,$field,$data);
		$data = mysqli_real_escape_string($link_cms,trim($data));
	}
  DebugText("data:".$data,3);
	if (IsFieldDateTime($table,$field))
	{
		DebugText("Field is DateTime",3);
		$data = checkField($table,$field,$data);
		$data = mysqli_real_escape_string($link_cms,trim($data));
	}
  DebugText("data:".$data,3);
	DebugText("prepForDB return:".$data,3);
	return $data;
}
function IsFieldInt($table,$field)
{
	DebugText("IsFieldInt($table,$field)",3);
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType,3);
	DebugText("varchar:".strpos($fieldType,"varchar"),3);
	$pos = strpos($fieldType,"int");
	DebugText("pos:".$pos,3);
	if ($pos === false)
	{
		DebugText("return 0 for int",3);
		return 0;
	}
	return 1;
}
function IsFieldDate($table,$field)
{
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType,3);
	DebugText("date:".strpos($fieldType,"date"),3);
	if ($fieldType == "date")
	{
		return 1;
	}
	return 0;
}
function IsFieldDateTime($table,$field)
{
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType,3);
	DebugText("varchar:".strpos($fieldType,"varchar"),3);
	if (strpos($fieldType,"datetime") >= 0)
	{
		return 1;
	}
	return 0;
}

function IsFieldVarChar($table,$field)
{
	DebugText("IsFieldVar($table,$field)",3);
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	DebugText("fieldType:".$fieldType,3);
	DebugText("varchar:".strpos($fieldType,"varchar"),3);
	$pos = strpos($fieldType,"varchar");
	if ($pos === false)
	{
		DebugText("return 0 for varchar",3);
		return 0;
	}
	return 1;
}
function FieldSize($table,$field)
{
	DebugText("FieldSize($table,$field)",3);
	$fieldSize = 0;
	if (!isset($_SESSION[$table."-".$field]))
	{
		getTableInfo($table);
	}
	$fieldType = $_SESSION[$table."-".$field];
	if (strpos($fieldType,"char")==0)
	{
		$fieldSize = str_replace("char(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldType);
	}
	if (strpos($fieldType,"varchar")==0)
	{
		$fieldSize = str_replace("varchar(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldType);
	}
	if (strpos($fieldType,"tinytext")==0)
	{
		$fieldSize = str_replace("tinytext(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldType);
	}
	if (strpos($fieldType,"mediumtext")==0)
	{
		$fieldSize = 16777215;
	}
	if (strpos($fieldType,"largetext")==0)
	{
		$fieldSize = 4294967295;
	}
	if (strpos($fieldType,"text")==0)
	{
		$fieldSize = 64*1024;
	}
	if (strpos($fieldType,"blob")==0)
	{
		$fieldSize = 64*1024;
	}
	if (strpos($fieldType,"mediumblob"))
	{
		$fieldSize = 16777215;
	}
	if (strpos($fieldType,"largeblob")==0)
	{
		$fieldSize = 4294967295;
	}
	if (strpos($fieldType,"int")==0)
	{
		$fieldSize = str_replace("int(","",$fieldType);
		$fieldSize = str_replace(")","",$fieldType);
	}
	if (strpos($fieldType,"date")==0)
	{
		$fieldSize = 10;
	}
	if (strpos($fieldType,"time")==0)
	{
		$fieldSize = 10;
	}
	if (strpos($fieldType,"datetime")==0)
	{
		$fieldSize = 17;
	}
	if (strpos($fieldType,"timestamp")==0)
	{
		$fieldSize = 17;
	}

	return $fieldSize;
}
?>
