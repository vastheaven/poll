<?php
  if(isset($_GET["pollid"]))
     $pollid = $_GET["pollid"];
  if(isset($_REQUEST["votefor"]))
     $votefor = $_POST["votefor"];
//     else
//    echo "votefor not set<br>";
    
$addrfile = "xml/addresses".$pollid.".xml";    
$resfile="xml/results".$pollid.".xml";
    
  // Returns a random RGB color (used to color the vote bars)
  function getRandomColor()
  {
       $r = rand(128,255); 
       $g = rand(128,255); 
       $b = rand(128,255); 
       $color = dechex($r) . dechex($g) . dechex($b);
       echo "$color";
  }
  //Get the IP of the user
 // $domain = $_SERVER["REMOTE_ADDR"];
    $domain = $_SERVER["cn"]; 
 $today = date("m/d/Y");

  echo "<table id=\"tblResults\" align=\"center\">";
  
  //If votefor is null, then we're just viewing results, so don't log the IP
  if ($votefor != "")
  {

    //Load the addresses XML file
    $doc = new DOMDocument();
    
    $doc->load($addrfile);
    $addresses = $doc->getElementsByTagName("address");
    $pVoted = false;
    $pFound = false;

    //Loop through the addresses nodes and see if the person has voted before
    foreach( $addresses as $address )
    {
  	$lastvisits = $address->getElementsByTagName("lastvisit");
  	$lastvisit = $lastvisits->item(0)->nodeValue;
  
  	$ips = $address->getElementsByTagName("ip");
  	$ip = $ips->item(0)->nodeValue;

  	if ($ip == $domain)
	{
	     $pFound = true;
	     //if ($lastvisit == $today)
         $pVoted = true;
	    // else
	    // {
		//$lastvisits->item(0)->nodeValue = $today;
		//$doc->save("xml/addresses.xml");
	    // }
	     //break;
	}
	else
	     continue;
    }

    if ($pVoted == true) //Already voted
    {
        echo "<tr><td colspan=\"3\" class=\"message\">You (".$domain.") already voted.</td></tr>";
    }
    else //Update the XML files
    {
	if ($pFound == false) //Add new node for IP and date to addresses.xml
  	{
	     echo "<tr><td colspan=\"3\" class=\"message\">Thanks for voting for $votefor!</td></tr>";

	     $newAddy = $doc->getElementsByTagName('addresses')->item(0);
	     $newAddressElement = $doc->createElement('address');

	     $newLastVisitElement = $doc->createElement('lastvisit');
	     $newAddressElement->appendChild($newLastVisitElement);
	     $newIPElement = $doc->createElement('ip');
	     $newAddressElement->appendChild($newIPElement);

	     $dayvalue = $doc->createTextNode($today);
	     $dayvalue = $newLastVisitElement->appendChild($dayvalue);

 	     $ipvalue = $doc->createTextNode($domain);
	     $ipvalue = $newIPElement->appendChild($ipvalue);

	     $newAddy->appendChild($newAddressElement);

	     $doc->save($addrfile);
  	}
	else
	{
	     echo "<tr><td colspan=\"3\" class=\"message\">Thanks for voting for $votefor!</td></tr>";
	}
	// Update the vote
	$doc = new DOMDocument();
  	$doc->load($resfile);
  	$pollitems = $doc->getElementsByTagName("pollitem");
  	foreach( $pollitems as $pollitem )
  	{
  		$entries = $pollitem->getElementsByTagName("entryname");
  		$entry = $entries->item(0)->nodeValue;
		if ($entry == $votefor)
		{
  		     $votes = $pollitem->getElementsByTagName("votes");
  		     $count = $votes->item(0)->nodeValue;
		     $votes->item(0)->nodeValue = $count + 1;
		     break;
		}
  	}
        
	$doc->save( $resfile);
    }
  }
  else
  {
     echo "<tr><td colspan=\"3\" class=\"message\">Poll Results</td></tr>";
  }

  // Get max vote count
  $doc = new DOMDocument();
  $doc->load($resfile);
  $maxvotes = 0;
  $mainpolls = $doc->getElementsByTagName("results");
  foreach ($mainpolls as $mainpoll) 
    $questionstr= $mainpoll->getAttribute("question");
  echo "<tr><td colspan='3' class='question'>".$questionstr."</td></tr>";
    
  $pollitems = $doc->getElementsByTagName("pollitem");
  foreach( $pollitems as $pollitem )
  {
  	$votes = $pollitem->getElementsByTagName("votes");
	$vote = $votes->item(0)->nodeValue;
  	$maxvotes = $maxvotes + $vote;
  }
  // Generate the results table
  $doc = new DOMDocument();
  $doc->load($resfile);
  $pollitems = $doc->getElementsByTagName("pollitem");
  foreach( $pollitems as $pollitem )
  {
  	$entries = $pollitem->getElementsByTagName("entryname");
  	$entry = $entries->item(0)->nodeValue;
  	$votes = $pollitem->getElementsByTagName("votes");
  	$vote = $votes->item(0)->nodeValue;
	$tempWidth = $vote / $maxvotes;
	$tempWidth = 300 * $tempWidth;
	$votepct = round(($vote / $maxvotes) * 100);
	echo "<tr><td width=\"30%\" class=\"polls\">$entry</td>";
	echo "<td width=\"50%\" class=\"resultbar\"><div class=\"bar\" style=\"background-color: ";
        getRandomColor();
        echo "; width: $tempWidth px;\">$votepct%</div></td><td width=\"20%\">($vote votes)</td></tr>";
  }
  echo "<tr><td class=\"total\" colspan=\"3\">$maxvotes people have voted in this poll.</td>";
  echo "</table>";
?>
