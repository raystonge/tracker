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
	                  if ($permission->hasPermission("Asset: List"))
	                  {
	                  	$caret = "";
	                  	if ($permission->hasPermission("Asset: Create"))
	                  	{
	                  		$caret = "<b class='caret'></b>";
	                  	}
	                  	?>
                        <li id="menu-item-11" class="<?php echo $assetClass;?>" data-dropdown="dropdown"><a href="/listAssets/" class="dropdown-toggle">Assets <?php echo $caret;?> </a>
                        <?php
                        if ($permission->hasPermission("Asset: Create") ||$permission->hasPermission("Asset: Import") || $permission->hasPermission("Asset: Create Software") )
                        {
                      	?>
	                     <ul class="dropdown-menu">
	                     <?php
	                     $newAsset = "/assetNew/";
	                     $userToOrganization = new UserToOrganization();
	                     $param = AddEscapedParam("","userId",$currentUser->userId);
	                     $userToOrganization->Get($param);
	                     if ($userToOrganization->numRows > 1)
	                     {
	                     	$newAsset = "/newAsset/";
	                     }
	                     if ($permission->hasPermission("Asset: Create"))
	                     {
	                     ?>
	                      <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="<?php echo $newAsset;?>">New</a></li>
                          <?php
	                     }
	                     if ($permission->hasPermission("Asset: Create Software"))
	                     {
	                     	?>
	                      <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/assetNewSoftware/">New Software</a></li>
                          <?php
	                     }
	                     if ($permission->hasPermission("Asset: Import"))
	                     {
	                      ?>
	                      <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/assetImport/">Import</a></li>
                          <?php
	                     }
                       if ($permission->hasPermission("Asset: eWaste"))
                       {
                        ?>
                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/assetDoeWaste/">Do eWaste</a></li>
                           <?php
                       }
	                    ?>
                      </ul>
                      <?php
	                  }
	                  }
	                  ?>
