<?php
//
//  Tracker - Version 1.6.0
//
//  v1.6.0
//   - updated nav for service pages
//  v1.5.0
//   - updated the nav for new pages
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
include "pageStart.php";
?>
<!DOCTYPE html>

<!--[if lt IE 7]>
<html class="ie ie6 lte9 lte8 lte7" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html class="ie ie7 lte9 lte8 lte7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 lte9 lte8" lang="en-US">
<![endif]-->
<!--[if IE 9]>
<html class="ie ie9" lang="en-US">
<![endif]-->
<!--[if gt IE 9]>  <html lang="en-US"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en-US"><!--<![endif]-->
  <head>
  	<script language="javascript">
	currentUserId = <?php echo $currentUser->userId;?>;
	</script>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
<meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
    <title><?php echo $pageTitle;?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="http://<?php echo $hostPath;?>/xmlrpc.php">

	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="<?php echo $hostPath;?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<link rel="alternate" type="application/rss+xml" title="Rayware Software » Feed" href="/feed/">
	<link rel="alternate" type="application/rss+xml" title="Rayware Software » Comments Feed" href="/comments/feed/">
	<link rel="stylesheet" id="admin-bar-css" href="/css/admin-bar.css" type="text/css" media="all">
	<link rel="stylesheet" id="bootstrap-style-css" href="/css/bootstrap.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="bootstrap-responsive-style-css" href="/css/bootstrap-responsive.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="cyberchimps_responsive-css" href="/css/cyberchimps-responsive.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="core-style-css" href="/css/core.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="style-css" href="/css/style.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="elements_style-css" href="/css/elements.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
	<link rel="stylesheet" id="jquery-ui-css" href="/css/jquery-ui-1.8.4.custom.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">

    <script src="/js/jquery-1.9.1.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

   <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!--<script src="/js/jquery-ui-1.10.3.custom.js"></script> -->

     <script src="/js/jqueryCommon.js" language="javascript"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/ajax.js"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/validate_form.js"></script>
<!--
<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-1.8.3.js"></script>
<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-ui.js"></script>
-->

<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery.form.js"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-ui.lookuptext.js"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery.inputmask.js"></script>

<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-common.js?version=<?php echo $jsVersion;?>"></script>
<script language="javascript" src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="/xmlrpc.php?rsd">
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml">
	<link href="/css/blitzer/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	.ie8 .container {
		/* max-width: 1020px;*/
		width:auto;}
	</style>	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
	<style type="text/css" media="print">#wpadminbar { display:none; }</style>


  	<style type="text/css" media="all">
	  body {
    	      	font-size: 14px;
    	      	font-family: Arial, Helvetica, sans-serif;
    	      	font-weight: normal;
    	  }
        .container {
       /* max-width: 1020px; */
      }
      .ui-widget.ui-widget-content{
        border-color: white;
      }
    </style>
    <?php
$jqueryFile = $sitePath."/ajax/".$firstDir.".js";
DebugText("jqueryFile:".$jqueryFile);
if (file_exists($jqueryFile))
{
	DebugText("jqueryFile exists");
	?>
	<script type="text/javascript" src="/ajax/<?php echo $firstDir;?>.js?version=<?php echo $jsVersion;?>"></script>
	<?php
}
else
{
	DebugText("jquery file does not exists");
}
$homeClass = "menu-item menu-item-type-custom menu-item-object-custom dropdown";
$ticketClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-1";
$assetClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-2";
$configClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-3";
$monitorClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-4";
$reportClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-5";
$poClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-5";
$contractClass = "menu-item menu-item-type-taxonomy menu-item-object-category dropdown menu-item-5";

