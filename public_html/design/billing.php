<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Report: Billing");
?>
<div class="adminArea">
<h2><a href="/billing/" class="breadCrumb">Billing</a></h2>
<form method="post" action="/billingReport/">
<table>
  <tr>
    <td>Organization:</td>
    <td>
      <?php
      $param = "organizationId in (".GetMyOrganizations().") and active=1";
      $organization = new Organization();
      $ok = $organization->Get($param);
      ?>
      <select id="organizationId" name="organizationId">
        <?php
          while ($ok)
          {
              ?>
              <option value="<?php echo $organization->organizationId;?>"><?php echo $organization->name;?></option>
              <?php
              $ok = $organization->Next();
          }
        ?>
      </select>

    </td>

  </tr>
  <tr>
    <?php
    $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
    $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

    $startDate = date("Y-m-d", $firstDayUTS);
    $stopDate = date("Y-m-d", $lastDayUTS);
    DebugText("startDate:".$startDate);
    DebugText("stopdate:".$stopDate);

    ?>
    <td>Start:</td><td><?php CreateDatePicker("startDate",$startDate);?></td>
    </tr>
    <tr>
    <td>End:</td><td><?php CreateDatePicker("stopDate",$stopDate);?></td>

  </tr>
  <tr>
    <td>&nbsp;<?php PrintFormKey();?></td>
    <td><?php CreateSubmit();?></td>
  </tr>
</table>
</form>
</div>
