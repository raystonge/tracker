<?php
include_once "tracker/permission.php";
PageAccess("Configs");
?>
<h2>Configuration</h2>
<div class="main_rlist">
<ul>

  <?php
  if ($permission->hasPermission("Config: Asset Condition"))
  {
  ?>
  <li class='mritem'> <a href="/listAssetCondition/" id="listAssetCondition">Asset Condition</a></li>
  <?php
  }
  ?>
  <?php
  if ($permission->hasPermission("Config: Asset Type"))
  {
  ?>
  <li class='mritem'> <a href="/listAssetType/" id="listAssetType">Asset Type</a></li>
  <?php
  }
  ?>  
  <?php
  if ($permission->hasPermission("Config: Controls"))
  {
  ?>
  <li class='mritem'> <a href="/listControls/" id="listControls">Controls</a></li>
  <?php
  }
  ?>    
  <?php
  if ($permission->hasPermission("Config: Insurance Payment"))
  {
  ?>
  <li class='mritem'> <a href="/listInsurancePayment/" id="listInsurancePayment">Insurance Payment</a></li>
  <?php
  }
  ?>  
  <?php
  if ($permission->hasPermission("Config: Insurance Repair"))
  {
  ?>
  <li class='mritem'> <a href="/listInsuranceRepair/" id="listInsuranceRepair">Insurance Repair</a></li>
  <?php
  }
  ?>
  <?php
  if ($permission->hasPermission("Config: Insurance Repair Complete"))
  {
  ?>
  <li class='mritem'> <a href="/listInsuranceRepairComplete/" id="listInsuranceRepairComplete">Insurance Repair Complete</a></li>
  <?php
  }
  ?>  
  <?php
  if ($permission->hasPermission("Config: Queue"))
  {
  ?>
  <li class='mritem'> <a href="/listQueues/" id="listQueues">Queues</a></li>
  <?php
  }
  ?>  
  <?php
  if ($permission->hasPermission("Config: Status"))
  {
  ?>
  <li class='mritem'> <a href="/listStatus/" id="listStatus">Status</a></li>
  <?php
  }
  ?> 
  <?php
  if ($permission->hasPermission("Config: Users"))
  {
  ?>
  <li class='mritem'> <a href="/listUsers/" id="listUsers">Users</a></li>
  <?php
  }
  ?>
  <?php
  if ($permission->hasPermission("Config: User Group"))
  {
  ?>
  <li class='mritem'> <a href="/listUserGroups/" id="listUserGroups">User Groups</a></li>
  <?php
  }
  ?>
  <?php 
  if ($permission->hasPermission("Config: Upgrade"))
  {
  ?>
  <li class='mritem'> <a href="/upgrade/" id="upgrade">Upgrade</a></li>
  <?php
  	  }
  ?>
  <?php 
  if ($permission->hasPermission("Config: Export Data Structure"))
  {
  ?>
  <li class='mritem'> <a href="/exportStructure/" id="upgrade">Export Data Structure</a></li>
  <?php
  	  }
  ?>

</ul>
</div>