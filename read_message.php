<?php include("inc/header.php"); ?>

<a href="messages.php">&laquo; All Messages</a>
 
 <h1>Conversation with<br> <a href="profile.php?user=<?php echo $_GET['with_user']; ?>"><?php echo $_GET['with']; ?></a></h1>
          
<!-- <div id="scrollbox"> -->
           <?php

//MARK ALL IN THREAD WHERE YOU ARE SENT_TO as VIEWED=1
    $viewed_query  = "UPDATE messages SET viewed=1 WHERE thread_id={$_GET['thread']} AND sent_to={$_SESSION['user_id']}";  
    $viewed_result = mysqli_query($connection, $viewed_query); 
  

//READ ALL MESSAGES
    $query  = "SELECT * FROM messages WHERE thread_id={$_GET['thread']} ORDER BY id ASC";  
    $result = mysqli_query($connection, $query);
    if($result){
        echo "<div class='message_container'>";
        //show each result value
        foreach($result as $show){
            
            if($show['sent_from']==$_SESSION['user_id']){
                $display="msg_right";
            }else{
                $display="msg_left";
            }
            
            $name=find_user_by_id($show['sent_from']);
            echo "<div class='message_content'>";
            if(empty($name['avatar'])){
            echo "<div class='$display'><i class=\"fa fa-user fa-3x\"></i></div>"; 
            }else{
            echo "<div class='$display'><img src='" . $name['avatar'] . "' class='thumb_avatar' onerror=\"this.src='http://lorempixel.com/50/50/'\"></div>";
            }
            echo "<div class=\"$display\"><p>From: <a href=\"profile.php?user=".$show['sent_from']."\">".$name['first_name']."</a>";
            echo "<br>Sent: ".$show['datetime']."</p>";
            echo "<p>" .htmlspecialchars_decode($show['content'])."</p></div>";
            echo "<div class=\"clearfix\"></div></div>";
             
                      
            }
            echo "</div>";
        }
 ?>
        <div class="sticky">
          <form method="POST" action="messages.php?send">
              
              <textarea name="msg" id="" cols="30" rows="10"></textarea><br>
              <input type="hidden" name="send_to" value="<?php echo $_GET['with_user']; ?>">
              <input type="hidden" name="thread" value="<?php echo $_GET['thread']; ?>">
              <input type="submit" name="sumbit" id="submit" value="Reply">
          </form>
        </div>
      
<script>
  $(document).ready(function() {
    $('html, body').animate({
      scrollTop: $('.message_content').last().offset().top
    }, 'slow');
  });
</script>        
<?php include("inc/footer.php"); ?>