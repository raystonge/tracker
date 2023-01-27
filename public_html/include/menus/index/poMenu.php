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
	                    if ($permission->hasPermission("PO: List"))
	                    {
	                  	$caret = "";
	                  	if ($permission->hasPermission("poNumber: Create"))
	                  	{
	                  		$caret = "<b class='caret'></b>";
	                  	}
	                    	?>
	                        <li id="menu-item-9" class="<?php echo $poClass;?>" data-dropdown="dropdown"><a href="/listpoNumber/" class="dropdown-toggle">PO Numbers <?php echo $caret;?></a>
	                        <?php
	                        $newTicket = "/poNumberNew/";
	                        if ($permission->hasPermission("poNumber: Create"))
	                        {
	                        	?>
                              <ul class="dropdown-menu">
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newTicket;?>">New</a></li>
                             </ul>
                             <?php
	                        }
	                        ?>
                      </li>
                      <?php
	                    }
	                  ?>
