<div class="col-lg-6">
    <form wire:submit.prevent="import" enctype="multipart/form-data">
        @csrf
        <input type="file" wire:model="importFile" class="@error('importFile') is-invalid @enderror">
        {{-- <button class="btn btn-secondary btn-sm">Import</button> --}}
        <button wire:loading.class="opacity-50" wire:target="import" class="btn btn-secondary btn-sm">
            <span wire:loading.remove wire:target="import">Upload File</span>
            <span wire:loading wire:target="import">Uploading...</span>
        </button>
        @error('importFile')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </form>

    @if(!empty($batchId))
    @php $batch = Bus::findBatch($this->batchId); @endphp
        <div wire:poll="updateImportProgress">
            {{ $batch->processedJobs() }} - 
            total: {{ $batch->totalJobs }}
            failled : {{ $batch->failedJobs }}
        </div>
        @if($batch->failedJobs)
            <div wire:poll="updateImportProgress" class="text-danger">Importing failled..</div>
        @endif
    @endif

    @if($importing && !$importFinished)
        <div wire:poll="updateImportProgress">Uploading...please wait.</div>
    @endif

    @if($importFinished)
        Finished Upload.
    @endif
</div>