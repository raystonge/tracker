<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$searchSerialNumber = GetTextField("assetSerialNumber");
$searchAssetTag = GetTextField("assetAssetTag");
?>
<a href="/newMonitor/<?php echo $assetId;?>/">Create new Monitor</a>
<table width="100%">
 <tr>
   <th>
     Name
   </th>
   <th>
     State
   </th>
   <th>
     Time
   </th>
 </tr>

<?php
$monitor = new Monitor();
$param = AddEscapedParam("", "assetId", $assetId);
$ok = $monitor->Get($param);
while ($ok)
{
    $state = "Up";
    if (!$monitor->state)
    {
        $state = "<span style='color:red;'>DOWN</span>";
    }

    ?>
    <tr class="mritem">
      <td>
        <a href="/assetMonitor/<?php echo $monitor->assetId;?>/<?php echo $monitor->monitorId;?>/"><?php echo $monitor->name;?></a>
      </td>
      <td>
        <?php echo $state;?>
      </td>
      <td>
        <?php echo $monitor->stateChangeDateTime;?>
      </td>
    </tr>
    <?php
    $ok = $monitor->Next();

}
?>
</table>
<div id="assetTickets"></div>
<div class="clear"></div>
