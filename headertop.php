<?php
if(isset($_POST['sign_in'])){
	 $sign_in_sql = "SELECT name FROM accounts WHERE email='".$_POST['user_email']."'";
	 $sign_in_que = $conn->query($sign_in_sql);
	 if($sign_in_que->num_rows > 0 ){
		 $sign_in_sql = "SELECT password FROM accounts WHERE email='".$_POST['user_email']."'";
	     $sign_in_que = $conn->query($sign_in_sql);
		 $pass_confirm = $sign_in_que->fetch_assoc();
		 print_r($pass_confirm);
		 if($pass_confirm['password'] == $_POST['user_password']){
			 $_SESSION['email'] = $_POST['user_email'] ;
		 }
	 }
}
if(isset($_SESSION['email'])){
	$user_detail_sql = "SELECT name FROM accounts WHERE email='".$_SESSION['email']."'";
	$user_detail_que = $conn->query($user_detail_sql);
	$user_detail = $user_detail_que->fetch_assoc();
	$wishlist_sql = "SELECT wishlist FROM accounts WHERE email='".$_SESSION['email']."'";
	$wishlist_que = $conn->query($wishlist_sql);
	$wishlist = $wishlist_que->fetch_assoc();
	$wishlist = explode(",",$wishlist['wishlist']);
	$wishlist_unique = array_unique($wishlist);
	$wishlist_total = count($wishlist_unique);
}
?>
<script>
$(document).ready(function(){
	 $('#login').click(function(){ $('#sign_in_div').css({'display':'block'}); } );	 
	 $('#user_div').hover(function(){ $('#user_dropdowndiv').css({'display':'block'}); },
		                 function(){ $('#user_dropdowndiv').css({'display':'none'});  } );  
	 $('#categories').hover(function(){ $('#catg_dropdown_div').css({'display':'block'}); },
		                         function(){ $('#catg_dropdown_div').css({'display':'none'}); } );						 				  
});
</script>
<div id='navibar'>
    <a class='nava' href='homepage.php'><h3 id='h'>Home</h3></a>
    <div id='searchdiv'>
	    <form action='searchdisp.php' enctype='application/x-www-urlencoded' method='post' name='search_form' id='search_form'>
	        <input type='text' name='search_product'>
		    <a href='#' onclick='document.getElementById("search_form").submit();'><img src='images/shopsite_search_icon.png'></a>
		</form>
	</div>
	<div id='shoppingcartdiv'>
	    <a href='cart.php'><h2>Shopping cart</h2></a>
		<img src='images/carticon.png'>
	</div>
	<a href='signup.php'><h2 id='new'>Sign Up</h2></a>
	<a href='#'><h2 id='login'>Sign In</h2></a>
	<a href='#' id='user_div_a'><div id='user_div'><img id='user' src='images/shopsite_user.png'>
	                 <div id='user_dropdowndiv'>
	                     <div id='user_detail'>
		                     <h3 id='user_name'><?php echo $user_detail['name'] ; ?></h3>
			                 <img src='images/shopsite_user.png'>
		                 </div>
		                 <hr align='center' size='1px' width='90%' style='margin:18px 5% 0px 5%;background-color:#424949;'>
		                 <h3 id='orders_h3'>Orders</h3>
		                 <h3 id='gift_card_h3'>Gift Cards</h3>
		                 <a href='cart.php' id='cart_a'><h3 id='shopping_cart_h3'>Shopping Cart</h3></a>
	                     <a href='wishlist.php' id='wishlist_a'><h3 id='wishlist_h3'>Wishlist</h3></a>
		                 <h5 id='wishlist_total'><?php echo (int)$wishlist_total - 1 ;?></h5>
		                 <hr align='center' size='1px' width='90%' style='margin:60px 5% 0px 5%;background-color:#424949;'>
		                 <a id='sign_out_a' href='logout.php'><h4>Sign Out</h4></a>
	                 </div>
				</div></a>
</div>
<div id='sign_in_div'>
     <div id='sign_in_logo'>
	     <h2>Shopsite</h2>
	 </div>
	 <div id='sign_in_page'>
	     <form action='' enctype='application/x-www-urlencoded' method='post'>
	     <h2>Email</h2>
		 <input type='email' name='user_email'>
		 <h2>Password</h2>
		 <input type='password' name='user_password'>
		 <button type='submit' name='sign_in'>Sign In</button>
		 </form>
	 </div>
