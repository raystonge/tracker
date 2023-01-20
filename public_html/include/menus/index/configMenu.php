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
