<?
	$form_id = $paramters;

	$form = $db->query("SELECT * FROM atl_posts WHERE post_type = 'form' AND id = '{$form_id}' ")->fetch_assoc();
	$form_data = $db->query("SELECT * FROM atl_postmeta WHERE post_id = {$form['id']}");
?>



<form method="/admin/forms/update/<? echo $form_id; ?>" id="form">
	<div class="row">
		<div class="formsec os">
			<label for="">Form Title</label>
			<input type="text" name="post_title" value="<? echo $form['post_title'] ?>" a-bind="form:<? $form_id; ?>:post_title" >
		</div>
	</div>
	<div class="row">
		<div class="formsec os">
			<label for="">Form Instructions</label>
			<textarea name="post_content" rows="3"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="os padr20" id="form_add">

		</div>
		<div class="os-4 border pad20 self-end">
			<div class="text-center strong text-sm text-upper">Add Form Elements</div>
			<hr>
			<div class="row">
				<div class="os-6 pad10">
					<a href="" class="btn block" template="text" template-target="#form_add">Text</a>
				</div>
				<div class="os-6 pad10">
					<a href="" class="btn block" template="text_area" template-target="#form_add">Text Area</a>
				</div>

				<div class="os-6 pad10">
					<a href="" class="btn block" template="dropdown" template-target="#form_add">Drop Down</a>
				</div>
				<div class="os-6 pad10">
					<a href="" class="btn block" template="phone" template-target="#form_add">Phone</a>
				</div>

				<div class="os-6 pad10">
					<a href="" class="btn block" template="number" template-target="#form_add">Number</a>
				</div>
				<div class="os-6 pad10">
					<a href="" class="btn block" template="multiple_choice" template-target="#form_add">Multiple Choice</a>
				</div>

				<div class="os-6 pad10">
					<a href="" class="btn block" template="checkboxes" template-target="#form_add">Checkboxes</a>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="os-6 pad10">
					<a href="" class="btn block"  template="break" template-target="#form_add">Break</a>
				</div>
				<div class="os-6 pad10">
					<a href="" class="btn block"  template="html" template-target="#form_add">HTML</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row pad20">
		<div class="os text-left">
			<input type="submit" value="Save" class="btn-primary">
		</div>
		<div class="os text-right">
			<a href="/admin/forms/delete/<?= $form_id; ?>" class="btn btn-danger">Delete</a>
		</div>
	</div>
</form>


<div class="templates hidden">
	<template id="text">
		<div class="border pad20 margb20">
			<strong>Single Text</strong>
			<div class="reorder"></div>
			<input type="hidden" name="meta[][order]" value="0">
			<div class="row">
				<div class="os padr10">
					<div class="formsec">
						<label for="">Label</label>
						<input type="text" name="meta[][text]" value="">
					</div>
				</div>
				<div class="os padl10">
					<div class="formsec">
						<label for="">Placeholder</label>
						<input type="text" name="meta[][text]" value="">
					</div>
				</div>
			</div>
		</div>
	</template>
	<template id="text_area">
		<div class="border pad20 margb20">
			<strong>Text Area</strong>
			<div class="reorder"></div>
			<input type="hidden" name="meta[][order]" value="0">
			<div class="row">
				<div class="os pad10">
					<div class="formsec">
						<label for="">Label</label>
						<input type="text" name="meta[][text]" value="">
					</div>
				</div>
				<div class="os pad10">
					<div class="formsec">
						<label for="">Placeholder</label>
						<input type="text" name="meta[][text]" value="">
					</div>
				</div>
			</div>
			<div class="row example">
				<label for=""></label>
				<textarea name="" id="" cols="30" rows="10" class="disabled" disabled></textarea>
			</div>
		</div>
	</template>
	<template id="dropdown">

	</template>
	<template id="phone">

	</template>
	<template id="number">

	</template>
	<template id="multiple_choice">

	</template>
	<template id="checkboxes">

	</template>
	<template id="break">
		<hr>
		<input type="hidden" name="meta[]" value="break" >
	</template>
	<template id="html">

	</template>
</div>