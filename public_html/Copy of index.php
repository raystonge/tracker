<?php 
include "pageStart.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<!-- Title and External Script Integration -->
<title><?php echo $pageTitle;?></title>
<link rel="alternate" type="application/rss+xml" title="<?php echo $siteName;?> RSS Feed" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/feed/">
<link rel="stylesheet" id="contact-form-7-css" href="/css/styles.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
<link rel="stylesheet" id="contact-form-7-css" href="/css/generalLayout.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">
<link rel="stylesheet" id="contact-form-7-css" href="/css/wp_core.css?version=<?php echo $jsVersion;?>" type="text/css" media="all">

<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/xmlrpc.php?rsd">
<link rel="index" title="<?php echo $siteName;?>" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/">


<link rel="canonical" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/">



<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/ajax.js"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/validate_form.js"></script>

<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>


<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-ui.lookuptext.js"></script>
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery.inputmask.js"></script>
<!-- 
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery.inputmask.extentions.js"></script>
 -->
<script language="javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery-common.js?version=<?php echo $jsVersion;?>"></script>
<script language="javascript" src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>


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
?>
</head>
<body class="home blog">
  <div id="site">
	<div id="wrapper">
	  <div id="header" class="fix">
		<div class="content fix">
		<!-- <img src="/images/pelogo-web.gif" /> -->
          <div class="site_desc_position"><?php echo $siteName;?>
		  </div>
		</div>
	  </div>
	  <div class="container fix ">
		<div class="effect containershadow">
		  <div class="effect containershadow_rpt">
			<div id="sitenav" class="content fix">
			  <div id="nav" class="fix">
				<ul class="clearfix">
	              <li class="page_item page-item-1"><a class="home" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/" title="Home">Home</a></li>
	              <?php
	              $permission = new Permission();
	              if ($permission->hasPermission("View: List Accounts"))
	              {
	              	?>
                    <li class="page_item page-item-2"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/listAccounts/" title="Accounts">Accounts</a></li>
	              	<?php
	              }
	              if ($permission->hasPermission("View: List Orders"))
	              {
	              	?>
                    <li class="page_item page-item-3"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/listOrders/" title="Orders">Orders</a></li>
                    <?php
	              }
	              if ($permission->hasPermission("View: List Production"))
	              {
	              	?>
                     <li class="page_item page-item-4"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/production/" title="Publication">Production</a></li>
	                <?php
	              }
	              if ($permission->hasPermission("View: Reports"))
	              {
	              	?>
                     <li class="page_item page-item-5"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/reports/" title="Reports">Reports</a></li>
                    <?php
                  }
	              if ($permission->hasPermission("View: Configs"))
	              {
	              	?>
                     <li class="page_item page-item-6"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/config/" title="Configs">Configs</a></li>
                    <?php
                  }
 	              if (isset($_SESSION['userId']))
	              {
	              	if ($_SESSION['userId'])
	              	{
	              ?>
                    <li class="page_item page-item-7"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/myNotes/" title="Logout">My Notes</a></li>
                    <li class="page_item page-item-8"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/myProfile/" title="Logout">My Profile</a></li>
                    <li class="page_item page-item-9"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/logout/" title="Logout">Logout</a></li>
                  <?php
	              	}
	              }
	              ?>
                 </ul>
              </div><!-- /nav -->
              <div class="clear"></div>
            </div>


<div id="contentcontainer" class="content fix">
  <div id="contentborder">
    <div id="maincontent">
      <?php
        if ($link_cms)
        {
        	DebugText("loading templateName:".$templateName);
        	include_once $templateName;
        }
        else
        {
        	echo "The database server is down";
        }

      ?>
	  <div class="clear"></div>
	</div>
  </div>
</div>
		</div>
	</div>
</div>

<!--full width bottom widget -->
<!--END full width bottom widget -->



		<div class="clear"></div>

<div id="footer">
	<div class="effect">
		<div class="content">
						<div id="fcolumns_container" class="fix">



</div>
	<div class="clear"></div>
	<div id="footerNav">
	</div>

	<div id="subfoot">
	  <p>Points East Publishing, Inc.<br>
	  P.O. Box 1077<br>
	    Portsmouth, NH 03802-1077<br>
	    1-888-778-5790
	    </p>
	    </p>
	  <hr class="hidden">
	</div><!--/subfoot -->

  </div><!--/wrapper -->
</div> <!-- end #site -->

<!-- Footer Scripts Go Here -->
	<!-- End Footer scripts -->
<!--
<script type="text/javascript" src="/js/jquery_002.js"></script>
<script type="text/javascript" src="/js/scripts.js"></script>
-->
</div></div></div>

<?php DebugOutput();?>
</body></html>