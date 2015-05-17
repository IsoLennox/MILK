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
                    foreach($result as $show){

                        echo "<option value=\"".$show['id']."\">".$show['first_name']." ".$show['last_name']."</option>";

                        }
                        echo "</select>";
                        echo "<textarea name=\"msg\" placeholder=\"Hello...\"></textarea>";
                    echo "<input type=\"submit\" name=\"submit\" value=\"Send Message\">";
                    echo "</form>";
                }else{
                    echo "There are no employees to send a message to!";
                }
    
    
    
    
    }elseif(isset($_GET['send'])){
        
        $send_to=$_POST['send_to'];
        $message=$_POST['msg'];
        $date=date('d/m/Y H:i');
        
        //SEE IF YOU HAVE A THREAD WITH THIS USER:  1=GET THREAD ID / 0= CREATE THREAD && GET THREAD ID
        
            $threadquery  = "SELECT * FROM thread WHERE (user1={$_SESSION} AND user2={$send_to}) OR (user2={$_SESSION} AND user1={$send_to}) LIMIT 1";  
            $threadresult = mysqli_query($connection, $threadquery);
//            $rows = mysqli_num_rows($threadresult);
//                if($rows >=1){
            if($threadresult){
                   //get this thread ID
                    $thread=mysqli_fetch_assoc($threadresult);
                    $thread_id=$thread['id'];
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
                        }else{
                            echo "Thread created, could not get ID";
                        }
                    }else{
                        echo "Could not create thread with this user!";
                    }
                }
        //INSERT MESSAGE WITH THREAD ID
        $new_message="INSERT INTO messages ( datetime, thread_id, sent_from, sent_to, content ) VALUES ( '{$date}', {$thread_id}, {$_SESSION['user_id']}, {$send_to}, '{$message}' )";
        $message_result=mysqli_query($connection, $new_message);
        if($message_result){
            redirect_to('read_message.php?thread='.$thread_id);
        }else{
            echo "Error sending this message";
            //send error report to dev??
        }
    
    
    }else{

?>
   <h1>Messages</h1>
    <h4> <a href="messages.php?new">New Message</a></h4> 
          <ul>
          <?php
                $query  = "SELECT * FROM thread WHERE user1 = {$_SESSION['user_id']} OR user2 = {$_SESSION['user_id']}";  
                $result = mysqli_query($connection, $query);
                $rows = mysqli_num_rows($result);
                if($rows >=1){
                    echo "<p>Your conversations:</p>";
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
                            echo "<li><a href=\"read_message.php?thread=".$show['id']."&with=".$with_name."\">Conversation with ".$with_name."</a></li>";
                        }
                    }else{
                    echo "You have no messages!";
                }
?> 
          </ul>
           <?php
        
    } 
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>