<?php

namespace App\Http\Controllers\Admin;

//use App\Http\Requests\CreateSectorRequest;
//use App\Http\Requests\UpdateSectorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SectorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AreaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Area::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/area');
        CRUD::setEntityNameStrings('area', 'areas');
        /*if (backpack_user()->hasPermissionTo('manifiestos_cliente')) {
            CRUD::denyAccess(['update', 'create', 'delete', 'show', 'list']);
        }*/
    }

    protected function defaultListColumns()
    {
        CRUD::addColumn([
            'name' => 'name', 
            'label' => 'Nombre'
        ]); 
        CRUD::addColumn([
            'name' => 'description', 
            'label' => 'Descripción'
        ]);
    }
    
    protected function defaultListFields()
    {
        CRUD::addField([
            'name' => 'name', 
            'label' => 'Nombre'
        ]); 
        CRUD::addField([
            'name' => 'description', 
            'label' => 'Descripción'
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
        //CRUD::setValidation(CreateSectorRequest::class);
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
        //CRUD::setValidation(UpdateSectorRequest::class);
        $this->defaultListFields();
    }

    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);
        $this->defaultListColumns();
    }
}