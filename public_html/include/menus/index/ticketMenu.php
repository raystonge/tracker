	                  <?php
	                    if ($permission->hasPermission("Ticket: List"))
	                    {
	                  	$caret = "";
	                  	if ($permission->hasPermission("Ticket: Create"))
	                  	{
	                  		$caret = "<b class='caret'></b>";
	                  	}
	                    	?>
	                        <li id="menu-item-9" class="<?php echo $ticketClass;?>" data-dropdown="dropdown"><a href="/listTickets/" class="dropdown-toggle">Tickets <?php echo $caret;?></a>
	                        <?php
	                        $newTicket = "/ticketNew/";
	                        $userToOrganization = new UserToOrganization();
	                        $param = AddEscapedParam("","userId",$currentUser->userId);
	                        $userToOrganization->Get($param);
	                        if ($userToOrganization->numRows > 1)
	                        {
	                        	$newTicket = "/newTicket/";
	                        }
													if ($permission->hasPermission("Ticket: Create: User Ticket"))
													{
														$newTicket = "/ticketNew";
													}
	                        if ($permission->hasPermission("Ticket: Create"))
	                        {
														$newTicket = "/newTicket/";
	                        	?>
                              <ul class="dropdown-menu">
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newTicket;?>">New</a></li>
	                           <!--<li id="menu-item-13" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-13"><a href="/blog/category/news/state/">State</a></li>-->
                             </ul>
                             <?php
	                        }
													if ($permission->hasPermission("Ticket: Create: User Ticket"))
	                        {
	                        	?>
                              <ul class="dropdown-menu">
	                           <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newTicket;?>">New</a></li>
	                           <!--<li id="menu-item-13" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-13"><a href="/blog/category/news/state/">State</a></li>-->
                             </ul>
                             <?php
	                        }
	                        ?>
                      </li>
                      <?php
	                    }
	                  ?>
