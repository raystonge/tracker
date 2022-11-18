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
include_once "tracker/spec.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/set.php";
$myMods = new Set(",");
$param = "sectionValue='userId$currentUser->userId' and keyValue like 'myMod%'";
$assetTypeId = GetTextField("assetTypeId",0);
?>
<div id="myMods_rlist" class="ui-droppable">
  <ul id="myModList" class="myMods ui-sortable">
    <?php
    $cnt = 1;
    $param = AddEscapedParam("","assetTypeId",$assetTypeId);

    $specToAssetType = new SpecToAssetType();
    $ok = $specToAssetType->Get($param);
    while ($ok)
    {
      $spec = new Spec($specToAssetType->specId);
      ?>
      <li class='lritem' id='moduleId_<?php echo $spec->specId;?>'>
          <div class="itemLeft">
            <span class='list_num'><?php echo $cnt++;?></span><br/>
          </div>

          <?php echo $spec->name;?>
          </span>

        </li>
      <?php
      $ok = $specToAssetType->Next();
    }

    ?>
  </ul>
</div>
