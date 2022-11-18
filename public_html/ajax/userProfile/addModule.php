<?php
/*
 * Created on Jan 2, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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