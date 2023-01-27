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
<div class="adminArea">
<?php
include_once "tracker/spec.php";
include_once "tracker/assetType.php";
include_once "tracker/specToAssetType.php";

$assetTypeId = 0;
if (isset($request_uri[2]))
{
	$assetTypeId = $request_uri[2];
}
$assetType = new AssetType($assetTypeId);
?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/assetType.php">
	<?php CreateHiddenField("assetTypeId",$assetTypeId);?>
	<table width="600px">
	 <tr>
		 <th>
		 Available Modules
		 </th>
		 <th>
		 My Modules
		 </th>
	 </tr>
	 <tr>
		 <td>
			 <div class='pane' id='availableModules'>


       </div>
		 </td>
		 <td>
			 <div class='pane' id='myModules'>

		 </div>
		 </td>
	 </tr>
 </table>
</form>
</div>
