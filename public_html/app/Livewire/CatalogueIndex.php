<?php

namespace App\Livewire;

use App\Models\{
    Catalogue
};
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CatalogueIndex extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Catalogue::query()->orderBy('id','desc');
    }

  

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Catalogue $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A'))
            ->add('updated_at_formatted', fn (Catalogue $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A'))
            ->add('name')
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Updated at', 'updated_at_formatted', 'updated_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            //
        ];
    }

    public function actions(Catalogue $row): array
    {
        return [
            Button::add('CTL'.$row->id)
                ->slot('CTL'.$row->id)
                ->class('text-bold')
                ->route('catalogue.show', ['catalogue' => $row])
                ->can(allowed: auth()->check()),

            Button::add('download-qr')
                ->slot('Download QR Code')
                ->class('btn btn-warning btn-sm')
                ->route('catalogue.downloadQrCode', ['id' => $row->id]),
        ];
    }
}
