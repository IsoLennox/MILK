<?php include("inc/header.php"); ?>

<a href="messages.php">&laquo; All Messages</a>
 
 <h1>Conversation with <a href="profile.php?user=<?php echo $_GET['with_user']; ?>"><?php echo $_GET['with']; ?></a></h1>
          
<div id="scrollbox">
           <?php

//MARK ALL IN THREAD WHERE YOU ARE SENT_TO as VIEWED=1
    $viewed_query  = "UPDATE messages SET viewed=1 WHERE thread_id={$_GET['thread']} AND sent_to={$_SESSION['user_id']}";  
    $viewed_result = mysqli_query($connection, $viewed_query); 
  

//READ ALL MESSAGES
    $query  = "SELECT * FROM messages WHERE thread_id={$_GET['thread']} ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){
       
        //show each result value
        foreach($result as $show){
            $name=find_user_by_id($show['sent_from']);
            echo "From: <a href=\"profile.php?user=".$show['sent_from']."\">".$name['first_name']."</a><br/>";
            echo "Sent: ".$show['datetime']."<br/>";
            echo htmlspecialchars_decode($show['content'])."<br/>";
            echo "<hr/><br/>";
             
                      
            }
        }
 ?>
      </div>
          <form method="POST" action="messages.php?send">
              
              <textarea name="msg" id="" cols="30" rows="10"></textarea>
              <input type="hidden" name="send_to" value="<?php echo $_GET['with_user']; ?>">
              <input type="hidden" name="thread" value="<?php echo $_GET['thread']; ?>">
              <input type="submit" name="sumbit" id="submit" value="Reply">
          </form>
        
      
        
<?php include("inc/footer.php"); ?>