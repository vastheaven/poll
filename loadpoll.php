<?php
  // Load the results xml file
    $pollid=$_GET["pollid"];
  $doc = new DOMDocument();
  $resfile = "xml/results".$pollid.".xml"; 
    $doc->load($resfile );;
  $root = $doc->getElementsByTagName("results")->item(0);
  $question = $root->getAttribute("question");
  $owner = $doc->getElementsByTagName("owner")->item(0)->nodeValue;
  $posttime = $doc->getElementsByTagName("posttime")->item(0)->nodeValue;
  $note = $doc->getElementsByTagName("note")->item(0)->nodeValue;

  echo "<table id=\"tblPoll\" align=\"center\"><tr><td class=\"question\">$question</td></tr>";
    echo "<tr><td class='note'> $note </td></tr>";
  echo "<tr><td class=\"pollitem\">";
  $pollitems = $doc->getElementsByTagName("pollitem");
  $id = 1;
  // Loop through each item, and create a radio button for each item
  foreach( $pollitems as $pollitem )
  {
  	$entries = $pollitem->getElementsByTagName("entryname");
  	$entry = $entries->item(0)->nodeValue;
  	$votes = $pollitem->getElementsByTagName("votes");
  	$vote = $votes->item(0)->nodeValue;
	if ($id==1)
	  	echo "<input id=\"entry$id\" class=\"radiobutton\" onclick=\"setVote('$entry')\" type=\"radio\" name=\"poll\" value=\"$entry\">$entry<br>";
	else
		echo "<input id=\"entry$id\" onclick=\"setVote('$entry')\" type=\"radio\" name=\"poll\" value=\"$entry\">$entry<br>";
	$id = $id + 1;
  }
  echo "</td></tr>";
  echo "<tr><td><i>by $owner at $posttime </i></td</tr>";

  echo "</table>";
?>
