<?php

require_once($plugin['path'].'/Post.php');

$edit_mode = false;
$post_data = null;
$action = 'list';
if(isset($_GET['action'])){
	$action = $_GET['action'];
}
if(isset($_GET['edit_id']) && $action == 'edit'){
	$post_data = Post::getById($_GET['edit_id']);
	if($post_data){
		$edit_mode = true;
	} else {
		echo 'Post ID not exist or missing!';
		return;
	}
}
if(isset($_GET['status'])){
	if($_GET['status'] == 'new'){
		show_alert('New post published!', 'success', true);
	} else if($_GET['status'] == 'updated'){
		show_alert('Post updated!', 'success', true);
	} else if($_GET['status'] == 'deleted'){
		show_alert('Post deleted!', 'warning', true);
	}
}
?>

<?php if($action == 'new-post' || ($action == 'edit' && $edit_mode)) { ?>
<link rel="stylesheet" href="../content/plugins/posts/css/codemirror.min.css">
<!-- KaTeX -->
<link rel="stylesheet" href="../content/plugins/posts/css/katex.min.css">
<link href="../content/plugins/posts/css/suneditor.min.css" rel="stylesheet">
<script src="../content/plugins/posts/js/suneditor.min.js"></script>
<!-- codeMirror -->
<script src="../content/plugins/posts/js/codemirror.min.js"></script>
<script src="../content/plugins/posts/js/htmlmixed.js"></script>
<script src="../content/plugins/posts/js/xml.js"></script>
<script src="../content/plugins/posts/js/css.js"></script>
<!-- KaTeX -->
<script src="../content/plugins/posts/js/katex.min.js"></script>
<style type="text/css">
	.sun-editor {
		font-family: inherit;
	}
</style>
<?php } ?>

