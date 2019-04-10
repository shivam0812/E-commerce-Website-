<?php
//$str = 's';
$str = $_GET['str'] ;
$strlen = strlen($str);

include('connect.php');
$searchdatasql = "SELECT product FROM reg_prods";
$searchdataq = $conn->query($searchdatasql) ;
$search_data = $searchdataq->fetch_assoc();

$suggkey = '';
while($search_data = $searchdataq->fetch_assoc()){
     $products[] = $search_data['product'];
}
$product_types = array_unique($products);
//print_r($product_types);
for($i=0;$i<count($product_types);$i++){
	 if(array_key_exists($i,$product_types)){
	     if($suggkey == ''){
	        if(strncasecmp($str,$product_types[$i],$strlen) == 0){
		    $suggkey = $product_types[$i];
	        }
	     }
	     else{
	   	    if(strncasecmp($str,$product_types[$i],$strlen) == 0){
		    $suggkey .= ",".$product_types[$i];
	        }	
	     }
	 }
}
echo $suggkey ;
?>