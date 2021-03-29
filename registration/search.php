<?php
include('server.php');
?>

<!-- COMMENT LILI: 		This page only contains the search form.
											The php script with the sql search is in search_res
											where the reuslts are displayed 											-->

<!DOCTYPE html>
<html>
<head>
	<title>Advanced Search</title>

</head>
<body>
	<?php include('header.html') ?>

  <div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
         <h1>Advanced Search</h1>
         <p>Can't find your cells? I bet, we can!</p>
    </div>

  	<form method="post" action="search_res.php">
			 <?php include('error.php'); ?>
			 <div class="container">
				 <h2>Enter the Details of your Search</h2>

				 <div class="input-group">
					 <label>Sample name:</label>
					 <input type="text" name="samplename" value="<?php echo $samplename; ?>">
				 </div>

				 <div class="input-group">
					 <label>Cell Type:</label>
					 <input type="text" name="celltype" value="<?php echo $celltype; ?>">
				 </div>

				 <div class="input-group">
					 <label for="idStorage">Storage:</label>
					 <?php
						 $sql = "Select * from Storage";
						 $result = mysqli_query($db, $sql);

						 echo "<select name='idStorage'>
						 <option value=''></option>";

						 while ($row = mysqli_fetch_array($result)) {
								echo "<option value='" .$row['idStorage']."'> ".$row['Storagename'] . "</option>";
						 }
						 echo "</select>";
							 ?>
				


				 <div class="input-group">
					 <label>Position:</label>
					 <input type="text" name="position" value="<?php echo $position; ?>">
				 </div>

				 <div class="input-group">
					 <label>Rack:</label>
					 <input type="text" name="rack" value="<?php echo $rack; ?>">
				 </div>

				 <div class="input-group">
					 <label>Frozen on the: </label>
					 <input type="text" name="frozendate" value="<?php echo $frozendate; ?>">
				 </div>

				 <div class="input-group">
					 <label>Select the availability of the tubes</label>
					 <select name="availability">
						 <option value="empty"></option>
						 <option value="privat">Privat</option>
						 <option value="semiprivat">Semiprivat</option>
						 <option value="public">Public</option>
					 </select>
			 	</div>

				<div class="input-group">
					<label>Quantity of tubes:</label>
					<input type="number" name="amount" value="<?php echo $amount; ?>">
				</div>

				 <div class="input-group">
					 <label>Keyword in Comment:</label>
					 <textarea input type="text" rows="10" cols="50" name="comment" value="<?php echo $comment; ?>"></textarea>
			 	</div>

	      <div class="input-group">
	   	  	<button type="submit" class="btn btn-success" name="reg_search">Search</button>
	   		</div>
			</div>
		</form>
	</div>
		<?php include('footer.html') ?>

 </body>
 </html>


 <div class="input-group">
	 <label>Select the availability for your tubes</label>
	 <select name="availability">
		 <option value="privat">Privat</option>
		 <option value="semiprivat">Semiprivat</option>
		 <option value="public">Public</option>
	 </select>
 </div>
