<?php
//
//  Tracker - Version 1.2.0
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
