<?php
include('connect.php');
session_start();
error_reporting(0);
if(isset($_GET['remove'],$_GET['quant'])){
	$quantity = (int)$_GET['quant'];
	$removesql = "SELECT shoppingcart FROM accounts WHERE email='".$_SESSION['email']."'";
	$removeque = $conn->query($removesql);
	$remove = $removeque->fetch_assoc();
	$removearr = explode(",",$remove['shoppingcart']);
    for($i=1;$i<=$quantity;$i++){
	    $removesearch = array_search($_GET['remove'],$removearr);
	    $numremove = (int)$removesearch ;
		array_splice($removearr,$numremove,1);
	}
	$removecart = implode(",",$removearr);
	$updatecartsql = "UPDATE accounts SET shoppingcart='$removecart' WHERE email='".$_SESSION['email']."'";
	if($conn->query($updatecartsql)){
		header("Location:cart.php");
	}
	else{
        echo $conn->error;		
	}
}
if(isset($_GET['minus'])){
	$numminus = (int)$_GET['minus'];
	$minussql = "SELECT shoppingcart FROM accounts WHERE email='".$_SESSION['email']."'";
	$minusque = $conn->query($minussql);
	$minus = $minusque->fetch_assoc();
	$minusarr = explode(",",$minus['shoppingcart']);
	array_splice($minusarr,$numminus,1);
	$minuscart = implode(",",$minusarr);
	$updatecartsql = "UPDATE accounts SET shoppingcart='$minuscart' WHERE email='".$_SESSION['email']."'";
	if($conn->query($updatecartsql)){
		header("Location:cart.php");
	}
	else{
        echo $conn->error;		
	}
}
if(isset($_GET['plus'])){
    $plussql = "SELECT shoppingcart FROM accounts WHERE email='".$_SESSION['email']."'" ;
    $plusque = $conn->query($plussql);
    $plus = $plusque->fetch_assoc();
    $plusarr = explode(",",$plus['shoppingcart']);
    array_push($plusarr,$_GET['plus']);
    $pluscart = implode(",",$plusarr);
    $updatecartsql = "UPDATE accounts SET shoppingcart='$pluscart' WHERE email='".$_SESSION['email']."'";
	if($conn->query($updatecartsql)){
		header("Location:cart.php");
	}
	else{
        echo $conn->error;		
	}
}
$shoppingcartsql = "SELECT shoppingcart FROM accounts WHERE email='".$_SESSION['email']."'" ;
$shoppingcartque = $conn->query($shoppingcartsql);
$shoppingcartitems = $shoppingcartque->fetch_assoc();
$cartitems = explode(",",$shoppingcartitems['shoppingcart']);
$cartitemsquantity = array_count_values($cartitems);
$cartitem = array_unique($cartitems);
//print_r();
?>

