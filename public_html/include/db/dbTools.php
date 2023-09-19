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
function getTables()
{
  global $link_cms;
  global $database_cms;
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("getTables");
  $result = mysqli_query($link_cms,"show tables");
  $tables = array();
  $cnt = 0;
  while ($row = mysqli_fetch_row($result))
  {
  	$tables[$cnt++] = $row[0];
  }
  return $tables;
}

function getFields($table)
{
  global $link_cms;
  global $database_cms;
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("getFields($table)");

  $result = mysqli_query($link_cms,"SHOW COLUMNS FROM ".$table);
  $fields = array();
  $cnt = 0;
  if (mysqli_num_rows($result) > 0)
  {
   	while ($row = mysqli_fetch_assoc($result))
   	{
   		$fields[$cnt++] = $row;
    }
  }
  return $fields;
}
function getFieldsArray($table)
{
  global $link_cms;
  global $database_cms;
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("getFields($table)");

  $result = mysqli_query($link_cms,"SHOW COLUMNS FROM ".$table);
  $fields = array();
  $cnt = 0;
  if (mysqli_num_rows($result) > 0)
  {
   	while ($row = mysqli_fetch_assoc($result))
   	{
   		$fieldName = $row['Field'];
   		$dataType = $row['Type'];
   		$fields[$fieldName] = $dataType;
      }
  }
  return $fields;
}

function createTable($table,$fname)
{
  global $link_cms;
  global $database_cms;
  echo "Creating table:".$table."<br>";
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("createTable($table)");
  $query = "create table ".$table."(";
  $fp = fopen($fname,"r");
  $cnt = 1;
  $primaryKey = "";
  while (($data = fgetcsv($fp,0,",")) !== FALSE)
  {
    $fieldName = $data[0];
   	$dataType = $data[1];
   	if ($cnt <> 1)
   	{
   		$query = $query.",";
   	}
   	else
   	{
   		$primaryKey = $fieldName;
   	}
   	$query = $query."`".$fieldName."` ".formatDataType($dataType);
   	if ($cnt == 1)
   	{
   		$query = $query." auto_increment";
   	}
   	$cnt++;
  }
  $query = $query.", primary key (`$primaryKey`)) ENGINE=MyISAM";
  fclose($fp);
  $result = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
}
function addTableField($table,$field,$dataType)
{
  global $link_cms;
  global $database_cms;
  echo "Adding Field:".$field."<br>";
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("addTableField($table,$field,$dataType)");
	$query = "alter table ".$table." add column ".$field." ".formatDataType($dataType);
	$results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
}
function modifyTableField($table,$field,$dataType)
{
  global $link_cms;
  global $database_cms;
  echo "Modify Field:".$field."<br>";
  DebugText("modifyTableField($table,$field,$dataType");
  mysqli_select_db($link_cms,$database_cms);	 // Reselect to make sure db is selected
  DebugText("modifyTableField($table,$field,$dataType)");
	$query = "alter table ".$table." change column ".$field." ".$field." ".formatDataType($dataType);
	$results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
}
function formatDataType($dataType)
{
	if ($dataType == "datetime")
	{
		return $dataType;
	}
	if ($dataType == "date")
	{
		return $dataType;
	}
	if ($dataType == "longblob")
	{
		return $dataType;
	}
	if ($dataType == "text")
	{
		return $dataType;
	}

	if (substr($dataType,0,4) == "int(")
	{
		$type = "integer";
		if (strpos($dataType,"unsigned"))
		{
			$type = $type." unsigned";
		}
		return $dataType;
	}
	if (substr($dataType,0,8)== "varchar(")
	{
		return $dataType;
	}
	return $dataType;
}
function doQuery($query)
{
  global $link_cms;
  global $database_cms;
	DebugText("[doQuery]");

  $results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
	$rows = array();
	$cnt = 0;
	while ($row = mysqli_fetch_array($results))
	{
	 	$rows[$cnt++] = $row;
	}
	return $rows;
}
function executeQuery($query)
{
  global $link_cms;
  global $database_cms;
	DebugText("[doQuery]");

  $results = mysqli_query($link_cms,$query);
	DebugText($query);
	DebugText("Error:".mysqli_error($link_cms));
  }
?>
