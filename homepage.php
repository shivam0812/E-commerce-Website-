<?php 
include('connect.php');
session_start();
error_reporting(0);
if(isset($_GET['cart'])){
$retrieve_cart_sql = "SELECT shoppingcart FROM accounts WHERE email='".$_SESSION['email']."'" ;
$retrieve_cart_que = $conn->query($retrieve_cart_sql);
$retrieve_cart = $retrieve_cart_que->fetch_assoc();
$retrieved_cart = explode(",",$retrieve_cart['shoppingcart']);
array_push($retrieved_cart,$_GET['cart']);
$updated_cart = implode(",",$retrieved_cart);
$update_cart_sql = "UPDATE accounts SET shoppingcart='".$updated_cart."' WHERE email='".$_SESSION['email']."'";
	 if($conn->query($update_cart_sql)){
		 header("Location:homepage.php");
	 }
	 else{
		$conn->error;
	 } 
}
if(isset($_GET['wish_add'])){
$retrieve_wishlist_sql = "SELECT wishlist FROM accounts WHERE email='".$_SESSION['email']."'" ;
$retrieve_wishlist_que = $conn->query($retrieve_wishlist_sql);
$retrieve_wishlist = $retrieve_wishlist_que->fetch_assoc();
$retrieved_wishlist = explode(",",$retrieve_wishlist['wishlist']);
array_push($retrieved_wishlist,$_GET['wish_add']);
$updated_wishlist = implode(",",$retrieved_wishlist);
$update_wishlist_sql = "UPDATE accounts SET wishlist='".$updated_wishlist."' WHERE email='".$_SESSION['email']."'";
	 if($conn->query($update_wishlist_sql)){
		header("Location:homepage.php");
	 }
	 else{
		$conn->error;
	 } 	
}
if(isset($_GET['order_confirm_msg'])){
	 echo "<div id='order_confirmation_div'>";
	     echo "<h3 id='order_confirmation_heading'>Order Confirmation</h3>";
		 echo "<h3 class='order_confirmation_details'>Your order has been confirmed.</h3>";
	     echo "<a href='#' id='orderlist_a'><h3 class='order_confirmation_details'>See Details</h3></a>";
	 echo "</div>";
}
?>
<html>
<head>
<title>Homepage | ShopSite | Products</title>
<meta charset="utf-8">
<meta name='viewport' content='width=device-width,initial-scale=1.0'>
<script src="jquery-3.3.1/jquery.js"></script>
<link rel="stylesheet" href="shopsite_hm.css">
<style>
#product_disp{
	width:100%;
	margin:10px 0 20px 0;
	overflow:hidden;
	background-color:#FDFEFE;
	border:1px solid #CCD1D1;
	border-radius:2px;
}
#top_heading{
	width:200px;
	margin:10px 0px 5px 3%;
	padding:0px 5px 0px 15px;
	color:#6E2C00;
	font-family:verdana;
}
#top_content{
	width:100%;
	overflow:hidden;
	margin:10px 0 20px 0;
}
.product{
	width:18.9%;
	height:340px;
	margin:10px 6px 10px 8px;
	float:left;
	border:1px solid #B2BABB;
	background-color:#FDFEFE;
	border-radius:2px;
	box-shadow: 0px -1px 3px #7B7D7D;
	box-sizing:border-box;
	position:relative;
}
.product img{
	border:1px solid #CCD1D1;
	margin:5px 20px 5px 25px;
	height:180px;
	width:200px;
}
#cartbtndiv{
	margin:10px 0px 0px 0px;
    background-color:#21618C;
}
.cartbtn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}
#compaccessories_disp{
   width:74%;
   margin:10px 1% 20px 1%;
   padding:0px 0px 0px 0px;
   background-color:#FDFEFE;
   border:1px solid #CCD1D1;
   border-radius:2px;
   overflow:hidden;
   position:relative;
   float:left;
}
#compaccessories_heading{
	width:350px;
	margin:10px 0px 5px 5%;
	padding:0px 0px 0px 15px;
	color:#6E2C00;
	font-family:verdana;
}
#compaccessories_leftbtn{
	width:50px;
	height:50px;
	position:absolute;
	left:10px;
	top:210px;
	z-index:1;
}
#compaccessories_rightbtn{
	width:50px;
	height:50px;
	position:absolute;
	right:0px;
	top:210px;
	z-index:1;
}
#compaccessories_content{
   width:92%;
   height:340px;
   overflow:hidden;
   margin:10px 4% 20px 4%;
   position:relative;
}
#compaccessories_abs{
	width:2700px;
	position:absolute;
	overflow:hidden;
}
.compaccessories_product{
	width:215px;
	height:340px;
	padding:0px 0px 0px 0px;
	margin:0px 5px 0px 5px;
	float:left;
	border:1px solid #B2BABB;
	background-color:#FDFEFE;
	border-radius:2px;
	box-sizing:border-box;
	position:relative;
}
.compaccessories_product img{
	height:180px;
	width:190px;
	border:1px solid #7FB3D5;
	margin:5px 10px 5px 10px;
}
#compaccessories_cartbtndiv{
	margin:12px 0px 0px 0px;
    background-color:#21618C;
}
.compaccessories_cartbtn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}
#side_ad_div_1{
	width:21%;
    margin:10px 1% 20px 1%;
	float:left;
	border:1px solid #CCD1D1;
}
#side_ad_div_1 img{
	width:98%;
	margin:5px 1% 5px 1%;
	height:auto;
}
#special_disp{
   width:98%;
   margin:10px 1% 20px 1%;
   padding:0px 0px 0px 0px;
	background-color:#FDFEFE;
	border:1px solid #CCD1D1;
   border-radius:2px;
   overflow:hidden;
}
#special_heading{
	width:215px;
	margin:10px 0px 5px 3%;
	padding:0px 0px 0px 15px;
	color:#6E2C00;
	font-family:verdana;
}
#special_content{
   width:100%;
   overflow:hidden;
   margin:10px 0 20px 0;
}
.special_product{
	width:18.80%;
	height:340px;
	padding:0px 0px 0px 0px;
	margin:10px 5px 10px 8px;
	float:left;
	border:1px solid #B2BABB;
	background-color:#FDFEFE;
	border-radius:2px;
	position:relative;
}
.special_product img{
	border:1px solid #CCD1D1;
	margin:5px 20px 5px 25px;
	height:180px;
	width:200px;
}
#special_cartbtndiv{
	margin:13px 0px 0px 0px;
    background-color:#21618C;
}
.special_cartbtn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}	
#accessories_disp{
   width:98%;
   margin:10px 1% 20px 1%;
   padding:0px 0px 0px 0px;
   background-color:#FDFEFE;
   border:1px solid #CCD1D1;
   border-radius:2px;
   overflow:hidden;
   position:relative;
}
#accessories_heading{
	width:140px;
	margin:10px 0px 5px 5%;
	padding:0px 0px 0px 15px;
	color:#6E2C00;
	font-family:verdana;
}
#accessories_content{
   width:92%;
   height:340px;
   overflow:hidden;
   margin:10px 4% 20px 4%;
}
.accessories_product{
	width:230px;
	height:340px;
	padding:0px 0px 0px 0px;
	margin:0px 5px 0px 5px;
	float:left;
	border:1px solid #B2BABB;
	background-color:#FDFEFE;
	border-radius:2px;
	box-sizing:border-box;
	position:relative;
}
.accessories_product img{
	height:180px;
	width:190px;
	border:1px solid #7FB3D5;
	margin:5px 10px 5px 10px;
}
#accessories_cartbtndiv{
	margin:13px 0px 0px 0px;
    background-color:#21618C;
}
.accessories_cartbtn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}
#wishlistbtndiv{
	position:absolute;
	top:30px;
	right:0px;
}
.wishlist_btn{
	width:132px;
	margin:0px 0px 0px 0px;
	padding:4px 0px 4px 8px;
	background-color:#1D8348;
	box-sizing:border-box;
	font-family:Palatino Linotype;
}
#wishlist_btn_a{
	text-decoration:none;
	color:black;
}
#cart_btn_a{
	text-decoration:none;
}
#product_name_a{
    text-decoration:none;
}	
.product_name{
	height:70px;
	margin:5px 0px 0px 0px;
	text-align:center;
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.product_price{
	margin:5px 0px 10px 0px;
	text-align:center;
	color:#1B4F72;
	font-family:Palatino Linotype;
}
#order_confirmation_div{
	width:500px;
	height:170px;
	position:absolute;
	top:200px;
	left:35%;
	overflow:hidden;
	box-sizing:border-box;
	background-color:#641E16;
	border:1px solid #515A5A;
	padding:5px;
	z-index:1;
	box-shadow:-1px -1px 5px #D0D3D4;
}
#order_confirmation_heading{
	font-family:verdana;
	margin:0px 0px 30px 0px;
	padding:5px 0px 5px 20px;
	box-sizing:border-box;
	background-color:#F2F4F4;
	border:1px solid  #B3B6B7;
	overflow:hidden;
	font-family:Palatino Linotype;
	box-shadow:-1px -1px 5px #626567;
}
#orderlist_a{
	color:#045679;
	font-weight:200;
}
.order_confirmation_details{
	font-family:verdana;
	margin:10px 0px 5px 0px;
	padding:0px 0px 0px 20px;
	box-sizing:border-box;
	font-weight:300;
}
</style>
<script>
</script>
</head>
<body>
<div id='main'>
<?php include('headertop.php'); ?>
<div id='contentmain'>
     <div id='product_disp'>
	     <h2 id='top_heading'>Top Products </h2>
		 <div id='top_content'>
		 <?php 
		 $topprodsql = "SELECT * FROM reg_prods LIMIT 10";
		 $topprodque = $conn->query($topprodsql) ;
		 if($topprodque = $conn->query($topprodsql)){
		     while($topprods = $topprodque->fetch_assoc()){
			     echo "<div class='product'>" ;
				 $match = 0;
				 for($i=0;$i<count($wishlist);$i++){
					 if(strcasecmp($wishlist[$i],$topprods['productid'])==0){
						 $match += 1;
					 }
				 }
				 if($match == 0){
			         echo "<div id='wishlistbtndiv'>
				             <a href='homepage.php?wish_add=".$topprods['productid']."' id='wishlist_btn_a'><h4 class='wishlist_btn'>Add to Wishlist</h4></a>
					       </div>";
				 }
			         echo "<a href='itemdisp.php?item=".$topprods['productid']."'><img  src='puploads/".$topprods['product_title_image']."'></a>" ;
			         echo "<a id='product_name_a' href='itemdisp.php?item=".$topprods['productid']."'><h4 class='product_name'>".$topprods['productname']."</h4></a>" ;
			         echo "<h5 class='product_price'>".$topprods['productprice']."</h5>" ;
			     echo "<div id='cartbtndiv'>
				             <a id='cart_btn_a' href='homepage.php?cart=".$topprods['productid']."'><h4 class='cartbtn'>Add To Cart</h4></a>
					   </div>" ;
			     echo "</div>" ;
		     }
		 }
		 else{
			 echo $conn->error ;
		 }	
		?>
		</div>
	 </div>
