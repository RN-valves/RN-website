<div class="row">
	<div class="table-responsive">
		<h4>Basic Details</h4>
		<table class="table table-bordered">
			<tr>
				<th>Name</th>
				<td>{{ $user->name??'' }}</td>
				<th>Mobile</th>
				<td>{{ $user->country->code??'' }}{{ $user->mobile??'' }}</td>
				<th>Email</th>
				<td>{{ $user->email??'' }}</td>
			</tr>
			<tr>
				<th>City</th>
				<td>{{ $user->city->name??'' }}</td>
				<th>State</th>
				<td>{{ $user->state->name??'' }}</td>
				<th>Pincode</th>
				<td>{{ $user->zipcode??'' }}</td>
			</tr>
		</table>
	</div>
</div>