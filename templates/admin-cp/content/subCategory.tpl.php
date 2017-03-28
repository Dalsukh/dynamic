<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<h1>
		Users / Buyers
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Buyers</li>
		</ol>
	</div>
	<hr>
	<div class="container">
		<div class="panel panel-default search-panel">			
	    <div class="panel-heading">
	    <div class="col-md-10">
	    	<h5 class="panel-title">Searching</h5>
	    </div>
	    <a href="addSubCategory.php" class="btn btn-success">Add SubCategory</a>	    
	    </div>
	        <!-- <div class="panel-body">
	            <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" accept-charset="UTF-8" class="form-filter" role="form">
	            <div class=" col-md-2 form-group">
	            <label for="filter[full_name]" class="">Category Name:</label>
	            <input class=" form-control " name="filter[category_name]" type="text" value="" id="filter[full_name]">	            
	            </div>
	            <div class=" col-md-2 form-group">
	            <label for="filter[email]" class="">Sub Category Name:</label>
	            <input class=" form-control" name="filter[email]" type="text" value="" id="filter[email]">	            
	            </div>
	            
	            <div class="form-group col-md-3">
	                <label for="Search" class="">&nbsp;</label><br/>
	                <input class="btn btn-sm btn-primary submit" type="submit" value="Search">
	                <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-sm btn-default">Cancel</a>
	            </div>
	            <div class="error">            
	            
	            
	            </div>
	        	</form>
	    	</div> -->
	    </div>
	</div>
  
  	<div class="container">
	<div class="box">
		<div class="box-body">
		<div class="table-responsive ">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<?php foreach($header_fields as $key=>$val){ ?>
							<th><?php echo $val ;?></th>
						<?php } ?>
						<!-- <th>Action</th> -->
					</tr>
				</thead>
				<tbody>
				<?php foreach ($categories as $key => $row) { ?>
					<tr>
						<?php foreach($header_fields as $Hkey=>$val){ ?>
							<td>
							<?php if($Hkey == "image") { ?>
							<img src="<?php echo $row['thumb'];?>" width="35px">
							<?php	} else{ ?>
							<?php echo $row[$Hkey] ;?>
							<?php  } ?>
							
								
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>		
			</table>
			<?php echo $markup;?>
		</div>
		</div>
	</div>
	</div>
</div>