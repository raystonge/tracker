<?php
/*
 * Created on Feb 6, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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