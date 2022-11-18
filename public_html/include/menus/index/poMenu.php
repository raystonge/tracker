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
