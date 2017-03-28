<!-- buyer.tpl.php -->
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
		    <a href="addUser.php" class="btn btn-success">Add User</a>	    
		    </div>
	        <div class="panel-body">
	            <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" accept-charset="UTF-8" class="form-filter" role="form">
	            <div class=" col-md-2 form-group">
	            
	            <label for="filter[full_name]" class="">Full Name:</label>
	            <input class=" form-control " name="filter[full_name]" type="text" value="<?php echo $input->get('filter.full_name'); ?>" id="filter[full_name]">	            
	            </div>
	            <div class=" col-md-2 form-group">
	            <label for="filter[email]" class="">Email:</label>
	            <input class=" form-control" name="filter[email]" type="text" value="<?php echo $input->get('filter.email'); ?>" id="filter[email]">
	            
	            </div>
	            <div class=" col-md-2 form-group">
	            <label for="filter[mobile]" class="">Mobile:</label>
	            <input class=" form-control " name="filter[mobile]" type="text" 
	            value="<?php echo $input->get('filter.mobile'); ?>" id="filter[mobile]">
	            
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
						<?php foreach($header_fields as $key=>$val){ ?>
							<th><?php echo $val ;?></th>
						<?php } ?>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $key => $row) { ?>
					<tr>
						<?php foreach($header_fields as $Hkey=>$val){ ?>
							<?php if($Hkey == "image" && $row[$Hkey]){ ?>
								<td>
								<img src="<?php echo $row['thumb'] ?>" width="50">
								</td>
							<?php }else { ?>
								<td><?php echo $row[$Hkey] ;?></td>
							<?php } ?>

						<?php } ?>
						<td>
							<!-- <a href="?show" class="btn btn-default"><i class="fa fa-eye"></i></a> -->
							<a href="editUser.php?id=<?php echo $row['id'];?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

							<a href="?action=Delete&id=<?php echo $row['id'];?>&page=<?php echo $page;?>" class="action_confirm btn btn-danger" data-method="delete" data-modal-text="are you sure delete this Buyer?" data-original-title="Delete buyer" title="Delete"
							><i class="fa fa-trash"></i></a>							
						</td>
					</tr>
				<?php } ?>
				</tbody>						
			</table>			
		</div>
		</div>		
	</div>
		<div class="text-right">
		<?php 
		echo $markup; 
		?>
		</div>
	</div>

</div>