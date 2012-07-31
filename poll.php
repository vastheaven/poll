<html>

<head>
	<title>Cardiff Physx Simple Poll System</title>
	<link rel="stylesheet" type="text/css" href="css/poll.css"/>
	<script language="javascript">
	     function setVote(voteName)
	     {
	      	document.getElementById("votefor").value = voteName;
	     }
	     function confirmSubmit() 
	     { 
		if (document.getElementById("votefor").value == "")
		{
		     var agree=confirm("Please select an entry before voting."); 
		     return false; 
		}
	     } 
	</script>
</head>

<body>
<?php
require_once("header.php");
?>
<?php $pollid=$_GET["pollid"]; 
    $actionurl = "results.php?pollid=".$pollid;
    echo '<FORM id="frmVote" action="'.$actionurl.'" method="POST">';
    ?>
	     <table id="tblMain" align="center">
	       	<tr>
			<td class="header"></td>
	     	</tr>
		<tr>
			<td>
			     <?php
                     //check user permission
                     
                     /*
                      * setup
                      */
                     $gmap = array(
                                   "all"  => "*",
                                   "ligo" => "Communities:LSCVirgoLIGOGroupMembers",
                                   "ligoguest" =>"*",
                                   "cardiff" => "cn=PHYSX-All,ou=PHYSX,ou=DAGroups,ou=Groups,o=Resources",
                                      );
                     $checkvar = "isMemberOf";
                     /*************/
                                      
                     $doc = new DOMDocument();
                     $resfile = "xml/results".$pollid.".xml"; 
                     $doc->load($resfile );;
                     $g = $doc->getElementsByTagName("groups")->item(0)->nodeValue;
                     
		     if(empty($g))
			$permit = true;
		     else{
                     	$groups = explode("#", $g);
                        $permit = false;

                     for($i=0;$i<count($groups);$i++)
                     {
                         $pg = $groups[$i];
			 if(!empty($pg)){
                         $pgmapped = $gmap[$pg]; 
                         if($pgmapped == "*"){
                             $permit = true;
                             break;
                         }
                         if(isset($_SERVER[$checkvar])){
                             $usergroup = $_SERVER[$checkvar];
                             //echo $usergroup."<br>".$pgmapped."<br><br>";
			     if (strpos($usergroup,$pgmapped) !== false){
                                 $permit = true;
                                 break;
                             }
                         }
			}
                     }
                     }

                     
                     if($permit){
                       $combineg="";
                        for($i=0;$i<count($groups)-1;$i++)
                        {
                            $combineg=$combineg."[".$groups[$i]."]";
                        }
			if(empty($combineg))
			echo "This poll opens to <b>all</b>.<br><br>";
			else
			echo "This poll opens to <b>".$combineg."</b>.<br><br>";
                        include "loadpoll.php";
		     }
                     else
                     {
                        $combineg="";
                        for($i=0;$i<count($groups)-1;$i++)
                        {
                            $combineg=$combineg."[".$groups[$i]."]";
                        }
                        exit("Sorry this poll only opens to group(s) <b>".$combineg."</b> Your current credential doesn't belong to these groups. <br>Your group env variable: ".$_SERVER[$checkvar]);
                     }
                     ?>
			</td>
		</tr>
		<tr>
			<td>
			     <input id="votefor" name="votefor" type="hidden"/>
			</td>
		</tr>
 		<tr>
			<td class="button">
			     <INPUT id="btnVote" class="btn" onclick="return confirmSubmit()" type="submit" value="Vote"/>
                    <INPUT id="btnView" class="btn" onclick="return setVote('')" type="submit" value="View"/>
			</td>

		</tr>

	     </table>
	</FORM>
</body>

</html>
