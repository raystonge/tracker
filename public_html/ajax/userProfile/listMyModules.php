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
include_once "tracker/set.php";
$myMods = new Set(",");
$param = "sectionValue='userId$currentUser->userId' and keyValue like 'myMod%'";
?>
<div id="myMods_rlist" class="ui-droppable">
  <ul id="myModList" class="myMods ui-sortable">

<?php
$cnt = 1;
$ok = $control->Get($param);
while ($ok)
{
	$module = new Module($control->valueInt);

	?>
            <li class='lritem' id='moduleId_<?php echo $module->moduleId;?>'>
                <div class="itemLeft">
                  <span class='list_num'><?php echo $cnt++;?></span><br/>
                </div>
                <span <?php if ($showMouseOvers) {echo "title='$module->description'";}?>>
                <?php echo $module->name;?>
                </span>

                <div class='roptions'>
                    <a href='#' class='r_delete'>
                      <img src='/images/layout/icon_trash.png'/>
                    </a>
                    <br/>
                </div>
              </li>
	<?php
	$ok = $control->Next();
}
?>
  </ul>
</div>
