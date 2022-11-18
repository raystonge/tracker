<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Report: Billing");
?>
<div class="adminArea">
<h2><a href="/personalProperty/" class="breadCrumb">Personal Property</a></h2>
<form method="post" action="/personalPropertyReport/">
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
    <td>&nbsp;</td>
    <td><?php CreateSubmit();?>
  </tr>
</table>
</form>
