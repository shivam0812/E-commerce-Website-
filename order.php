<?php
include('connect.php');
session_start();
//unset($_SESSION['fulladdress']);
$_SESSION['shop'] = $_GET['shop'];
if(isset($_SESSION['shop'])){
	$userdetailsql = "SELECT * FROM accounts WHERE email='".$_SESSION['email']."'";
	$userdetailque = $conn->query($userdetailsql);
	$userdetail = $userdetailque->fetch_assoc();
	$reg_email = $userdetail['email'];
	$reg_name = $userdetail['name'];
	$orderdetailsql = "SELECT * FROM reg_prods WHERE productid='".$_SESSION['shop']."'";
	$orderdetailque = $conn->query($orderdetailsql);
	$orderitem = $orderdetailque->fetch_assoc();
	$product_id = $orderitem['productid'];
	$product_name = $orderitem['productname'];
	$product_price = $orderitem['productprice'];
    $checksql = "SELECT * FROM order_list WHERE reg_email='".$reg_email."' and product_id='".$product_id."'";
    $checkque =	$conn->query($checksql);
	$check = $checkque->fetch_assoc();
	if($checkque->num_rows > 0){
        $placeordersql = "UPDATE order_list SET reg_email='$reg_email',reg_name='$reg_name',
                          product_id='$product_id',product_name='$product_name',product_price='$product_price',						  
						  WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";			
	}
	else{
	    $placeordersql = "INSERT INTO order_list(reg_email,reg_name,product_id,product_name,product_price,quantity)
	                      VALUES('$reg_email','$reg_name','$product_id','$product_name','$product_price','1')";
		if($conn->query($placeordersql) == true){
			header("Location:order.php?shop=".$_SESSION['shop']);
		}
		else{
		    $conn->error;
		}
	}
}
if(isset($_POST['fulladdress'])){
        $pin = $_POST['pin'];
        $address = $_POST['address'];
        $landmark = $_POST['landmark'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $mobnum = $_POST['mobnum'];		
        $_SESSION['fulladdress'] = compact("address","city","state","pin","landmark","mobnum"); 
        $fa_arr = implode(",",$_SESSION['fulladdress']);
        $updatedeliverysql = "UPDATE order_list SET deliveryaddress='".$fa_arr."',mobile_num='".$mobnum."'
                              WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";	
        if($conn->query($updatedeliverysql) == true){
			header("Location:order.php?shop=".$_SESSION['shop']);
		}
		else{
		    $conn->error;
		}						  
}
if(isset($_GET['plus'])){
	    $quantitysql = "SELECT quantity FROM order_list WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
	    $quantityque = $conn->query($quantitysql);
	    $quantity = $quantityque->fetch_assoc();
	    $quantity = $quantity['quantity'];
	    $quantity = (int) $quantity ;
	    $quantity += 1 ; 
        $updatequantitysql = "UPDATE order_list SET quantity='".$quantity."' WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
		if($conn->query($updatequantitysql) == true){
			header("Location:order.php?shop=".$_SESSION['shop']);
		}
		else{
		    $conn->error;
		}
}
if(isset($_GET['minus'])){
	        $quantitysql = "SELECT quantity FROM order_list WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
	        $quantityque = $conn->query($quantitysql);
	        $quantity = $quantityque->fetch_assoc();
	        $quantity = $quantity['quantity'];
	        $quantity = (int) $quantity ;
			if($quantity > 1){
	            $quantity -= 1 ; 
                $updatequantitysql = "UPDATE order_list SET quantity='".$quantity."' 
			                         WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
			    if($conn->query($updatequantitysql) == true){
			       header("Location:order.php?shop=".$_SESSION['shop']);
		        }
		        else{
			       $conn->error;
		        }
	        }
}
if(isset($_GET['pay'])){
	 echo "<div id='paymentdiv'>";
     echo "<div id='payment_modes_div'>";
         echo "<h3 id='mode_cr'>Credit Card</h3>";
         echo "<h3 id='mode_db'>Debit Card</h3>";
         echo "<h3 id='mode_nb'>Net Banking</h3>";
         echo "<h3 id='mode_cod'>Cash on Delivery</h3>";
     echo "</div>";  		   
     echo "<div id='paydiv'>";
	     echo "<form action='' enctype='application/x-www-urlencoded' method='post'>";
             echo "<h3 id='cardnumhed'>Card No.</h3>";
             echo "<input id='cardnuminp' type='text' name='dbnum'>";
             echo "<h3 id='exphed'>Expiry</h3>";
             echo "<select>";
             echo "<option>01</option>"; echo "<option>02</option>"; echo "<option>03</option>"; echo "<option>04</option>"; echo "<option>05</option>"; 
			 echo "<option>06</option>"; echo "<option>07</option>"; echo "<option>08</option>"; echo "<option>09</option>"; echo "<option>10</option>";
			 echo "<option>11</option>"; echo "<option>12</option>";
		     echo "</select>";
		     echo "<select>";
             echo "<option>18</option>"; echo "<option>19</option>"; echo "<option>20</option>"; echo "<option>21</option>"; echo "<option>22</option>"; 
			 echo "<option>23</option>"; echo "<option>24</option>"; echo "<option>25</option>"; echo "<option>26</option>"; echo "<option>27</option>";
			 echo "<option>28</option>"; echo "<option>29</option>";
		     echo "</select>";
		     echo "<h3 id='cvvhed'>CVV</h3>";
		     echo "<input type='text' name='cvv' id='cvvin'>";
		     echo "<input id='paybtn' type='submit' name='pay_submit' value='Pay'>";
		 echo "</form>";
	 echo "</div>";
     echo "</div>";	 
}
if(isset($_POST['pay_submit'])){
	$getordersql = "SELECT * FROM order_list WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
	$getorderque = $conn->query($getordersql) ;
	$getorder = $getorderque->fetch_assoc();
	$getamount = $getorder['product_price'];
	$getquantity = $getorder['quantity'];
	$getamount = ltrim($getorder['product_price'],"Rs.");
	$getamount = (int)$getamount;
	$getquantity = (int)$getquantity;
	$total_amount = (($getamount * $getquantity) + (89 * $getquantity));
	$updateamountsql = "UPDATE order_list SET total_amount='".$total_amount."'
                        WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
						if($conn->query($updateamountsql)==true){
							unset($_SESSION['fulladdress']);
							unset($_SESSION['shop']);
                            header("Location:homepage.php?order_confirm_msg");
						}
						else{
							$conn->error;
						}
}
?>

<html>
<head>
<title>Homepage | ShopSite | Products</title>
<meta charset="utf-8">
<script src="jquery-3.3.1/jquery.js"></script>
<link rel="stylesheet" href="shopsite_hm.css">
<style>
#orderdiv{
	width:100%;
	min-height:400px;
	overflow:hidden;
	border:1px solid #EAEDED;
	margin:10px 0px 8px 0px;
}
#itemshed{
	width:28%;
	float:left;
	margin:0px 1px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
