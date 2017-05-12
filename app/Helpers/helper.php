<?php
/**
 * Created by PhpStorm.
 * User: Victor Souto
 * Date: 08/05/2017
 * Time: 14:10
 */


/**
 * is the menu active?
 *
 * @param $page
 * @return string
 */
function isActive($page, $class = 'current-page') {

    if (Route::currentRouteName() == $page )
        return $class;
}

/**
 * is the menu active?
 *
 * @param $page
 * @return string
 */
function isSubMenuActive($subMenu) {

    $route = Route::currentRouteName();

    if (!$route)
        return false;

    if ($subMenu == 'entities') {
        switch ($route){
            case 'advogados.index':
            case 'clientes.index':
            case 'correspondentes.index':
            case 'servicos.index':
            case 'users.index':
            case 'comarcas.index':
                return 'highlight active';
        }
    }

    if ($subMenu == 'regions') {
        switch ($route){
            case 'countries':
            case 'states':
            case 'cities':
                return 'highlight active';
        }
    }

    switch ($route){
        case strstr($route, $subMenu
        ):
            return 'highlight active';
    }
}

function getCurrentRoute() {

    $path = false;
    if (\Illuminate\Support\Facades\Route::getCurrentRoute() !== null )
        $path = \Illuminate\Support\Facades\Route::getCurrentRoute()->getPath();

    if ($path == '/')
        $path = 'planner';

    return $path;
}

function getFileClass($filename)
{
    $path = pathinfo($filename);

    if ($path && !empty($path['extension'])) {

        switch ($path['extension']) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'png':
                return 'fa-image';
                break;
            case 'doc':
            case 'docx':
                return 'fa-file-word-o';
                break;
            case 'pdf':
                return 'fa-pdf-o';
                break;
            case 'xls':
                return 'fa-excel-o';
                break;
            default:
                return 'fa-file';
                break;
        }
    }

    return 'fa-file';
}


function getUserRoute($menu){

    $user_level = Auth::user()->level;

    switch ($menu) {
        case 'dashboard':
            if ($user_level >= 3)
                return route('home');

            if ($user_level == 1)
                return route('dashboard_correspondente');

            if ($user_level == 2)
                return route('dashboard_cliente');

            break;
        case 'diligencias':
            if ($user_level >= 3)
                return route('diligencias.index');
            break;
    }

}

function getUserGroup($nivel = false, $style = false) {

    $nivel = (!$nivel)? Auth::user()->level : $nivel;

    $label = '';

    switch ($nivel) {
        case '0':

            break;
        case '1':
            $label = $style? '<button type="button" class="btn btn-transparent btn-info">Correspondente</button>' : 'Correspondente';
            break;
        case '2':
            $label =  $style? '<button type="button" class="btn btn-default btn-transparent">Cliente</button>' : 'Cliente';
            break;
        case '3':
            $label =  $style? '<button type="button" class="btn btn-success btn-transparent">Operador</button>' : 'Operador';
            break;
        case '4':
            $label =  $style? '<button type="button" class="btn btn-success btn-transparent">Negociador</button>' : 'Negociador';
            break;
        case '5':
            $label =  $style? '<button type="button" class="btn btn-warning btn-transparent">Coordenador</button>' : 'Coordenador';
            break;
        case '6':
            $label =  $style? '<button type="button" class="btn btn-warning">Financeiro</button>' : 'Financeiro';
            break;
        case '9':
            $label =  $style? '<button type="button" class="btn btn-danger btn-transparent">Admin</button>' : 'Admin';
            break;
    }

    return $label;
}