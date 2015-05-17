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
                        //see if came from user's profile
                            if(isset($_GET['route'])){
                                if($_GET['route']==$show['id']){
                                    $selected="selected";
                                }
                            }else{
                                $selected="";
                            }
                        
                        
                        echo "<option ".$selected." value=\"".$show['id']."\">".$show['first_name']." ".$show['last_name']."</option>";

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
        $message=addslashes($message);
        $message=htmlentities($message);
        $message=htmlspecialchars($message);
      
        
        $date=date('d/m/Y H:i');
        
        //SEE IF YOU HAVE A THREAD WITH THIS USER:  1=GET THREAD ID / 0= CREATE THREAD && GET THREAD ID
        if(isset($_POST['thread'])){
            $thread_id=$_POST['thread'];
        }else{
            $threadquery  = "SELECT * FROM thread WHERE (user1={$_SESSION['user_id']} AND user2={$send_to}) OR (user2={$_SESSION['user_id']} AND user1={$send_to})";  
            $threadresult = mysqli_query($connection, $threadquery);
            $rows = mysqli_num_rows($threadresult);
                if($rows >=1){
//            if($threadresult){
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
            redirect_to('read_message.php?thread='.$thread_id.'&with_user='.$send_to.'&with='.$with_user);
        }else{
            echo "Error sending this message: ".$message." to user: ".$send_to." on thread: ".$thread_id;
            //send error report to dev??
        }
    
    
    }else{

?>
   <h1>Messages</h1>
    <h4> <a href="messages.php?new">New Message</a></h4> 
          <ul>
          <?php
                //Find which threads have new messages
                $new_query  = "SELECT * FROM messages WHERE sent_to = {$_SESSION['user_id']} AND viewed=0";  
                $new_result = mysqli_query($connection, $new_query);
                if($new_result){
                    $new_messages=array();
                    foreach($new_result as $new){
                        array_push($new_messages, $new['thread_id']);
                    }
                }
        
        
                $query  = "SELECT * FROM thread WHERE user1 = {$_SESSION['user_id']} OR user2 = {$_SESSION['user_id']}";  
                $result = mysqli_query($connection, $query);
                $rows = mysqli_num_rows($result);
                if($rows >=1){
                    echo "<hr/>";
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
                        
                        
                        //NOTIFY WHICH THREAD HAS NEW MESSAGES
                            if(in_array($show['id'], $new_messages)){
                                $new_alert="NEW! ";
                            }else{
                                $new_alert="";
                            }//end new message indicator
                        
                            echo "<li>".$new_alert."<a href=\"read_message.php?thread=".$show['id']."&with=".$with_name."&with_user=".$with_id."\">Conversation with ".$with_name."</a></li>";
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