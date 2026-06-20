<?php

namespace App\Livewire;

use App\Models\{
    User,
    Enquiry
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

final class EnquiryIndex extends PowerGridComponent
{
    use WithExport;
    public int $city_id = 0;
    public int $state_id = 0;

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
        //return Enquiry::query();
        if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Estimater','Digital Marketer'])){
            return Enquiry::query()
            ->orderByDesc('published_at')
            ->when(
                $this->city_id,
                fn ($builder) => $builder->whereHas(
                    'city',
                    fn ($builder) => $builder->where('city_id', $this->city_id)
                )
                ->with(['city','state','salesmen'])
            );
        }else{
            return Enquiry::query()
            ->where(['salesmen_id' => auth()->user()->id])
            ->orderByDesc('published_at')
            ->when(
                $this->city_id,
                fn ($builder) => $builder->whereHas(
                    'city',
                    fn ($builder) => $builder->where('city_id', $this->city_id)
                )
                ->with(['city','state','salesmen'])
            );
        }
    }

    public function relationSearch(): array
    {
        return [
            'city' => [
                'name',
            ],
            'state' => [
                'name',
            ],
            'salesmen' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Enquiry $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('published_at_formatted', fn (Enquiry $model) => Carbon::parse($model->published_at)->timezone('Asia/Kolkata')->format('d M Y'))
            ->add('salesmen', fn ($model) => e( $model->salesmen->name??'' ))
            ->add('name')
            ->add('company_name')
            ->add('mobile')
            ->add('enquiry_type')
            ->add('scource_type')
            ->add('state', fn ($dish) => e($dish->state->name))
            ->add('city', fn ($dish) => e($dish->city->name))
            ->add('zipcode')
            ->add('purpose')
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Published At', 'published_at_formatted', 'published_at')
                ->sortable(),
                
            Column::make('AssignedTo', 'salesmen')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Company Name', 'company_name')
                ->sortable()
                ->searchable(),

            Column::make('Mobile', 'mobile')
                ->sortable()
                ->searchable(),
                
            Column::make('Enquiry Type', 'enquiry_type')
                ->sortable()
                ->searchable(),
                
            Column::make('Scource', 'scource_type')
                ->sortable()
                ->searchable(),
                
            Column::make('State', 'state')
                ->sortable()
                ->searchable(),
                
            Column::make('City', 'city')
                ->sortable()
                ->searchable(),
                
            Column::make('Pincode', 'zipcode')
                ->sortable()
                ->searchable(),
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
                
            Column::make('Message/Purpose', 'purpose')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name', 'name')
            //  ->operators(['contains', 'is', 'is_not']),
            Filter::inputText('published_at')->placeholder('YYYY-MM-DD (Published At)'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('purpose')->placeholder('Message/Purpose'),
            Filter::inputText('company_name')->placeholder('Company Name'),
            Filter::inputText('enquiry_type')->placeholder('Enquiry Type'),
            Filter::inputText('scource_type')->placeholder('Scource'),
            Filter::inputText('mobile')->placeholder('Mobile'),
            Filter::inputText('zipcode')->placeholder('Zipcode'),
            Filter::inputText('email')->placeholder('Email'),
            Filter::inputText('user_code')->placeholder('UserCode'),
            Filter::inputText('city')
                ->filterRelation('city', 'name'),
            Filter::inputText('state')
                ->filterRelation('state', 'name'),
            Filter::inputText('salesmen')
                ->filterRelation('salesmen', 'name'),

            Filter::select('status')
                ->dataSource(Enquiry::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),
        ];
    }

    public function actions(Enquiry $row): array
    {
        return [
            Button::add('RN'.$row->id)
                ->slot('RN'.$row->id)
                ->class('')
                ->route('enquiries.show', ['enquiry' => $row])
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
