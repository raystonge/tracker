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
	                    if ($permission->hasPermission("Report: List"))
	                    {
	                  	$caret = "";
	                  	if ($permission->hasPermission("Report: List"))
	                  	{
	                  		$caret = "<b class='caret'></b>";
	                  	}
	                    	?>
	                        <li id="menu-item-9" class="<?php echo $reportClass;?>" data-dropdown="dropdown"><a href="/listReports/" class="dropdown-toggle">Reports <?php echo $caret;?></a>
                              <ul class="dropdown-menu">
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/viewReports/">Reports</a></li>
	                        <?php
	                        if ($permission->hasPermission("Report: Bad Asset"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/listBadAssets/">Bad Assets</a></li>
                             <?php
	                        }
	                        if ($permission->hasPermission("Report: Create Ticket"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/createTicketReport/">Create Ticket Report</a></li>
                             <?php
	                        }

	                        if ($permission->hasPermission("Report: Create Asset"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/createAssetReport/">Create Asset Report</a></li>
                             <?php
	                        }
	                        ?>
	                        <?php
	                        if ($permission->hasPermission("Report: Billing"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/billing/">Billing</a></li>
                             <?php
	                        }
	                        if ($permission->hasPermission("Report: Personal Property"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/personalProperty/">Personal Property</a></li>
                             <?php
	                        }
	                        ?>
                          <?php
	                        if ($permission->hasPermission("Report: Leases"))
	                        {
	                        	?>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/leases/">Leases</a></li>
                             <?php
	                        }
													if ($permission->hasPermission("Report: Assign Personal Property Building"))
													{
														?>
														 <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/assignPPBuilding/">Assign Personal Property Building</a></li>
														 <?php
													}
                          if ($permission->hasPermission("Report: Moves"))
                          {
                            ?>
                             <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/moveReport/">Assets that have moved building</a></li>
                             <?php
                          }
                          ?>
                             </ul>

                      </li>
                      <?php
	                    }
	                  ?>
