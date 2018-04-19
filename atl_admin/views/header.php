<!DOCTYPE html>
<html>
<head>
	<title>HAL - Admin</title>

	<? atlas_header(); ?>
</head>
<body>
	<div class="page">
		<div class="row">
			<div id="left" class="os-2 bg-dark">
				<h5 class="logo strong pad20 bg-primary text-upper text-center">HAL Admin</h5>
				<ul class="nav os-menu">
					<? admin_navigation(); ?>
				</ul>
			</div>
			<div id="right" class="os">
				<div class="page_header bg-grey">
					<div class="pull-left page_title">
						<? echo $view->getTitle(); ?>
					</div>
					<div class="pull-right account_actions">
						account
					</div>
					<div class="pull-right filter">
						filter
					</div>
				</div>
				<div class="content">