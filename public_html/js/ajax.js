// JavaScript Document
//<script type="text/javascript">

/***********************************************
* Dynamic Ajax Content- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var bustcachevar=1 //bust potential caching of external pages after initial request? (1=yes, 0=no)
var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function ajaxupdatepage(url, params)
{
  var XMLHttpRequestObject = false
  if (window.XMLHttpRequest) // if Mozilla, Safari etc
    XMLHttpRequestObject = new XMLHttpRequest()
  else
    if (window.ActiveXObject)
	{ // if IE
      try {
            XMLHttpRequestObject = new ActiveXObject("Msxml2.XMLHTTP")
          } 
      catch (e)
	  {
        try{
             XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP")
           }
        catch (e)
		{
		}
      }
    }
    else
      return false
    if (XMLHttpRequestObject)
    {
//	  alert(url);
	  //alert(params);
      XMLHttpRequestObject.open("POST",url,true);  
	  XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      XMLHttpRequestObject.onreadystatechange = function() 
      { 
        if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
	    {
          var xmlDocument = XMLHttpRequestObject.responseXML;
//        options = xmlDocument.getElementsByTagName("option");
//        listoptions();
        } 
      } 
//	  alert("sending params");
      XMLHttpRequestObject.send(params); 
      //document.getElementById("phototag").innerHTML=XMLHttpRequestObject.responseText
   }
}

function ajaxpage(url, containerid)
{
	//alert(url);
  var XMLHttpRequestObject = false
  if (window.XMLHttpRequest) // if Mozilla, Safari etc
    XMLHttpRequestObject = new XMLHttpRequest()
  else
    if (window.ActiveXObject)
	{ // if IE
      try {
            XMLHttpRequestObject = new ActiveXObject("Msxml2.XMLHTTP")
          } 
      catch (e)
	  {
        try{
             XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP")
           }
        catch (e)
		{
		}
      }
    }
    else
      return false
  XMLHttpRequestObject.onreadystatechange=function()
  {
  loadpage(XMLHttpRequestObject, containerid)
  }
  if (bustcachevar) //if bust caching of external page
    var bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
  XMLHttpRequestObject.open('GET', url+bustcacheparameter, true)
  XMLHttpRequestObject.send(null)
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
{
text = page_request.responseText;
//alert(containerid);
//alert(text);
inner = document.getElementById(containerid);
//document.getElementById(containerid).innerHTML=text;
//alert(text);
inner.innerHTML=text;
}
}

function loadobjs(){
if (!document.getElementById)
return
for (i=0; i<arguments.length; i++){
var file=arguments[i]
var fileref=""
if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
if (file.indexOf(".js")!=-1){ //If object is a js file
fileref=document.createElement('script')
fileref.setAttribute("type","text/javascript");
fileref.setAttribute("src", file);
}
else if (file.indexOf(".css")!=-1){ //If object is a css file
fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet");
fileref.setAttribute("type", "text/css");
fileref.setAttribute("href", file);
}
}
if (fileref!=""){
document.getElementsByTagName("head").item(0).appendChild(fileref)
loadedobjects+=file+" " //Remember this object as being already added to page
}
}
}

//</script>