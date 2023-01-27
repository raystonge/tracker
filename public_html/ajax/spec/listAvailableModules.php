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
