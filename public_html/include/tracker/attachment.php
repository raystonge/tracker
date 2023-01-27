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
include_once "tracker/mimeType.php";
class Attachment {
	var $initialized = 0;
	var $dbhost;
	var $dbname;
	var $dbuser;
	var $dbpass;
	var $dblink;

	var $results;
	var $row;

	var $attachmentId;
	var $assetId;
	var $ticketId;
	var $contractId;
	var $originalName;
	var $ext;
	var $mimeTypeId;
	var $url;
	var $uploadDate;
	var $userId;
	var $poNumberId;

	var $orderBy;
	var $limit;
	var $page;
	var $perPage;
	var $start;
	var $numRows;

	var $className = "Attachment";

	function __construct() {
		$a = func_get_args();
		$i = func_num_args();
		if (method_exists($this, $f = '__construct' . $i)) {
			call_user_func_array(array (
				$this,
				$f
			), $a);
		} else {
			$this->init();
		}
	}
	function __construct0() {
		$this->init();
	}
	function __construct1($id) {
		$this->init();
		$this->GetById($id);
	}

	function init() {
		global $now;

		DebugText($this->className . "[Init]");
		$this->initialized = 1;
		$this->assetId = 0;
		$this->ticketId = 0;
		$this->contractId = 0;
		$this->attachmentId = 0;
		$this->originalName = "";
		$this->ext = "";
		$this->url = "";
		$this->mimeTypeId = "";
		$this->userId = 0;
		$this->poNumberId = 0;
		$this->uploadDate = $now;
		$this->orderBy = "title";

		$this->page = 1;
		$this->start = 0;
		$this->perPage = 0;
		$this->limit = 0;
		return;
	}

