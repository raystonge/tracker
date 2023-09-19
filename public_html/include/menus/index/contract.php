<?php
//
//  Tracker - Version 1.4.0
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
				 </ul>
				 <?php
			}
			if ($permission->hasPermission("Contract: Create: User Contract"))
			{
				?>
					<ul class="dropdown-menu">
				 <li id="menu-item-10" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-10"><a href="<?php echo $newContract;?>">New</a></li>
				 </ul>
				 <?php
			}
			?>
	</li>
	<?php
	}
?>
