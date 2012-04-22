<?php

$servers =  array(
"j.gtld-servers.net.",
"k.gtld-servers.net.",
"l.gtld-servers.net.",
"m.gtld-servers.net.",
"a.gtld-servers.net.",
"b.gtld-servers.net.",
"c.gtld-servers.net.",
"d.gtld-servers.net.",
"e.gtld-servers.net.",
"f.gtld-servers.net.",
"g.gtld-servers.net.",
"h.gtld-servers.net.",
"i.gtld-servers.net.",
);

for($i=0; $i<count($servers); $i++){
	system("host -t a  ns1.superstar-adv.com ".$servers[$i]);
	print "<br>\n";
}

?>
