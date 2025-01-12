<?php
//insert.php  
$connect = mysqli_connect("localhost", "root", "", "leaves");
if(!empty($_POST))
{
 $output = '';
    $name = mysqli_real_escape_string($connect, $_POST["name"]);  
    $address = mysqli_real_escape_string($connect, $_POST["address"]);  
    $Month = mysqli_real_escape_string($connect, $_POST["Month"]);  
    $designation = mysqli_real_escape_string($connect, $_POST["designation"]);  
    $age = mysqli_real_escape_string($connect, $_POST["age"]);
	$image = mysqli_real_escape_string($connect, $_POST["image"]); 
	$a1 = mysqli_real_escape_string($connect, $_POST["a1"]); 
    $a2 = mysqli_real_escape_string($connect, $_POST["a2"]);  
    $a3 = mysqli_real_escape_string($connect, $_POST["a3"]);
	$a4 = mysqli_real_escape_string($connect, $_POST["a4"]);  
	$a5 = mysqli_real_escape_string($connect, $_POST["a5"]);  
    $a6 = mysqli_real_escape_string($connect, $_POST["a6"]);
	$a7 = mysqli_real_escape_string($connect, $_POST["a7"]);
	$a8 = mysqli_real_escape_string($connect, $_POST["a8"]);
	$a9 = mysqli_real_escape_string($connect, $_POST["a9"]);
	$a10 = mysqli_real_escape_string($connect, $_POST["a10"]);
	$a11 = mysqli_real_escape_string($connect, $_POST["a11"]);
	$a12 = mysqli_real_escape_string($connect, $_POST["a12"]);
	$a13 = mysqli_real_escape_string($connect, $_POST["a13"]);
	$a14 = mysqli_real_escape_string($connect, $_POST["a14"]);
	$a15 = mysqli_real_escape_string($connect, $_POST["a15"]);
    $a16 = mysqli_real_escape_string($connect, $_POST["a16"]);
	$a17 = mysqli_real_escape_string($connect, $_POST["a17"]);
	$a18 = mysqli_real_escape_string($connect, $_POST["a18"]);
	$a19 = mysqli_real_escape_string($connect, $_POST["a19"]);

		
	
    $query = "
    INSERT INTO tbl_employee (name, address, Month, designation, age, image,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,total)  
     VALUES('$name', '$address', '$Month', '$designation', '$age','$image','$a1','$a2','$a3','$a4','$a5','$a6','$a7','$a8','$'$a9','$a10','$a11','$a12','$a13','$a14','$a15','$a16','$a17','$a18','$a19')";
    if(mysqli_query($connect, $query))
    {
     $output .= '<label class="text-success">employee evaluation has been Inserted</label>';
     $select_query = "SELECT * FROM tbl_employee ORDER BY id DESC";
     $result = mysqli_query($connect, $select_query);
     $output .= '
      <table class="table table-bordered">  
                    <tr>  
                         <th width="70%">Employee Name</th>  
                         <th width="30%">View</th>  
                    </tr>

     ';
     while($row = mysqli_fetch_array($result))
     {
      $output .= '
       <tr>  
                         <td>' . $row["name"] . '</td>  
                         <td><input type="button" name="view" value="view" id="' . $row["id"] . '" class="btn btn-info btn-xs view_data" /></td>  
                    </tr>
      ';
     }
     $output .= '</table>';
    }
    echo $output;
}
?>


