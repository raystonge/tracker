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
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset($assetId);
$label = "";
if (strlen($asset->name))
{
	$label = $asset->name;
}
else
{
	$label = $asset->serialNumber;
}
echo $label." - ";
?>
<a href="/process/asset/createTicket.php?assetId=<?php echo $asset->assetId;?>">Create Ticket for Asset</a>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active">
	                    <a href='/editTicket/<?php echo $assetId;?>/' title='Ticket'><span>Asset</span></a>
	                  </li>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/ticketsAsset/<?php echo $assetId;?>/' title='Tickets'><span>Tickets</span></a></li>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/attachmentAsset/<?php echo $assetId;?>/' title='Attachments'><span>Attachments</span></a></li>
	                  <?php
	                  $assetType = new AssetType($asset->assetTypeId);
	                  if ($assetType->monitor)
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/monitorAsset/<?php echo $assetId;?>/' title='Monitor'><span>Monitor</span></a></li>
	                  <?php
	                  }
	                  ?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/historyAsset/<?php echo $assetId;?>/' title='History'><span>History</span></a></li>
	                </ul>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

<div class="clear"></div>

	<div id='tab-editor'>
     <?php
     include $sitePath."/design/asset/editor.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
</div>
