<?php
	if(!defined('__AFOX__')) exit();
	$is = !empty($DOC);
	$is_manager = isManager(__MID__);
?>

<section id="bdDelete">
	<header>
		<h3 class="clearfix">
			<span class="pull-left"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> <?php echo getLang('delete')?></span>
			<a class="close" href="<?php echo getUrl('disp','')?>"><span aria-hidden="true">×</span></a>
		</h3>
		<hr class="divider">
	</header>
	<article>
		<form method="post" autocomplete="off" data-exec-ajax="board.deleteDocument">
		<input type="hidden" name="success_return_url" value="<?php echo getUrl('disp','','srl','','cpage','','rp','')?>" />
		<input type="hidden" name="wr_srl" value="<?php echo $is?$DOC['wr_srl']:''?>" />
			<div>
			<?php if (empty($_MEMBER) || (!$is_manager&&empty($DOC['mb_srl']))) { ?>
				<div class="form-group">
					<label for="id_mb_password"><?php echo getLang('password')?></label>
					<input type="password" name="mb_password" class="form-control" id="id_mb_password" required>
				</div>
			<?php } ?>
				<div class="form-group">
					<label for="id_wr_title"><?php echo getLang('title')?></label>
					<input type="text" class="form-control" id="id_wr_title" value="<?php echo $is?escapeHtml($DOC['wr_title']):''?>" readonly="readonly">
				</div>
				<div class="form-group">
					<label for="id_wr_content"><?php echo getLang('content')?></label>
					<textarea class="form-control mh-20 vresize" id="id_wr_content" readonly="readonly"><?php echo $is?$DOC['wr_content']:''?></textarea>
				</div>
				<div class="area-button">
					<button type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> <?php echo getLang('delete')?></button>
				</div>
			</div>
		</form>
	</article>
</section>
