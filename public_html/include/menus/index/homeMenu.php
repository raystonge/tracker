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
	                           <!--<li id="menu-item-13" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-13"><a href="/blog/category/news/state/">State</a></li>-->
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