<html>
<head>
<title>Shopping Cart | ShopSite</title>
<meta charset="utf-8">
<script src="jquery-3.3.1/jquery.js"></script>
<link rel="stylesheet" href="shopsite_hm.css">
<style>
#cartdiv{
    width:74%;
    float:left;
	margin:1px 0px 2px 0px;
	padding:5px 0px 5px 2px;
	border:1px solid #AEB6BF;	
}
#itemshed{
	width:58%;
	float:left;
	margin:0px 1px 5px 0px;
	padding:5px 0px 5px 15px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	font-family:Gadget;
	color:#424949;
}
#deliveryhed{
	width:27%;
	float:left;
	margin:0px 1px 0px 0px;
	padding:5px 0px 5px 10px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;	
	color:#424949;
}
#amnthed{
	width:9%;
	float:left;
	margin:0px 1px 0px 0px;
	padding:5px 0px 5px 10px;
	border:1px solid #EAECEE;
	background-color:#F8F9F9;	
	color:#424949;
}
.cartdivinr{
	width:100%;
	overflow:hidden;
	margin:5px 0px 5px 0px;
}
.itemdiv{
	width:59.60%;
	float:left;
	overflow:hidden;
	border:1px solid #EAEDED;
	background-color:#FBFCFC;
	box-sizing:border-box;
}
.itemdiv img{
	float:left;
	margin:5px 10px 5px 5px;
	border:1px solid #D6EAF8;
}
.itemdetailsdiv{
	width:42.50%;
	float:left;
	overflow:hidden;
	box-sizing:border-box;
}
.itemdetailsdiv h2{
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.itemdetailsdiv h4{
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.itemdetailsdiv h5{
	color:#1B4F72;
	font-family:Palatino Linotype;
}
.quantdiv{
	width:26%;
	float:left;
	overflow:hidden;
	margin:10px 0px 0px 0px;
	padding:5px 0px 5px 10px;
	box-sizing:border-box;
}
.quantdiv a{
	float:left;
}
.quantdiv h2{
	float:left;
	width:23px;
	padding:8px 0px 0px 10px;
	margin:0px 0px 0px 0px;
	color:#616A6B;
}
.deliverydiv{
	width:27%;
	float:left;
	overflow:hidden;
	margin:10px 0px 0px 12px;
}
.deliverydiv h3{
	color:#616A6B;
}
.deliverydiv h5{
	color:#616A6B;
}
.amntdiv{
	width:9%;
	float:left;
	overflow:hidden;
	margin:20px 0px 0px 5px;
}
.amntdiv h3{
	text-align:center;
	color:#616A6B;
}
#transactdiv{
    width:25%;
    float:left;
    margin:50px 0px 0px 5px;
	border:1px solid #AEB6BF;
	background-color:#FBFCFC;	
}
#transactdiv h1{
	border:1px solid #EAECEE;
	background-color:#F8F9F9;
	width:180px;
	margin:5px 0px 10px 5px;
	padding:0px 0px 0px 5px;
	box-sizing:border-box;
	color:#424949;
}
#cartdetailsheds{
	width:75%;
	float:left;
}
#cartdetailsheds h4{
	margin:20px 0px 10px 5px;
	color:#616A6B;
}
#cartdetailsbill{
	width:20%;
	float:left;
}
#cartdetailsbill h4{
	margin:20px 0px 10px 5px;
	color:#616A6B;	
}
#topay{
	margin:25px 0px 10px 0px;
	color:#616A6B;
}
</style>
</head>
<body>
<div id='main'>
<?php include('headertop.php') ;?>
<div id="contentmain">
   <div id="cartdiv">
       <h3 id="itemshed">Items</h3>
	   <h3 id="deliveryhed">Delivery Details</h3>
	   <h3 id="amnthed">Total</h3>
       <?php
	     if(isset($_SESSION['email'])){
			 $itemssql = "SELECT * FROM reg_prods ";
			 $itemsque = $conn->query($itemssql);
             while($items = $itemsque->fetch_assoc()){			 
			     for($i=0;$i<count($cartitems);$i++){
				    if($cartitem[$i] == $items['productid']){
					   $totalitems += 1;
					   $totalquant += $cartitemsquantity[$cartitem[$i]];
					   echo "<div class='cartdivinr'>";
					      echo "<div class='itemdiv'>";
						     echo "<img src='puploads/".$items['product_title_image']."' style='height:180px;width:165px;'>";
						     echo "<div class='itemdetailsdiv'>";
						        echo "<a href=\"itemdisp.php?item=".$items['productid']."\"><h4>".$items['productname']."</h4></a>" ;
			                    echo "<h5>".$items['productprice']."</h5>" ;
						        echo "<a href='cart.php?remove=".$items['productid']."&quant=".$cartitemsquantity[$cartitem[$i]]."'><h2>Remove</h2></a>";
						     echo "</div>";
							 echo "<div class='quantdiv'>";
						         echo "<a href='cart.php?minus=".$i."'><img src='images/cartminusicon.png' style='height:35px;width:35px;' ></a>";
					             echo "<h2>".$cartitemsquantity[$cartitem[$i]]."</h2>";
							     echo "<a href='cart.php?plus=".$items['productid']."'><img src='images/cartplusicon.png' style='height:35px;width:35px;' ></a>";
					         echo "</div>";
					      echo "</div>";
					      echo "<div class='deliverydiv'>";
					         echo "<h3>Delivery Charges Rs. 89</h2>";
							 echo "<h5>10 Days Replacement Policy</h5>";
					      echo "</div>";
					         echo "<div class='amntdiv'>";
							 $price = ltrim($items['productprice'],"Rs.");
							 $numprice = (int)$price ;
							 $into = (int)$cartitemsquantity[$cartitem[$i]] ;
							 $totalprice = (($numprice * $into) + (89 * $into)) ;
					         echo "<h3>Rs. ".$totalprice."</h2>";
					      echo "</div>";
					   echo "</div>";
					   $totalpricepayable += $totalprice;
					}
			    }
			 
		    }
		}
	   ?>
   </div>
   <div id="transactdiv">
       <h1>Cart Details</h1>
       <?php
	      echo "<div id='cartdetailsheds'>";
	         echo "<h4>No. of Items</h4>";
		     echo "<h4>Total Delivery Charges</h4>";
			 echo "<hr align='center' width='95%'>";
		     echo "<h4 id='topay'>Total Amount Payable</h4>";
		  echo "</div>";
	      echo "<div id='cartdetailsbill'>";
		     echo "<h4>".$totalitems."</h4>";
			 $tdc = ($totalquant * 89);
			 echo "<h4>".$tdc."</h4>";
			 echo "<hr align='center' width='90%'>";
			 echo "<h4 id='topay'>".$totalpricepayable."</h4>";
		  echo "</div>";
	   ?>
   </div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>