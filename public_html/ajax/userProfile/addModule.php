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
include_once "globals.php";
include_once "tracker/module.php";

  $status = "success";
  $cnt = 1;
  $id = 0;
  if (isset($_GET["moduleId"]))
  {
  	$id = $_GET["moduleId"];
  }
  $id = str_replace("itemId_","",$id);
  $module = new Module($id);
  $html = "<li id='moduleId_$id' class='lritem'><div class='itemLeft'><span class='list_num'>$cnt</span></div>";
  if ($showMouseOvers)
  {
  	$html = $html."<span title='$module->description'>";
  }
  else
  {
  	$html = $html."<span>";
  }
  $html = $html.$module->name."</span><div class='roptions'><a href='#' class='r_delete'><img src='/images/layout/icon_trash.png'/> </a> <br/>  </div></li>";
  $control = new Control();
  $control->section="userId".$currentUser->userId;
  $control->key = "myMod1";
  $control->valueInt = $id;
  $control->datatype = "integer";
  $control->Persist();
  echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$id.'"}';
 // DebugOutput();
?>
