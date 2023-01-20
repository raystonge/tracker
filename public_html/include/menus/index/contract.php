<?php
	if ($permission->hasPermission("Contract: List"))
	{
	$caret = "";
	if ($permission->hasPermission("Contract: Create"))
	{
		$caret = "<b class='caret'></b>";
	}
		?>
			<li id="menu-item-9" class="<?php echo $contractClass;?>" data-dropdown="dropdown"><a href="/listContracts/" class="dropdown-toggle">Contracts <?php echo $caret;?></a>
			<?php
			$newContract = "/contractNew/";
			$userToOrganization = new UserToOrganization();
			$param = AddEscapedParam("","userId",$currentUser->userId);
			$userToOrganization->Get($param);
			if ($userToOrganization->numRows > 1)
			{
				$newContract = "/newContract/";
			}
			if ($permission->hasPermission("Contract: Create: User Contract"))
			{
				$newContract = "/contractNew";
			}
			if ($permission->hasPermission("Contract: Create"))
			{
				$newContract = "/newContract/";
				?>
					<ul class="dropdown-menu">
				 <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newContract;?>">New</a></li>
				 <!--<li id="menu-item-13" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-13"><a href="/blog/category/news/state/">State</a></li>-->
				 </ul>
				 <?php
			}
			if ($permission->hasPermission("Contract: Create: User Contract"))
			{
				?>
					<ul class="dropdown-menu">
				 <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newContract;?>">New</a></li>
				 <!--<li id="menu-item-13" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-13"><a href="/blog/category/news/state/">State</a></li>-->
				 </ul>
				 <?php
			}
			?>
	</li>
	<?php
	}
?>
