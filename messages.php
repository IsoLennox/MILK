<?php
$current_page="messages";
include("inc/header.php"); ?>

   <?php
    if(isset($_GET['new'])){
        
        echo "<h1>Compose New Message</h1>";
        
            $query  = "SELECT * FROM users WHERE is_employee=1 AND id != {$_SESSION['user_id']}";  
            $result = mysqli_query($connection, $query);
            $rows = mysqli_num_rows($result);
                if($rows >=1){
                   echo "<form action=\"messages.php?send\" method=\"POST\">"; 
                        echo "<select name=\"send_to\">";
                    //show each result value
                   
                    //see if came from user's profile
                    if(isset($_GET['route'])){
                                 echo "<option value=\"".$_GET['route']."\">".$_GET['name']."</option>";
                            }else{
                        foreach($result as $show){ 
                                echo "<option value=\"".$show['id']."\">".$show['first_name']." ".$show['last_name']."</option>"; 
                            }
                    }//end check if user pre-selected
                    
                        echo "</select>";
                        echo "<textarea name=\"msg\" placeholder=\"Hello...\"></textarea>";
                    echo "<input type=\"submit\" name=\"submit\" value=\"Send Message\">";
                    echo "</form>";
                    echo "<a href=\"messages.php\" onclick=\"return confirm('Leave the page? This will not save your message!');\"><i class=\"fa fa-times\"></i> Cancel</a> ";
                }else{
                    echo "There are no employees to send a message to!";
                }
     
    }elseif(isset($_GET['send'])){
        //SUBMITTED NEW MESSAGE TO USER 
        $send_to=$_POST['send_to'];
        $message=$_POST['msg'];
        $message=addslashes($message);
        $message=htmlentities($message);
        $message=htmlspecialchars($message);
        $date=date('m/d/Y H:i');
        
        //SEE IF YOU HAVE A THREAD WITH THIS USER:  1=GET THREAD ID / 0= CREATE THREAD && GET THREAD ID
        if(isset($_POST['thread'])){
            $thread_id=$_POST['thread'];
        }else{
            $threadquery  = "SELECT * FROM thread WHERE (user1={$_SESSION['user_id']} AND user2={$send_to}) OR (user2={$_SESSION['user_id']} AND user1={$send_to})";  
            $threadresult = mysqli_query($connection, $threadquery);
            $rows = mysqli_num_rows($threadresult);
                if($rows >=1){ 
                   //get this thread ID
                    $thread=mysqli_fetch_assoc($threadresult);
                    $thread_id=$thread['id'];
                    echo "Found thread";
                }else{
                    //insert a new thread, get ID
                    $new_thread="INSERT INTO thread (user1, user2) VALUES ({$_SESSION['user_id']}, {$send_to})";
                    $thread_created=mysqli_query($connection, $new_thread);
                    if($thread_created){
                        $get_thread="SELECT * FROM thread WHERE user1={$_SESSION['user_id']} AND user2={$send_to} LIMIT 1";
                        $thread_retreived=mysqli_query($connection, $get_thread);
                        if($thread_retreived){
                            $thread=mysqli_fetch_assoc($thread_retreived);
                            $thread_id=$thread['id'];
                            echo "New thread created!";
                        }else{
                            echo "Thread created, could not get ID";
                        }
                    }else{
                        echo "Could not create thread with this user!";
                    }
                }
        }//end get thread ID
        
        //INSERT MESSAGE WITH THREAD ID
        $new_message="INSERT INTO messages ( datetime, thread_id, sent_from, sent_to, content ) VALUES ( '{$date}', {$thread_id}, {$_SESSION['user_id']}, {$send_to}, '{$message}' )";
        $message_result=mysqli_query($connection, $new_message);
        if($message_result){
            $name=find_user_by_id($send_to);
            $with_user=$name['first_name']."%20".$name['last_name'];
            //REDIRECT TO THIS MESSAGE THREAD
            redirect_to('read_message.php?thread='.$thread_id.'&with_user='.$send_to.'&with='.$with_user);
        }else{
            echo "Error sending this message: ".$message." to user: ".$send_to." on thread: ".$thread_id;
            //send error report to dev??
        }
    
    
    }else{

?>
   <h1>Messages</h1>
    <a href="messages.php?new" class='large_link'><i class="fa fa-envelope"> </i> New Message</a>
          <!-- <ul> -->
          <?php
                //Find which threads have new messages
                $new_query  = "SELECT * FROM messages WHERE sent_to = {$_SESSION['user_id']} AND viewed=0";  
                $new_result = mysqli_query($connection, $new_query);
                if($new_result){
                    $new_messages=array();
                    //messages that have not been viewed and match current user
                    //push to end of new message array, with the new thread id
                    foreach($new_result as $new){
                        array_push($new_messages, $new['thread_id']);
                    }
                }
        
        
                $query  = "SELECT * FROM thread WHERE user1 = {$_SESSION['user_id']} OR user2 = {$_SESSION['user_id']}";  
                $result = mysqli_query($connection, $query);
                $rows = mysqli_num_rows($result);
                if($rows >=1){
                    // echo "<hr/>";
                    //show each result value
                    foreach($result as $show){
                        
                        //GET USER WHO IS NOT YOU
                        if($show['user1']==$_SESSION['user_id']){
                            $with_id=$show['user2'];
                        }elseif($show['user2']==$_SESSION['user_id']){
                            $with_id=$show['user1'];
                        }
                        
                            $withquery  = "SELECT * FROM users WHERE id={$with_id}";  
                            $withresult = mysqli_query($connection, $withquery);
                            if($withresult){
                                $user=mysqli_fetch_assoc($withresult);
                            }
                            $with_name=$user['first_name']." ".$user['last_name'];
                            $with_img=$user['avatar'];
                        
                        
                        //NOTIFY WHICH THREAD HAS NEW MESSAGES
                            if(in_array($show['id'], $new_messages)){
                                $new_alert="<div class='new_alert'></div> ";
                            }else{
                                $new_alert="";
                            }//end new message indicator
                        
                            echo "<div class='notes_container'><div class='item_content'><a href=\"read_message.php?thread=".$show['id']."&with=".$with_name."&with_user=".$with_id."\" class='small_link'>Conversation with ". $with_name. " " . $new_alert . "</a>";
                           
                        
                        
                        
                        //GET LAST MESSAGE FROM THIS THREAD
                        
                        //Find which threads have new messages
                $last_message_query  = "SELECT * FROM messages WHERE thread_id={$show['id']} ORDER BY id DESC LIMIT 1";  
                $msg_result = mysqli_query($connection, $last_message_query);
                if($msg_result){
                    $this_msg=mysqli_fetch_assoc($msg_result);
                    $last_message=$this_msg['content'];
                    $last_time=$this_msg['datetime'];
                        //LIMIT CHARACTER PREVIEW
                        $position=50; // Define how many character you want to display. 
                        $last_message = substr($last_message, 0, $position)."...."; 
                    echo "<p>" . $last_message . "<br>".$last_time."</p></div>";
                    if(empty($with_img)){
                        echo "<div class='thumb_avatar item_img_content'><i class=\"fa fa-user fa-5x\"></i></div>"; 
                    }else{
                        echo "<div class='thumb_avatar item_img_content'><img src=\"{$with_img}\" onerror=\"this.src='http://lorempixel.com/100/100/abstract'\"  alt=\"{$with_name}'s avatar\"></div>"; 
                    }
                    
                }
                        
                        
                            echo "<div class=\"clearfix\"></div></div>";
                        }
                        echo "<div class=\"clearfix\"></div>";
                    }else{
                    echo "You have no messages!";
                }
?> 
          <!-- </ul> -->
           <?php
        
    } 
 ?>
    
      
        
<?php include("inc/footer.php"); ?>