<?php
if(!defined('__AFOX__')) exit();

function proc($data) {
	// 권한 체크
	if(!isGrant('list', $data['id']) && !isManager($data['id'])) {
		return set_error(getLang('error_permitted'),4501);
	}

	$search = empty($data['combine']) ? '' : $data['combine'];
	$page = empty($data['page']) ? 1 : $data['page'];

	$_mids = [];
	$_count = 20;
	$_this = getModule('search');

	if(!empty($_this)) {
		$_mids = empty($_this['md_extra'])?[]:unserialize($_this['md_extra']);
		if(!empty($_mids)) $_mids = $_mids['md_ids'];
		$_count = empty($_this['md_list_count'])?20:$_this['md_list_count'];
	}

	$schs = [];
	if(!empty($search)) {
		$schkeys = ['title'=>'wr_title','content'=>'wr_content','nick'=>'mb_nick','tag'=>'wr_tags','date'=>'wr_regdate'];
		$ss = explode(':', $search);
		if(count($ss)>1 && !empty($schkeys[$ss[0]])) {
			$search = trim(implode(':', array_slice($ss,1)));
			if(!empty($search)) $schs = [$schkeys[$ss[0]].'{LIKE}'=>($ss[0]==='date'?'':'%').$search.'%'];
		} else {
			$schs = ['wr_title{LIKE}'=>'%'.$search.'%', 'wr_content{LIKE}'=>'%'.$search.'%'];
		}
	}

	$_wheres = [
		'md_id{IN}'=>implode(',', $_mids),
		'(_OR_)' =>$schs
	];

	//if(count($wheres)) $_wheres = array_merge($_wheres, $wheres);

	$_list = DB::gets(_AF_DOCUMENT_TABLE_, 'SQL_CALC_FOUND_ROWS *', $_wheres, 'md_id,wr_regdate', (($page-1)*$_count).','.$_count);
	return setDataListInfo($_list, $page, $_count, DB::foundRows());
}

/* End of file default.php */
/* Location: ./module/search/disp/default.php */