if (!isset($request_uri[1]) )
{
	$homeClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-1 active";
}
else
{
	$page = $request_uri[1];
	DebugText("currentPage:".$page);
	switch ($page)
	{
		case "listTickets":
		case "ticketNew" :
		case "ticketnew" :
		case "newTicket" :
		case "ticketEdit":
		case "ticketAssets":
	  case "ticketSchedule":
		case "ticketAttachment":
		case "ticketJumbo":
		case "ticketInsurance":
		case "ticketDeleteAttachment":
    case "viewTicket" :
		case "ticketHistory": $ticketClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2 dropdown active";
		                 break;
		case "listAssets":
		case "newAsset":
		case "assetNew" :
		case "assetnew" :
		case "newAsset" :
		case "editAsset":
		case "assetEdit" :
		case "ticketAsset":
		case "attachmentAsset":
		case "assetJumbo" :
		case "assetSoftwareDevice":
		case "doAssetImport":
		case "assetAccount" :
		case "assetAttachment":
		case "assetDeleteAttachment":
		case "assetAssignSerialNumber":
		case "assetMonitor":
    case "assetHistory":
    case "assetTickets":
		case "accessory":
		case "newMonitor":
		case "assetMonitorList":
    case "viewAsset" :
    case "assetContract":
    case "assetValue" :
    case "assetCredentials":
    case "editUserCredentials":
    case "newUserCredentials":
    case "moveAsset":
		case "historyAsset": $assetClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-3 dropdown active";
		                     break;
		case "monitor":

		                $monitorClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-4 dropdown active";
		                break;
		case "listAssetCondition":
		case "newAssetCondition":
		case "editAssetCondition":
		case "listAssetType":
		case "newAssetType":
		case "editAssetType":
		case "listControls":
		case "newControl":
		case "editControl":
		case "listInsurancePayment":
		case "newInsurancePayment":
		case "editInsurancePayment":
		case "listInsuranceRepair":
		case "newInsuranceRepair":
		case "editInsuranceRepair":
		case "listInsuranceRepairComplete":
		case "newInsuranceRepairComplete":
		case "editInsuranceRepairComplete":
		case "listQueues":
		case "newQueue":
		case "editQueue":
		case "listStatus":
		case "newStatus":
		case "editStatus":
		case "listUsers":
    case "doUserImport":
    case "importUsers";
		case "newUser":
		case "editUser":
		case "editUserPermission":
		case "listUserGroups":
		case "newUserGroup":
		case "editUserGroup":
		case "editUserGroupPermission":
    case "listServices" :
    case "newService" :
    case "editService" :
    case "assignService" :
		case "exportStructure":
		case "upgrade":
		case "doUpgrade":
		                            $configClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-3 dropdown active";
		                            break;
		case "poNumberEdit" :
		case "poNumberNew" :
		case "listpoNumber" :
    case "poNumberView" :
		case "poNumberAssets" :
		case "poNumberAttachment" :
		case "poNumberHistory" :
		                            $poClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-3 dropdown active";
		                            break;
    case "listContracts" :
    case "contractNew" :
    case "contractEdit" :
    case "contractView" :
    case "viewContract" :
    case "contractAssets" :
    case "contractAttachment" :
    case "listContracts":
		case "contractDeleteAttachment":
    case "contractHistory" :
                               $contractClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-3 dropdown active";
                               break;

		case "billing" :
		case "billingReport" :
		case "listBadAssets" :
		case "viewReports":
		case "listReports":
    case "leases":
    case "leaseReport":
    case "moveReport" :
    case "personalProperty" :
    case "personalPropertyReport" :
		                            $reportClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-3 dropdown active";
		                            break;

		default: $homeClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-1 dropdown active ";
		         break;
	}


}
$footerName = $siteName." - ".getAppVersion()." Build ".getAppBuld();
?>
<script language="javascript">
$(document).ready(function () {
	$("#s").blur(function() {
		  $("#searchform").submit();
		  /*
    	  var formData = $(":input").serializeArray();
          var link = "/process/search.php";
          $.post(link, formData);*/
    })
	link = "/ajax/results/overDueTickets.php";
	$.getJSON(link,'',

	            function (data)
	            {
	              if (data.status == 'success')
	              {
	              	if (data.numOfOverDue > 0)
	              	{
	              		var msg = "You have "+data.numOfOverDue+" tickets that are at least 7 day over due\n Tickets:"+data.tickets;
	              		alert(msg);
	              	}
	              }
	            }
	            );
	link = "/ajax/results/monitor/pageTitle.php";
	$.getJSON(link,'',

	            function (data)
	            {
	              if (data.status == 'success')
	              {
	              	$(document).attr("title", data.pageTitle);
	              }
	            }
	            );

});
</script>
  </head>
  <body class="home blog logged-in admin-bar  customize-support">
  <!--
	<div class="container-full">
      <div class="container">
      	<div class="row-fluid">
          <div class="span6">
        	<div class="top-head-description">
        		<?php echo $siteName;?>
        	</div>
        </div>
      </div>
    </div>
    -->
    <div class="container">
	  <div id="wrapper" class="container-fluid">
		<header id="cc-header" class="row-fluid">
		  <div class="span7">
			<hgroup>
		      <h1 class="site-title">
		        <?php echo $siteName;?>
		      </h1>
		    </hgroup>
		  </div>
	    </header>
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-ifeature-home">
	                    <a href="<?php echo $hostPath;?>">
	                      <img src="/images/home.png" alt="Home">
	                    </a>
	                  </li>
	                  <?php
	                  include "menus/index/homeMenu.php";
	                  include "menus/index/ticketMenu.php";
	                  include "menus/index/assetMenu.php";
	                  include "menus/index/poMenu.php";
                    include "menus/index/contract.php";
	                  include "menus/index/monitorMenu.php";
	                  include "menus/index/reportMenu.php";
	                  include "menus/index/configMenu.php";
	                  ?>
                    </ul>
                  </div>
                  <?php
                  if ($permission->hasPermission("Search"))
                  {
                  	?>
				              <form method="post" id="searchform" class="navbar-search pull-right" action="/process/search.php" role="search">
	                      <input class="search-query input-medium" name="s" id="s" placeholder="Search" type="text" >
	                      <?php PrintFormKey("searchKey");?>
                      </form>
                    <?php
                  }
                  ?>
                  <div class="clear"></div>
      			</div><!-- collapse -->
			    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a>
              </div><!-- container -->
            </div><!-- .navbar-inner .row-fluid -->
          </div><!-- main-navigation navbar -->
	    </nav><!-- #navigation -->
	    <?php
	    DebugText("*** Start of Template ***");
	    include $templateName;
	    DebugText("*** End of Template ***");
	    ?>


        </div><!-- #container -->
      </div><!-- close main wrapper -->
    </div><!-- close container -->

    <div id="footer-main-wrapper" class="container-fluid">
      <div id="footer-wrapper" class="container">
        <footer class="site-footer row-fluid">
        <div id="copyright"><?php echo $footerName;?><br>&copy; Rayware Software</div>
        </footer><!-- .site-footer .row-fluid -->
      </div><!-- #wrapper .container-fluid -->
     <?php
     $userId = GetTextFromSession("userId",0,0);
     if ($userId)
     {
     	echo "logged in as: ".$currentUser->fullName;
     }
     ?>
    </div><!-- footer wrapper -->
    <?php DebugOutput();?>
  </body>
</html>
