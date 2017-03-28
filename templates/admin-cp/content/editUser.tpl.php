<?php
//editUser.tpl.php
?>
<!-- //addUser.tpl.php -->
<!-- buyer.tpl.php -->
<div class="content-wrapper">
	<div class="content-header">
		<h1>
		Edit Users / Buyers
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
        <form method="post">
		
		<div class="row">
		<?php foreach($fields as $key=>$row) { ?>
		<div class="col-md-8 col-sm-12 form-group">
			<label class="col-md-4 col-sm-6"><?php echo $row[1]?></label>
			<div class="col-md-6 col-sm-6">
			<?php if($row[2]=="text") { ?> 
			<input type="text" name="<?php echo $row[0];?>" class="form-control"
			value="<?php echo $user_data['data'][$row[0]];?>"/>
			<?php } else if($row[2]=="file") { ?> 
			<input type="file" name="<?php echo $row[0];?>" class="form-control"/>
			<?php } else if($row[2]=="textarea") { ?>
			<textarea name="<?php echo $row[0] ?>" class="form-control"><?php echo $user_data['data'][$row[0]];?></textarea>
			<?php } else if($row[2]=="radio") { ?>
			<?php 
				for($i=3;$i<count($row);$i++) {

				echo "<label><input type='radio' name='{$row[0]}' value='$row[$i]'";
				echo $user_data['data'][$row[0]]==$row[$i]?"checked":'';
				echo "> ".$row[$i]."</label><br/>";
				} 
			?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
		<ul>
		<?php foreach($errors as $key=>$val) { ?>
				<li><?php echo $val;?></li>
		<?php } ?>
		</ul>
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
        
        </div>
        </form>
	</section>
	</div>
</div>