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
include "globals.php";
include_once "tracker/poNumber.php";
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/priority.php";
include_once "tracker/status.php";
include_once "tracker/permission.php";

ProperAccessTest();
$permission = new Permission();
$_SESSION['searchNumPerPage'] = $maxTicketsPerPage;

$poNumber = new poNumber();
$poNumber->SetPerPage(GetTextField("searchNumPerPage",$maxTicketsPerPage));
$param = "";
$pages = 1;
$poNumber->SetOrderBy("poDate desc");
$numRows = $poNumber->Count($param);
if ($poNumber->perPage)
{
	$pages = ceil($numRows/$poNumber->perPage);
}
$_SESSION['searchNumPerPage'] = $poNumber->perPage;
$page = 1;
DebugText("Compute page we are on");
$page = GetURI(1,1);
$page = GetURI(2,1);
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}
$page = GetTextField("page",$page);
$poNumber->SetPage($page);
$param = "";
$sectionName = "";
$organizationId = 0;
$sectionName = GetTextField("sectionName");
if (strlen($sectionName))
{
	$param1 = AddEscapedFullLikeParam("","poNumber",$sectionName);
	$param2 = AddEscapedFullLikeParam("","description",$sectionName);
	$param = "(".$param1." or ".$param2.")";

}
$organizationId = GetTextField("organization",0);
if (!$organizationId)
{
	$param1 = "organizationId in (".GetMyOrganizations().")";
	$param = AddParam($param,$param1);
}
else
{
	$param = AddParam($param,"organizationId=".$organizationId);
}
$reconciled = GetTextField("reconciled",-1);
if ($reconciled >= 0)
{
	$param = AddEscapedParam($param, "reconciled", $reconciled);
}
?>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listAssets";
      if ($pages > $maxAssetPages)
      {
      	$pages = $maxAssetPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php
      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<form name="assets" method="post" action="/process/poNumber/reconcile.php">

<table class="width100">
  <tr>
    <th>
      PO Number
    </th>
    <th>
      Description
    </th>
    <th>
      Date
    </th>
    <th>
    Type
    </th>
    <th>
    Cost
    </th>
    </th>
    <th>
    Received
    </th>

    <?php
    if ($permission->hasPermission("poNumber: Reconcile"))
    {
	?>
    <th width="8%">
    Reconciled
    </th>
    <?php
    }
    ?>
    <th>
    &nbsp;

  </tr>
<?php
  $ok = $poNumber->Search($param);
  $showButton = $ok;
  while ($ok)
  {
  	?>
  <tr class="mritem">
    <td>
      	<?php
      	if ($permission->hasPermission("poNumber: Edit"))
        {
        	?>
        	<a href="/poNumberEdit/<?php echo $poNumber->poNumberId;?>/"><?php echo $poNumber->poNumber;?></a>
        	<?php
        }
        else
        {
        	if ($permission->hasPermission("poNumber: View"))
        	{
        		?>
        		<a href="/poNumberView/<?php echo $poNumber->poNumberId;?>/"><?php echo $poNumber->poNumber;?></a>
        		<?php
        	}
        	else
        	{
        		echo $poNumber->poNumber;
        	}

        }
	    ?>

    </td>
    <td>
      <?php echo $poNumber->description;?>
    </td>
    <td>
      <?php echo $poNumber->poDate;?>
    </td>
    <td>
    <?php echo $poNumber->poType;?>
   </td>
   <td>
     <?php echo $poNumber->cost;?>
   </td>

   <td>
   <?php
   if (strlen($poNumber->receivedDate))
   {
     echo $poNumber->receivedDate;
   }
   else
   {
		 if ($permission->hasPermission("poNumber: Edit: PO Recieve"))
		 {
        CreateCheckBox("received".$poNumber->poNumberId,$poNumber->poNumberId, "",0,"Click to Receive PO","toReceivePO");
		 }
   }
   ?>
   </td>
   <?php
     if ($poNumber->received && $permission->hasPermission("poNumber: Edit: PO Reconcile"))
     {
     ?>
   <td align="center" width="8%">
     <?php
        CreateCheckBox("reconciled".$poNumber->poNumberId,$poNumber->poNumberId, "",$poNumber->reconciled,"Click to reconcile PO","toReconcilePO");
      ?>
   </td>
   <?php
     }?>
   <td>
   &nbsp;
   </td>
  	<?php
  	$ok = $poNumber->Next();
  }
?>
</table>
<?php
 PrintFormKey( );
 CreateSubmit("Update","Update");?>
</form>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listpoNumber";
      if ($pages > $maxTicketPages)
      {
      	$pages = $maxTicketPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<?php DebugOutput();?>
