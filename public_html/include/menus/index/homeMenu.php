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
	                    if ($currentUser->userId)
	                    {
	                  	$caret = "";
	                  	$dropDown = "";
	                  		$caret = "<b class='caret'></b>";
	                  		$dropDown = "data-dropdown='dropdown'";
	                  		$dropDownToggle = "class='dropdown-toggle'";
	                    	?>

	                        <li id="menu-item-9" class="<?php echo $homeClass;?>" data-dropdown="dropdown"><a href="/" class="dropdown-toggle">Home <?php echo $caret;?></a>
	                          <ul class="dropdown-menu">
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/userProfile/">User Profile</a></li>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/systemNotes/">System Notes</a></li>
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="/logout/">Logout</a></li>
                             </ul>
                      </li>
                      <?php
	                    }
	                    else
	                    {
	                    	?>
	                    	<li id="menu-item-20" class="<?php echo $homeClass;?>"><a href="/">Home</a></li>
	                    	<?php
	                    }
	                  ?>