</div>
<div id='compaccessories_disp'>
	 <h2 id='compaccessories_heading'>Computers & Accessories</h2>
	 <div id='compaccessories_leftbtn'><img src='images/shopsite_leftbtn.png' style='height:40px;width:40px;'></div>
	 <div id='compaccessories_content'>
		 <div id='compaccessories_abs'>
		 <?php
		 $compaccessoriesprodsql = "SELECT * FROM reg_prods WHERE productcategory='Computers & Accessories' LIMIT 12";
         if($conn->query($compaccessoriesprodsql)== true){
             $compaccessoriesprodque = $conn->query($compaccessoriesprodsql);
			 while($compdata = $compaccessoriesprodque->fetch_assoc()){
				 echo "<div class='compaccessories_product'>" ;
				 $match = 0;
				 for($i=0;$i<count($wishlist);$i++){
					 if(strcasecmp($wishlist[$i],$compdata['productid'])==0){
						 $match += 1;
					 }
				 }
				 if($match == 0){
			         echo "<div id='wishlistbtndiv'>
				             <a href='homepage.php?wish_add=".$compdata['productid']."' id='wishlist_btn_a'><h4 class='wishlist_btn'>Add to Wishlist</h4></a>
					       </div>";
				 }
                     echo "<a href='itemdisp.php?item=".$compdata['productid']."'><img src='puploads/".$compdata['product_title_image']."'></a>" ;
			         echo "<a id='product_name_a' href='itemdisp.php?item=".$compdata['productid']."'><h4 class='product_name'>".$compdata['productname']."</h4></a>" ;
			         echo "<h5 class='product_price'>".$compdata['productprice']."</h5>" ;
					 echo "<div id='compaccessories_cartbtndiv'>
					         <a id='cart_btn_a' href='homepage.php?cart=".$compdata['productid']."'><h4 class='compaccessories_cartbtn'>Add To Cart</h4></a>
						   </div>" ;
			     echo "</div>" ;					 
			 }
		 }
         else{
			 echo $conn->error ;
		 }			   
		 ?>
		 </div>
	 </div>
	 <div id='compaccessories_rightbtn'><img src='images/shopsite_rightbtn.png' style='height:40px;width:40px;'></div>
