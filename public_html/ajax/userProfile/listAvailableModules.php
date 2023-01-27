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
include_once "tracker/userGroup.php";
include_once "tracker/userToGroup.php";
include_once "tracker/set.php";
$userGroup = new UserGroup();
$param = "name='Admin'";
$userGroup->Get($param);

$userToUserGroup = new UserToGroup();
$myMods = new Set(",");
$param = "sectionValue='userId$currentUser->userId' and keyValue like 'myMod%'";
$ok = $control->Get($param);
while ($ok)
{
	$myMods->Add($control->valueInt);
	$ok = $control->Next();
}
$module = new Module();
$param = "userId=".$currentUser->userId." and userGroupId=".$userGroup->userGroupId;
$isAdmin = $userToUserGroup->Get($param);
DebugText("figure out if user is assignee");
$param = "assignee=1";
$ok = $userGroup->Get($param);
$assigneeGroups = new Set(",");
while ($ok)
{
	$assigneeGroups->Add($userGroup->userGroupId);
	$ok = $userGroup->Next();
}
$assigneeGroups->Add(0);
$param = "userId=".$currentUser->userId." and userGroupId in (".$assigneeGroups->data.")";
$isAssignee = $userToUserGroup->Get($param);
DebugText("isAssignee:".$isAssignee);
$param1 = "";
$param = "userId = $currentUser->userId or userId=0";
if (strlen($myMods->data))
{
	$param1 = "moduleId not in($myMods->data)";
}
if ($isAdmin)
{
	$param = AddOrParam($param,"admin=1");
}
if ($isAssignee)
{
	$param = AddOrParam($param,"assignee=1");
}
if (strlen($param1))
{
	$param ="(".$param.") and ".$param1;
}
?>
<div id="availableMods_rlist">
  <ul class="ui-sortable">

<?php
$cnt = 1;
$ok = $module->Get($param);
while ($ok)
{
	?>
            <li class='lritem ui-draggable mods' id='itemId_<?php echo $module->moduleId;?>'>
                <div class="itemLeft">
                  <span class='list_num'><?php echo $cnt++;?></span><br/>
                </div>
                <span <?php if ($showMouseOvers) {echo "title='$module->description'";}?>>
                <?php echo $module->name;?>
                </span>
                <!--
                <div class='roptions'>
                    <a href='#' class='r_delete'>
                      <img src='/images/layout/icon_trash.png'/>
                    </a>
                    <br/>

                </div>
              </li>
                -->
	<?php
	$ok = $module->Next();
}
?>
  </ul>
</div>
<?php //DebugOutput();?>