	function GetById($id) {
		DebugText($this->className . "[GetById]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected

		if (!is_numeric($id)) {
			$this->attachmentId = 0;
			return 0;
		}
		$param = "attachmentId = $id";
		return ($this->Get($param));

	}
	function Count($param) {
		DebugText($this->className . "[Count]");
		global $link_cms;
		global $database_cms;
		$this->numRows = 0;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$query = "Select count(*) as numRows from attachment";
		if ($param) {
			$query = $query . " where " . $param;
		}
		$this->results = mysqli_query($link_cms, $query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
		if ($this->row = mysqli_fetch_array($this->results)) {
			$this->numRows = $this->row['numRows'];
		}
		return ($this->numRows);

	}

	function Get($param) {
		DebugText($this->className . "[Get]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$query = "Select * from attachment";
		if ($param) {
			$query = $query . " where " . $param;
		}
		$query = $query . " order by attachmentId asc";
		$this->results = mysqli_query($link_cms, $query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
		return ($this->Next());
	}
	function Next() {
		DebugText($this->className . "[Next]");
		if ($this->row = mysqli_fetch_array($this->results)) {
			$this->attachmentId = $this->row['attachmentId'];
			$this->assetId = $this->row['assetId'];
			$this->ticketId = $this->row['ticketId'];
			$this->contractId = $this->row['contractId'];
			$this->originalName = trim(stripslashes($this->row['originalName']));
			$this->url = trim(stripslashes($this->row['url']));
			$this->mimeTypeId = trim(stripslashes($this->row['mimeTypeId']));
			$this->ext = $this->row['ext'];
			$this->userId = $this->row['userId'];
			$this->poNumberId = $this->row['poNumberId'];
			$this->uploadDate = $this->row['uploadDate'];
		} else {
			$this->init();
		}
		return ($this->attachmentId);
	}
	function Insert() {
		DebugText($this->className . "[Insert]");
		global $link_cms;
		global $database_cms;
		global $currentUser;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected

		$originalName = prepForDB("attachment", "originalName", $this->originalName);
		$url = prepForDB("attachment", "url", $this->url);
		$uploadDate = prepForDB("attachment", "uploadDate", $this->uploadDate);
		$userId = $currentUser->userId;
		$query = "insert into attachment(assetId,ticketId,contractId,poNumberId,originalName,ext,mimeTypeId,url,uploadDate,userId) value ($this->assetId,$this->ticketId,$this->contractId,$this->poNumberId,'$originalName','$this->ext',$this->mimeTypeId,'$url','$uploadDate',$this->userId)";

		$results = mysqli_query($link_cms, $query);
		$this->attachmentId = mysqli_insert_id($link_cms);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function Update() {
		DebugText($this->className . "[Update]");
		global $link_cms;
		global $database_cms;
		global $currentUser;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		$originalName = prepForDB("attachment", "originalName", $this->originalName);
		$url = prepForDB("attachment", "url", $this->url);
		$uploadDate = prepForDB("attachment", "uploadDate", $this->uploadDate);
		$this->userId = $currentUser->userId;
		$query = "Update attachment set ticketId=$this->ticketId, poNumberId=$this->poNumberId,userId = $this->userId,contractId=$this->contractId,assetId=$this->assetId,ext='$this->ext',originalName='$originalName',mimeTypeId=$this->mimeTypeId, url='$url',uploadDate = '$uploadDate' where attachmentId = $this->attachmentId";
		$results = mysqli_query($link_cms, $query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}
	function Delete() {
		global $sitePath;
		DebugText($this->className . "[Delete]");
		global $link_cms;
		global $database_cms;
		mysqli_select_db($link_cms, $database_cms); // Reselect to make sure db is selected
		if (!$this->attachmentId) {
			return;
		}
		$type = "ticket/" . $this->ticketId;
		if ($this->assetId) {
			$type = "asset/" . $this->assetId;
		} else
			if ($this->contractId) {
				$type = "contract/" . $this->contractId;
			}

		$path = $sitePath . "/attachments/" . $type . "/" . $this->originalName;
		if (!($this->mimeType == "url")) {
			@ unlink($path);
		}
		$query = "Delete from attachment where attachmentId = $this->attachmentId";
		$results = mysqli_query($link_cms, $query);
		DebugText($query);
		DebugText("Error:" . mysqli_error($link_cms));
	}

	function attachmentPath() {
		DebugText($this->className . "[attachmentPath]");
		global $sitePath;
		$attachmentPath = "/attachments";
		if ($this->assetId) {
			$attachmentPath = $attachmentPath . "/asset/" . $this->assetId;
		} else {
			if ($this->ticketId) {
				$attachmentPath = $attachmentPath . "/ticket/" . $this->ticketId;
			} else {
				if ($this->contractId) {
					$attachmentPath = $attachmentPath . "/contract/" . $this->contractId;
				}
				else
				{
					if ($this->poNumberId)
					{
						$attachmentPath = $attachmentPath . "/poNumber/" . $this->poNumberId;
					}
				}
			}
		}
		$path = $sitePath . $attachmentPath . "/" . $this->originalName;
		return $path;
	}
	function attachmentViewer() {
		DebugText($this->className . "[attachmentPath]");
		global $hostPath;
		$attachmentPath = "/attachments";
		if ($this->assetId) {
			$attachmentPath = $attachmentPath . "/asset";
		} else {
			$attachmentPath = $attachmentPath . "/ticket";
		}
		$path = "";
		$mimeType = new MimeType($this->mimeTypeId);
		DebugText("mimeType:".$mimeType->handler);
		switch ($mimeType->handler) {
			case "browser"  : $path=$this->url;
			              break;
			case "text" :
				$path = $hostPath . "/process/attachment/viewText.php?id=" . $this->attachmentId;
				break;
			case "image" :
				$path = $hostPath . "/process/attachment/viewImage.php?id=" . $this->attachmentId;
				break;
			case "pdf" :
				$path = $hostPath . "/process/attachment/viewPDF.php?id=" . $this->attachmentId;
				break;
			case "default" :
				$path = $hostPath . "/process/attachment/viewAttachment.php?id=" . $this->attachmentId;
				break;
			default :
				$path = $hostPath . $attachmentPath . "/" . $this->attachmentId . $this->ext;
		}
		DebugText("assetViewer:" . $path);
		return $path;
	}
	function Persist() {
		if ($this->attachmentId) {
			$this->Update();
		} else {
			$this->Insert();
		}
	}
}
?>
