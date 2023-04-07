<?php
	if(isset($_GET['status'])){
		$class = 'alert-success';
		$message = '';
		if($_GET['status'] == 'deleted'){
			$message = 'Backup file removed!';
		} elseif($_GET['status'] == 'restored'){
			$message = 'CMS restored!';
		}
		echo '<div class="alert '.$class.' alert-dismissible fade show" role="alert">'.$message.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	}
?>
<div class="section">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>File</th>
					<th>Size</th>
					<th>Created</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				<?php

				if(file_exists( ABSPATH . 'admin/backups' )){
					$files = scandir( ABSPATH . 'admin/backups' );
					$files = array_diff($files, array('.', '..'));
					$index = 0;
					foreach ($files as $file) {
						if(strtolower(pathinfo($file,PATHINFO_EXTENSION)) === 'zip'){
							$index++;
							?>
							<tr>
								<td scope="row"><?php echo $index ?></td>
								<td><?php echo substr($file, 0, -15) ?></td>
								<td><?php echo round(filesize('backups/'.$file)/1000) ?> KB</td>
								<td><?php echo date("F d Y H:i:s", filemtime('backups/'.$file)) ?></td>
								<td>
									<span class="actions">
										<a class="download" href="backups/<?php echo $file ?>" data-toggle="tooltip" data-placement="top" title="Download this backup file"><i class="fa fa-download circle text-success" aria-hidden="true"></i></a>
										<a class="restore" href="#" data-url="<?php echo DOMAIN . PLUGIN_PATH ?>backup-restore/action.php?action=restore&name=<?php echo $file ?>" data-toggle="tooltip" data-placement="top" title="Restore this backup file"><i class="fa fa-sync-alt circle" aria-hidden="true"></i></a>
										<a class="delete" href="#" data-url="<?php echo DOMAIN . PLUGIN_PATH ?>backup-restore/action.php?action=delete&name=<?php echo $file ?>"><i class="fa fa-trash circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete this backup file"></i></a>
									</span>
								</td>
							</tr>
							<?php
						}
					}
				}

				?>
			</tbody>
		</table>
	</div>
	<button onclick="backup_site('type=part')" class="btn btn-primary btn-md">Backup</button>
	<button onclick="backup_site('type=full')" class="btn btn-primary btn-md">Full Backup</button>

	<div class="bs-callout bs-callout-warning">Database is not backed up. <a href="https://cloudarcade.net/tutorial/how-to-backup-your-database/" target="_blank">How to backup your database?</a></div>
	<div class="bs-callout bs-callout-info">Backup: Smaller file size, ignoring games, thumbnails and vendor folder.</div>
</div>
<script type="text/javascript">
	function backup_site(params){
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../content/plugins/backup-restore/backup.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onload = function() {
			if (xhr.status === 200) {
				console.log(xhr.responseText);
				if(xhr.responseText != 'success'){
					alert('Error! open console log for more info!');
				} else {
					location.reload();
				}
			}
			else {
				alert('failed!');
			}
		}.bind(this);
		xhr.send(params);
	}
	$(document).ready(function(){
		$('.restore').on('click', function(e){
			e.preventDefault();
			if(confirm('Do you want to restore this Backup file ? this action can\'t be undo.')){
				location.href = $(this).data('url');
			}
		});
		$('.delete').on('click', function(e){
			e.preventDefault();
			if(confirm('Do you want to delete this Backup file ? this action can\'t be undo.')){
				location.href = $(this).data('url');
			}
		});
	});
</script>