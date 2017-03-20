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
	        <div class="panel-body">
	            <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" accept-charset="UTF-8" class="form-filter" role="form">
	            <div class=" col-md-2 form-group">
	            <label for="filter[full_name][value]" class="">Full Name:</label>
	            <input class=" form-control " name="filter[full_name][value]" type="text" value="" id="filter[full_name][value]">
	            <input name="filter[full_name][operator]" type="hidden" value="like">
	            </div>
	            <div class=" col-md-2 form-group">
	            <label for="filter[email][value]" class="">Email:</label>
	            <input class=" form-control" name="filter[email][value]" type="text" value="" id="filter[email][value]">
	            <input name="filter[email][operator]" type="hidden" value="=">
	            </div>
	            <div class=" col-md-2 form-group">
	            <label for="filter[mobile][value]" class="">Mobile:</label>
	            <input class=" form-control " name="filter[mobile][value]" type="text" value="" id="filter[mobile][value]">
	            <input name="filter[mobile][operator]" type="hidden" value="like">
	            </div>
	            <div class="form-group col-md-3">
	                <label for="Search" class="">&nbsp;</label><br/>
	                <input class="btn btn-sm btn-primary submit" type="submit" value="Search">
	                <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-sm btn-default">Cancel</a>
	            </div>
	            <div class="error">            
	            
	            
	            </div>
	            </form>
	    </div>
	    </div>
	</div>
  
  	<div class="container">
	<div class="box">
		<div class="box-body">
		<div class="table-responsive ">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<?php foreach($categories[0] as $key=>$val){ ?>
							<th><?php echo $key ;?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($categories as $key => $row) { ?>
					<tr>
						<?php foreach($row as $val){ ?>
							<td><?php echo $val ;?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>		
			</table>
		</div>
		</div>
	</div>
	</div>
</div>