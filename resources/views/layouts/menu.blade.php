@php
    $group1 = Request::is('negocios') || Request::is('sucursales') || Request::is('usuarios') ? 'active' : '';
    $group1s = Request::is('negocios') || Request::is('sucursales') || Request::is('usuarios') ? 'show' : '';
    $group2 = Request::is('socios') || Request::is('socios/crear') || Request::is('visitas') || Request::is('visitas/listado') ? 'active' : '';
    $group2s = Request::is('socios') || Request::is('socios/crear') || Request::is('visitas') || Request::is('visitas/listado') ? 'show' : '';
    $group3 = Request::is('categorias') || Request::is('proveedores') || Request::is('productos') ? 'active' : '';
    $group3s = Request::is('categorias') || Request::is('proveedores') || Request::is('productos') ? 'show' : '';
    $group4 = Request::is('boxes') || Request::is('usercash') || Request::is('ventas') ? 'active' : '';
    $group4s = Request::is('boxes') || Request::is('usercash') || Request::is('ventas') ? 'show' : '';
    $group5 = Request::is('almacenes') || Request::is('ventaalmacen') ? 'active' : '';
    $group5s = Request::is('almacenes') || Request::is('ventaalmacen') ? 'show' : '';
    $group6 = Request::is('servicios') || Request::is('clientes') ? 'active' : '';
    $group6s = Request::is('servicios') || Request::is('clientes') ? 'show' : '';
    $group7 = Request::is('creditos') || Request::is('cotizaciones') || Request::is('gastos') || Request::is('reportes') ? 'active' : '';
    $group7s = Request::is('creditos') || Request::is('cotizaciones') || Request::is('gastos') || Request::is('reportes') ? 'show' : '';
