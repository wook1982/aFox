<?php
if(!defined('__AFOX__')) exit();
@include_once _AF_THEME_PATH_ . 'lang/' . _AF_LANG_ . '.php';

addJSLang(['error','id','password','login','auto_login','member_signup','member_find','captcha_code','confirm_save','setup']);
addCSS(_AF_THEME_URL_ . 'index' . (__DEBUG__ ? '.css?' . _AF_SERVER_TIME_ : '.min.css'));
addJS(_AF_THEME_URL_ . 'index' . (__DEBUG__ ? '.js?' . _AF_SERVER_TIME_ : '.min.js'));
if(__FULL_LOGIN__) {
	addCSS(_AF_THEME_URL_ . 'login' . (__DEBUG__ ? '.css?' . _AF_SERVER_TIME_ : '.min.css'));
}

/* End of file common.php */
/* Location: ./theme/default/common.php */
/* 이 파일이 존재하면 해당 theme 파일을 읽기전 자동으로 가장 먼저 읽어들임   */
