<?php
include('connect.php');
session_start();
$itemdispsql = "SELECT * FROM reg_prods WHERE productid='".$_GET['item']."'";
$itemdispque = $conn->query($itemdispsql);
$item = $itemdispque->fetch_assoc();
$productimages = explode(",",$item['productimages']);
$productspecs = explode(",",$item['productspecs']);
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
$similiar_sql = "SELECT * FROM reg_prods WHERE product='".$item['product']."'";
$similiar_que = $conn->query($similiar_sql);
$similiar_items = $similiar_que->fetch_assoc();
?>
<html>
<head>
<title>Homepage | ShopSite | Products</title>
<meta charset="utf-8">
<script src="jquery-3.3.1/jquery.js"></script>
<link rel='stylesheet' href='shopsite_hm.css'>
<style>
#itemdiv{
	width:64%;
	border:1px solid #CCD1D1;
	margin:1px 5px 1px 0px;
	float:left;
}
#imagesdiv{
	width:90px;
	float:left;
	margin:5px 10px 5px 10px;
}
#imagesdiv img{
	height:75px;
	width:75px;
	margin:5px 5px 5px 10px;
	border:1px solid #1B2631;
	box-shadow:-1px -1px 5px #7B7D7D;
}
#imagediv{
	width:65%;
	float:left;
	border:1px solid #CCD1D1;
	margin:5px 5px 5px 5px;
}
#titleimg{
	height:420px;
	width:420px;
	margin:5px 10px 5px 10px;
	border:1px solid #717D7E;
	float:left;
}
#buy_addcartdiv{
	width:24%;
	float:left;
	padding:0px 0px 0px 0px;
	margin:300px 10px 0px 40px;
}
#cart_btn_a{
	text-decoration:none
}
#cartbtn{
	width:180px;
    margin:0px 0px 0px 0px;
	padding:7px 4px 5px 8px;
	border-radius:2px;
	border:1px solid black;
	background-color:#21618C;
	color:black;
	font-family:Palatino Linotype;
}
#shop_btn_a{
	text-decoration:none
}
#shopbtn{
	width:168px;
	margin:20px 0px 10px 0px;
	padding:7px 0px 5px 25px;
	border-radius:2px;
	border:1px solid black;
	background-color:orange;
	color:#6E2C00;
	font-family:Palatino Linotype;
}
#itemdescriptiondiv{
	width:100%;
	overflow:hidden;
	margin:10px 0px 10px 0px;
}
.itemdetails_heds{
	margin:0px 1px 5px 1px;
	padding:5px 0px 5px 15px;
	border:1px solid #D0D3D4;
	background-color: #F8F9F9;
	font-family:Gadget;
	color:#424949;
	box-sizing:border-box;
}
.itemdetails{
	color:#1B4F72;
	font-family:verdana;
	font-weight:500;
	margin:10px 10px 5px 20px;
}
#similiar_item_div{
	width:34%;
	border:1px solid #CCD1D1;
	margin:1px 0px 1px 5px;
    padding:5px 5px 5px 5px;
	float:left;
}
#similiar_heading{
	width:100%;
	padding:0px 0px 5px 10px;
}
.similiar_product{
	width:49%;
	height:320px;
	float:left;
	margin:2px 1px 2px 1px;
	border:1px solid #CCD1D1;
	overflow:hidden;
}
.similiar_product img{
	width:190px;
	height:170px;
	margin:5px 14px 5px 14px;
	border:1px solid #CCD1D1;
}
.similiar_product_name{
	margin:10px 0px 5px 0px;
	height:50px;
	text-align:center;
	color:#1B4F72;
	font-family:Palatino Linotype;	
}
.similiar_product_price{
	margin:5px 0px 5px 0px;
	text-align:center;
	color:#1B4F72;
	font-family:Palatino Linotype;	
}
#similiar_cartbtndiv{
	margin:23px 0px 0px 0px;
    background-color:#21618C;
}
.similiar_cartbtn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}
</style>
</head>
<body>
<div id="main">
<?php include('headertop.php'); ?>
<div id="contentmain">
     <div id='itemdiv'>
         <div id='imagediv'>
             <div id='imagesdiv'>
			     <?php
				  for($c=0;$c<count($productimages);$c++){
                     echo "<img src='puploads/".$productimages[$c]."'>";
				  }
				 ?>
             </div>
		     <img id='titleimg' src='puploads/<?php echo $item['product_title_image']; ?>'>
         </div>
         <div id='buy_addcartdiv'>
             <a id='cart_btn_a' href='itemdisp.php?cart=<?php echo $_item['productid'] ;?>'><h2 id='cartbtn'>ADD TO CART</h2></a> 
             <a id='shop_btn_a' href='order.php?shop=<?php echo $item['productid'] ; ?>'><h2 id='shopbtn'>SHOP NOW</h2></a>		 
         </div>
         <div id='itemdescriptiondiv'>	 
             <h1 class='itemdetails'><?php echo $item['productname']; ?></h1>
	         <h3 class='itemdetails'><?php echo $item['productprice']; ?></h3>
			 <h2 class='itemdetails_heds'>Description</h2>
			     <h3 class='itemdetails'><?php echo $item['productdescription']; ?></h3>
			 <h2 class='itemdetails_heds'>Category</h2>
			     <h3 class='itemdetails'><?php echo $item['productcategory']; ?></h3>
			 <h2 class='itemdetails_heds'>Specification</h2>
			     <h3 class='itemdetails'><?php echo $productspecs[0]; ?></h3>
				 <h3 class='itemdetails'><?php echo $productspecs[1]; ?></h3>
				 <h3 class='itemdetails'><?php echo $productspecs[2]; ?></h3>
				 <h3 class='itemdetails'><?php echo $productspecs[3]; ?></h3>
	     </div>
     </div>
     <div id='similiar_item_div'>
	     <h3 id='similiar_heading'>Similiar Items</h3>
         <?php
         while($similiar_items = $similiar_que->fetch_assoc()){
             echo "<div class='similiar_product'>";
		         echo "<img src='puploads/".$similiar_items['product_title_image']."' >" ;
		         echo "<h4 class='similiar_product_name'>".$similiar_items['productname']."</h4>" ;
	             echo "<h5 class='similiar_product_price'>".$similiar_items['productprice']."</h5>" ;
	             echo "<div id='similiar_cartbtndiv'>
				       <a href='itemdisp.php?cart=".$similiar_items['productid']."&item=".$item['productid']."'><h4 class='similiar_cartbtn'>Add to Cart</h4></a>
	                   </div>";
			 echo "</div>" ;
         }
         ?>
     </div>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>