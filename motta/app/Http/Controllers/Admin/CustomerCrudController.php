<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\CreateCustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as customerStore; }
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
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('cliente', 'clientes');
        if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete', 'show', 'list']);
        }
        
    }

    public function store()
    {
        //Obtenemos el requeste mediante una función, porque es protected.
        $request = $this->crud->getRequest();

        //Creamos la contraseña. Para esto el request que hemos obtenido nos da lo que llenamos en el formulario mediante llamados a get("nombre del atributo"), all() devuelve todo, set("nombre del atributo", "lo que quieras setear").
        $password = $request->request->get("ruc").strtolower(str_replace(' ', '', $request->request->get("name"))[0]);
        $password = Hash::make($password);

        //Inserta a la tabla usuario y se obtiene el id.
        $var = DB::table('users')->insertGetId(
            ['name' => $request->request->get("name"),'user_name' => $request->request->get("ruc"), 'password' => $password ]
        );

        //Insertamos el rol para el usuario
        DB::table('model_has_roles')->insertGetId(
           ['role_id' => 3, 'model_type' => 'App\User' ,'model_id' => $var]
        );

        //utilizamos el set para asignarle el usuario al cliente.
        $request->request->set("user_id", $var);
        
        //Aqui se guarda, todo lo que ocurre antes de aqui es antes de que se guarde el formulario(before insert)
        $response = $this->customerStore();
        //Todo lo de aqui es after insert
        
        return $response;
    }

    protected function defaultListColumns()
    {
        CRUD::addColumn([
            'name'  =>  'name',
            'label' =>  'Nombre'
        ]);

        CRUD::column('ruc');

        CRUD::addColumn([
            'name'  =>  'manager',
            'label' =>  'Encargado',
            'key'   =>  'Managerk'
        ]);

        CRUD::addColumn([
            'name'  =>  'number_phone',
            'label' =>  'N° telefono',
            'type'  =>  'phone',
            'key'   =>  'Phonek'

        ]);
        
        CRUD::addColumn([
            'type'      =>  'relationship',
            'name'      =>  'sector',
            'label'     =>  'Sector',
            'attribute' =>  'name'
        ]);
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([
            'name'=>'name',
            'label'=>'Nombre'
        ]);;
        
        CRUD::field('ruc');
        
        CRUD::addField([
            'name'=>'manager',
            'label'=>'Encargado'
        ]);
        
        CRUD::addField([
            'name'=>'number_phone',
            'label'=>'N° telefono'
        ]);
        
        //quitar esto en un futuro
        CRUD::addField([
            'name' => 'user_id',
            'type'  => 'hidden',
            'default' => '1'
        ]);
        
        CRUD::addField([
            'type' => "relationship",
            'attribute'=>"name",
            'name' => 'sector_id', // the method on your model that defines the relationship
            'ajax' => true,
            'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"
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
        //CRUD::enableDetailsRow();  //Probar, se ve interesante
        CRUD::removeColumn('Managerk');
        CRUD::removeColumn('Phonek');
        CRUD::enableExportButtons();
    }
    
    protected function fetchSector()
    {
        return $this->fetch(\App\Models\Sector::class);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateCustomerRequest::class);
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
        CRUD::setValidation(UpdateCustomerRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->defaultListColumns();
    }
}
