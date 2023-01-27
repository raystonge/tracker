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
