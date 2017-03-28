<!-- addProduct.tpl.php -->
<div class="content-wrapper">
	<div class="content-header">
		<h1>
		Add Category
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Buyers</li>
		</ol>
	</div>
	<hr>
	<div class="container">
	<section>
		
	  	<?php if(!empty($msg)){ ?>
	  		<div class="success <?php echo empty($msg)?'':'alert alert-success  alert-dismissable'; ?>">
	  		<?php echo $msg; ?>
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true">&times;</span>
	  		</button>
	  		</div>

            
        <?php } ?>
        <form method="post" enctype="multipart/form-data">
        
        <?php require_once("productForm.tpl.php");?>
		</ul>
		</div>
		<div class="row">
			<div class="col-md-6"><br/></div>	
			<div class="col-md-4"><br/></div>	
			<div class="col-md-4"><br/></div>	
			<div class="col-xs-6">
        	<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Submit">
        	<input type="reset" name="" class="btn btn-default">
        	<br/><br/>
        </div>
		</div>
        </form>
	</section>
	</div>
	
</div>