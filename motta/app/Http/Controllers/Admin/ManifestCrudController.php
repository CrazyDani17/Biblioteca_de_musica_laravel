<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Requests\CreateManifestRequest;
use App\Http\Requests\UpdateManifestRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ManifestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ManifestCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as ManifestStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Manifest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/manifest');
        CRUD::setEntityNameStrings('manifiesto', 'manifiestos');
        if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete']);
        }
    }

    public function store()
    {

        $request = $this->crud->getRequest();
        $request->request->set("user_id", backpack_user()->id);

        //Aqui se guarda, todo lo que ocurre antes de aqui es antes de que se guarde el formulario(before insert)
        $response = $this->ManifestStore();
        //Todo lo de aqui es after insert
        
        return $response;
    }

    protected function addCustomCrudFilters()
    {
        $this->crud->addFilter(
            [ // daterange filter
                'type' => 'date_range',
                'name' => 'date_range',
                'label'=> 'Escoja un rango de fechas',
                // 'date_range_options' => [
                // 'format' => 'YYYY/MM/DD',
                // 'locale' => ['format' => 'YYYY/MM/DD'],
                // 'showDropdowns' => true,
                // 'showWeekNumbers' => true
                // ]
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'create_date', '>=', $dates->from);
                $this->crud->addClause('where', 'create_date', '<=', $dates->to);
            }
        );

    }

    protected function defaultListColumns()
    {
        CRUD::column('code')->label('Código');

        CRUD::addColumn([
            'label'     =>  'Cliente',
            'type'      =>  'relationship',
            'name'      =>  'customer',
            'attribute' =>  'name',
            'key'       =>  'NameClient'

        ]);

        CRUD::addColumn([
            'label'     =>  'Ruc',
            'type'      =>  'relationship',
            'name'      =>  'customer',
            'attribute' =>  'ruc',
            'key'       =>  'Ruc'
        ]);

        CRUD::addColumn([
            'type'      =>  'select',
            'label'     =>  'Sector',
            'name'      =>  'customer_id',
            'key'       =>  'ctasSor',
            'entity'    =>  'customer.sector',
            'attribute' =>  'name',
            'model'     =>  "App\Models\Customer"
        ]);

        CRUD::column('pick_up_date')->label('Fecha de recojo');

        CRUD::addColumn([
            'name'      =>  'file',
            'label'     =>  'Adjunto',
            'type'      =>  'upload_multiple',
            'disk'      =>  'documentos', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        ]);

        
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([   
            'name'      => 'code',
            'label'     => 'Codigo',
        ]);

        CRUD::addField([   
            'name'      => 'create_date',
            'label'     => 'Fecha de creación',
        ]);

        CRUD::addField([   
            'name'      => 'pick_up_date',
            'label'     => 'Fecha de recojo',
        ]);

        CRUD::addField([   
            'name'      => 'file',
            'label'     => 'Archivos',
            'type'      => 'upload_multiple',
            'upload'    => true,
            'disk'      => 'documentos', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        ]);

        CRUD::addField([
            'type'      => "relationship",
            'attribute' =>"name",
            'label'     => 'Tipo de documento',
            'name'      => 'document_type_id', // the method on your model that defines the relationship
            //'ajax' => true,
            'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"
        ]);

        CRUD::addField([
            'name'      => 'customer_id',
            'label'     => 'Cliente',
            'entity'    => 'customer',
            'attribute' => 'ruc', // the belt's attribute
            'model'     => "App\Models\Customer" 
        ]);
        
        CRUD::addField([
            'name'                      => 'address_id',
            'type'                      => 'select2_from_ajax',
            'label'                     => 'Dirección',
            'attribute'                 => 'address',
            'dependencies'              => ['customer_id'],
            'data_source'               => url("api/address"),
            'placeholder'               => "Select an address",
            'minimum_input_length'      => 0,
            'entity'                    => 'address',
            'model'                     => "App\Models\Address",
            'include_all_form_fields'   => true,
        ]);

        CRUD::addField([
            'name' => 'user_id',
            'type'  => 'hidden',
            'default' => '1'
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->defaultListColumns();
        if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            $customer=DB::table('customers')->where('user_id', backpack_user()->id )->first();
            CRUD::addClause('where', 'customer_id', '=', $customer->id);
            CRUD::removeColumn('Ruc');
            CRUD::removeColumn('ctasSor');
            CRUD::removeColumn('NameClient');
        }
        $this->addCustomCrudFilters();
        CRUD::enableExportButtons();
    }

    protected function fetchDocument_type()
    {
        return $this->fetch(\App\Models\Document_type::class);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateManifestRequest::class);
        $this->defaultListFields();
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateManifestRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);
        $this->defaultListColumns();
    }
}
