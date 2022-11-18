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
$assetTypeId = GetTextField("assetTypeId",0);
?>

<div id="availableMods_rlist">
  <ul class="ui-sortable">

		<?php
		$cnt = 1;
		$param = AddEscapedParam("","assetTypeId",$assetTypeId);

		$spec = new Spec();
		$ok = $spec->Get("");
		while ($ok)
		{
			$specToAssetType = new SpecToAssetType();
			if (!$specToAssetType->Get($param))
			{
				?>
				<li class='lritem' id='moduleId_<?php echo $spec->specId;?>'>
						<div class="itemLeft">
							<span class='list_num'><?php echo $cnt++;?></span><br/>
						</div>

						<?php echo $spec->name;?>
						</span>

					</li>
				<?php
			}
			$ok = $spec->Next();
		}


		?>
  </ul>
</div>
<?php //DebugOutput();?>
