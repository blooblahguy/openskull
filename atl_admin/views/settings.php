<form method="POST" action="/admin/entries/create" class="os-6">
	<p class="em text-center">This form is to test CRM functionality</p>
	<div class="row">
		<div class="formsec os pad20">
			<label for="">First Name</label>
			<input type="text" name="first_name" required>
		</div>
		<div class="formsec os pad20">
			<label for="">Last Name</label>
			<input type="text" name="last_name" required>
		</div>
	</div>
	<div class="row">
		<div class="formsec os pad20">
			<label for="">Email</label>
			<input type="text" name="email" required>
		</div>
		<div class="formsec os pad20">
			<label for="">Phone</label>
			<input type="text" name="phone">
		</div>
	</div>
	<div class="formsec pad20">
		<label for="">Questions or Comments</label>
		<textarea name="message" rows="10"></textarea>
	</div>
	<div class="formsec text-center">
		<input type="submit" class="btn btn-secondary">
	</div>
</form>