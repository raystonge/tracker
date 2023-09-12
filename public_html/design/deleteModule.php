<?php
//
//  Tracker - Version 1.11.0
//
//  v1.11.0
//   - fixed error when trying to delete modules
//
//  v1.8.2
//   - fixing cross site security error on delete
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
include_once "tracker/module.php";
$moduleId = GetURI(2,0);

$key = GetURI(3,"");
if (!$moduleId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteModule"))
{
	echo "This is not allowed at this time";
	exit;
}
$param = "moduleId=".$moduleId;
$module = new Module($moduleId);
if (!$module->moduleId)
{
  echo "Invalid operation";
  exit;
}
if ($permission->hasPermission("Report: Edit") || $module->userId == $currentUser->userId)
{
  $module->Delete();
  echo "Report ".$module->name." has been deleted";
}
else {
  echo "Report was not deleted";
}
?>
