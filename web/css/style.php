<?php
	header('Content-Type: text/css');

	error_reporting(0);
	
	require_once 'scssphp/scss.inc.php';
	use Leafo\ScssPhp\Compiler;

	$scss = new Compiler();
	$scss->setImportPaths('');
	$scss->setSourceMap(Compiler::SOURCE_MAP_INLINE);
	$scss->setFormatter('Leafo\ScssPhp\Formatter\Compact');

	echo $scss->compile('@import "style.scss";');
?>