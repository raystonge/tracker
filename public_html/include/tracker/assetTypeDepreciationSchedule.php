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
class AssetTypeDepreciationSchedule
{
  public $results;
  protected $isDirty;
  public $row;
  public $className="AssetTypeDepreciationSchedule";
  public $cacheKey;
  public $orderBy;
  public $limit;
  public $page;
  public $perPage;
  public $start;
  public $numRows;
  public $_assoc;
  public $ttl;
  public $isLazy = 1;
  public $isLoaded = 0;
  public $assetTypeDepreciationScheduleId;
  public $assetTypeId;
  public $year1;
  public $year2;
  public $year3;
  public $year4;
  public $year5;
  public $year6;
  public $year7;
  public $year8;
  public $year9;
  public $year10;
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
      $this->_init();
    }
  }

  function __construct0()
  {
    $this->_init();
  }

  function __construct1($id)
  {
      $this->_init();
      if (!$this->isLazy)
      {
        $this->GetById($id);
      }
      else
      {
        $this->id = $id;
      }
  }

  function getIsDirty()
  {
  	return $this->isDirty;
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
  function SetTTL($ttl)
  {
    DebugText($this->className."[SetTTL($ttl]");
  	 $this->ttl = $ttl;
  	 DebugText("Setting TTL:".$this->ttl);
  }
  function SetCacheKey($cacheKey)
  {
  	 DebugText($this->className."[SetCacheKey($cacheKey]");
  	 $this->cacheKey = $cacheKey;
  	 DebugText("Setting cacheKey:".$this->cacheKey);
  }
  function _init()
  {
    $this->ttl = 1000;
    $this->_assoc = "";
    $this->page= 0;
    $this->orderBy= "";
    $this->limit= 0;
    $this->isLoaded= 0;
    $this->isDirty= 0;
    $this->assetTypeDepreciationScheduleId = 0;
    $this->assetTypeId = 0;
    $this->year1 = 0;
    $this->year2 = 0;
    $this->year3 = 0;
    $this->year4 = 0;
    $this->year5 = 0;
    $this->year6 = 0;
    $this->year7 = 0;
    $this->year8 = 0;
    $this->year9 = 0;
    $this->year10 = 0;
  }
  function getAssetTypeDepreciationScheduleId()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->assetTypeDepreciationScheduleId;
  }
  function setAssetTypeDepreciationScheduleId($assetTypeDepreciationScheduleId)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->assetTypeDepreciationScheduleId= $assetTypeDepreciationScheduleId;
  }

  function getAssetTypeId()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->assetTypeId;
  }
  function setAssetTypeId($assetTypeId)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->assetTypeId= $assetTypeId;
  }

  function getYear1()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year1;
  }
  function setYear1($year1)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year1= $year1;
  }

  function getYear2()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year2;
  }
  function setYear2($year2)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year2= $year2;
  }

  function getYear3()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year3;
  }
  function setYear3($year3)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year3= $year3;
  }

  function getYear4()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year4;
  }
  function setYear4($year4)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year4= $year4;
  }

  function getYear5()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year5;
  }
  function setYear5($year5)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year5= $year5;
  }

  function getYear6()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year6;
  }
  function setYear6($year6)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year6= $year6;
  }

  function getYear7()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year7;
  }
  function setYear7($year7)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year7= $year7;
  }

  function getYear8()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year8;
  }
  function setYear8($year8)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year8= $year8;
  }

  function getYear9()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year9;
  }
  function setYear9($year9)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year9= $year9;
  }

  function getYear10()
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    return $this->year10;
  }
  function setYear10($year10)
  {
    if (!$this->isLoaded && $this->isLazy && $this->assetTypeDepreciationScheduleId)
    {
  	   $this->GetById($this->assetTypeDepreciationScheduleId);
    }
    $this->isDirty = 1;
    $this->year10= $year10;
  }

  function GetById($id)
  {
  	global $appName;
  	if (is_numeric($id))
  	{
  		$this->cacheKey = $appName."_".$this->className."_".$id;
  		$param = "assetTypeDepreciationScheduleId =".$id;
  		$this->Get($param);
  	}
     else
     {
        $this->_init();
     }
  }
  function Get($param="")
  {
  	DebugText($this->className."[Get]");
  	global $link_cms;
  	global $database_cms;
  	global $memcache;
  	global $dbCache;
  	global $appName;
  	mysqli_select_db($link_cms,$database_cms);
  	$this->start = ($this->page-1)*$this->perPage;
  	$query = "Select * from assetTypeDepreciationSchedule";
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
  function doQuery($query)
  {
  	DebugText($this->className."[doQuery]");
  	global $link_cms;
  	global $database_cms;
  	global $memcache;
  	global $dbCache;
  	global $appName;
  	mysqli_select_db($link_cms,$database_cms);
  	$this->start = ($this->page-1)*$this->perPage;
  	$this->results = mysqli_query($link_cms,$query);
  	DebugText($query);
  	DebugText("Error:".mysqli_error($link_cms));
     return($this->Next());
  }
  function Next()
  {
    $this->isLoaded = 1;
    $this->isDirty= 0;
    if ($row = mysqli_fetch_array($this->results))
    {
  		$this->assetTypeDepreciationScheduleId = trim(stripslashes($row['assetTypeDepreciationScheduleId']));
  		$this->assetTypeId = trim(stripslashes($row['assetTypeId']));
  		$this->year1 = trim(stripslashes($row['year1']));
  		$this->year2 = trim(stripslashes($row['year2']));
  		$this->year3 = trim(stripslashes($row['year3']));
  		$this->year4 = trim(stripslashes($row['year4']));
  		$this->year5 = trim(stripslashes($row['year5']));
  		$this->year6 = trim(stripslashes($row['year6']));
  		$this->year7 = trim(stripslashes($row['year7']));
  		$this->year8 = trim(stripslashes($row['year8']));
  		$this->year9 = trim(stripslashes($row['year9']));
  		$this->year10 = trim(stripslashes($row['year10']));
    }
    else
    {
      $this->_init();
    }
  }
  function _update()
  {
  	DebugText($this->className."[_update]");
  	global $link_cms;
  	global $database_cms;
  	global $today;
  	global $appName;
  	global $memcache;
  	global $dbCache;
  	mysqli_select_db($link_cms,$database_cms);
  	$assetTypeDepreciationScheduleId = prepForDB("assetTypeDepreciationSchedule","assetTypeDepreciationScheduleId",$this->assetTypeDepreciationScheduleId);
  	$assetTypeId = prepForDB("assetTypeDepreciationSchedule","assetTypeId",$this->assetTypeId);
  	$year1 = prepForDB("assetTypeDepreciationSchedule","year1",$this->year1);
  	$year2 = prepForDB("assetTypeDepreciationSchedule","year2",$this->year2);
  	$year3 = prepForDB("assetTypeDepreciationSchedule","year3",$this->year3);
  	$year4 = prepForDB("assetTypeDepreciationSchedule","year4",$this->year4);
  	$year5 = prepForDB("assetTypeDepreciationSchedule","year5",$this->year5);
  	$year6 = prepForDB("assetTypeDepreciationSchedule","year6",$this->year6);
  	$year7 = prepForDB("assetTypeDepreciationSchedule","year7",$this->year7);
  	$year8 = prepForDB("assetTypeDepreciationSchedule","year8",$this->year8);
  	$year9 = prepForDB("assetTypeDepreciationSchedule","year9",$this->year9);
  	$year10 = prepForDB("assetTypeDepreciationSchedule","year10",$this->year10);
    $query = "update assetTypeDepreciationSchedule set assetTypeDepreciationScheduleId='$assetTypeDepreciationScheduleId', assetTypeId='$assetTypeId', year1='$year1', year2='$year2', year3='$year3', year4='$year4', year5='$year5', year6='$year6', year7='$year7', year8='$year8', year9='$year9', year10='$year10' where assetTypeDepreciationScheduleId=$this->assetTypeDepreciationScheduleId";
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
   DebugText(mysqli_error($link_cms));
  	if ($dbCache)
  	{
  		$cacheKey = $appName."_".$this->className."_".$this->assetTypeDepreciationScheduleId;
  		$setKey = md5($cacheKey);
  		$memcache->delete($setKey);
  	}
    $this->isDirty= 0;
  	return $this->assetTypeDepreciationScheduleId;
  }
  function _insert()
  {
  	DebugText($this->className."[_insert]");
  	global $link_cms;
  	global $database_cms;
  	global $today;
  	mysqli_select_db($link_cms,$database_cms);
    $assetTypeDepreciationScheduleId = prepForDB("assetTypeDepreciationSchedule","assetTypeDepreciationScheduleId",$this->assetTypeDepreciationScheduleId);
    $assetTypeId = prepForDB("assetTypeDepreciationSchedule","assetTypeId",$this->assetTypeId);
    $year1 = prepForDB("assetTypeDepreciationSchedule","year1",$this->year1);
    $year2 = prepForDB("assetTypeDepreciationSchedule","year2",$this->year2);
    $year3 = prepForDB("assetTypeDepreciationSchedule","year3",$this->year3);
    $year4 = prepForDB("assetTypeDepreciationSchedule","year4",$this->year4);
    $year5 = prepForDB("assetTypeDepreciationSchedule","year5",$this->year5);
    $year6 = prepForDB("assetTypeDepreciationSchedule","year6",$this->year6);
    $year7 = prepForDB("assetTypeDepreciationSchedule","year7",$this->year7);
    $year8 = prepForDB("assetTypeDepreciationSchedule","year8",$this->year8);
    $year9 = prepForDB("assetTypeDepreciationSchedule","year9",$this->year9);
    $year10 = prepForDB("assetTypeDepreciationSchedule","year10",$this->year10);
    $query = "Insert into assetTypeDepreciationSchedule (assetTypeDepreciationScheduleId, assetTypeId, year1, year2, year3, year4, year5, year6, year7, year8, year9, year10) Values ( '$assetTypeDepreciationScheduleId', '$assetTypeId', '$year1', '$year2', '$year3', '$year4', '$year5', '$year6', '$year7', '$year8', '$year9', '$year10')";
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
    DebugText(mysqli_error($link_cms));
    $this->isDirty= 0;
  	$this->assetTypeDepreciationScheduleId = mysqli_insert_id($link_cms);
  	return $this->assetTypeDepreciationScheduleId;
  }
  function Delete()
  {
  	DebugText($this->className."[Delete]");
  	global $link_cms;
  	global $database_cms;
  	mysqli_select_db($link_cms,$database_cms);
  	if ($this->assetTypeDepreciationScheduleId <= 0)
  	{
  		DebugText("assetTypeDepreciationScheduleId <= 0($this->assetTypeDepreciationScheduleId)");
  		return;
  	}
  	$query = "delete from address where id=".$this->assetTypeDepreciationScheduleId;
  	$results = mysqli_query($link_cms,$query);
  	DebugText($query);
    DebugText(mysqli_error($link_cms));
    $this->_init();
  }
  function Persist()
  {
    DebugText($this->className."[Persist]");
    DebugText("isDirty:".$this->isDirty);

    if ($this->getAssetTypeDepreciationScheduleId())
    {
      $this->_update();
    }
    else
    {
      $this->_insert();
    }
  }
}
?>
