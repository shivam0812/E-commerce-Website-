<?php
include('connect.php');
session_start();
if(isset($_POST['submit'])){
	$newn = $_POST['nname'];
	$newem = $_POST['nemail'];
	$newp = $_POST['npass'];
	$newg = $_POST['gender'];
	$newc = $_POST['country'];
    $newd = $_POST['date'];
	$newt = $_POST['time'];
	$newimg = $_FILES['propic']['name'];
	
	$upload = 'auploads/'.basename($newimg);
    
    if(move_uploaded_file($_FILES['propic']['tmp_name'],$upload)){
       echo "File Uploaded";
	}	
	else{
		echo "Error:".$conn->error;
	}
	
	$valemsql = "SELECT email FROM accounts WHERE email='".$newem."'";
	$valemque = $conn->query($valemsql);
	if($valemque->num_rows > 0){
		echo "Email already exixts";
	}
	else{
		if($newn != ""){
	       $signupsql = "INSERT INTO accounts(name,email,password,gender,profile_pic,country,date,time)
             VALUES('$newn','$newem','$newp','$newg','$newimg','$newc','$newd','$newt')";
		}
			 
    if($conn->query($signupsql) == true){	
        echo "Successful";
	}
    else{
       echo $conn->error;
	}
    }	
}
?>

<html>
<head>
<title>Sign Up | ShopSite</title>
<meta charset="utf-8" >
<link rel="stylesheet" href="shopsite_hm.css">
<style>
#usraccdiv{
	width:77%;
	overflow:hidden;
	margin:0 auto;
}
.label1{
	width:20%;
	float:left;
	font-size:22px;
	margin:0px 0px 0px 0px;
	padding:10px 0px 10px 10px;
	font-family:Trebuchet MS;
}
#sinupform{
	width:77%;
	margin:0 auto;
}
#sinupform h1{
	font-size:25px;
	font-family:Trebuchet MS;
}
#fnd{
	overflow:hidden;
	margin:0px 0px 5px 0px;
}
#fed{
	overflow:hidden;
	margin:0px 0px 5px 0px;
}
#fpd{
	overflow:hidden;
	margin:0px 0px 5px 0px;
}
#fpcnfrmd{
	overflow:hidden;
	margin:0px 0px 5px 0px;
}
#fgd{
	overflow:hidden;
}
#fppd{
	overflow:hidden;
	margin:10px 0px 0px 0px;
}
#fcd{
	overflow:hidden;
	margin:10px 0px 10px 0px;
}
#fdd{
	overflow:hidden;
	margin:10px 0px 10px 0px;
}
#ftd{
	overflow:hidden;
	margin:10px 0px 0px 0px;
}
#fnd h1{
	width:20%;
	float:left;
	margin:5px 10% 10px 10px;
}
#fed h1{
	width:20%;
	float:left;
	margin:5px 10% 10px 10px;
}
#fpd h1{
	width:20%;
	float:left;
	margin:5px 10% 10px 10px;
}
#fpcnfrmd h1{
	width:25%;
	float:left;
	margin:5px 5% 10px 10px;
}
#fgd h1{
	width:20%;
	float:left;
	margin:10px 10% 10px 10px;
}
#fppd h1{
	width:20%;
	float:left;
	margin:5px 10% 10px 10px;
}
#fcd h1{
	width:20%;
	float:left;
	margin:5px 10% 5px 10px;
}
#fdd h1{
	width:20%;
	float:left;
	margin:5px 10% 5px 10px;
}
#ftd h1{ 
	width:20%;
	float:left;
	margin:5px 10% 5px 10px;
}
#fnd input{
	float:left;
}
#fed input{
	float:left;
}
#fpd input{
	float:left;
}
#fpcnfrmd input{
	float:left;
}
#fgrd{
	width:68%;
	float:left;
	margin:15px 0px 10px 0px;
}
#fgrd h3{
	float:left;
	width:12%;
	margin:0px 0px 0px 10px;
	font-family:Trebuchet MS;
}
#fgrd input{
	float:left;
}
#fppd input{
	margin:12px 0px 10px 0px;
	float:left;
}
#fcd select{
	height:32px;
	width:18%;
	float:left;
	margin:8px 0px 10px 0px;
	padding:2px 0px 2px 10px;
	font-size:16px;
}
#fdd input{
	margin:10px 0px 10px 0px;
	float:left;
	height:25px;
	width:16%;
	font-size:16px;
}
#ftd input{
	margin:10px 0px 10px 0px;
	float:left;
	height:25px;
	width:16%;
	font-size:16px;
}
.inpclass{
	width:350px;
	height:30px;
}
#sbmit{
	width:120px;
	height:35px;
	margin:15px 10px 15px 10px;
	border-radius:5px;
	font-size:22px;
	color:black;
}
</style>
</head>
<body>
<div id="main">
    <?php include('headertop.php'); ?>
    <div id="contentmain">
	  	 <div id="usraccdiv">
	       <h1 class="label1">Create Account</h1>
	     </div>
         <div id="sinupform">
         <form name="sinup_form" action="" method="post" enctype="multipart/form-data" >
            <div id="fnd">
			<h1 >Name: </h1>
               <input type="text" name="nname"  class="inpclass" value="<?php if(isset($_POST['submit']) && $_POST['nname'] == ""){ echo "Enter Your Name";}?>"><br>
            </div>
			<div id="fed">
			<h1 >Email: </h1>
               <input type="email" name="nemail" class="inpclass">
			</div>
			<div id="fpd">   
            <h1 >Password: </h1>
               <input type="password" name="npass" class="inpclass">
			</div>
			<div id="fpcnfrmd">
			   <h1>Confirm Password:</h1>
			   <input type="password" name="npasscnfrm" class="inpclass">
			</div>
			<div id="fgd">
            <h1>Gender: </h1>
			   <div id="fgrd">
               <input type="radio" name="gender" value="male" checked="checked" ><h3>Male</h3>
               <input type="radio" name="gender" value="female" ><h3>Female</h3>
               <input type="radio" name="gender" value="other" ><h3>Other</h3>
			   </div>
			</div> 
			<div id="fppd">   
            <h1>Profile Picture: </h1>
              <input type="file" name="propic" ><br>
			</div>
			<div id="fcd">
            <h1>Country: </h1>
               <select name="country">
                  <option value="india">India</option>
                  <option value="sri lanka">Sri Lanka</option>
                  <option value="china">China</option>
                  <option value="japan">Japan</option>
                  <option value="america">United States</option>
                  <option value="uk">United Kingdom</option>
				  <option value="uae">United Arab Emirates</option>
				  <option value="france">France</option>
				  <option value="safrica">South Africa</option>
				  <option value="germany">Germany</option>
              </select><br>
			</div>
			<div id="fdd">
            <h1>Date:</h1>
               <input type="date" name="date" ><br>
			</div>
			<div id="ftd">
            <h1>Time:</h1>
               <input type="time" name="time" ><br>
			</div>
        <input type="submit" name="submit" value="Submit" id="sbmit">
	    </form>
      </div>
    </div>
    <?php include('footer.php'); ?>	
</div>
</form>
</body>
</html>