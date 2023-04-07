<?php

if( !USER_ADMIN && ADMIN_DEMO ){
	die();
}

?>

<div class="section">
	<?php
		if(!IMPORT_THUMB){
			show_alert('Import Thumbnails option must be activated!', 'warning');
			echo '<p>Import Thumbnails option located at Settings > Advanced.</p>';
		}
	?>
	<p>This plugin is used to import all external thumbnails to stored locally</p>
	<?php if(!isset($_POST['action'])){ ?>
	<form method="post" enctype="multipart">
		<input type="hidden" name="action" value="get_list">
		<button type="submit" class="btn btn-primary btn-md">Get List</button>
	</form>
	<div class="mb-5"></div>
	<h5>Generate small thumbanail only</h5>
	<form method="post" enctype="multipart">
		<input type="hidden" name="action" value="get_list_small">
		<button type="submit" class="btn btn-secondary btn-md">Get List</button>
	</form>
	<?php } elseif($_POST['action'] == 'get_list'){
		$conn = open_connection();
		$sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM games WHERE LEFT(thumb_1, 4) = :http LIMIT 20';
		$st = $conn->prepare($sql);
		$st->bindValue(":http", 'http', PDO::PARAM_STR);
		$st->execute();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		//
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query($sql)->fetch()[0];
		if(!$totalRows){
			echo('<h3>All game thumbnails already stored locally.</h3>');
		} else {
			$ids = [];
			echo '<h3>'.count($row).' of '.$totalRows.' games found!</h3>';
			?>
			<div class="mb-3"></div>
			<form method="post" enctype="multipart" id="form-import-thumb">
				<input type="hidden" name="action" value="get_list">
			<?php
			foreach($row as $game){
				$ids[] = $game['id'];
				?>
				<div class="form-check" id="<?php echo 'd_id-'.$game['id'] ?>">
					<input class="form-check-input" type="checkbox" name="game[]" value="<?php echo $game['id'] ?>" id="<?php echo 'g_id-'.$game['id'] ?>" checked>
					<label class="form-check-label" for="<?php echo 'g_id-'.$game['id'] ?>">
						<?php echo $game['source'].' > '.$game['title'] ?>
					</label>
				</div>
				<?php
			}
			?>	
				<div class="mb-3"></div>
				<?php if(IMPORT_THUMB){ ?>
				<button type="submit" class="btn btn-primary btn-md" id="btn-import-thumb">Import All</button>
				<?php } ?>
			</form>
			<div class="mt-4 d-none" id="thumb-import-status">(On progress) 10 / 100 imported</div>
			<button class="btn btn-primary btn-md mt-4 d-none" id="btn-reload">Reload</button>
			<?php
		}
	} elseif($_POST['action'] == 'get_list_small'){
		if(SMALL_THUMB){
			$conn = open_connection();
			$sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM games WHERE thumb_small = :str LIMIT 20';
			$st = $conn->prepare($sql);
			$st->bindValue(":str", '', PDO::PARAM_STR);
			$st->execute();
			$row = $st->fetchAll(PDO::FETCH_ASSOC);
			//
			$sql = "SELECT FOUND_ROWS() AS totalRows";
			$totalRows = $conn->query($sql)->fetch()[0];
			if(!$totalRows){
				echo('<h3>All games already have small thumbnail.</h3>');
			} else {
				$ids = [];
				echo '<h3>'.count($row).' of '.$totalRows.' games found!</h3>';
				?>
				<div class="mb-3"></div>
				<form method="post" enctype="multipart" id="form-import-thumb-small">
				<?php
				foreach($row as $game){
					$ids[] = $game['id'];
					?>
					<div class="form-check" id="<?php echo 'd_id-'.$game['id'] ?>">
						<input class="form-check-input" type="checkbox" name="game[]" value="<?php echo $game['id'] ?>" id="<?php echo 'g_id-'.$game['id'] ?>" checked>
						<label class="form-check-label" for="<?php echo 'g_id-'.$game['id'] ?>">
							<?php echo $game['source'].' > '.$game['title'] ?>
						</label>
					</div>
					<?php
				}
				?>	
					<div class="mb-3"></div>
					<?php if(IMPORT_THUMB){ ?>
					<button type="submit" class="btn btn-primary btn-md" id="btn-import-thumb">Generate All</button>
					<?php } ?>
				</form>
				<div class="mt-4 d-none" id="thumb-import-status">(On progress) 10 / 100 generated</div>
				<button class="btn btn-primary btn-md mt-4 d-none" id="btn-reload">Reload</button>
				<?php
			}
		} else {
			show_alert('Small Thumbnails option must be activated!', 'warning');
			echo '<p>Small Thumbnails option located at Settings > Advanced.</p>';
		}
	} ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn-reload').click(()=>{
			location.reload();
		});
		$( "#form-import-thumb" ).submit(function( event ) {
			event.preventDefault();
			let arr = $( this ).serializeArray();
			let list = [];
			let count = 0;
			let total = 0;
			arr.forEach((item)=>{
				if(item['name'] == 'game[]'){
					list.push(item.value);
				}
			});
			total = list.length;
			$('#thumb-import-status').removeClass('d-none');
			$('#thumb-import-status').text(count + '/' + total + ' imported');
			$('#btn-import-thumb').prop('disabled', true);
			$('#btn-import-thumb').text('IMPORTING...');
			pre_import();
			function pre_import(){
				if(list.length){
					import_thumb_plugin(list[0], 'import').then((res)=>{
						if(res == 'ok'){
							count++;
							$('#thumb-import-status').text(count + '/' + total + ' imported');
							$('#d_id-'+list[0]).remove();
							list.shift();
							pre_import();
						} else {
							console.log(res);
							$('#thumb-import-status').text('Failed to complete all request');
							alert('Failed!');
						}
					});
				} else {
					if(count){
						$('#btn-reload').removeClass('d-none');
						alert('Completed!');
					}
				}
			}
		});
		$( "#form-import-thumb-small" ).submit(function( event ) {
			event.preventDefault();
			let arr = $( this ).serializeArray();
			let list = [];
			let count = 0;
			let total = 0;
			arr.forEach((item)=>{
				if(item['name'] == 'game[]'){
					list.push(item.value);
				}
			});
			total = list.length;
			$('#thumb-import-status').removeClass('d-none');
			$('#thumb-import-status').text(count + '/' + total + ' generated');
			$('#btn-import-thumb').prop('disabled', true);
			$('#btn-import-thumb').text('IMPORTING...');
			pre_import();
			function pre_import(){
				if(list.length){
					import_thumb_plugin(list[0], 'generate-small').then((res)=>{
						if(res == 'ok'){
							count++;
							$('#thumb-import-status').text(count + '/' + total + ' generated');
							$('#d_id-'+list[0]).remove();
							list.shift();
							pre_import();
						} else {
							console.log(res);
							$('#thumb-import-status').text('Failed to complete all request');
							alert('Failed!');
						}
					});
				} else {
					if(count){
						$('#btn-reload').removeClass('d-none');
						alert('Completed!');
					}
				}
			}
		});
		function import_thumb_plugin(id, action){
			let wait = new Promise((res) => {
				$.ajax({
					url: '../content/plugins/thumbnail-importer/action.php',
					type: 'POST',
					dataType: 'json',
					data: {action: action, id: id},
					success: function (data) {
						//console.log(data.responseText);
					},
					error: function (data) {
						//console.log(data.responseText);
					},
					complete: function (data) {
						res(data.responseText);
					}
				});
			});
			return wait;
		}
	});
</script>