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
      <h1>Advanced Search <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
	   	<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
	 		</svg></h1>
      <p>Can't find your cells? I bet, we can!</p>
    </div>

		<form method="post" action="search_res.php">
			 <?php include('error.php'); ?>
			 <div class="container">
					 <h2>Enter the Details of your Search</h2>

					 <div class="row">
						  <div class="col-sm-3 d-sm-flex align-items-center">
									<label class="m-sm-0">Tube name</label>
									 <input
									   type="text"
									   name="samplename"
									   class="form-control ml-sm-2"
									   placeholder="E.coli"
									   value="<?php echo $samplename; ?>"
									 >
							</div>
							<div class="col-sm-3 d-sm-flex align-items-center">
								   <label class="m-sm-0">Cell type</label>
								   <input
									 type="text"
									 name="celltype"
									 class="form-control ml-sm-2"
									 placeholder="MDCK"
									 value="<?php echo $celltype; ?>"
									 >
							</div>
					 </div>

					 <div class="col-sm-3 d-sm-flex align-items-center">
							 <label class="m-sm-0">Owner</label>
							 <select class="custom-select"
								 <option selected>Private</option>
								 <option value="1">Private</option>
								 <option value="2">Ask me first</option>
								 <option value="3">Public</option>
							   </select>
					 </div>
			 </div>

			 <div class="row">
					 <div class="col-sm-3 d-sm-flex align-items-center">
						   <label class="m-sm-0">Position</label>
						   <input
							 type="text"
							 name="position"
							 class="form-control ml-sm-2"
							 placeholder="rack 9 - 7A "
							 value="<?php echo $position; ?>"
							 >
					 </div>


					 <div class="col-sm-3 d-sm-flex align-items-center">
						   <label class="m-sm-0">Date</label>
						   <input
							 type="text"
							 name="frozendate"
							 class="form-control ml-sm-2"
							 placeholder="dd/mm/yyyy"
							 value="<?php echo $frozendate;?>"
							 >
					 </div>

					<div class="input-group">
 							<br>
					</div>


		      <div class="input-group">
			   	  	<button type="submit" class="btn btn-success" name="reg_search">Search
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
							  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg></button>
			   	  	<button type="submit" class="btn btn-success" name="reg_search">Search</button>
		   		</div>
			</div>
		</form>
	</div>
	<?php include('footer.html') ?>

 </body>
 </html>
