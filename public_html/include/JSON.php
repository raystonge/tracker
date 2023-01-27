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
class JSON{
	var $cnt;
	var $cntRecords;
	var $labels;
	var $values;
	var $records;
	var $className = "JSON";
	function __construct()
	{
		$this->cnt = 0;
		$this->cntRecords = 0;
		$this->labels = array();
		$this->values = array();
		$this->records = array();
	}
	function AddValue($label,$value)
	{
		DebugText($this->className."[AddValue($label,$value)]");
		$this->labels[$this->cnt] = $label;
		$this->values[$this->cnt++] = $value;
	}
	function CreateRecord()
	{
		DebugText($this->className."[CreateRecord]");
		DebugText("cnt:".$this->cnt);
		$data = "";
		for ($i=0; $i < $this->cnt;$i++)
		{
			if (strlen($data))
			{
				$data = $data.",";
			}
			$data = $data.'"'.$this->labels[$i].'":"'.$this->values[$i].'"';
		}
		$data = "{".$data."}";
		$this->records[$this->cntRecords++]=$data;
		$this->labels = array();
		$this->values = array();
		$this->cnt = 0;
	}
	function GetRecord($recordNum=1)
	{
		DebugText($this->className."[GetRecord]");
		return ($this->records[$recordNum-1]);
	}

	function GetArray()
	{
		DebugText($this->className."[GetArray]");
		$data = "";
		for ($i = 0; $i < $this->cntRecords; $i++)
		{
			if (strlen($data))
			{
				$data = $data.",";
			}
			$data = $data.$this->records[$i];
		}
		$data = "[".$data."]";
		return $data;
	}
}
?>