<div class="section">
	<?php if($action == 'new-post'){ ?>
		<?php
		$results = array();
		$results['post'] = new Post;
		?>
		<h2><?php _e('New Post') ?></h2>
		<div class="mb-4"></div>
		<form id="plugin-form-newpost" method="post">
			<input type="hidden" name="postId" value="<?php echo esc_int($results['post']->id) ?>"/>
			<div class="form-group">
				<label for="title"><?php _e('Post Title') ?>:</label>
				<input type="text" class="form-control" id="newposttitle" name="title" placeholder="Name of the post" required autofocus maxlength="255" value=""/>
			</div>
			<div class="form-group">
				<label for="slug"><?php _e('Post Slug') ?>:</label>
				<input type="text" class="form-control" id="newpostslug" name="slug" placeholder="Post url ex: this-is-sample-post" required autofocus maxlength="255" value=""/>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label for="thumb"><?php _e('Post Thumbail') ?>:</label>
						<input type="text" class="form-control" id="postthumb" name="thumb" placeholder="https://domain.com/media/post-img.jpg" autofocus maxlength="255" />
					</div>
					<div class="col-md-6">
						<label><?php _e('Or upload Image') ?></label>
						<input type="file" class="form-control-file" id="image-file" accept=".png, .jpg, .jpeg, .gif">
					</div>
				</div>
			</div>
			<div class="form-group">
				<img id="preview-thumbnail" src="<?php echo DOMAIN ?>images/post-no-thumb.png" style="max-height: 120px;">
			</div>
			<div class="form-group">
				<label for="content"><?php _e('Content') ?>:</label>
				<textarea class="form-control" name="content" id="p-content"></textarea>
			</div>
			<div class="form-group">
				<label for="title"><?php _e('Created Date') ?>:</label>
				<input type="date" class="form-control" name="created_date" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo date( "Y-m-d" ); ?>" />
			</div>
			<input type="submit" class="btn btn-primary"  name="saveChanges" value="<?php _e('Publish') ?>" />
		</form>
		<br>
		<p>
			<div class="bs-callout bs-callout-info">You can upload image with Editor</div>
		</p>
		<p>
			WYSIWYG editor by <a href="https://github.com/JiHong88/SunEditor" target="_blank">SunEditor</a>
		</p>
	<?php } else if($action == 'edit' && $edit_mode){ ?>
		<h2><?php _e('Edit Post') ?></h2>
		<div class="mb-4"></div>
		<form id="plugin-form-editpost" method="post">
			<input type="hidden" name="id" value="<?php echo esc_int($post_data->id) ?>"/>
			<div class="form-group">
				<label for="title"><?php _e('Post Title') ?>:</label>
				<input type="text" class="form-control" id="newposttitle" name="title" placeholder="Name of the post" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $post_data->title )?>"/>
			</div>
			<div class="form-group">
				<label for="slug"><?php _e('Post Slug') ?>:</label>
				<input type="text" class="form-control" id="newpostslug" name="slug" placeholder="Post url ex: this-is-sample-post" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $post_data->slug )?>"/>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label for="thumb"><?php _e('Post Thumbail') ?>:</label>
						<input type="text" class="form-control" id="postthumb" name="thumb" placeholder="https://domain.com/media/post-img.jpg" autofocus maxlength="255" value="<?php echo htmlspecialchars( $post_data->thumbnail_url )?>" />
					</div>
					<div class="col-md-6">
						<label><?php _e('Or upload Image') ?></label>
						<input type="file" class="form-control-file" id="image-file" accept=".png, .jpg, .jpeg, .gif">
					</div>
				</div>
			</div>
			<div class="form-group">
				<img id="preview-thumbnail" src="<?php echo DOMAIN ?>images/post-no-thumb.png" style="max-height: 120px;">
			</div>
			<div class="form-group">
				<label for="content"><?php _e('Content') ?>:</label>
				<textarea class="form-control" name="content" id="p-content"><?php echo $post_data->content ?></textarea>
			</div>
			<div class="form-group">
				<label for="title"><?php _e('Created Date') ?>:</label>
				<input type="date" class="form-control" name="created_date" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo date( "Y-m-d", $post_data->created_date ); ?>" />
			</div>
			<input type="submit" class="btn btn-primary"  name="saveChanges" value="<?php _e('Save') ?>" />
		</form>
		<br>
		<p>
			<div class="bs-callout bs-callout-info">You can upload image with Editor</div>
		</p>
		<p>
			WYSIWYG editor by <a href="https://github.com/JiHong88/SunEditor" target="_blank">SunEditor</a>
		</p>
	<?php } else if($action == 'list'){ ?>
		<a href="dashboard.php?viewpage=plugin&name=posts&action=new-post">
			<button class="btn btn-primary btn-md"><?php _e('New Post') ?></button>
		</a>
		<table class="table table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th><?php _e('Title') ?></th>
				<th><?php _e('Created') ?></th>
				<th><?php _e('Slug') ?></th>
				<th><?php _e('URL') ?></th>
				<th><?php _e('Action') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$results = array();
			$data = Post::getList();
			$results['posts'] = $data['results'];
			$results['totalRows'] = $data['totalRows'];
			$index = 0;
			foreach ( $results['posts'] as $post ) {
				$index++;
				?>
			<tr>
				<th scope="row"><?php echo esc_int($index); ?></th>
				<td>
					<?php echo esc_string($post->title)?>
				</td>
				<td>
					<?php echo date('j M Y', $post->created_date) ?>
				</td>
				<td>
					<?php echo esc_string($post->slug)?>
				</td>
				<td><a href="<?php echo get_permalink('post', $post->slug) ?>" target="_blank"><?php _e('Visit') ?></a></td>
				<td><span class="actions"><a class="editpost" href="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=plugin&name=posts&action=edit&edit_id=<?php echo esc_int($post->id)?>"><i class="fa fa-pencil-alt circle" aria-hidden="true"></i></a><a class="deletepost" href="#" id="<?php echo esc_int($post->id)?>"><i class="fa fa-trash circle" aria-hidden="true"></i></a></span></td>
			</tr>
			<?php } ?>
		</tbody>
		</table>
		<p><?php _e('%a posts in total.', esc_int($results['totalRows'])) ?></p>
	<?php } ?>
</div>

