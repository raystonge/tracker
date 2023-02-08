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
	                  if ($permission->hasPermission("Config"))
	                  {
	                  		$caret = "<b class='caret'></b>";

	                  	?>
                      <li id="menu-item-11" class="<?php echo $configClass;?>" data-dropdown="dropdown"><a href="/config/" class="dropdown-toggle">Config <?php echo $caret;?> </a>
                        <ul class="dropdown-menu">
                          <?php
                          if ($permission->hasPermission("Config: Asset Condition"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listAssetCondition/">Asset Condition</a></li>
	                      <?php
                          }
                          ?>

                          <?php
                          if ($permission->hasPermission("Config: Asset Type"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listAssetType/">Asset Type</a></li>
	                      <?php
                          }
                          ?>
													<?php
													if ($permission->hasPermission("Config: Service"))
													{
														?>
													<li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listServices/">Services</a></li>
												<?php
													}
													?>
                          <?php
                          if ($permission->hasPermission("Config: Building"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listBuildings/">Buildings</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Controls"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listControls/">Controls</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Organization"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listOrganizations/">Organizations</a></li>
	                      <?php
                          }
                          ?>
													<?php
                          if ($permission->hasPermission("Config: Specs"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listSpecs/">Specs</a></li>
	                      <?php
                          }
                          ?>
													<?php
													if ($permission->hasPermission("Config: Organization"))
													{
														?>
													<li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listModules/">Modules</a></li>
												<?php
													}
													?>
                          <?php
                          if ($permission->hasPermission("Config: PO Number"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listpoNumber/">PO Number</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Queue"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listQueues/">Queues</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Status"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listStatus/">Status</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: User"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listUsers/">Users</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: User Group"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/listUserGroups/">User Groups</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Export Structure"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/exportStructure/">Export Structure</a></li>
	                      <?php
                          }
                          ?>
                          <?php
                          if ($permission->hasPermission("Config: Upgrade"))
                          {
                          	?>
	                        <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-12"><a href="/upgrade/">Upgrade</a></li>
	                      <?php
                          }
                          ?>
                        </ul>
                      </li>
                      <?php
	                  }
	                  ?>
