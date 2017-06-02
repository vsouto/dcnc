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
                return 'fa-image text-info ';
                break;
            case 'doc':
            case 'docx':
                return 'fa-file-word-o text-info ';
                break;
            case 'pdf':
                return 'fa-file-pdf-o text-danger ';
                break;
            case 'xls':
                return 'fa-excel-o text-info ';
                break;
            default:
                return 'fa-file text-info ';
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

function getUrgenciaClass($val) {

    switch ($val) {
        case 'Crítica':
            return "<span class='label label-critica'>$val</span>";
            break;
        case 'Urgente':
            return "<span class='label label-urgente'>$val</span>";
            break;
        case 'Alta':
            return "<span class='label label-alta'>$val</span>";
            break;
        case 'Média':
            return "<span class='label label-media'>$val</span>";
            break;
        case 'Normal':
            return "<span class='label label-info'>$val</span>";
            break;
    }

    return $val;
}

function calculateRatingPercentage($avg) {

    $avg = number_format($avg, 0, ',', '.');

    $calculo = $avg * 100 / 5;

    return number_format($calculo, 0, ',', '.');;
}

function getCorrespondentesUsoPercentage($qtd, $total) {

    return number_format(($qtd * 100) / $total,0,'','.');
}

function getRatingStars($rating) {

    $star = '<i class="fa fa-star"></i>';

    return str_repeat($star,$rating);
}