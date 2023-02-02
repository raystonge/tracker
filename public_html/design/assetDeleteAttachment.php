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
include_once "tracker/attachment.php";
include_once "tracker/asset.php";

$attachmentId = 0;
if (isset($request_uri[2]))
{
	$attachmentId = $request_uri[2];
}
$attachment = new Attachment($attachmentId);
$asset = new Asset($attachment->assetId);
$assetId = $asset->assetId;
$url = "/assetAttachment/".$asset->assetId."/";
include_once "tracker/assetType.php";
$assetType = new AssetType($asset->assetTypeId);
include $sitePath."/design/asset/assetInfoHeader.php";
?>
<div class="adminArea">
  <a href="/process/asset/createTicket.php?assetId=<?php echo $asset->assetId;?>">Create Ticket for Asset</a>

  <div id='main_column'>
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/asset/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

<div class="clear"></div>

	<div id='tab-editor'>
	<?php
	include $sitePath."/design/common/attachmentDelete.php";
	?>
	</div>
</div>
