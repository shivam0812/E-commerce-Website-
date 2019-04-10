<?php
include('connect.php');
session_start();
if(isset($_POST['reg'])){
	 $productname = $_POST['pname'];
	 $product = $_POST['product'];
	 $productdescription = $_POST['pdesc'];
	 $productid = $_POST['pid'];
	 $productimage = $_FILES['pimg']['name'];
	 $productimages = implode(",",$_FILES['pimgs']['name']);
	 $productcategory = $_POST['pcategory'];
	 $productspecs = implode(",",$_POST['pspecs']);
	 $productprice = $_POST['pprice'];
	 $useremail = $_POST['useremail'];
	 
	 $puploads = "puploads/".$productimage;
	 if(move_uploaded_file($_FILES['pimg']['tmp_name'],$puploads)){
		 $filemsg1 = "File Uploaded";
	 }
	 else{
		 $filemsg1 = "Error".$conn->error;
	 }
	 $uploaddir = 'puploads/';
    foreach ($_FILES['pimgs']['error'] as $key => $error)
    {
        if ($error == UPLOAD_ERR_OK)
        {
            $tmp_name = $_FILES['pimgs']['tmp_name'][$key];
            $filename = $_FILES['pimgs']['name'][$key];
            $uploadfile = $uploaddir .basename($filename);
            if (move_uploaded_file($tmp_name, $uploadfile))
            {
                $filemsgs2 = "File Uploaded" ;
            }
            else
            {
                $filemsgs2 = "Error".$conn->error ;
            }
        }
    }
	
	    if(isset($_POST['useremail'])){
		  if($_POST['useremail'] == $_SESSION['email']){
			$prodregsql = "INSERT INTO reg_prods (product,productname,productdescription,productid,product_title_image,productimages,productcategory,productspecs,productprice,useremail)
			        VALUES('$product','$productname','$productdescription','$productid','$productimage','$productimages','$productcategory','$productspecs','$productprice','$useremail')";
		    if($conn->query($prodregsql)==true){
				echo "Product Registered";
			}
			else{
				echo $conn->error;
			}

            }
        }
 }
?>
<html>
<head>
<title>Product Registration | ShopSite</title>
<meta charset="utf-8">
<link rel="stylesheet" href="shopsite_hm.css">
<script src="jquery-3.3.1/jquery.js"></script>
<style>
#formdiv{
	width:76%;
	margin:0 auto;
	padding:10px 0px 0px 0px;
}
#formdiv h1{
	font-size:25px;
	width:20%;
	font-family:Trebuchet MS;
}
.regprods{
	width:100%;
	margin:0px 0px 0px 0px;
	overflow:hidden;
}
.regprods h1{
	float:left;
	margin:5px 10% 0px 0px;
}
.regprods input{
	float:left;
}
.regprods select{
	float:left;
	width:20%;
	height:32px;
	margin:5px 0px 0px 0px ;
	padding:2px 0px 2px 10px;
	font-size:16px;
}
#regprodsspc{
	width:100%;
	margin:5px 0px 0px 0px;
	overflow:hidden;
}
#regprodsspc h1{
	float:left;
	margin:5px 10% 0px 0px;
}
#regprodsinp{
	width:60%;
	float:left;
	margin:5px 0px 0px 0px;
}
#morespc{
	margin:5px 0px 5px 5%;
}
.inpf{
	width:350px;
	height:35px;
	margin:0px 0px 5px 0px; 
}
#inptextarea{
    width:450px;
    height:100px;
    padding:0px 0px 0px 0px;	
}
#pr{
	width:100px;
	height:25px;
	margin:5px 0px 2px 0px;
}
#sbmit{
	width:120px;
	height:35px;
	margin:15px 10% 15px 10px;
	border-radius:5px;
	font-size:20px;
	color:black;
}
</style>
</head>
<body>
<div id="main">
  <?php include('headertop.php'); ?>
  <div id="contentmain">
     <div id="formdiv">
		<form name="productform" action="" enctype="multipart/form-data" method="post" id="prodrg">
		   <div class="regprods">
		     <h1>Product Name:</h1>
		     <input type="text" name="pname" class="inpf">
		   </div>
		   <div class="regprods">
		     <h1>Product:</h1>
		     <input type="text" name="product" class="inpf">
		   </div>
		   <div class="regprods">
		   <h1>Product Description:</h1>
		   <input type="textarea" name="pdesc" class="inpf" id="inptextarea">
		   </div>
		   <div class="regprods">
		   <h1>Product ID:</h1>
		   <input type="text" name="pid" class="inpf">
		   </div>
		   <div class="regprods">
		   <h1>Product Image:</h1>
		   <input type="file" name="pimg" >
		   </div>
		   <div class="regprods">
		   <h1>More Images:</h1>
		   <input type="file" name="pimgs[]" multiple="multiple">
		   </div>
		   <div class="regprods">
		   <h1>Category:</h1>
		   <select name="pcategory">
		       <option>Home</option>
			   <option>Home Appliances</option>
			   <option>Accessories</option>
			   <option>Electronics</option>
			   <option>Clothes</option>
			   <option>Computers & Accessories</option>
			   <option>Gaming & Accessories</option>
			   <option>Gadgets</option>
			   <option>Furniture</option>
			   <option>Fitness</option>
			   <option>Health & Nutrition</option>
			   <option>Tools & Utilities</option>
		   </select>
		   </div>
		   <div id="regprodsspc">
		   <h1>Product Specifications:</h1>
		   <div id="regprodsinp">
		   <input type="text" name="pspecs[]"  class="inpf"><br>
		   <input type="text" name="pspecs[]"  class="inpf"><br>
		   <input type="text" name="pspecs[]"  class="inpf"><br>
		   <input type="text" name="pspecs[]"  class="inpf"><br>
		   <input type="button" id="morespc" value="More">
		   </div>
		   </div>
		   <div class="regprods">
		   <h1>Product Price:</h1>
		   <input type="text" name="pprice" id="pr" >
		   </div>
		   <div class="regprods">
		   <h1>Email:</h1>
		   <input type="email" name="useremail" class="inpf">
		   </div>
		   <div id="btnsave"><input type="submit" name="reg" value="Register" id="sbmit"></div>
		</form>
	 </div>
  </div>
  <?php include('footer.php'); ?>
</div>
<script>
   $(document).ready(function(){
	  $("#morespc").click(function(){
		  $("#regprodsinp").prepend("<input type='text' name='pspecs[]' class='inpf'>");
      });			  
   });
</script>
</body>
</html>