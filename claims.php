<?php include("inc/header.php"); ?>

<!--FOR EMPLOYEES-->

<h1>Claims</h1>

<form action="#">
    <input type="text" name="search" value="" placeholder="Search Claims by ID, Policyholder, or content...">
    <input type="submit" name="submit" id="submit" value="Find Claims">
</form>
 
       <ul class="inline">
           <li><a href="claims.php">All</a></li>
           <li><a href="claims.php?pending">Pending</a></li>
           <li><a href="claims.php?approved">Approved</a></li>
           <li><a href="claims.php?denied">Denied</a></li>
       </ul>
       
       
       <?php
//get type of claim queried
    if(isset($_GET['pending'])){
    
    //select all where claim type == pending   order by id ASC  
        ?>
        <h2>Pending Claims</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.
        </p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.</p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <?php   
    
    }elseif(isset($_GET['approved'])){
    
    //select all where claim type == approved    order by id DESC  
        ?>
        <h2>Approved Claims</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.
        </p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.</p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <?php 
    
    }elseif(isset($_GET['denied'])){
    
    //select all where claim type == approved    order by id DESC  
        ?>
        <h2>Denied Claims</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.
        </p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.</p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <?php   }else{
 
    //select all claims order by id DESC  
        ?>
        <h2>All Claims</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.
        </p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id libero nam velit perspiciatis quis commodi soluta? Repudiandae aliquam rem molestias reprehenderit in repellat vitae, placeat atque veniam, facilis saepe.</p>
        <a href="claim_details.php?id=1">View this Claim</a>
        <Br/>
 <?php }//end show claims dependant on uery
?>

      
        
<?php include("inc/footer.php"); ?>