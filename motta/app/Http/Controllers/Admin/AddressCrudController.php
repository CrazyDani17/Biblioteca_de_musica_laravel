<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\CreateAddressRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AddressCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AddressCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Address::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/address');
        CRUD::setEntityNameStrings('dirección', 'direcciones');
        if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete', 'show', 'list']);
        }
    }

    protected function defaultListColumns()
    {
        CRUD::addColumn([
            'type'      =>  'relationship',
            'name'      =>  'customer',
            'label'     =>  'Cliente',
            'attribute' =>  'name'
        ]);

        CRUD::addColumn([
            'name'      => 'address',
            'label'     => 'Dirección'
        ]);
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([
            'name'      => 'customer_id',
            'label'     => 'Cliente',
            'entity'    => 'customer',
            'attribute' => 'ruc', 
            'model'     => "App\Models\Customer" 
        ]);

        CRUD::addField([
            'name'      => 'address',
            'label'     => 'Dirección',
            
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
        CRUD::enableExportButtons();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateAddressRequest::class);
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
        CRUD::setValidation(UpdateAddressRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->defaultListColumns();
    }
}
