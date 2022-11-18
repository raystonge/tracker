<?php
/*
 * Created on Feb 28, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
//get the q parameter from URL
$q=$_GET["q"];
$xml = "";
//find out which feed was selected

if($q=="Google")
  {
  $xml=("http://www.google.com/appsstatus/rss/en");
  }
elseif($q=="MSNBC")
  {
  $xml=("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
  }
$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')
->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')
->item(0)->childNodes->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')
->item(0)->childNodes->item(0)->nodeValue;

//output elements from "<channel>"
/*
echo("<p><a href='" . $channel_link
  . "'>" . $channel_title . "</a>");
echo("<br>");
echo($channel_desc . "</p>");
*/
//get and output "<item>" elements


$xpath = new DOMXPath($xmlDoc);
$count = $xpath->evaluate('count(//item)');


$x=$xmlDoc->getElementsByTagName('item');

 
 
for ($i=0; $i<$count; $i++)
  {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue;

  echo ("<p><a href='" . $item_link
  . "'>" . $item_title . "</a>");
  echo ("<br>");
  echo ($item_desc . "</p>");
  }
/*  
$cnt = 0;
foreach ($xmlDoc->getElementsByTagName('item') as $node) 
{
    if($cnt == 8 ) {
       break;
     }    
    $itemRSS = array ( 
      'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
      'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
      'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
      'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
      );
      $cnt++;
      ?>
      <a href="<?php echo $itemRSS['link'] ;?>"><?php echo $itemRSS['title']; ?></a>
      
      <?php
} 
*/ 
?>