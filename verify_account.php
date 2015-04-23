<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<!--IF ACCOUNT IS NOT VERIFIED IN DB, USER WILL BE SENT TO THIS PAGE INSTEAD OF HOME PAGE AFTER LOGIN-->
<body>
      <!--  Put app logo here? -->
   <h1>Verify Account</h1>
   <form action="#">
       <input name="verify" type="text" placeholder="Verification Code">
       <input name="submit" type="submit" value="Verify Account">
   </form> 
   <a href="#" onclick="alert('Please enter your email address');">Send New Verification Code</a>
 
  
   <a href="login.php">Back To Log In</a>
    
</body>
</html>