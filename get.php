<?
include("config.inc.php");

function check_valid_address($domainname) {

//Check domain length > 2 || < 63 characters
    if (strlen($domainname) < 3){
        return 1;
//Check domain can not start with -
    } elseif (ereg("^-|-$", $domainname)){
       return 2;
//Letters , numbers and - _ only
    } elseif (!ereg("([a-z]|[A-Z]|[0-9]|-){".strlen($domainname)."}", $domainname)){
        return 3;
    }
  return 0;
}

function whois ($tld, $getdomainname)
{
global $whois_servers,$whois_available,$whois_error,$statusmsg;

//Strip html
$getdomainname = strip_tags($getdomainname);

//Strip www. and http://
$getdomainname = str_replace("www.", "", $getdomainname);
$getdomainname = str_replace("http://", "", $getdomainname);

//Replace Space
$getdomainname = str_replace(" ", "", $getdomainname);

//Split .com .net .org or .* (Split text after .)
$getdomainname = explode(".", $getdomainname);

//Join domain with tld (.com,.net,.org, .*)
$domainname = $getdomainname[0] . "." . $tld;

//Select Whois Server in config.inc.php
$select_server = $whois_servers[$tld][0];

//Connect to selected whois server
$sock = @fsockopen($select_server,43);

//Initial value for display status message in config.inc.php
$domainstatus = 0;

	if(!$sock) {
	//Can't connect to Server
	$domainstatus = 4;
	}else{
	$send_request = @fputs($sock,"$domainname\r\n");
		if(!$send_request) {
		//Unable to send request
		$domainstatus = 4;
		}else{
		while(!feof($sock)) {
		$result .= fgets($sock,128);
		}

$result = str_replace("\n", "<br>", $result);


//Check error or Available
for($i=0;$i<count($whois_error);$i++){

if(@eregi($whois_error[$i],$result)) {
//error?
$domainstatus = 4;
}

}

//Check excedded quota from whois server (.org limited 4 query per minute/server ip) :(
if(@eregi("EXCEEDED",$result)) {
//Exceeded server quota?

// $domainstatus = 5;   
// there is no limit with the proxy that is why we set the statusmsg to [0]

$domainstatus = 0;
}

//No error
if($domainstatus == 0){
		//Check Available

				if(@eregi($whois_servers[$tld][1],$result)) {
				//Available
				$domainstatus = 0;
				}else{
				$domainstatus = 6; //taken
				}


}



		}
@fclose($sock);

		}
return $domainstatus;

}

//-------------------------Start main program-------------------------

if ($_GET['domainname'] != '') {
$domainname = $_GET['domainname'];

//check valid or not
$isvalid = check_valid_address($domainname);

//Check tld
if($isvalid ==0){
$domainstatus[0] = whois('com',$domainname );
$domainstatus[1] = whois('net',$domainname );
$domainstatus[2] = whois('org',$domainname );
$domainstatus[3] = whois('info',$domainname );
$domainstatus[4] = whois('biz',$domainname );
$domainstatus[5] = whois('de',$domainname );
$domainstatus[6] = whois('co.uk',$domainname );
$domainstatus[7] = whois('nl',$domainname );
$domainstatus[8] = whois('eu',$domainname );
$domainstatus[9] = whois('it',$domainname );
$domainstatus[10] = whois('mobi',$domainname );
$domainstatus[11] = whois('asia',$domainname );
$domainstatus[12] = whois('name',$domainname );
$domainstatus[13] = whois('at',$domainname );
$domainstatus[14] = whois('ch',$domainname );
$domainstatus[15] = whois('es',$domainname );
$domainstatus[16] = whois('be',$domainname );
$domainstatus[17] = whois('nu',$domainname );
$domainstatus[18] = whois('se',$domainname );
$domainstatus[19] = whois('us',$domainname );


$tld[0] = ".com";
$tld[1] = ".net";
$tld[2] = ".org";
$tld[3] = ".info";
$tld[4] = ".biz";
$tld[5] = ".de";
$tld[6] = ".co.uk";
$tld[7] = ".nl";
$tld[8] = ".eu";
$tld[9] = ".it";
$tld[10] = ".mobi";
$tld[11] = ".asia";
$tld[12] = ".name";
$tld[13] = ".at";
$tld[14] = ".ch";
$tld[15] = ".es";
$tld[16] = ".be";
$tld[17] = ".nu";
$tld[18] = ".se";
$tld[19] = ".us";

//-----------------------Prepare Results ----------------------------

for($i=0;$i<count($tld);$i++){
if($domainstatus[$i] > 0){


//Domain Taken or Error

$status[$i] = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td bgcolor=\"#Fe0000\" class=\"normaltext\"><div align=\"center\"><strong><font color=\"#FFFFFF\">";
		$status[$i] .= $tld[$i]." ";
		$status[$i] .= $statusmsg[$domainstatus[$i]];
		$status[$i] .= "</font> </strong></div></td></tr><tr> 
          <td class=\"result\"><center><a href=\"http://www.$domainname$tld[$i]\">Website</a></center></td>
        </tr>
      </table>";

}else{

//Domain Available
$status[$i] = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <tr> 
                  <td bgcolor=\"#A3C401\" class=\"normaltext\">
<div align=\"center\"><strong><font color=\"#FFFFFF\">$tld[$i] is available!</font></strong></div></td>
<br>
<a href=\"http://www.google.com/\">Register</a>

                </tr>



              </table>";

}
}

//---------------------------------Print Results-------------------------------------------
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<table width=\"600\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
  <tr valign=\"top\"> 
    <td colspan=\"3\" class=\"bookmarktext\"><center>Search Result for <b>$domainname</b></center></td>
  </tr>
	  <tr valign=\"top\"> 
  <td width=\"150\">$status[0]</td>
  <td width=\"150\">$status[1]</td>
  <td width=\"150\">$status[2]</td>
  <td width=\"150\">$status[3]</td>
  <td width=\"150\">$status[4]</td>
</tr><tr>  
  <td width=\"150\">$status[5]</td>
  <td width=\"150\">$status[6]</td>
  <td width=\"150\">$status[7]</td>
  <td width=\"150\">$status[8]</td>
  <td width=\"150\">$status[9]</td>
</tr><tr>
  <td width=\"150\">$status[10]</td>
  <td width=\"150\">$status[11]</td>
  <td width=\"150\">$status[12]</td>
  <td width=\"150\">$status[13]</td>
  <td width=\"150\">$status[14]</td>
</tr><tr>
  <td width=\"150\">$status[15]</td>
  <td width=\"150\">$status[16]</td>
  <td width=\"150\">$status[17]</td>
  <td width=\"150\">$status[18]</td>
  <td width=\"150\">$status[19]</td>
</tr>
                        
<tr valign=\"top\"> 
 
  </tr>

</table>";

}else{

//not valid domain

echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<table width=\"600\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" bgcolor=\"#FFFF00\">
  <tr valign=\"top\"> 
    <td colspan=\"3\" class=\"bookmarktext\"><center><b>$statusmsg[$isvalid]</b></center></td>
    </tr>
</table>";
}

}
die();
?>
