<?php

namespace App\Http\Controllers\Admin;

use DB;
//use App\Http\Requests\CreateManifestRequest;
//use App\Http\Requests\UpdateManifestRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ManifestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttendanceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as AttendanceStore; }
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
        CRUD::setModel(\App\Models\Attendance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attendance');
        CRUD::setEntityNameStrings('asistencia', 'asistencias');
        /*if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete']);
        }*/
    }

    public function store()
    {

        $request = $this->crud->getRequest();
        $request->request->set("user_id", backpack_user()->id);

        //Aqui se guarda, todo lo que ocurre antes de aqui es antes de que se guarde el formulario(before insert)
        $response = $this->AttendanceStore();
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
        CRUD::addColumn([
            'label'     =>  'Trabajador',
            'type'      =>  'relationship',
            'name'      =>  'employee',
            'attribute' =>  'names',
            //'key'       =>  'NameClient'
        ]);

        CRUD::column('date')->label('Fecha de registro');

        CRUD::addColumn([
            'label'     =>  'Usuario',
            'type'      =>  'relationship',
            'name'      =>  'user',
            'attribute' =>  'name',
            //'key'       =>  'NameClient'
        ]);
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([
            'label'     =>  'Trabajador',
            'type'      =>  'relationship',
            'name'      =>  'employee_id',
            'attribute' =>  'names',
            'entity'    =>  'employee',
            //'key'       =>  'NameClient'
        ]);

        CRUD::addField([   
            'name'      => 'date',
            'label'     => 'Fecha de registro',
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
        /*if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            $customer=DB::table('customers')->where('user_id', backpack_user()->id )->first();
            CRUD::addClause('where', 'customer_id', '=', $customer->id);
            CRUD::removeColumn('Ruc');
            CRUD::removeColumn('ctasSor');
            CRUD::removeColumn('NameClient');
        }*/
        $this->addCustomCrudFilters();
        CRUD::enableExportButtons();
    }

    protected function fetchEmployee()
    {
        return $this->fetch(\App\Models\Employee::class);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        //CRUD::setValidation(CreateManifestRequest::class);
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
        //CRUD::setValidation(UpdateManifestRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);
        $this->defaultListColumns();
    }
}