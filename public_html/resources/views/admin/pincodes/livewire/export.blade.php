<div class="col-lg-6">
    <a wire:click="export" class="btn btn-outline-primary btn-sm">Export Pincodes Sheet</a>

    @if($exporting && !$exportFinished)
        <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
    @endif

    @if($exportFinished)
        Done. Download file <a class="stretched-link" wire:click="downloadExport"><i class="bx bx-cloud-download"></i> here </a>
    @endif
</div>