<?php

namespace App\Livewire;

use App\Models\{
    BPoint
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

final class BulletPointIndex extends PowerGridComponent
{
    use WithExport;
    public int $model_id = 0;
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
        //return Category::query()->with(['content']);
        return BPoint::query()
            ->latest()
            ->when(
                $this->model_id,
                fn ($builder) => $builder->whereHas(
                    'model',
                    fn ($builder) => $builder->where('model_id', $this->model_id)
                )
                ->with(['model'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'model' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (BPoint $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('model_type')
            ->add('model_id')
            ->add('model_name', fn (BPoint $bpoint) => $bpoint->model->name??'')
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Model Name', 'model_type')
                ->sortable()
                ->searchable(),

            Column::make('Model Id', 'model_id')
                ->sortable()
                ->searchable(),

            Column::make('Model Name', 'model_name')
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
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('model_type')->placeholder('model_type'),
            Filter::inputText('model_id')->placeholder('model_id'),

            Filter::select('status')
                ->dataSource(BPoint::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::select('model_type')
                ->dataSource(BPoint::select('model_type')->groupBy('model_type')->get())
                ->optionLabel('model_type')
                ->optionValue('model_type'),

            /*Filter::inputText('content_name')
                ->filterRelation('content', 'name'),*/
        ];
    }

    public function actions(BPoint $row): array
    {
        return [
            Button::add('BPNT'.$row->id)
                ->slot('BPNT'.$row->id)
                ->class('text-bold')
                ->route('bPoints.show', ['bPoint' => $row])
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