</div>
<div id='side_ad_div_1'>
    <img src='images/hzone_washing_machine.jpg' alt=''>
</div>
<div id='special_disp'>
	 <h2 id='special_heading'>Special Offers</h2>
	 <div id='special_content'>
	 <?php
	 $specprodsql = "SELECT * FROM reg_prods LIMIT 10 OFFSET 10";
     if($conn->query($specprodsql)== true){
         $specprodque = $conn->query($specprodsql);
		 while($qdata = $specprodque->fetch_assoc()){
			 echo "<div class='special_product'>" ;
				 $match = 0;
				 for($i=0;$i<count($wishlist);$i++){
					 if(strcasecmp($wishlist[$i],$qdata['productid'])==0){
						 $match += 1;
					 }
				 }
				 if($match == 0){
			         echo "<div id='wishlistbtndiv'>
				             <a href='homepage.php?wish_add=".$qdata['productid']."' id='wishlist_btn_a'><h4 class='wishlist_btn'>Add to Wishlist</h4></a>
					       </div>";
				 }
                 echo "<a href='itemdisp.php?item=".$qdata['productid']."'><img src='puploads/".$qdata['product_title_image']."'></a>" ;
			     echo "<a id='product_name_a' href='itemdisp.php?item=".$qdata['productid']."'><h4 class='product_name'>".$qdata['productname']."</h4></a>" ;
			     echo "<h5 class='product_price'>".$qdata['productprice']."</h5>" ;
				 echo "<div id='special_cartbtndiv'>
				         <a id='cart_btn_a' href='homepage.php?cart=".$qdata['productid']."'><h4 class='special_cartbtn'>Add To Cart</h4></a>
					   </div>" ;
			 echo "</div>" ;					 
		 }
	 }
     else{
	     echo $conn->error ;
	 }			   
	 ?>
	 </div>