#quanthed{
	width:10%;
	float:left;
	margin:0px 1px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
#addresshed{
	width:25%;
	float:left;
	margin:0px 1px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
#deliveryhed{
	width:25%;
	float:left;
	margin:0px 1px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
#amnthed{
	width:11.70%;
	float:left;
	margin:0px 0px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
.orderdivinr{
	width:100%;
	overflow:hidden;
	margin:5px 0px 0px 0px;
}
#itemdiv{
    width:28%;
	float:left;
	overflow:hidden;
	border:1px solid #EAEDED;
	background-color:#FBFCFC;
	box-sizing:border-box;
}
#itemdiv img{
	height:150px;
	width:150px;
	margin:5px 5px 10px 15px;
    border:1px solid #CCD1D1;	
}
#itemdetailsdiv h4{
	margin:5px 5px 5px 5px;
	padding:0px 5px 0px 10px;
	box-sizing:border-box;
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.itemdetailsdiv h4{
	margin:5px 5px 5px 5px;
	padding:0px 5px 0px 10px;
	box-sizing:border-box;
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.itemdetailsdiv h5{
	margin:5px 5px 5px 5px;
	padding:0px 5px 0px 10px;
	box-sizing:border-box;
	color:#1B4F72;
	font-family:Palatino Linotype;
}
#quantdiv{
    width:10%;
	float:left;
	overflow:hidden;
}
#quantdiv img{
	margin:5px 3px 5px 3px;
	height:35px;
	width:35px;
	float:left;
}
#quantdiv h2{
	width:50px;
	margin:5px 0px 5px 0px;
	padding:5px 5px 5px 5px;
	float:left;
}
#addressdiv{
    width:25%;
	float:left;
	overflow:hidden;
	padding:5px 0px 5px 0px ;
	box-sizing:border-box;
}
#addressdiv h5{
	margin:5px 0px 0px 0px;
	padding:0px 5px 0px 15px;
	font-family:verdana;
	font-weight:400;
	box-sing:border-box;
}
.addressformhed{
	margin:5px 0px 5px 0px;
	padding:0px 5px 0px 10px;
	box-sizing:border-box;
	font-weight:400;
	font-family:Palatino Linotype;
}
#pininp{
	width:35%;
	height:25px;
	margin:0px 0px 0px 5px;
}
.addressforminp{
	width:75%;
	height:30px;
	margin:0px 0px 0px 5px;
}
#addressdiv select{
	margin:3px 0px 3px 10px;
}
#mobnuminp{
	width:50%;
	height:25px;
	margin:0px 0px 0px 5px;	
}
#addsbmitbtn{
	width:80px;
	height:35px;
	margin:0px 30px 0px 20px;
	border-radius:1px;
	font-size:22px;
	color:black;
	font-family:Palatino Linotype;
	background-color:#7F8C8D;
}
#deliverydiv{
    width:25%;
	float:left;
	padding:10px 0px 5px 0px;
	box-sizing:border-box;
	overflow:hidden;
}
#deliverydiv h3{
	margin:5px 0px 8px 0px;
	padding:0px 0px 0px 15px;
	color:#616A6B;
	box-sizing:border-box;
}
#deliverydiv h5{
	margin:5px 0px 5px 0px;
	padding:0px 0px 0px 15px;
	color:#616A6B;
	box-sizing:border-box;
}
#amntdiv{
    width:12%;
	float:left;
	padding:10px 0px 5px 0px;
	overflow:hidden;
	box-sizing:border-box;
}
#amntdiv h3{
	margin:5px 0px 5px 0px;
	padding:0px 0px 0px 15px;
	color:#616A6B;
	box-sizing:border-box;
}
#pay_btn{
	width:180px;
	float:right;
	color:#17202A ;
	margin:20px 10px 10px 20px;
	padding:5px 5px 5px 15px;
	font-family:Palatino Linotype;
	background-color:#7F8C8D;
	border:1px solid #D0D3D4;
	box-sizing:border-box;
	box-shadow:0px 1px 5px #B2BABB;
}
#paymentdiv{
	width:530px;
	position:absolute;
	margin:150px 30% 0px 30%;
	padding:5px 5px 5px 5px;
	background-color:#641E16;
    border:1px solid #221818;
	box-sizing:border-box;
	box-shadow:1px 1px 3px #B2BABB;
	overflow:hidden;
}
#mode_cr{
	width:23%;
	float:left;
	margin:5px 0px 10px 1px;
	padding:5px 0px 5px 5px; 
	border:1px solid #3E0B0B;
	box-sizing:border-box;
	font-family:Palatino Linotype;
	box-shadow:-1px -1px 3px #424949;
}
#mode_db{
	width:23%;
	float:left;
	margin:5px 0px 10px 1px;
	padding:5px 0px 5px 10px;
	border:1px solid #3E0B0B;
	box-sizing:border-box;
	font-family:Palatino Linotype;
	box-shadow:-1px -1px 3px #424949;
}
#mode_nb{
	width:23%;
	float:left;
	margin:5px 0px 10px 1px;
	padding:5px 0px 5px 5px;
	border:1px solid #3E0B0B;
	box-sizing:border-box;
	font-family:Palatino Linotype;
	box-shadow:-1px -1px 3px #424949;
}
#mode_cod{
	width:30%;
	float:left;
	margin:5px 0px 10px 1px;
	padding:5px 0px 5px 3px;
	box-sizing:border-box;
	border:1px solid #3E0B0B;
	font-family:Palatino Linotype;
	box-shadow:-1px -1px 3px #424949;
}
#paydiv{
	margin:5px 0px 0px 0px;
	padding:25px 5px 25px 10px;
	box-sizing:border-box;
	border:1px solid #3E0B0B;
	box-shadow:0px 1px 5px #7B7D7D;
	overflow:hidden;
}
#cardnumhed{
	width:100px;
	float:left;
	margin:10px 10px 10px 10px;
}
#cardnuminp{
	width:250px;
	float:left;
	margin:10px 100px 10px 10px; 
}
#exphed{
	width:110px;
	float:left;
	margin:10px 10px 10px 10px;
}
#cvvhed{
	width:70px;
	float:left;
	margin:10px 10px 10px 20px;	
}
#paydiv select{
	margin:10px 10px 10px 0px;
	float:left;
}
#cvvin{
	margin:10px 10px 10px 0px;
	float:left;
	width:50px;
}
#paybtn{
	margin:8px 10px 10px 20px;
	border:1px solid black;
	border-radius:3px;
	font-weight:bold;
	padding:5px 10px 5px 10px;
	background-color:orange;
}
</style>
</head>
<body>
<div id="main">
<?php include('headertop.php'); ?>
<div id="contentmain">
     <div id="orderdiv">
         <h3 id="itemshed">Items</h3>
	     <h3 id="quanthed">Quantity</h3>
		 <h3 id="addresshed">Delivery Address</h3>
	     <h3 id="deliveryhed">Delivery Details</h3>
	     <h3 id="amnthed">Total</h3>
         <div class='orderdivinr'>
			 <div id='itemdiv'>
				 <img src='puploads/<?php echo $orderitem['product_title_image'];?>'>
				 <div class='itemdetailsdiv'>
					 <h4><?php echo $orderitem['productname'];?></h4>
			         <h5><?php echo $orderitem['productprice'];?></h5>
				 </div>
			 </div>
			 <div id='quantdiv'>
			 <?php
			 $quantitysql = "SELECT quantity FROM order_list WHERE reg_email='".$_SESSION['email']."' and product_id='".$_SESSION['shop']."'";
	         $quantityque = $conn->query($quantitysql);
	         $quantitydisp = $quantityque->fetch_assoc();
			 ?>
				 <a href='order.php?minus=1&shop=<?php echo $_SESSION['shop'];?>'><img src='images/cartminusicon.png'></a>
				 <h2><?php echo $quantitydisp['quantity'] ;?></h2>
				 <a href='order.php?plus=1&shop=<?php echo $_SESSION['shop'];?>'><img src='images/cartplusicon.png'></a>
			 </div>
			 <div id='addressdiv'>
			 <?php
			   if(isset($_SESSION['fulladdress'])){
				   echo "<h5>".$_SESSION['fulladdress']['address']."</h5>";
				   echo "<h5>".$_SESSION['fulladdress']['city'].",".$_SESSION['fulladdress']['state']."</h5>";
				   echo "<h5>".$_SESSION['fulladdress']['pin']."</h5>";
				   echo "<h5>".$_SESSION['fulladdress']['landmark']."</h5>";
				   echo "<h5>".$_SESSION['fulladdress']['mobnum']."</h5>";
			   }
			   else{
			    echo "<form action='' enctype='application/x-www-urlencoded' method='post'>";
				echo "<h4 class='addressformhed'>Pincode</h4>";
			    echo "<input  type='text' name='pin' id='pininp'>";
			    echo "<h4 class='addressformhed'>Address</h4>";
				echo "<input class='addressforminp' type='text' name='address' >";
				echo "<h4 class='addressformhed'>Landmark</h4>";
				echo "<input class='addressforminp' type='text' name='landmark' >";
				echo "<h4 class='addressformhed'>City</h4>";
				echo "<select name='city'>";
					echo "<option>Agra</option>"; echo "<option>Agartala</option>"; echo "<option>Ahmedabad</option>"; echo "<option>Aligarh</option>"; echo "<option>Chennai</option>"; 
					echo "<option>Dhanbad</option>"; echo "<option>Farrukhabad</option>"; echo "<option>Firozabad</option>"; echo "<option>Ghaziabad</option>"; echo "<option>Gwalior</option>";
					echo "<option>Guwahati</option>"; echo "<option>Hyderabad</option>"; echo "<option>Haldia</option>"; echo "<option>Indore</option>"; echo "<option>Jabalpur</option>"; 
					echo "<option>Jodhpur</option>"; echo "<option>Kolkata</option>"; echo "<option>Kota</option>"; echo "<option>Lucknow</option>"; echo "<option>Ludhiana</option>";
				echo "</select>";
				echo "<h4 class='addressformhed'>State</h4>";
				echo "<select name='state'>";
                    echo "<option>Andhra Pradesh</option>"; echo "<option>Arunachal Pradesh</option>"; echo "<option>Bihar</option>"; echo "<option>Chattisgarh</option>"; echo "<option>Delhi</option>"; 
					echo "<option>Goa</option>"; echo "<option>Himachal Pradesh</option>"; echo "<option>Haryana</option>"; echo "<option>Jammu & Kashmir</option>"; echo "<option>Karnataka</option>";
				echo "</select>";
					echo "<h4 class='addressformhed'>Mobile Number</h4>";
					echo "<input type='text' name='mobnum' id='mobnuminp'>";
					echo "<input id='addsbmitbtn' type='submit' name='fulladdress' value='Save'>";
				echo "</form>";
			   }
			 ?>    
			 </div>
			 <div id='deliverydiv'>
			     <h3>Minimum Delivery Charges Rs. 89</h3>
				 <h3>Additional Delivery Charges Rs. 0</h3>
				 <h5>10 Days Replacement Policy</h5>
			 </div>
		     <div id='amntdiv'>
			     <?php
				   $price = ltrim($orderitem['productprice'],"Rs.");
			       $numprice = (int)$price ;
				   $numquantity = (int)$quantitydisp['quantity'] ;
			       $total_amount = (($numprice * $numquantity) + (89 * $numquantity)) ;
				 ?>
			     <h3>Rs. <?php echo $total_amount ;?></h3>
			 </div>
	     </div>
		 <?php
		 if(isset($_SESSION['fulladdress'])){
		     echo "<div id='shopoptionsdiv'>";
                 echo "<a href='order.php?pay&shop=".$orderitem['productid']."'><h2 id='pay_btn'>Pay Rs. ".$total_amount."</h2></a>";
             echo "</div>";
		 }
		 ?>
     </div>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>