<div class="row">
	@foreach($imports??'' as $import)
	<div class="col-md-3 p-2">
		<div class="card h-100 text-center ">
			<div class="card-header py-2 bg-light">
				{{ $import->created_at->format('d M Y, H:i:s') }}
			</div>
			<div class="card-body p-1 pt-3">
				<p>
					<strong>UploadBy:</strong> {{ $import->user->name??'' }} <br><br>
					<small>{{ $import->file_name??'' }}</small>
				</p>
			</div>
			<div class="card-footer p-1 bg-light">
				<a download="" href="{{ url($import->file_path) }}" class="btn btn-sm btn-block btn-success"><i class="bx bx-cloud-download"></i> Download</a>
				@can('delete-uploaded-excel-file')
				<a href="{{ route('commons.delete_imported_excels', $import) }}" class="btn btn-sm btn-block btn-danger confirmDelete"><i class="bx bx-trash"></i></a>
				@endcan
			</div>
		</div>
	</div>
	@endforeach
</div>