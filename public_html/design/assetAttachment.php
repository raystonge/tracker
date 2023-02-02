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
PageAccess("Asset: View Attachments");
include_once "tracker/assetType.php";
include_once "tracker/ticket.php";
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}

include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset($assetId);
$ticket = new Ticket();
$assetType = new AssetType($asset->assetTypeId);
include $sitePath."/design/asset/assetInfoHeader.php";
?>
<div class="adminArea">
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
     include $sitePath."/design/asset/attachment.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
