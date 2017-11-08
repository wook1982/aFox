<?php
if(!defined('__AFOX__')) exit();

$_PROTECT['proc.deleteaddonconfig']		= ['grant' => 's'];
$_PROTECT['proc.deleteboard']			= ['grant' => 's'];
$_PROTECT['proc.deletecomments']		= ['grant' => 's'];
$_PROTECT['proc.deletedocuments']		= ['grant' => 's'];
$_PROTECT['proc.deletefile']			= ['grant' => 's'];
$_PROTECT['proc.deletefiles']			= ['grant' => 's'];
$_PROTECT['proc.deletethemeconfig']		= ['grant' => 's'];

$_PROTECT['proc.updateaddonconfig']		= ['grant' => 's'];
$_PROTECT['proc.updatemenu']			= ['grant' => 's'];
$_PROTECT['proc.updatesetup']			= ['grant' => 's'];
$_PROTECT['proc.updatesetuptheme']		= ['grant' => 's'];
$_PROTECT['proc.updatethemeconfig']		= ['grant' => 's'];
$_PROTECT['proc.updateboard']			= ['grant' => 's'];

$_PROTECT['proc.emptyrecyclebin']		= ['grant' => 's'];
$_PROTECT['proc.movedocuments']			= ['grant' => 's'];

$_PROTECT['proc.updatefile']			= ['grant' => 'm'];

$_PROTECT['proc.getaddonform']			= ['grant' => 'm'];
$_PROTECT['proc.getthemeform']			= ['grant' => 'm'];
$_PROTECT['proc.getwidgetform']			= ['grant' => 'm'];
$_PROTECT['proc.getboard']				= ['grant' => 'm'];
$_PROTECT['proc.getfile']				= ['grant' => 'm'];
$_PROTECT['proc.getfilelist']			= ['grant' => 'm'];


/* End of file protect.php */
/* Location: ./module/admin/protect.php */
