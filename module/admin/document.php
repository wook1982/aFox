<?php
	if(!defined('__AFOX__')) exit();

	$search = empty($_DATA['search'])?null:'%'.$_DATA['search'].'%';
	$doc_list = getDBList(_AF_DOCUMENT_TABLE_,[
		'md_id{<>}'=>'_AFOXtRASH_',
		'OR' =>empty($search)?[]:['wr_title{LIKE}'=>$search, 'wr_content{LIKE}'=>$search]
	],'wr_regdate desc', empty($_DATA['page']) ? 1 : $_DATA['page'], 20);
?>

<table class="table table-hover table-nowrap">
<thead class="table-nowrap">
	<tr>
		<th class="col-xs-1">#<?php echo getLang('board')?></th>
		<th><?php echo getLang('title')?></th>
		<th class="col-xs-1"><?php echo getLang('status')?></th>
		<th class="col-xs-1 hidden-xs hidden-sm"><?php echo getLang('secret')?></th>
		<th class="col-xs-1"><?php echo getLang('author')?></th>
		<th class="col-xs-1"><?php echo getLang('date')?></th>
	</tr>
</thead>
<tbody>

<?php
	$end_page = $total_page = 0;
	$start_page = $current_page = 1;

	if(!empty($doc_list['error'])) {
		echo showMessage($doc_list['message'], $doc_list['error']);
	} else {
		$current_page = $doc_list['current_page'];
		$total_page = $doc_list['total_page'];
		$start_page = $doc_list['start_page'];
		$end_page = $doc_list['end_page'];

		foreach ($doc_list['data'] as $key => $value) {
			echo '<tr class="afox-list-item" data-exec-ajax="board.getDocument" data-ajax-param="wr_srl,'.$value['wr_srl'].',with_module_config,1,with_file_list,1" data-modal-target="#document_modal"><th scope="row">'.$value['md_id'].'</th>';
			echo '<td>'.escapeHtml(cutstr(strip_tags($value['wr_title']),50)).(empty($value['wr_reply'])?'':' (<small>'.$value['wr_reply'].'</small>)').'</td>';
			echo '<td>'.($value['wr_status']?$value['wr_status']:'-').'</td>';
			echo '<td class="hidden-xs hidden-sm">'.($value['wr_secret']?'Y':'N').'</td>';
			echo '<td>'.escapeHtml($value['mb_nick'],true).'</td>';
			echo '<td>'.date('Y/m/d', strtotime($value['wr_regdate'])).'</td></tr>';
		}
	}
?>

</tbody>
</table>

<nav class="navbar clearfix">
	<ul class="pager visible-xs-block visible-sm-block">
		<li class="previous<?php echo $current_page <= 1?' disabled':''?>"><a href="<?php echo  $current_page <= 1 ? '#" onclick="return false' : getUrl('page',$current_page-1)?>" aria-label="Previous"><span aria-hidden="true">&lsaquo;</span> <?php echo getLang('previous') ?></a></li>
		<li><span class="col-xs-5"><?php echo $current_page.' / '.$total_page?></span></li>
		<li class="next<?php echo $current_page >= $total_page?' disabled':''?>"><a href="<?php echo $current_page >= $total_page ? '#" onclick="return false' : getUrl('page',$current_page+1)?>" aria-label="Next"><?php echo getLang('next') ?> <span aria-hidden="true">&rsaquo;</span></a></li>
	</ul>
	<ul class="pagination hidden-xs hidden-sm pull-right">
		<?php if($start_page>10) echo '<li><a href="'.getUrl('page',$start_page-10).'">&laquo;</a></li>'; ?>
		<li<?php echo $current_page <= 1 ? ' class="disabled"' : ''?>><a href="<?php echo  $current_page <= 1 ? '#" onclick="return false' : getUrl('page',$current_page-1)?>" aria-label="Previous"><span aria-hidden="true">&lsaquo;</span></a></li>
		<?php for ($i=$start_page; $i <= $end_page; $i++) echo '<li'.($current_page == $i ? ' class="active"' : '').'><a href="'.getUrl('page',$i).'">'.$i.'</a></li>'; ?>
		<li<?php echo $current_page >= $total_page ? ' class="disabled"' : ''?>><a href="<?php echo $current_page >= $total_page ? '#" onclick="return false' : getUrl('page',$current_page+1)?>" aria-label="Next"><span aria-hidden="true">&rsaquo;</span></a></li>
		<?php if(($total_page-$end_page)>0) echo '<li><a href="'.getUrl('page',$end_page+1).'">&raquo;</a></li>'; ?>
	</ul>
	<ul class="pagination">
	<li><form class="form-inline search-form" action="<?php echo getUrl('') ?>" method="get">
		<input type="hidden" name="admin" value="<?php echo $_DATA['admin'] ?>">
		<input type="text" name="search" value="<?php echo empty($_DATA['search'])?'':$_DATA['search'] ?>" class="form-control" placeholder="<?php echo getLang('search_text') ?>" required>
		<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search" aria-hidden="true"></i> <?php echo getLang('search') ?></button>
		<?php if(!empty($_DATA['search'])) {?><button class="btn btn-default" type="button" onclick="location.replace('<?php echo getUrl('search','') ?>')"><?php echo getLang('cancel') ?></button><?php }?>
	</form></li>
	</ul>
</nav>

<div id="document_modal" class="modal fade bs-admin-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
	<form class="modal-content" onsubmit="return false" method="post" autocomplete="off">
	<input type="hidden" name="success_return_url" value="<?php echo getUrl()?>" />
	<input type="hidden" name="md_id" value="" />
	<input type="hidden" name="wr_srl" value="" />

	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel"><?php echo getLang('document')?></h4>
	  </div>
	  <div class="modal-body">
		<div class="form-group" style="display:none">
			<select name="wr_category" class="form-control">
			<option value=""><?php echo getLang('category')?></option>
			</select>
		</div>
		<div class="form-group">
			<label for="id_wr_title"><?php echo getLang('title')?></label>
			<input type="text" name="wr_title" class="form-control" id="id_wr_title" maxlength="255">
		</div>
		<div class="form-group">
			<?php dispEditor(
					'wr_content',
					'',
					[
						'file'=>[99999,'',0],
						'toolbar'=>array(getLang('content'), ['wr_type'=>['1', ['TEXT'=>'0','MKDW'=>'1','HTML'=>'2']],'wr_secret'=>[false,'Secret']])
					]
				);
			?>
		</div>
	  </div>
	  <div class="modal-footer clearfix">
		<button type="button" class="btn btn-warning pull-left" data-act-change="board.deleteDocument"><?php echo getLang('recycle_bin')?></button>
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getLang('close')?></button>
		<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i> <?php echo getLang('save')?></button>
	  </div>
	</form>
  </div>
</div>

<?php
/* End of file document.php */
/* Location: ./module/admin/document.php */