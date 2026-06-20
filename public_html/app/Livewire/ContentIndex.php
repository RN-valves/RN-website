<?php

namespace App\Livewire;

use App\Models\{
    Content
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

final class ContentIndex extends PowerGridComponent
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
        return Content::query();
    }

    /*public function relationSearch(): array
    {
        //
    }*/

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Content $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('title')
            ->add('status')
            ->add('is_visible_website', fn ($model) => $model->is_visible_website ? 'Visible' : 'InVisible');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'title')
                ->sortable()
                ->searchable(),
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
                
            Column::make('is Visible?', 'is_visible_website')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('title')->placeholder('Name'),

            Filter::select('status')
                ->dataSource(Content::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),
        ];
    }

    public function actions(Content $row): array
    {
        return [
            Button::add('CT'.$row->id)
                ->slot('CT'.$row->id)
                ->class('text-bold')
                ->route('contents.show', ['content' => $row])
                ->can(allowed: auth()->check()),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
