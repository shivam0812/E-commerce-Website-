<?php
include('connect.php');
session_start();
$scan_sql = "SELECT * FROM reg_prods"; 
$scan_que = $conn->query($scan_sql);
while($scan_data = $scan_que->fetch_assoc()){
	 $data_array[] = $scan_data['productname'] ;
}
?>
<html>
<head>
<title>ShopSite | Products</title>
<meta charset="utf-8">
<script src="jquery-3.3.1/jquery.js"></script>
<link rel="stylesheet" href="shopsite_hm.css">
<style>
#search_disp{
	width:100%;
	margin:10px 0 20px 0;
	overflow:hidden;
	background-color:#FDFEFE;
	border:1px solid #CCD1D1;
	border-radius:2px;
}
#search_heading{
	width:280px;
	margin:10px 0px 5px 3%;
	padding:0px 5px 0px 15px;
	color:#6E2C00;
	font-family:verdana;
	box-sizing:border-box;
}
#search_content{
	width:100%;
	overflow:hidden;
	margin:10px 0 20px 0;
}
.search_product{
	width:18.9%;
	height:340px;
	margin:10px 6px 10px 8px;
	float:left;
	border:1px solid #B2BABB;
	background-color:#FDFEFE;
	border-radius:2px;
	box-shadow: 0px -1px 3px #7B7D7D;
	box-sizing:border-box;
}
.search_product img{
	border:1px solid #CCD1D1;
	margin:5px 20px 5px 25px;
	height:180px;
	width:200px;
}
#search_cartbtn_div{
	margin:10px 0px 0px 0px;
    background-color:#21618C;
}
#search_cart_btn{
	width:100px;
    margin:0 auto;
	padding:6px 0px 6px 5px;
	color:black;
	font-family:Palatino Linotype;
}
.search_product_h4{
	height:70px;
	margin:5px 0px 5px 0px;
	text-align:center;
	color:#616A6B;
	box-sixing:border-box;
	font-family:Palatino Linotype;
}
.search_product_h5{
	margin:5px 0px 5px 0px;
	text-align:center;
	color:#1C2833;
	box-sixing:border-box;
	font-family:Palatino Linotype;
}
</style>
</head>
<body>
<div id="main">
<?php include('headertop.php') ; ?>
<div id="contentmain">
     <div id="search_disp">
	     <h2 id="search_heading">Searched Products</h2>
		 <div id="search_content">
		 <?php 
		 if(!empty($_POST['search_input'])){
			 $scan_sql = "SELECT * FROM reg_prods WHERE product='".$_POST['search_product']."'"; 
			 $scan_que = $conn->query($scan_sql);
			 if($scan_que->num_rows > 0){
			     $scan_result = $scan_que->fetch_assoc();
		         $search_product_sql = "SELECT * FROM reg_prods WHERE productcategory='".$scan_result['productcategory']."'";
		         $search_product_que = $conn->query($search_product_sql) ;
		             while($searchproducts = $search_product_que->fetch_assoc()){
			             echo "<div class='search_product'>" ;
			             echo "<img src='puploads/".$searchproducts['product_title_image']."'>" ;
			             echo "<a href='itemdisp.php?item=".$searchproducts['productid']."'><h4 class='search_product_h4'>".$searchproducts['productname']."</h4></a>" ;
			             echo "<h5 class='search_product_h5'>".$searchproducts['productprice']."</h5>" ;
			             echo "<div id='search_cartbtn_div'>
				              <a href='homepage.php?cart=".$searchproducts['productid']."'><h4 id='search_cart_btn'>Add To Cart</h4></a>
						      </div>" ;
			             echo "</div>" ;
		             }
			 }
			 else{
				 $scan_sql = "SELECT * FROM reg_prods WHERE productcategory='".$_POST['search_product']."'"; 
			     $scan_que = $conn->query($scan_sql);
			     if($scan_que->num_rows > 0){
		             while($searchproducts = $scan_que->fetch_assoc()){
			             echo "<div class='search_product'>" ;
			             echo "<img src='puploads/".$searchproducts['product_title_image']."'>" ;
			             echo "<a href='itemdisp.php?item=".$searchproducts['productid']."'><h4 class='search_product_h4'>".$searchproducts['productname']."</h4></a>" ;
			             echo "<h5 class='search_product_h5'>".$searchproducts['productprice']."</h5>" ;
			             echo "<div id='search_cartbtn_div'>
				              <a href='homepage.php?cart=".$searchproducts['productid']."'><h4 id='search_cart_btn'>Add To Cart</h4></a>
						      </div>" ;
			             echo "</div>" ;
		             }
		         }
				 else{
                     for($i=0;$i<count($data_array);$i++){
						 $match = strchr($data_array[$i],$_POST['search_product']);
						 if($match != false){
							 $scan_sql = "SELECT * FROM reg_prods WHERE productcategory='".$_POST['search_product']."'"; 
			                 $scan_que = $conn->query($scan_sql);
		                     while($searchproducts = $scan_que->fetch_assoc()){
			                     echo "<div class='search_product'>" ;
			                         echo "<img src='puploads/".$searchproducts['product_title_image']."'>" ;
			                         echo "<a href='itemdisp.php?item=".$searchproducts['productid']."'><h4 class='search_product_h4'>".$searchproducts['productname']."</h4></a>" ;
			                         echo "<h5 class='search_product_h5'>".$searchproducts['productprice']."</h5>" ;
			                         echo "<div id='search_cartbtn_div'>
				                             <a href='homepage.php?cart=".$searchproducts['productid']."'><h4 id='search_cart_btn'>Add To Cart</h4></a>
						                   </div>" ;
			                         echo "</div>" ;
		                     }
							 break;
						 }
					 }
				 }
			 }
		 }
		 else{
			 echo $conn->error;
		 }
		 if(isset($_GET['catg_product'])){
	         $get_product_sql = "SELECT productcategory FROM reg_prods WHERE product='".$_GET['catg_product']."'";
	         $get_product_que = $conn->query($get_product_sql);
	         if($get_product_que->num_rows > 0){
				 $get_product = $get_product_que->fetch_assoc();
		         $search_product_sql = "SELECT * FROM reg_prods WHERE productcategory='".$get_product['productcategory']."'";
		         $search_product_que = $conn->query($search_product_sql) ;
		         if($search_product_que = $conn->query($search_product_sql)){
		             while($searchproducts = $search_product_que->fetch_assoc()){
			             echo "<div class='search_product'>" ;
			             echo "<img src='puploads/".$searchproducts['product_title_image']."'>" ;
			             echo "<a href='itemdisp.php?item=".$searchproducts['productid']."'><h4 class='search_product_h4'>".$searchproducts['productname']."</h4></a>" ;
			             echo "<h5 class='search_product_h5'>".$searchproducts['productprice']."</h5>" ;
			             echo "<div id='search_cartbtn_div'>
				              <a href='homepage.php?cart=".$searchproducts['productid']."'><h4 id='search_cart_btn'>Add To Cart</h4></a>
						      </div>" ;
			             echo "</div>" ;
		             }
		         }
			 }
		     else{
			     echo $conn->error ;
		     }
         }
        		 
		 ?>
		 </div>
	 </div>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>