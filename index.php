<html>
<head>
<title>Cardiff Physx Simple Poll System</title>
</head>

<body>
<?php
require_once("header.php");
?>
<div id=main align="center">

<a href="creat.php">Creat a poll</a><br><br>
<?php 
    $directory = "xml/";
    $pollnum=0;
    if (glob($directory . "*.xml") != false)
    {
        $filecount = count(glob($directory . "*.xml"))/2;
        $pollnum=$filecount;
    }
    for($i=1;$i<=$pollnum;$i++){
       // echo '<a href=poll.php?pollid='.$i.'>poll '.$i.'</a> ';
        $doc = new DOMDocument();
        $resfile = "xml/results".$i.".xml";
        if (file_exists($resfile)) {
        $doc->load($resfile );;
        $root = $doc->getElementsByTagName("results")->item(0);
        $question = $root->getAttribute("question");
        $owner = $doc->getElementsByTagName("owner")->item(0)->nodeValue;
        $posttime = $doc->getElementsByTagName("posttime")->item(0)->nodeValue;
        echo  '<b><a href=poll.php?pollid='.$i.'>'.$question.'</a></b>                    by '.$owner.'      at '.$posttime.' <br>';
        //if($i%8==0)
        //    echo "<br>";
        }
    }

    ?>
</div>
</body>


</html>
