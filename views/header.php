<!DOCTYPE html>
<html>
<head>
	<title><? echo $page->getTitle(); ?></title>

	<meta charset="<? echo $page->getTitle(); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<? atlas_header(); ?>
</head>
<body>
	<div class="header_outer">
		<div class="header container">
			<div class="header_top">
				<a href="/" class="logo inline-block pull-left h2 text-upper padtb20">Grimporium</a>
				<div class="search pull-right padtb20 self-middle">
					<form action="/search">
						<input type="text" name="s" value="<? $_GET['s']; ?>" placeholder="Search..." >
						<!-- <input type="submit" class="search-submit"> -->
					</form>
				</div>
				<div class="clear"></div>
			</div>
			<div class="nav os-menu">
				<li><a href="/">News</a></li>
				<li><a href="/new-players">New Players</a></li>
				<li><a href="/database">Database</a></li>
				<li><a href="/tools">Tools</a></li>
				<li><a href="/guides">Guides</a></li>
				<li><a href="/forums">Forums</a></li>
			</div>
		</div>
	</div>
	<div class="content_outer padtb20">
		<div class="content container">