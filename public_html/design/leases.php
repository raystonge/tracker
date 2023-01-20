<?php
include_once "tracker/permission.php";
include_once "tracker/contract.php";
PageAccess("Report: Leases");
?>
<div class="adminArea">
<h2><a href="/leases/" class="breadCrumb">Leases</a></h2>
<form method="post" action="/leaseReport/">
  <table>
    <tr>
      <td>
        Contracts: <select name="contractId">
          <option value="0">All active Leases</option>
          <?php
          $contract = new Contract();
          $param = "isLease=1 and expireDate >='".$today."'";

          $ok = $contract->Get($param);
          while ($ok)
          {
            ?>
            <option value="<?php echo $contract->contractId;?>""><?php echo $contract->name;?></option>
            <?php
            $ok = $contract->Next();
          }
           ?>
        </select>
      </td>
    </tr>
    <tr>
       <td>
         <?php CreateSubmit();?>
       </td>
    </td>
  </table>
</form>
<?php DebugOutput();
