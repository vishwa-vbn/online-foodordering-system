
<?php 

include 'config.php';

session_start();
$user_id=$_SESSION['user_id'];

if(!isset($user_id))
{
   header('location:login.php');
}


if(isset($_GET['can_id']))
{

   $can_order_id=$_GET['can_id'];
   $cancle_status='canceled';
   mysqli_query($conn,"UPDATE `orders` SET delivery_Time='$cancle_status' WHERE id='$can_order_id'") or die('query failed');
   $message[]="order cancled successfully";

}

?> 


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body id="orderbody">
   


<?php include'header.php'; ?>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="RICON" onclick="this.parentElement.remove();">X</i>
      </div>
      ';
   }
}
?>

<div id="ordersec">
  <div class="otitle"> <h1 >Your Orders</h1> 

</div>
   <div class="box-o-container">

      <div class="o-div1">

                  <?php

                  $select_orders=mysqli_query( $conn,"SELECT * FROM `orders` WHERE user_id='$user_id ' ") or die('query failed');
                  if(mysqli_num_rows($select_orders)>0)
                  {
                     while($fetch_orders = mysqli_fetch_assoc($select_orders))
                    {

                        global $food_name;

                       $food_na= explode(" (",$fetch_orders['total_products'] );
                       $food_name=$food_na[0]
                  ?>








               <div class= "orderdiv" >
                  
                  <div  id="imgword">

                     <div>
                          <img class="foodimg"   src="uploaded_img/<?php echo $fetch_orders['image']; ?>" > 
                      </div>
   
                          <div id="contentdiv">
                                   <div class="Oname" > <?php  echo $fetch_orders['total_products'] ;?>  </div>
                                    <div class="address"><p > Address:  <?php echo $fetch_orders['address']; ?> </p></div> 
                                     <div class="doo"> Ordered on : <?php echo $fetch_orders['dateOforder']; ?> </div>
                                         <div class="pstatus"> delivery time/status: <?php echo $fetch_orders['delivery_Time']; ?></div>
                                        <div class="edelivery">payment : <?php echo $fetch_orders['payment_status']; ?></div>

                             
                                         <div class= "rdiv"> 
                                        <a  id="bill_link" href="customerbill.php?od_id=<?php echo $fetch_orders['id']; ?>" >get bill</a> 

                                        <a  id="can_link" href="orders.php?can_id=<?php echo $fetch_orders['id']; ?>" >cancel</a> 
                                                                                  
                                                <button type="button"  id="rbtn" name="rview"  value="<?php echo $food_name ?>" onclick="showreview(this)" > Write Review </button>
                                           </div>




                     
                                           
                   
                                     <div class="Oprice"> <h3><?php  echo $fetch_orders['total_price']; ?>/- </h3></div>

                              </div>


                              


                   </div>

      



     
               


               </div>

    
      
                       


      
  




<?php


   }
}

   ?>

   



   

   </div>


   </div>


<div id="reviewdiv">
                                 


                                 <form action="" method="post">
                                    <div id="rflex"> 
                                       
                                    <label id='rlable'> Name:  </label>
                                    <div><h3 id="item_name"> </h3></div>  

                                    </div>
                                    <input type="hidden" id="hname" name="hname" >
                                    <textarea id="textbox" name="textr" cols="50" rows="4" placeholder="write review..."></textarea>
                                    <div id="rev_btn" ><input  id="r_btn" type="submit" value="Submit" name="rsubmit" > </div>
                                  </form>

 </div>



 <?php 

 if(isset($_POST['rsubmit']))
 {
$hidden_name= $_POST['hname'];
$rtextarea= $_POST['textr'];

mysqli_query($conn," INSERT INTO `reviews` (user_id,food_name,review)VALUES('$user_id','$hidden_name','$rtextarea')") or die('query failed');




 }

 ?>

<script src="./js/admin_control.js"></script>
    
</body>
</html>





