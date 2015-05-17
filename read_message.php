<?php include("inc/header.php"); ?>

<a href="messages.php">&laquo; All Messages</a>
 
 <h1>Conversation with <?php echo $_GET['with']; ?></h1>
          
<div id="scrollbox">
           <?php

//MARK ALL IN THREAD WHERE YOU ARE SENT_TO as VIEWED=1
    $viewed_query  = "UPDATE messages WHERE thread={$_GET['thread']} AND sent_to={$_SESSION['user_id']} SET viewed=1";  
    $viewed_result = mysqli_query($connection, $viewed_query);
  

//READ ALL MESSAGES
    $query  = "SELECT * FROM messages WHERE thread_id={$_GET['thread']} ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){
       
        //show each result value
        foreach($result as $show){
            $name=find_user_by_id($show['sent_from']);
            echo "From: <a href=\"profile.php?id=".$show['sent_from']."\">".$name['first_name']."</a><br/>";
            echo "Sent: ".$show['datetime']."<br/>";
            echo $show['content']."<br/>";
            echo "<hr/><br/>";
             
                      
            }
        }
 ?>
      </div>
          <form action="#">
              
              <textarea name="reply" id="" cols="30" rows="10"></textarea>
              <input type="submit" name="sumbit" id="submit" value="Reply">
          </form>
        
      
        
<?php include("inc/footer.php"); ?>