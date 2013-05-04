<?
/*---------------------------------------------------------
AjaxDomainSearch v1.1
Copyright (C) 2006-2007 Nattawat Palakawong

Website: http://www.ajaxdomainsearch.com
Contact: contact@ajaxdomainsearch.com
First Created: 2006-11-28.
Last Updated: 2007-11-04.

What's New:
Version 1.1 add .info .biz .us / rewrite code
Version 1.0 first version only .com .net .org

- - - - - - - - - - - - - - - - - - - -
Ajax Whois using InterNetX Whois Proxy v1.3
Modified by: Alexander Werner (July 11th 2012)
Contact: alex@eff-bee-eye.de

Version 1.3
Added: more than 30 new TLDs
Improved: DNSCHECK Fallback for domains that have no whois server

Version 1.2
Added: InterNetX Whois Proxy Connectivity
Added: Changed to send requests on enter instead of per-keystroke
in order to limit the number of request sent to the whois server
- - - - - - - - - - - - - - - - - - - - -
DomainCat
Modified by: Alexander Werner (May 3rd 2013)

Added: Migrated to Github
- - - - - - - - - - - - - - - - - - - - - -

Usage:

see readme.txt for more info


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
---------------------------------------------------------*/

$whois_servers = Array(

'com' => array('whois.internic.net','No match for'),
'net' => array('whois.internic.net','No match for'),
'org' => array('whois.pir.org','NOT FOUND'),
'info' => array('whois.afilias.net','NOT FOUND'),
'biz' => array('whois.nic.biz','Not found'),
'de' => array('whois.autodns3.de','free'),
'co.uk'=> array('whois.nic.uk','No match for'),
'nl' => array('whois.autodns3.de','free'),
'eu' => array('whois.eu','FREE'),
'it' => array('whois.nic.it','AVAILABLE'),
'mobi' => array('whois.dotmobiregistry.net','NOT FOUND'),
'asia' => array('whois.nic.asia','NOT FOUND'),
'name' => array('whois.nic.name','No match'),
'at' => array('whois.nic.at','nothing found'),
'ch' => array('whois.nic.ch','We do not have an entry in our database matching your query'),
'es' => array('whois.autodns3.de','free'),
'be' => array('whois.dns.be','FREE'),
'nu' => array('whois.nic.nu','NO MATCH'),
'se' => array('whois.iis.se','not found'),
'us' => array('whois.nic.us','Not found')





);

$whois_error = Array('Can\'t get information');

//status message
$statusmsg[0] = "is available!";
$statusmsg[1] = "Domain name length < 3 letter.";
$statusmsg[2] = "Domain name can not start or end with -.";
$statusmsg[3] = "Please use letters , numbers and - only.";
$statusmsg[4] = "Can\'t lookup. Please try later";


// we replace statusmsg[5] because the whois proxy has no limit
$statusmsg[5] = "This server exceeded whois server quota. Please try again later.";
$statusmsg[6] = "is taken";
?>

