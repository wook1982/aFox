<?php
if(!defined('__AFOX__')) exit();
?>

<article class="clearfix">

	<?php
		$current_page = $_{'board'}['current_page'];
		$total_page = $_{'board'}['total_page'];
		$start_page = $_{'board'}['start_page'];
		$end_page = $_{'board'}['end_page'];
		$srl = empty($_DATA['srl'])?0:$_DATA['srl'];
		$_tmp = '<i class="glyphicon glyphicon-lock" aria-hidden="true"></i> ';

		$is_manager = isManager($_DATA['id']);
		$login_srl = empty($_MEMBER['mb_srl']) ? false : $_MEMBER['mb_srl'];

		$box_items = [false=>'',true=>''];
		$_tmp_image = _AF_URL_.'common/img/no_image.png';
		$_required_extras = [];

		// 확장변수가 있으면 필수만 골라냄
		if (!empty($_CFG['md_extra']['keys'])) {
			foreach($_CFG['md_extra']['keys'] as $ex_key=>$ex_caption){
				if(substr($ex_caption,-1,1) === '*') $_required_extras[] = $ex_key;
			}
		}

		foreach ($_{'board'}['data'] as $key => $val) {
			$wr_secret =  $val['wr_secret'] == '1';
			$wr_permit = !$wr_secret || $is_manager || $login_srl === $value['mb_srl'];

			$_image = DB::get('SELECT mf_srl FROM '._AF_FILE_TABLE_.' WHERE md_id=:1 AND mf_target=:2 AND mf_type LIKE "image%"', [$_DATA['id'],$val['wr_srl']]);
			$wr_extra_vars = '';

			if (count($_required_extras) > 0) {
				foreach($_required_extras as $ex_key){
					$wr_extra_vars .= '<div class="wr_extra_area"><strong>'.substr($_CFG['md_extra']['keys'][$ex_key],0,-1).':</strong> <span>'.$val['wr_extra']['vars'][$ex_key].'</span></div>';
				}
			}

			$box_items[true] = '<a href="'.(!$wr_permit&&$wr_secret?'#requirePassword" data-srl="'.$val['wr_srl'].'" data-param="srl,'.$val['wr_srl']:getUrl('srl',$val['wr_srl'],'disp','','cpage','','rp','')).'"><div class="img-container" style="background-image: url(\''.(empty($_image['mf_srl'])?$_tmp_image:_AF_URL_.'?file='.$_image['mf_srl'].'&thumb').'\')"></div></a>';
			$box_items[false] = '<h3 class="text-ellipsis"><a href="'.(!$wr_permit&&$wr_secret?'#requirePassword" data-srl="'.$val['wr_srl'].'" data-param="srl,'.$val['wr_srl']:getUrl('srl',$val['wr_srl'],'disp','','cpage','','rp','')).'"'.($val['wr_srl']==$srl?' class="active"':'').'>'.($wr_secret?$_tmp:'').escapeHtml($val['wr_title'], true).'</a>'.($val['wr_reply']>0?' <small>(+'.$val['wr_reply'].')</small>':'').'</h3>';
			$box_items[false] .= '<div class="author clearfix"><span class="mb_nick pull-left" data-srl="'.$val['mb_srl'].'" data-rank="'.(ord($val['mb_rank']) - 48).'">'.$val['mb_nick'].'</span><span class="pull-right">'.date('Y/m/d', strtotime($val['wr_update'])).'</span></div>'.$wr_extra_vars.'<div class="wr_content">'.cutstr(!$wr_permit&&$wr_secret?getLang('msg_is_secret'):toTEXT($val['wr_content']), __MOBILE__?100:300).'</div>';
			?>

			<div class="item_area<?php echo (__MOBILE__?' mobile':'').($val['wr_srl']==$srl?' active':'') ?> clearfix">
				<div class="pull-left">
					<?php echo $box_items[true] ?>
				</div>
				<div class="pull-right">
					<?php echo $box_items[false] ?>
				</div>
			</div>

			<?php
		}
	?>

</article>
