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
class Set{
	var $data;
	var $separator;
	var $index;
	var $className = "Set";
	function init()
	{
		$this->data = "";
		$this->index = -2;
		$this->separator = "|";
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
	}
	function __construct0()
	{
		$this->init();
	}

	function __construct1($separator)
	{
		$this->init();
		$this->separator = $separator;
	}
	function InSet($val)
	{
		if (!strlen($this->data))
	    {
	    	return (0);
	    }
		$val = trim($val);
		if (!strlen($val))
		{
	       return (0);
		}
		$list = explode($this->separator,$this->data);
		$found = 0;
		for ($i = 0; !$found && ($i < sizeof($list)); $i++)
		{
			if ($val == $list[$i])
			{
				$found = 1;
			}
		}
		return ($found);
	}
	function Add($val)
	{
		$val = trim($val);
		if (!strlen($val))
		{
			return;
		}
		if ($this->InSet($val))
		{
			return;
		}
		if (strlen($this->data))
		{
			$this->data = $this->data.$this->separator.$val;
		}
		else
		{
			$this->data = $val;
		}
	}
	function Remove($item)
	{
		$items = explode($this->separator,$this->data);
		$index = -1;
		$found = 0;
		for ($i = 0; !$found && $i < count($items); $i++)
		{
			if ($items[$i]==$item)
			{
				$index = $i;
				$found = 1;
			}
		}
		if ($found)
		{
			$items = array_splice($items,$index,1);
			$this->data = implode($this->separator,$items);
		}
	}
	function hasItems()
	{
		return (strlen($this->data));
	}
	function GetAsArray()
	{
		return(explode($this->separator,$this->data));
	}
	function SetData($str)
	{
		$this->data =  $str;
		$items = explode($this->separator,$this->data);
		$this->SetIndex(sizeof($items)-1);
		$this->SetIndex(0);
	}
	function SetIndex ($index)
	{
		$this->index = $index;
	}
	function GetIndex()
	{
		DebugText($this->className."[GetIndex]");
		DebugText("currentIndex:".$this->index);
		DebugText("data:".$this->data);
		if (($this->index == -2) && strlen(trim($this->data)))
		{
			$list = explode($this->separator,$this->data);
			DebugText("list size:".sizeof($list));
			if (sizeof($list))
			{
				$this->index = 0;
			}
		}
		DebugText("returning:".$this->index);
		return $this->index;
	}
	function GetValue()
	{
		if ($this->index < 0)
		{
			return("");
		}
		$list = explode($this->separator,$this->data);
		$val = $list[$this->index++];

		if ($this->index >= sizeof($list))
		{
			$this->index = -1;
		}

		return($val);
	}
	function GetSize()
	{
		if (!strlen($this->data))
		{
			return (0);
		}

		$list = explode($this->separator,$this->data);
		$val = count($list);
		return ($val);
	}
}
?>
