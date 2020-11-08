<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<!-- Users, Roles, Permissions -->
@if(backpack_user()->hasPermissionTo('administrador'))
	<li class="nav-title">Usuarios</li>
	<li class="nav-item nav-dropdown">
		<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
		<ul class="nav-dropdown-items">
		<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Usuarios</span></a></li>
		<li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
		<li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permisos</span></a></li>
		</ul>
	</li>
@endif

@if(backpack_user()->hasPermissionTo('administrador') or backpack_user()->hasPermissionTo('manifiestos_cliente') or backpack_user()->hasPermissionTo('manifiestos_administrador'))
	<li class="nav-title">Manifiestos</li>
@endif

@if(backpack_user()->hasPermissionTo('administrador') or backpack_user()->hasPermissionTo('manifiestos_administrador'))
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('address') }}'><i class='nav-icon la la-map-marker'></i> Direcciones</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customer') }}'><i class='nav-icon la la-user-plus'></i> Clientes</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('document_type') }}'><i class='nav-icon la la-paperclip'></i> Tipos de Documentos</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sector') }}'><i class='nav-icon la la-map-signs'></i> Sectores</a></li>
@endif

@if(backpack_user()->hasPermissionTo('administrador') or backpack_user()->hasPermissionTo('manifiestos_cliente') or backpack_user()->hasPermissionTo('manifiestos_administrador'))
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('manifest') }}'><i class='nav-icon la la-folder-open'></i> Manifiestos</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('area') }}'><i class='nav-icon la la-folder-open'></i> Areas</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('identification_document_type') }}'><i class='nav-icon la la-folder-open'></i> Tipos de documento de identidad</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i class='nav-icon la la-folder-open'></i> Trabajadores</a></li>
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attendance') }}'><i class='nav-icon la la-folder-open'></i> Asistencia</a></li>
@endcan