<script type="text/javascript">
	if(document.getElementById("image-file")){
		document.getElementById("image-file").onchange = function() {
			let fd = new FormData();
			fd.append('action', 'upload_image');
			let files = $('#image-file')[0].files[0];
			fd.append('file-0', files);
			$.ajax({
				url: 'includes/ajax-actions.php',
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false,
				success: function(response){
					let data = JSON.parse(response);
					if(data.result){
						$('#postthumb').val(data.result[0].url);
						$('#preview-thumbnail').attr("src", $('#postthumb').val());
					} else {
						console.log(data);
						alert('Failed to upload. Check console')
					}
				},
			});
		};
	}
	var sun_editor;
	$(document).ready(()=>{
		if($('#postthumb').val()){
			$('#preview-thumbnail').attr("src", $('#postthumb').val());
		}
		if(typeof(SUNEDITOR) != 'undefined'){
			sun_editor = SUNEDITOR.create('p-content', {
				display: 'block',
				width: '100%',
				height: 'auto',
				font: ['Poppins'],
				minHeight: '400px',
				popupDisplay: 'full',
				charCounter: true,
				charCounterLabel: 'Characters :',
				buttonList: [
			        ['undo', 'redo',
			        'font', 'fontSize', 'formatBlock',
			        'paragraphStyle', 'blockquote',
			        'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript',
			        'fontColor', 'hiliteColor', 'textStyle',
			        'removeFormat',
			        'outdent', 'indent',
			        'align', 'horizontalRule', 'list', 'lineHeight',
			        'table', 'link', 'image', 'video', 'audio', /** 'math', */ // You must add the 'katex' library at options to use the 'math' plugin.
			        /** 'imageGallery', */ // You must add the "imageGalleryUrl".
			        'fullScreen', 'showBlocks', 'codeView',
			        'preview']
			    ],
			    imageUploadUrl: 'includes/ajax-actions.php?action=upload_image',
			    imageMultipleFile: false,
			    imageAccept: '.jpg, .png, .jpeg, .gif',
				placeholder: 'Start typing something...',
				codeMirror: CodeMirror,
				katex: katex
			});
		}
		//
		$( "form" ).submit(function( event ) {
			let arr = $( this ).serializeArray();
			if($(this).attr('id') === 'plugin-form-newpost'){
				event.preventDefault();
				let content = sun_editor.getContents(true);
				if(content){
					let data = {
						action: 'newPost',
						title: get_value(arr, 'title'),
						slug: (get_value(arr, 'slug').toLowerCase()).replace(/\s+/g, "-"),
						thumbnail_url: get_value(arr, 'thumb'),
						created_date: get_value(arr, 'created_date'),
						content: content,
					}
					sendPostAction(data, true);
				} else {
					alert('Post content cannot be blank');
				}
			} else if($(this).attr('id') === 'plugin-form-editpost'){
				event.preventDefault();
				let content = sun_editor.getContents(true);
				let data = {
					action: 'editPost',
					title: get_value(arr, 'title'),
					slug: (get_value(arr, 'slug').toLowerCase()).replace(/\s+/g, "-"),
					thumbnail_url: get_value(arr, 'thumb'),
					id: get_value(arr, 'id'),
					created_date: get_value(arr, 'created_date'),
					content: content,
				}
				sendPostAction(data, true);
			}
		});
		function get_value(arr, key){
			for(let i=0; i<arr.length; i++){
				if(arr[i].name === key){
					return arr[i].value;
				}
			}
		}
		function sendPostAction(data, reload, action, id){
			$.ajax({
				url: '<?php echo DOMAIN . PLUGIN_PATH . "posts/action.php" ?>',
				type: 'POST',
				dataType: 'json',
				data:data,
				success: function (data) {
					//console.log(data.responseText);
				},
				error: function (data) {
					//console.log(data.responseText);
				},
				complete: function (data) {
					console.log(data.responseText);
					if(reload){
						if(data.responseText == 'newPost'){
							window.location = 'dashboard.php?viewpage=plugin&name=posts&status=new';
						} else if(data.responseText == 'editPost'){
							window.location = 'dashboard.php?viewpage=plugin&name=posts&status=updated';
						} else if(data.responseText == 'deletePost'){
							window.location = 'dashboard.php?viewpage=plugin&name=posts&status=deleted';
						} else {
							location.reload();
						}
					}
				}
			});
		}
		$( "#newposttitle" ).click(function() {
			let parent = $( "#newposttitle" );
			parent.change(function(){
				$( "#newpostslug" ).val((parent.val().toLowerCase()).replace(/\s+/g, "-"));
			});
		});
		$( "#postthumb" ).change(function() {
			$('#preview-thumbnail').attr("src", $(this).val());
		});
		$( ".deletepost" ).click(function() {
			let id = $(this).attr('id');
			if(confirm('Are you sure want to delete this post ?')){
				let data = {
					action: 'deletePost',
					id: id,
				}
				sendPostAction(data, true);
			}
		});
		<?php
			if($edit_mode){ ?>
				$('#trigger-edit').click();
			<?php }
		?>
	});
</script>