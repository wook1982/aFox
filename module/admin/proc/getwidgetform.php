<?php

if(!defined('__AFOX__')) exit();

function load_template($_template_file) {
	require($_template_file);
}

function proc($data) {

	if(!isset($data['wg_id'])) return set_error(getLang('error_request'),4303);

	$_template_file = _AF_WIDGETS_PATH_ . $data['wg_id'] . '/setup.php';

	if(!file_exists($_template_file)) {
		return set_error(getLang('error_founded'),4201);
	}

	$_WIDGET_INFO = [];
	@require_once _AF_WIDGETS_PATH_ . $data['wg_id'] . '/info.php';

	ob_start();

	$author = empty($_WIDGET_INFO['link'])?escapeHtml($_WIDGET_INFO['author']):('<a href="'.escapeHtml($_WIDGET_INFO['link']).'" target="_blank">'.escapeHtml($_WIDGET_INFO['author']).'</a>');

	echo '<div class="form-group"><h3 style="margin-top:0">'.escapeHtml($_WIDGET_INFO['title']).'</h3>'
		.'<div class="row"><label class="col-md-2">'.getLang('version').'</label> '.escapeHtml($_WIDGET_INFO['version']).'</div>'
		.'<div class="row"><label class="col-md-2">'.getLang('date').'</label> '.escapeHtml($_WIDGET_INFO['date']).'</div>'
		.'<div class="row"><label class="col-md-2">'.getLang('author').'</label> '.$author.' ('.escapeHtml($_WIDGET_INFO['email']).')</div>'
		.'<p class="help-block">'.nl2br(escapeHtml($_WIDGET_INFO['description'])).'</p></div><hr style="margin:15px 0 20px">';

	require($_template_file);

	return ['tpl'=>ob_get_clean()];
}

/* End of file getwidgetform.php */
/* Location: ./module/admin/proc/getwidgetform.php */