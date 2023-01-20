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
          <?php
          $contract = new Contract();
          $ok = $contract->Get("isLease=1");
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
