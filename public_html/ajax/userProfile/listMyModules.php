<?php
/*
 * Created on Jan 1, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
