		<?php require_once('conn.php');
		include('inc/header.php'); 
		include('delete.php');
        include('receiver_action.php');
		?>
		<html>
		<head>
		<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
		<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/js/dataTables.min.js" />
		<link rel="stylesheet" href="css/fonts.css">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/myjs.js"></script>

			
		
		</head>  
		<title>وحدات الطابق الأرضي</title>
		<body>
		
		<div class="container contact" align="right">	
		<h2>وحدات الطابق الأرضي</h2>
		<div class="modal" tabindex="-1" role="dialog" aria-labelledby="..." aria-hidden="true">
		...
		</div>
	
		<div class="container contact">	
		<h4><br>
 <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-lg" align="right">اضافة وحدة</button> </h4> 
		<div class="modal" tabindex="-1" role="dialog" aria-labelledby="..." aria-hidden="true">
		...
		</div>
			
		<!-- Large modal -->
		
		<br>
		<br>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle" align="right">
		    <h3>اسم الوحدة</h3></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		</button>
		يرجى ادخال اسم الوحدة
		</div>
		<div class="modal-body">
		<form name="fupForm" action="<?php echo $editFormAction; ?>" id="fupForm"  method="POST">
		<table border="0" align="center">
		<tbody>
		<tr>
		  <td width="85" valign="middle" nowrap="nowrap" style="text-align: left"><div class="form-group" align="left"></div></td>
		  <td width="445" valign="middle">&nbsp;</td>
		  <td width="34" valign="middle">&nbsp;</td>
		  <td width="64" valign="middle" nowrap="nowrap">&nbsp;</td>
		  <td width="302" valign="middle">&nbsp;</td>
		  </tr>
		<tr>
		  <td valign="middle" nowrap="nowrap"><div align="right" class="form-group" style="text-align: left" align="right">  </div></td>
		  <td valign="middle"><div class="form-group"><input type="text" class="form-control" id="name" placeholder="الإسم" name="name" align="right">
		    </div></td>
		  </tr>
		<tr>
		  <td valign="middle" nowrap="nowrap">&nbsp;</td>
		  <td colspan="3" valign="middle">&nbsp;</td>
		  <td align="center" valign="middle">&nbsp;</td>
		  </tr>
		<tr>
		  <td valign="middle" nowrap="nowrap">&nbsp;</td>
		  <td colspan="3" valign="middle">&nbsp;</td>
		  <td align="center" valign="middle">&nbsp;</td>
		  </tr>
    
      	 
  </tbody>
</table>
		</div>
   	        <div class="modal-footer">
		  <button>
        <a id="Present2" href="#" name="MM_insert" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" onClick="Present(); "> ارسال </a>
</button> <h4></p></h4>
      </div>
    </div>
  </div>

		<?php $date = date('d-m-Y');?>

		<input type=hidden class="form-control" id="date" name="date" value="<?php echo $date; ?>"/> 
		</div>

<!-- Button trigger modal -->


		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">ارسال</h5>
		</div>
		<div class="modal-body">
		انت على وشك اضافة وحدة جديدة الى قائمة الوحدات
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
		<button type="submit" class="btn btn-danger" name="submit" value="confirm">تأكيد</button>
		<input type="hidden" name="MM_insert" value="form1">
		</div>
		</div>
		</div>
		</div>
		<input type="hidden" name="MM_update" value="fupForm">
		</form>			
			
<table id="scoreTable" class="table table-bordered table-striped" align="right">
  <thead>
	  <tr>
		            <th>حذف</th>
					<th>تعديل</th>
                    <th>الإسم</th>
					<th>الرقم</th>
                </tr>
            </thead>
            <tbody>
                <?php
 
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
					echo '<td> 
					<form action="product_delete.php" method="post" style="display:inline;">
					<input type="hidden" name="id" value="' . $row['G_category_id'] . '">
					<button type="submit"><img src="icons/352303_delete_icon.png"></button>
                    </form>
                    </td>';	
					
                    echo '<td>
					<form action="product_update.php" method="post1" style="display:inline;">
					<input type="hidden" name="id" value="' . $row['G_category_id'] . '">
					<button type="submit"><img src="icons/211781_more_icon.png"></button>
                    </form>	
					<br>
                    </td>';					
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['G_category_id'] . '</td>';

					echo '</tr>';
                }

                ?>
        </tbody>
        </table>
		<div align="center">
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>
		</div>
		</div>
		</div>
		</div>
		<?php include('inc/footer.php');?><br>
<script>
$(document).ready(function() {
    $('#scoreTable').DataTable();
});
</script>
		</body>

		</html>		  
		<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
		<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



<script>

let table = new DataTable('#a');
</script>

