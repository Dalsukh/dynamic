<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	<div class="content-header">
		<h1>
		Category
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Category</li>
		</ol>
	</div>
	<hr>
	<div class="container">
		<div class="panel panel-default search-panel">			
		    <div class="panel-heading">
		    <div class="col-md-10">
		    	<h5 class="panel-title">Searching</h5>
		    </div>
		    <a href="addCategory.php" class="btn btn-success">Add Category</a>	    
		    </div>
	        <div class="panel-body">
	            <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" accept-charset="UTF-8" class="form-filter" role="form">

	            <div class=" col-md-2 form-group">
	            <label for="filter[name]" class="">Category Name:</label>
	            <input class=" form-control " name="filter[name]" type="text" value="" id="filter[name]">
	            </div>

	            <div class=" col-md-2 form-group">
	            <label for="filter[keywords]" class="">Keywords:</label>
	            <input class=" form-control " name="filter[keywords]" type="text" value="" id="filter[keywords]">
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
	
  	<div class="clearfix"></div> 
	<div class="container">
		<div class="box">
		<div class="box-body table-responsive ">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<?php foreach($header_fields as $key=>$val){ ?>
						<th><?php echo $val ;?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($categories as $key => $row) { ?>
				<tr>
					<?php foreach($row as $HKey=>$val){ ?>
						<td>
						<?php 
						if($HKey == 'image' ||$HKey == 'thumb' && !empty($val)){ ?>
							<img src="<?php echo $val;?>" alt="" width="25px">
						<?php	
						}
						else
						{
							echo $val ;
						}
						?>							
						</td>
					<?php } ?>
					<td>
					<a href="editCategory.php?id=<?php echo $row['id'];?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

							<a href="?action=Delete&id=<?php echo $row['id'];?>&page=<?php echo $page;?>" class="action_confirm btn btn-danger" data-method="delete" data-modal-text="are you sure delete this Category?" data-original-title="Delete Category" title="Delete"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>		
		</table>
		<?php echo $markup; ?>
		</div>		
		</div>
	</div>
	</div>
</div>