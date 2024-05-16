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
PageAccess("Asset: Import");
include_once "tracker/building.php";
include_once "tracker/poNumber.php";
include_once "tracker/contract.php";

$contract = new Contract();
?>
<div class="adminArea">
  <div id='main_column'>
    <form action="/doAssetImportCSV/" method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data">
    Import File: <input  <?php if ($showMouseOvers){echo 'title="Select file to Import"';}?> name="importFile" type="file" id="importFile" />
    <br>
    <select id="buildingId" name="buildingId">
      <?php
      $building = new Building();
      $param = "organizationId = 11";
      $cnt = 0;
      $ok = $building->Get($param);
      while ($ok && $cnt < 10)
      {
        $cnt++;
        ?>
        <option value="<?php echo $building->buildingId; ?>">
          <?php echo $building->name; ?>
        </option>
        <?php
        $ok = $building->Next();
      }


      ?>
    </select>
    <br>
    <select id="poNumberId" name="poNumberId">
      <?php
      $param = "isLease=1";
      $ok = $contract->Get($param);
      while ($ok)
      {
        $poNumber = new poNumber($contract->poNumberId);
        ?>
        <option value="<?php echo $poNumber->poNumberId; ?>"><?php echo $poNumber->poNumber;?></option>
        <?php
        $ok = $contract->Next();
      }
      ?>
    </select>
    <br>
    <input type="submit" name="import" value="Import" id="import"/><br>
 
    </form>

    <div class="clear"></div>
  </div>
</div>
<div id="results">
</div>
