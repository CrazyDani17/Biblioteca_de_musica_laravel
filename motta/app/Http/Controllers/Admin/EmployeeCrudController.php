<?php

namespace App\Http\Controllers\Admin;

use DB;
//use App\Http\Requests\UpdateCustomerRequest;
//use App\Http\Requests\CreateCustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as employeeStore; }
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
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('trabajadores', 'trabajadores');
        /*if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete', 'show', 'list']);
        }*/
        
    }

    public function store()
    {
        //Obtenemos el requeste mediante una función, porque es protected.
        $request = $this->crud->getRequest();

        //Creamos la contraseña. Para esto el request que hemos obtenido nos da lo que llenamos en el formulario mediante llamados a get("nombre del atributo"), all() devuelve todo, set("nombre del atributo", "lo que quieras setear").
        $password = $request->request->get("document_number").strtolower(str_replace(' ', '', $request->request->get("names"))[0]);
        $password = Hash::make($password);

        //Inserta a la tabla usuario y se obtiene el id.
        $var = DB::table('users')->insertGetId(
            ['name' => $request->request->get("names"),'user_name' => $request->request->get("document_number"), 'password' => $password ]
        );

        //Insertamos el rol para el usuario
        DB::table('model_has_roles')->insertGetId(
           ['role_id' => 3, 'model_type' => 'App\User' ,'model_id' => $var]
        );

        //utilizamos el set para asignarle el usuario al cliente.
        $request->request->set("user_id", $var);
        
        //Aqui se guarda, todo lo que ocurre antes de aqui es antes de que se guarde el formulario(before insert)
        $response = $this->employeeStore();
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
            'name'  =>  'document_number',
            'label' =>  'Número de documento'
        ]);

        CRUD::addColumn([
            'name'  =>  'names',
            'label' =>  'Nombres'
        ]);

        CRUD::addColumn([
            'name'  =>  'last_name',
            'label' =>  'Apellido Paterno',
        ]);

        CRUD::addColumn([
            'name'  =>  'second_last_name',
            'label' =>  'Apellido Materno',
        ]);
        
        CRUD::addColumn([
            'name'      =>  'state',
            'label'     =>  'Estado',
        ]);
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([
            'name'  =>  'document_number',
            'label' =>  'Número de documento'
        ]);

        CRUD::addField([
            'name'  =>  'names',
            'label' =>  'Nombres'
        ]);

        CRUD::addField([
            'name'  =>  'last_name',
            'label' =>  'Apellido Paterno',
        ]);

        CRUD::addField([
            'name'  =>  'second_last_name',
            'label' =>  'Apellido Materno',
        ]);
        
        CRUD::addField([
            'name'      =>  'state',
            'label'     =>  'Estado',
        ]);

        //quitar esto en un futuro
        CRUD::addField([
            'name' => 'user_id',
            'type'  => 'hidden',
            'default' => '1'
        ]);

        CRUD::addField([
            'type'      => "relationship",
            'attribute' =>"name",
            'name'  =>  'identification_document_type_id',
            'label' =>  'Tipo de documento de identidad',
            'inline_create' => true,
        ]);
        
        CRUD::addField([
            'type' => "select2_multiple",
            'attribute'=>"name",
            'entity' => 'area',
            'model' => "App\Models\Area",
            'name' => 'area', // the method on your model that defines the relationship
            'ajax' => true,
            'pivot' => true,
            'inline_create' => [ 'entity' => 'area' ]
        ]);

        /*'document_number',
        'names',
        'last_name',
        'second_last_name',
        'user_id',
        'identification_document_type_id',
        'state',*/
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
        //CRUD::enableDetailsRow();  //Probar, se ve interesante
        /*CRUD::removeColumn('Managerk');
        CRUD::removeColumn('Phonek');*/
        CRUD::enableExportButtons();
    }
    
    protected function fetchArea()
    {
        return $this->fetch(\App\Models\Area::class);
    }

    protected function fetchIdentification_document_type()
    {
        return $this->fetch(\App\Models\Identification_document_type::class);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        //CRUD::setValidation(CreateCustomerRequest::class);
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
        //CRUD::setValidation(UpdateCustomerRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->defaultListColumns();
        CRUD::addColumn([
            'type' => "select_multiple",
            'attribute'=>"name",
            'entity' => 'area',
            'model' => "App\Models\Area",
            'name' => 'area', // the method on your model that defines the relationship
            'ajax' => true,
            'pivot' => true,
            'inline_create' => [ 'entity' => 'area' ]
        ]);
    }
}