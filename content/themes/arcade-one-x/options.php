<?php

$path = TEMPLATE_PATH . '/css/skin/';

$files = scan_files($path);
$styles = [];

if(isset($_POST['action'])){
	if($_POST['action'] == 'select-skin'){
		update_option('arcade-one-skin', $_POST['style']);
		show_alert('SAVED!', 'success');
	} elseif($_POST['action'] == 'update-icons-data'){
		file_put_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json', $_POST['data']);
		show_alert('SAVED!', 'success');
	}
}

$category_icons = json_decode( file_get_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json'), true);

foreach($files as $filename){
	$base = basename($filename);
	if(substr($base, -4) == '.css'){
		array_push($styles, substr($base, 0, -4));
	}
}

$selected_skin = get_option('arcade-one-skin');
if(!$selected_skin){
	$selected_skin = 'default';
}

echo '<h4>'._t('Select Theme Skin').'</h4>';
echo '<br>';
echo '<form method="post">';
echo '<input type="hidden" name="action" value="select-skin"/>';
foreach($styles as $style){
	$checked = '';
	if($style == $selected_skin){
		$checked = 'checked';
	}
	?>
	<div class="form-check">
		<input class="form-check-input" type="radio" name="style" value="<?php echo $style ?>" id="<?php echo $style ?>" <?php echo $checked ?>>
		<label class="form-check-label" for="<?php echo $style ?>">
			<?php echo $style ?>
		</label>
	</div>
	<?php
}
echo '<br>';
echo '<button type="submit" class="btn btn-primary btn-md">'._t('SAVE').'</button>';
echo '</form>';

?>
<br>
<h4>Category Icons</h4>
<br>
<form method="post" id="form-icons">
	<input type="hidden" name="action" value="update-icons-data" />
	<input type="hidden" id="data-target" name="data" value="" />
	<div class="row">
		<div class="col">
			<label>ID:</label>
		</div>
		<div class="col">
			<label>Category Slug (separated by comma):</label>
		</div>
	</div>
	<?php
	foreach ($category_icons as $key => $value) {
		?>
		<div class="row">
			<img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $key; ?>.svg">
			<div class="form-group col">
				<input type="text" class="form-control t-key" name="val" value="<?php echo $key ?>" readonly required>
			</div>
			<div class="form-group col">
				<input type="text" class="form-control t-value" name="val" value="<?php echo implode(',', $value); ?>" required>
			</div>
		</div>
		<?php
	}
	?>
</form>
<button id="save-icon-conf" class="btn btn-primary btn-md">Save</button>
<script type="text/javascript">
	$(document).ready(()=>{
		$('#save-icon-conf').click(()=>{
			if(true){
				let res = '{';
				let error;
				let t1 = $('.t-key').serializeArray();
				let t2 = $('.t-value').serializeArray();
				let total = t1.length;
				for(let i=0; i<total; i++){
					if(t1[i].value && t2[i].value){
						res += '"'+t1[i].value+'"'+': '+JSON.stringify(t2[i].value.split(','))+',';
					}
				}
				if(res.slice(-1) === ','){
					res = res.slice(0, -1);
				}
				res += '}';
				let x = JSON.parse(res);
				if(res !=  '{}'){
					$('#data-target').val(res);
					$('form#form-icons').submit();
				}
			}
		});
	});
</script>