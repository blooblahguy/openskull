<div class="row height100 content-center">
	<div class="os-md-4 text-center self-center">
		<div class="bg-primary text-upper strong pad20">
			Login
		</div>
		<form action="/account/login" class="border bordert0 pad20" method="POST">
			<input type="hidden" name="redirect" value="/admin/login">
			<div class="formsec">
				<label for="">Email</label>
				<input type="text" name="email">
			</div>
			<div class="formsec">
				<label for="">Password</label>
				<input type="password" name="password">
			</div>
			<div class="formsec">
				<input type="submit" value="Login">
			</div>
		</form>
	</div>
</div>