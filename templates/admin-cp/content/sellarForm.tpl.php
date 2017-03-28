<?php
//sellarForm.tpl.php
?>
	<form method="post">
		<div class="row">
		<?php foreach($fields as $key=>$row) { ?>
		<div class="col-md-8 col-sm-12 form-group">
			<label class="col-md-4 col-sm-6">
			<?php echo ucfirst(str_replace("_"," ",$row[0]))?></label>
			<div class="col-md-6 col-sm-6">
			<?php if($row[2]=="text") { ?> 
			<input type="text" name="<?php echo $row[0];?>" class="form-control"
			value="<?php echo isset($user_data)?$user_data['data'][$row[0]]:$input->get($row[0]);?>"/>
			<!--  -->
			<?php } else if($row[2]=="file") { ?> 
			<input type="file" name="<?php echo $row[0];?>" class="form-control"/>
			<?php } else if($row[2]=="textarea") { ?>
			<textarea name="<?php echo $row[0] ?>" class="form-control"><?php echo $input->get($row[0]);?></textarea>
			<?php } else if($row[2]=="radio") { ?>
			<?php 
				for($i=3;$i<count($row);$i++) {
					echo "<label><input type='radio' name='{$row[0]}' value='$row[$i]'> ".$row[$i]."</label><br/>";
				}

			?>
			<?php
				}
				if(isset($errors[$row[0]])){
					echo '<span class="errors">'.$errors[$row[0]].'</span>';
				}
			?>
			</div>
		</div>
		<?php } ?>
		<div class="alert">
		<ul class="errors">
		<?php foreach($errors as $key=>$val) { ?>
				<!-- <li><?php //echo $val;?></li> -->
		<?php } ?>