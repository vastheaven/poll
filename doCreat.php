<?php
    if(isset($_GET["pollid"]))
        $pollid = $_GET["pollid"];
    else 
        exit("no poll id");
    
    $question="";
    if(isset($_POST["question"]))
        //$question=$_POST["question"]."<br>(Post by: ".$_SERVER["cn"].")";
        $question=$_POST["question"];
    else
       exit("no question, not valid");
       
    $note="";
    if(isset($_POST["note"]))
        //$question=$_POST["question"]."<br>(Post by: ".$_SERVER["cn"].")";
        $note=$_POST["note"];

    $opensto = $_POST['opensto'];
    if(empty($opensto))
    {
        echo("You didn't select any 'opensto'. This poll will open to all.");
    }
    else
    {
        $N = count($opensto);
        echo("You selected $N $opensto(s): ");
        for($i=0; $i < $N; $i++)
        {
            echo($opensto[$i] . " ");
        }
    }

 
    $options=array();
    
    $i=1;
    $optnum=0;
    for($i=1;$i<=10;$i++){
        $name = "option".$i;
        if(isset($_POST[$name])){
            $options[] = $_POST[$name];
            $optnum++;
            //echo $_POST[$name];
        }
        else
            break;
        
    }
    $xmlDoc = new DOMDocument();
    $root = $xmlDoc->appendChild($xmlDoc->createElement("results"));
    $root->setAttribute("question",$question);
    $metadata = $root->appendChild($xmlDoc->createElement("metadata"));
    $groups="";
    for($i=0; $i<count($opensto); $i++)
    {
        $groups=$groups.$opensto[$i]."#";

    }
    $posttime = date("j F Y, g:i a");
    $metadata->appendChild($xmlDoc->createElement("owner",$_SERVER["cn"]));
    $metadata->appendChild($xmlDoc->createElement("groups",$groups));
    $metadata->appendChild($xmlDoc->createElement("posttime",$posttime));

    $root->appendChild($xmlDoc->createElement("note", $note));

    for($i=0;$i<$optnum;$i++)
    {
        $optionitem = $root->appendChild($xmlDoc->createElement("pollitem"));
        $optionitem->appendChild($xmlDoc->createElement("entryname",$options[$i]));
        ;
        $optionitem->appendChild($xmlDoc->createElement("votes",0));
        
    }
    $resfile="xml/results".$pollid.".xml";
    $xmlDoc->save($resfile);
    
    $xmlDoc = new DOMDocument();
    $root = $xmlDoc->appendChild($xmlDoc->createElement("addresses"));
    $addrfile="xml/addresses".$pollid.".xml";
    $xmlDoc->save($addrfile);
    
    echo "<h3> Your poll has been created successfully </h3>";
    echo '<a href=poll.php?pollid='.$pollid.'>Go to the poll page</a>';

?>
