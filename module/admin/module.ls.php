<?php
	if(!defined('__AFOX__')) exit();

	$md_list = [];
	$out = DB::query('SELECT md_key FROM '._AF_MODULE_TABLE_.' WHERE 1 ORDER BY md_key');
	if($ex = DB::error()) {
		echo showMessage($ex->getMessage(),$ex->getCode());
	} else {
		while ($row = DB::assoc($out)) {
			$md_list[$row['md_key']] = true;
		}
	}
?>

<table class="table table-hover">
<thead class="table-nowrap">
	<tr>
		<th>#<?php echo getLang('module')?></th>
		<th class="hidden-xs"><?php echo getLang('version')?></th>
		<th class="hidden-xs hidden-sm"><?php echo getLang('author')?></th>
		<th class="col-xs-1"><?php echo getLang('setup')?></th>
	</tr>
</thead>
<tbody>

<?php
$skip_arr = ['admin'=>1,'member'=>1,'editor'=>1,'page'=>1,'board'=>1];
$module_dir = _AF_MODULES_PATH_;

foreach ($skip_arr as $key => $value) {
	@include $module_dir.$key.'/info.php';

	echo '<tr><th scope="row">'.(escapeHtml(empty($_MODULE_INFO['title'])?$name:$_MODULE_INFO['title'])).'</th>';
	echo '<td class="hidden-xs">'.(empty($_MODULE_INFO['version'])?'...':$_MODULE_INFO['version']).'</td>';
	echo '<td class="hidden-xs hidden-sm">'.(empty($_MODULE_INFO['author'])?'...':'<a href="'.(empty($_MODULE_INFO['link'])?'mailto:'.$_MODULE_INFO['email'].'"':$_MODULE_INFO['link'].'" target="_blank"').'>'.$_MODULE_INFO['author'].'</a>').'</td>';
	echo '<td><button type="button" class="btn btn-primary btn-xs min-width-100" '.'disabled="disabled">'.getLang('none').'</button></td></tr>';
}

if(is_dir($module_dir)) {
	foreach(glob($module_dir.'*', GLOB_ONLYDIR) as $dir) {
		$name = basename($dir);
		if(isset($md_list[$name])) $md_list[$name] = false;
		if(!empty($skip_arr[$name])) continue;

		$_MODULE_INFO = [];
		@include $module_dir.$name.'/info.php';

		echo '<tr><th scope="row">'.(escapeHtml(empty($_MODULE_INFO['title'])?$name:$_MODULE_INFO['title'])).'</th>';
		echo '<td class="hidden-xs">'.(empty($_MODULE_INFO['version'])?'...':$_MODULE_INFO['version']).'</td>';
		echo '<td class="hidden-xs hidden-sm">'.(empty($_MODULE_INFO['author'])?'...':'<a href="'.(empty($_MODULE_INFO['link'])?'mailto:'.$_MODULE_INFO['email'].'"':$_MODULE_INFO['link'].'" target="_blank"').'>'.$_MODULE_INFO['author'].'</a>').'</td>';
		echo '<td><button type="button" class="btn btn-primary btn-xs min-width-100" onclick="parent.location.replace(\''.getUrl('mid',$name).'\')">'.getLang('setup').'</button></td></tr>';
	}
}
?>

</tbody>
</table>

<table class="table table-hover">
<thead class="table-nowrap">
	<tr>
		<th>#<?php echo getLang('removed_module')?></th>
		<th><?php echo getLang('empty_module')?></th>
	</tr>
</thead>
<tbody>
<?php
	foreach($md_list as $key => $value) {
		if($value) echo '<tr><td>'.$key.'</td><td class="col-xs-1"><button type="button" class="btn btn-primary btn-xs min-width-100" data-empty-module="'.$key.'">'.getLang('empty_module').'</button></td></tr>';
	}
?>
</tbody>
</table>

<?php
/* End of file module.ls.php */
/* Location: ./module/admin/module.ls.php */