<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

class ShopNotificationDataGrid extends DataGrid
{
    protected $sortOrder = 'desc'; //asc or desc

    protected $index = 'id';

    protected $itemsPerPage = 20;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('shop_notifications')
            ->where('shop_notifications.deleted_flag', 0)
            ->select('shop_notifications.*');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'display_flag',
            'label' => trans('admin::app.datagrid.display_flag'),
            'type' => 'thumbnail',
            'searchable' => false,
            'sortable' => false,
            'filterable' => false,
            'wrapper' => function ($value) {
                if ($value->display_flag == 1)
                    return '表示中';
                else
                    return '非表示';
            }
        ]);

        $this->addColumn([
            'index' => 'admin_name',
            'label' => trans('admin::app.datagrid.admin_name'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => trans('admin::app.datagrid.title'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('admin::app.datagrid.created_at'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'updated_at',
            'label' => trans('admin::app.datagrid.last_updated_at'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'Edit Notification',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.shop-notification.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        // $this->addAction([
        //     'title' => 'Delete Notification',
        //     'method' => 'POST', // use GET request only for redirect purposes
        //     'route' => 'admin.shop-notification.delete',
        //     'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'notification']),
        //     'icon' => 'icon trash-icon'
        // ]);

        $this->addAction([
            'title' => 'Delete Notification',
            'method' => 'MODAL', // use GET request only for redirect purposes
            'route' => 'admin.shop-notification.delete',
            'confirm_text' => 'この通知を削除してよろしいですか？',
            'icon' => 'icon trash-icon'
        ]);

        $this->enableAction = true;
    }
}