</div>
<div id='accessories_disp'>
	 <h2 id='accessories_heading'>Accessories</h2>
	 <div id='accessories_content'>
		 <?php
		 $accessoriesprodsql = "SELECT * FROM reg_prods WHERE productcategory='Accessories' LIMIT 5";
         if($conn->query($accessoriesprodsql)== true){
         $accessoriesprodque = $conn->query($accessoriesprodsql);
		 while($ascdata = $accessoriesprodque->fetch_assoc()){
			 echo "<div class='accessories_product'>" ;
				 $match = 0;
				 for($i=0;$i<count($wishlist);$i++){
					 if(strcasecmp($wishlist[$i],$ascdata['productid'])==0){
						 $match += 1;
					 }
				 }
				 if($match == 0){
			         echo "<div id='wishlistbtndiv'>
				             <a href='homepage.php?wish_add=".$ascdata['productid']."' id='wishlist_btn_a'><h4 class='wishlist_btn'>Add to Wishlist</h4></a>
					       </div>";
				 }
                 echo "<a href='itemdisp.php?item=".$ascdata['productid']."'><img src='puploads/".$ascdata['product_title_image']."'></a>" ;
			     echo "<a id='product_name_a' href='itemdisp.php?item=".$ascdata['productid']."'><h4 class='product_name'>".$ascdata['productname']."</h4></a>" ;
			     echo "<h5 class='product_price'>".$ascdata['productprice']."</h5>" ;
			     echo "<div id='accessories_cartbtndiv'>
				         <a id='cart_btn_a' href='homepage.php?cart=".$ascdata['productid']."'><h4 class='accessories_cartbtn'>Add To Cart</h4></a>
					   </div>" ;
			 echo "</div>" ;					 
		 }
		 }
         else{
			 echo $conn->error ;
		 }			   
	     ?>
	 </div>
</div>
<script>
$(document).ready(function(){
	 var x = 1;
	 var y = 3;
     $("#compaccessories_rightbtn").click(function(){
	     if(x < 3){
		     $("#compaccessories_abs").animate({left: "-=900"},1000);  
             x++;
             y--;				 
         }	
	 });
	 $("#compaccessories_leftbtn").click(function(){
		 if(y < 3){
		     $("#compaccessories_abs").animate({left: "+=900px"},1000);
			 y++;
			 x--;
		 }
     });
});	
</script>
<?php include('footer.php'); ?>
</div>
</body>
</html>