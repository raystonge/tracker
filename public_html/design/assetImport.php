<?php
PageAccess("Asset: Import");
?>
<div class="adminArea">
  <div id='main_column'>
    <form action="/doAssetImport/" method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data">
    Import File: <input  <?php if ($showMouseOvers){echo 'title="Select file to Import"';}?> name="importFile" type="file" id="importFile" />
    <br>	
    <input type="submit" name="import" value="Import" id="import"/>
    </form>

    <div class="clear"></div>
  </div>
</div>
<div id="results">
</div>