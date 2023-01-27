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
