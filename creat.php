<html>
    <head>
    <title>Cardiff Physx Simple Poll System</title>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                          $("#addoption").click(function(){
                                                var totalnum = $("#options").attr("totalnum");
                                                var id = parseInt(totalnum)+1;
                                                var conetent = '<a id="option'+id.toString()+'">option'+id.toString()+'*: <input type="text" class="input_required" name="option'+id+'"/> <br></a>';
                                                $("#options").append(conetent);
                                                $("#options").attr("totalnum", id.toString());
                                                
                                       });
                           $("#deloption").click(function(){
                                                var totalnum = $("#options").attr("totalnum");
                                                var id = parseInt(totalnum);
                                                if(id>1){
                                                var tag = '#option'+id.toString();
                                                $(tag).remove();
                                                 $("#options").attr("totalnum", id-1);
                                                }
                                       });

                          $('#openstoall').click(function(){
                          if (this.checked) {
                            $(".pollgroup").prop("checked", true);                       
                            $(".pollgroup").attr("disabled", true);
                          } else {
                             $(".pollgroup").prop("checked", false);                      
                            $(".pollgroup").removeAttr("disabled");
                          } 
                                               });
                                                            
                          
                          });

function validateForm()
{
    var valid = true;
    var b = true;
    $('.input_required').each(function(i) {
                              if( $(this).val()==""){
                              valid = false;
                              $(this).css("border", "1px solid red");   //temp set, should use css file
                             // $(this).css("background-color", "yellow");  //temp set, should use css file
                              
                              //focus on the first empty field
                              if(b){
                              $(this).focus();
                              b = false;
                              }
                              }
                              else
                              {
                              $(this).removeAttr("style");  //temp set, should use css file
                              }
                              
                              });
    
    return valid;
}
        </script>
    </head>
    
    <body>  
    <?php
require_once("header.php");
?>  
<?php
    /*
    if (!isset($_SERVER['PHP_AUTH_PW'])||($_SERVER['PHP_AUTH_PW']!="cardiffphysx")) {
        header('WWW-Authenticate: Basic realm="Enter password"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Please send email to grav-it@astro.cf.ac.uk if you want to creat a poll';
        exit;
    } else {
        echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    }*/
    ?>
        <h3 align="center">Creat your poll</h3>
        <div id="form" align="center">
        <?php 
            $directory = "xml/";
            $pollid=1;
            if (glob($directory . "*.xml") != false)
            {
                $filecount = count(glob($directory . "*.xml"))/2;
                $pollid=$filecount+1;
            }
            echo '<form name="input" action="doCreat.php?pollid='.$pollid.'" method="POST">'
        ?>
        <div id="polltitle">
            <h4>Question*:
            <input id="question" class="input_required" type="text" name="question" size="35" /><h4>

        </div>
       <div class="formfield">
          <label for="textarea">Note: </label>
          <textarea id="note" name="note" cols="35" rows="3"></textarea>
       </div>
         <br>
        <a href="#" id="addoption">add</a>
        <a href="#" id="deloption">del</a>
        <div id="options" totalnum="1">
        <a id="option1"> option1*: <input type="text" name="option1" class="input_required"/><br></a>
        </div>
        
        <br>
Opens to: 
        <input id="openstoall" type="checkbox" name="opensto[]" value="all" />all groups        
        <input class="pollgroup" type="checkbox" name="opensto[]" value="ligo" />ligo       
        <input type="checkbox" class="pollgroup"  name="opensto[]" value="ligoguest" />ligo guest
        <input type="checkbox" class="pollgroup"  name="opensto[]" value="cardiff" />Cardiff Uni
        <br /><br />

        <input type="submit" onclick="return validateForm()" id="create" value="Create the Poll"/>
        </form>
   </div>

    </body>

    
    
</html>
    
    

