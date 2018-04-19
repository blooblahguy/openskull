<?
	$forms = $controller->retrieve();
?>

<div class="row height100">
	<div class="os-2 left height100 padr20 bordr" id="left_data">
		<a href="/admin/forms/create" class="create btn block btn-secondary">Create Form</a>
		<hr>
		<div class="list" action="template:form_template">
			<? while ($form = $forms->fetch_assoc()) { ?>
				<a href="/admin/forms/view/<?= $form['id']; ?>"><?= $form['post_title'] ?></a>
			<? } ?>
		</div>
	</div>
	<div class="os right height100 padl20" id="right_data">
		<? if (! $action == "view") { ?>
			<div class="row height100 content-middle">
				<div class="em text-muted os self-center text-center">
					<h2>Nothing Here</h2>
					<p>Select an item from the left <br> or create a new item.</p>
				</div>
			</div>
		<? } else { ?>
			<? include('form_view.php'); ?>
		<? } ?>
	</div>

	<template id="form_template">

	</template>
</div>