@endphp
<li class="{{ $group1 }}">
    <a class="nav-link group-li {{ $group1s }}">
        <i class="fas fa-user-cog"></i><span>Administrador</span>
    </a>
    <ul class="list-items {{ $group1s }}">
        <li class="{{ Request::is('negocios') ? 'active' : '' }}">
            <a href="{{ route('negocios.index') }}" class="nav-link">
                <i class="fas fa-building"></i><span>Negocios</span>
            </a>
        </li>
        <li class="{{ Request::is('sucursales') ? 'active' : '' }}">
            <a href="{{ route('sucursales.index') }}" class="nav-link">
                <i class="fas fa-landmark"></i><span>Sucursales</span>
            </a>
        </li>
        <li class="{{ Request::is('usuarios') ? 'active' : '' }}">
            <a href="{{ route('usuarios.index') }}" class="nav-link">
                <i class="fas fa-users"></i><span>Usuarios</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ $group2 }}">
    <a class="nav-link group-li {{ $group2s }}">
        <i class="fas fa-handshake"></i><span>Socios</span>
    </a>
    <ul class="list-items {{ $group2s }}">
        <li class="{{ Request::is('socios/crear') ? 'active' : '' }}">
            <a href="{{ route('socios.create') }}" class="nav-link">
                <i class="fas fa-user-plus"></i><span>Registrar Socio</span>
            </a>
        </li>
        <li class="{{ Request::is('socios') ? 'active' : '' }}">
            <a href="{{ route('socios.index') }}" class="nav-link">
                <i class="fas fa-user-shield"></i><span>Lista de Socios</span>
            </a>
        </li>
        <li class="{{ Request::is('visitas') ? 'active' : '' }}">
            <a href="{{ route('visitas.index') }}" class="nav-link">
                <i class="fas fa-calendar-check"></i><span>Visitas del Día</span>
            </a>
        </li>
        <li class="{{ Request::is('visitas/listado') ? 'active' : '' }}">
            <a href="{{ route('visitas.listado') }}" class="nav-link">
                <i class="fas fa-calendar-alt"></i><span>Historial de Visitas</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ $group3 }}">
    <a class="nav-link group-li {{ $group3s }}">
        <i class="fas fa-gifts"></i><span>Productos</span>
    </a>
    <ul class="list-items {{ $group3s }}">
        <li class="{{ Request::is('categorias') ? 'active' : '' }}">
            <a href="{{ route('categorias.index') }}" class="nav-link">
                <i class="fas fa-tags"></i><span>Categorias</span>
            </a>
        </li>
        <li class="{{ Request::is('proveedores') ? 'active' : '' }}">
            <a href="{{ route('proveedores.index') }}" class="nav-link">
                <i class="fas fa-user-tie"></i><span>Proveedores</span>
            </a>
        </li>
        <li class="{{ Request::is('productos') ? 'active' : '' }}">
            <a href="{{ route('productos.index') }}" class="nav-link">
                <i class="fas fa-cubes"></i><span>Lista de Productos</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ $group4 }}">
    <a class="nav-link group-li {{ $group4s }}">
        <i class="fas fa-store"></i><span>Ventas</span>
    </a>
    <ul class="list-items {{ $group4s }}">
        <li class="{{ Request::is('boxes') ? 'active' : '' }}">
            <a href="{{ route('boxes.index') }}" class="nav-link">
                <i class="fas fa-cash-register"></i><span>Cajas</span>
            </a>
        </li>
        <li class="{{ Request::is('usercash') ? 'active' : '' }}">
            <a href="{{ route('usercash.index') }}" class="nav-link">
                <i class="fas fa-shopping-basket"></i><span>Vender</span>
            </a>
        </li>
        <li class="{{ Request::is('ventas') ? 'active' : '' }}">
            <a href="{{ route('ventas.index') }}" class="nav-link">
                <i class="fas fa-hand-holding-usd"></i><span>Historial de Ventas</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ $group5 }}">
    <a class="nav-link group-li {{ $group5s }}">
        <i class="fas fa-archive"></i><span>Almacen</span>
    </a>
    <ul class="list-items {{ $group5s }}">
        <li class="{{ Request::is('almacenes') ? 'active' : '' }}">
            <a href="{{ route('almacenes.index') }}" class="nav-link">
                <i class="fas fa-arrow-alt-circle-up"></i><span>Altas</span>
            </a>
        </li>
        <li class="{{ Request::is('ventaalmacen') ? 'active' : '' }}">
            <a href="{{ route('ventaalmacen.index') }}" class="nav-link">
                <i class="fas fa-chart-line"></i><span>Ventas</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ $group6 }}">
    <a class="nav-link group-li {{ $group6s }}">
        <i class="fas fa-tools"></i><span>Servicios</span>
    </a>
    <ul class="list-items {{ $group6s }}">
        <li class="{{ Request::is('servicios') ? 'active' : '' }}">
            <a href="{{ route('servicios.index') }}" class="nav-link">
                <i class="fas fa-list-alt"></i><span>Lista de Servicios</span>
            </a>
        </li>
        <li class="{{ Request::is('clientes') ? 'active' : '' }}">
            <a href="{{ route('clientes.index') }}" class="nav-link">
                <i class="fas fa-user-friends"></i><span>Clientes</span>
            </a>
        </li>
    </ul>
</li>


<li class="{{ $group7 }}">
    <a class="nav-link group-li {{ $group7s }}">
        <i class="fas fa-tachometer-alt"></i><span>Gestor</span>
    </a>
    <ul class="list-items {{ $group7s }}">
        <li class="{{ Request::is('creditos') ? 'active' : '' }}">
            <a href="{{ route('creditos.index') }}" class="nav-link">
                <i class="fab fa-bitcoin"></i><span>Creditos</span>
            </a>
        </li>
        <li class="{{ Request::is('cotizaciones') ? 'active' : '' }}">
            <a href="{{ route('cotizaciones.index') }}" class="nav-link">
                <i class="fas fa-clipboard-list"></i><span>Cotizaciones</span>
            </a>
        </li>
        <li class="{{ Request::is('gastos') ? 'active' : '' }}">
            <a href="{{ route('expenses.index') }}" class="nav-link">
                <i class="fas fa-receipt"></i><span>Gastos</span>
            </a>
        </li>
        <li class="{{ Request::is('reportes') ? 'active' : '' }}">
            <a href="{{ route('reportes.index') }}" class="nav-link">
                <i class="fas fa-chart-pie"></i><span>Reportes</span>
            </a>
        </li>
    </ul>
</li>
