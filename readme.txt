*******   WhoisNinja **********

Based On:  Ajax Whois and

Ajax Whois using InterNetX Proxy v1.3 [12.7.2012]


How to use:

1)Upload all files to a server
2)Make sure your IP address is activated by InterNetX for the Whois Proxy service
3)In the file get.php configure:


$domainstatus[0] = whois('com',$domainname );

and

$tld[0] = ".com";


you need to add one $domainstatus and one $tld for each new TLD you want to activate


4) in config.inc.php you need to add the whois server for the TLD you want to activate:

Copy one of the lines in $whois_servers and enter the whois server of the registry OR
use the InterNetX Whois Proxy by using:

whois.autodns3.de

All replies from the whois proxy will answer "free" if a domain is available



Important information:  a query for one TLD using the whois proxy will deplete one query from your monthly contingent. If you activate all the TLDs and query one term, it will deplete multiple queries from the contingent. Only activate the ones you really need.




__EOF__