</div>
<div id='header'>
     <div id='logo'>
         <h1>Shopsite</h1>
	 </div>
	 <a href='#'><div id='categories'>
	     <a href='#'><h3 id='catg_1'>Gadgets<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_2'>Health & Nutrition<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_3'>Clothes<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_4'>Accessories<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_5'>Home Appliances<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_6'>Electronics<img src='images/shop-caret.png'></h3></a>
		 <a href='#'><h3 id='catg_7'>Tools & Utilities, Furniture & More<img src='images/shop-caret.png'></h3></a>
		 <div id='catg_dropdown_div'>
	     <div id='gadgets'>
		     <a href='searchdisp.php?catg_product=Selfie Stick'><p>Selfie Stick</p></a>
			 <a href='searchdisp.php?catg_product=Camera'><p>Camera</p></a>
			 <a href='searchdisp.php?catg_product=Smartwatch'><p>Smartwatch</p></a>
			 <a href='searchdisp.php?catg_product=Virtual Reality Box'><p>Virtual Reality Box</p></a>
			 <a href='searchdisp.php?catg_product=Screen Magnifier'><p>Screen Magnifier</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='gaming_accessories'>Gamign & Accessories</h4></a>
			 <a href='searchdisp.php?catg_product=X Box'><p>X Box</p></a>
			 <a href='searchdisp.php?catg_product=Gaming Laptop'><p>Gaming Laptop</p></a>
		 </div>
	     <div id='health_nutrition'>
		     <a href='searchdisp.php?catg_product=Vitamin Supplement'><p>Vitamin Supplement</p></a>
			 <a href='searchdisp.php?catg_product=Protein Supplement'><p>Protein Supplement</p></a>
			 <a href='searchdisp.php?catg_product=Nutrition Drink'><p>Nutrition Drink</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='fitness'>Fitness</h4></a>
			 <a href='searchdisp.php?catg_product=Yoga Mat'><p>Yoga Mat</p></a>
			 <a href='searchdisp.php?catg_product=Gloves'><p>Gloves</p></a>
			 <a href='searchdisp.php?catg_product=Dumbbell'><p>Dumbbell</p></a>
			 <a href='searchdisp.php?catg_product=Treadmill'><p>Treadmill</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='health_equipment'>Health Equipment</h4></a>
			 <a href='searchdisp.php?catg_product=Blood Pressure Monitor'><p>Blood Pressure Monitor</p></a>
		 </div>
		 <div id='clothes'>
		     <a href='searchdisp.php?catg_product='><h4 id='men_clothes'>Men's</h4></a>
		     <a href='searchdisp.php?catg_product=Shirts'><p>Shirts</p></a>
			 <a href='searchdisp.php?catg_product=T-shirts'><p>T-shirts</p></a>
			 <a href='searchdisp.php?catg_product=Waistcoat'><p>Waistcoat</p></a>
			 <a href='searchdisp.php?catg_product=Jackets'><p>Jackets</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='women_clothes'>Women's</h4></a>
			 <a href='searchdisp.php?catg_product=Sports Wear'><p>Sports Wear</p></a>
			 <a href='searchdisp.php?catg_product=Top'><p>Top</p></a>
			 <a href='searchdisp.php?catg_product=Dresses'><p>Dresses</p></a>
			 <a href='searchdisp.php?catg_product=Shrugs'><p>Shrugs</p></a>
			 <a href='searchdisp.php?catg_product=Sweatshirts'><p>Sweatshirts</p></a>
		 </div>
		 <div id='accessories'>
		     <a href='searchdisp.php?catg_product=Wallets'><p>Wallets</p></a>
			 <a href='searchdisp.php?catg_product=Bags'><p>Bags</p></a>
			 <a href='searchdisp.php?catg_product=Sunglasses'><p>Sunglasses</p></a>
			 <a href='searchdisp.php?catg_product=Jackets'><p>Jackets</p></a>
			 <a href='searchdisp.php?catg_product=Shoes'><p>Shoes</p></a>
			 <a href='searchdisp.php?catg_product=Belt'><p>Belt</p></a>
			 <a href='searchdisp.php?catg_product=Card Holder'><p>Card Holder</p></a>
			 <a href='searchdisp.php?catg_product=Watches'><p>Watches</p></a>
		 </div>
		 <div id='home_appliances'>
		     <a href='searchdisp.php?catg_product=Air Conditioner'><p>Air Conditioner</p></a>
			 <a href='searchdisp.php?catg_product=Refrigerator'><p>Refrigerator</p></a>
			 <a href='searchdisp.php?catg_product=Food Proccessor'><p>Food Proccessor</p></a>
			 <a href='searchdisp.php?catg_product=Coffee Maker'><p>Coffee Maker</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='home'>Home</h4></a>
			 <a href='searchdisp.php?catg_product=Laptop Table'><p>Laptop Table</p></a>
			 <a href='searchdisp.php?catg_product=Home Theatre'><p>Home Theatre</p></a>
			 <a href='searchdisp.php?catg_product=Magazine Holder'><p>Magazine Holder</p></a>
		 </div>
		 <div id='electronics'>
		     <a href='searchdisp.php?catg_product='><h4 id='mobiles'>Mobile Phones</h4></a>
		     <a href='searchdisp.php?catg_product=mobile phone'><p>Honor 7X</p></a>
			 <a href='searchdisp.php?catg_product=mobile phone'><p>Galaxy Max</p></a>
			 <a href='searchdisp.php?catg_product=mobile phone'><p>Lenovo K6</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='comp_accessories'>Computer & Accessories</h4></a>
			 <a href='searchdisp.php?catg_product=Headphones'><p>Headphones</p></a>
			 <a href='searchdisp.php?catg_product=Earphones'><p>Earphones</p></a>
			 <a href='searchdisp.php?catg_product=Power Bank'><p>Power Bank</p></a>
			 <a href='searchdisp.php?catg_product=Speakers'><p>Speakers</p></a>
			 <a href='searchdisp.php?catg_product=Mini PC'><p>Mini PC</p></a>
			 <a href='searchdisp.php?catg_product=USB Port'><p>USB Port</p></a>
		 </div>
		 <div id='tools_utilities'>
		     <a href='searchdisp.php?catg_product=Torches'><p>Torches</p></a>
			 <a href='searchdisp.php?catg_product=Digital Weighing Scale'><p>Digital Weighing Scale</p></a>
			 <a href='searchdisp.php?catg_product=Glue Gun'><p>Glue Gun</p></a>
			 <a href='searchdisp.php?catg_product='><h4 id='furniture'>Furniture</h4></a>
			 <a href='searchdisp.php?catg_product=Tables'><p>Tables</p></a>
			 <a href='searchdisp.php?catg_product=Dressing Table'><p>Dressing Table</p></a>
			 <a href='searchdisp.php?catg_product=Bean Bags'><p>Bean Bags</p></a>
			 <a href='searchdisp.php?catg_product=Drawers'><p>Drawers</p></a>
		 </div>
	 </div>
	 </div></div>
</div>