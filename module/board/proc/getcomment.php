<?php

if(!defined('__AFOX__')) exit();

function proc($data) {
	if(!isset($data['rp_srl'])) return set_error(getLang('error_request'),4303);
	global $_MEMBER;

	$field = '*';
	$default_field = 'rp_srl,wr_srl,rp_secret,mb_srl,mb_password';

	// 요청값이 있으면 요청값만 보냄
	$response_tags = $data['response_tags'];
	if(!empty($response_tags) && count($response_tags) > 0) {
		$field = $default_field.','.implode(',', $response_tags);
	}

	$cmt = getComment($data['rp_srl'], $field);
	if(!empty($cmt['error'])) {
		return set_error($cmt['message'],$cmt['error']);
	} else if(empty($cmt['rp_srl'])) {
		return set_error(getLang('error_founded'),4201);
	}

	$doc = getDocument($cmt['wr_srl'], 'md_id,wr_srl,wr_secret,wr_title,mb_srl,wr_updater');
	if(!empty($doc['error'])) {
		return set_error($doc['message'],$doc['error']);
	} else if(!isGrant('view', $doc['md_id'])) {
		return set_error(getLang('error_permitted'),4501);
	}

	// 비밀글이면
	if($doc['wr_secret'] == '1' && !isManager($doc['md_id'])) {
		// 권한 체크
		return set_error(getLang('error_permitted'),4501);
	}

	// 비밀글이면
	if($cmt['rp_secret'] == '1' && !isManager($doc['md_id'])) {
		// 권한 체크
		if(empty($_MEMBER) || empty($cmt['mb_srl'])) {
			if(empty($data['mb_password'])) {
				return set_error(getLang('request_input', ['password']),1);
			}
			if (empty($cmt['mb_password']) || !checkPassword($data['mb_password'], $cmt['mb_password'])) {
				return set_error(getLang('error_permitted'),4501);
			}
		} else if($_MEMBER['mb_srl'] != $cmt['mb_srl']) {
			return set_error(getLang('error_permitted'),4501);
		}
	}

	// 비밀번호는 암호화 되있지만 그래도 노출 안되게 제거
	unset($cmt['mb_password']);
	//if($hide_ipaddress) unset($cmt['mb_ipaddress']);

	// 문서에 대한 기본 정보 포함
	if($doc['md_id'] == '_AFOXtRASH_') {
		$cmt['md_id'] = $doc['wr_updater'];
		$cmt['wr_trash'] = true;
	} else {
		$cmt['md_id'] = $doc['md_id'];
		$cmt['wr_trash'] = false;
	}
	$cmt['wr_title'] = $doc['wr_title'];
	$cmt['wr_mb_srl'] = $doc['mb_srl'];

	// JSON 사용시 모듈설정이 필요할때를 위해 만든옵션
	return $cmt;
}

/* End of file getcomment.php */
/* Location: ./module/board/proc/getcomment.php */
