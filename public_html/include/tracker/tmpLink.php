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
class TmpLink
{
	var $initialized = 0;
	var $dbhost;
	var $dbrndString;
	var $dbuser;
	var $dbpass;
	var $dblink;

	var $results;
	var $row;

	var $tmpLinkId;
	var $rndString;
	var $userId;
	var $password;
	var $orderBy;

	var $className = "TmpLink";
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
		$this->tmpLinkId = 0;
		$this->rndString = "";
		$this->userId = 0;
		$this->password = "";
		$this->orderBy = "tmpLinkId";
		$this->page = 1;
		$this->start = 0;
		$this->perPage = 0;
		$this->limit = 0;
	}
	function SetOrderBy($orderBy)
	{
		$this->orderBy = $orderBy;
	}
	function Get($param)
	{
		DebugText($this->className . "[Get]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected

		$query = "Select * from tmpLink";
		if ($param)
		{
			$query = $query . " where " . $param;
		}
		if (strlen(trim($this->orderBy)))
		{
			$query = $query . " order by " . $this->orderBy;
		}
		$this->results = mysqli_query($link_cms,$query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
		return ($this->Next());
	}
	function Next()
	{
		DebugText($this->className . "[Next]");
		if ($this->row = mysqli_fetch_array($this->results))
		{
			$this->tmpLinkId = $this->row['tmpLinkId'];
			$this->rndString = trim(stripslashes($this->row['rndString']));
			$this->userId = $this->row['userId'];
			$this->password = trim(stripslashes($this->row['password']));
		} else
		{
			$this->init();
		}
		return ($this->tmpLinkId);
	}
	function GetById($id)
	{
		DebugText($this->className . "[GetById]");
		if (!is_numeric($id))
		{
			return;
		}
		$param = "tmpLinkId = $id";
		return ($this->Get($param));

	}
	function Update()
	{
		DebugText($this->className . "[Update]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$rndString = prepForDB("tmpLink","rndString");
		$password = prepForDB("tmpLink","rndString");
		$query = "Update tmpLink set rndString='$rndString', userId=$this->userId,password='$password' where tmpLinkId = $this->tmpLinkId";
		$results = mysqli_query($link_cms,$query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function Insert()
	{
		DebugText($this->className . "[Insert]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$this->password = $this->generatePassword();
		$this->rndString = crypt($this->password);
		$rndString = prepForDB("tmpLink","rndString",$this->rndString);
		$password = prepForDB("tmpLink","rndString",$this->password);
		$query = "Insert into tmpLink (rndString,userId,password) value ('$rndString',$this->userId,'$password')";
		$results = mysqli_query($link_cms,$query);
		$this->tmpLinkId = mysqli_insert_id($link_cms);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function Delete()
	{
		DebugText($this->className . "[Insert]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$query = "delete from tmpLink where tmpLinkId=" . $this->tmpLinkId;
		$results = mysqli_query($link_cms,$query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function generatePassword()
	{
		$newPassword = "";
		for ($i = 0; $i < 8; $i++)
		{
			$newPassword = $newPassword . chr(65 + rand(0, 25));
		}
		return $newPassword;
	}
}
?>
