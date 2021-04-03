<?php
/**
 * Created by PhpStorm.
 * User: Salehi
 * Date: 5/10/2020
 * Time: 13:39
 */

namespace App\Support;


class DataTableHelpers
{
    /**
     * @return string
     */
    public static function toggleBottom($model, $modelName): string
    {
        $route = route($modelName . '.toggle.active', $model->id);
        $class = !$model->active ? 'danger fa fa-window-close' : 'success fa fa-check';
        $active_badge = $model->active ? 'success' : 'danger';
        $active = $model->active ? 'فعال' : 'غیرفعال';
        return
            "<a href='{$route}' class='active-btn btn-circle btn-icon-only' style='display:inline-grid'>
                   <i class='alert-{$class}  active-btn-icon'></i>
                   <span class='badge badge-$active_badge active-btn-badge'> $active</span></a>";
    }

    public static function positionHandles($query,$table)
    {
        return "<span class='fa fa-angle-up data_table_move' data-id=$query->id data-table=$table data-type='moveAfter' style='cursor: pointer'></span>
<span class='fa fa-angle-down data_table_move' data-id=$query->id data-table=$table data-type='moveBefore' style='cursor: pointer'></span>";
    }
}
