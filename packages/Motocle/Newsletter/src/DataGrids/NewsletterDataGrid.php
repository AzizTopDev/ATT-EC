<?php

namespace Motocle\Newsletter\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

class NewsletterDataGrid extends DataGrid
{
    protected $index = 'id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('newsletter_templates')->select('id', 'name', 'subject', DB::raw('DATE_FORMAT(created_at, "%Y/%m/%d") as created_at'), DB::raw('DATE_FORMAT(updated_at, "%Y/%m/%d") as updated_at'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'name',
            'label' => trans('newsletter::app.cms.newsletter.template-name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'subject',
            'label' => trans('newsletter::app.cms.newsletter.subject'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('newsletter::app.cms.newsletter.created_at'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'updated_at',
            'label' => trans('newsletter::app.cms.newsletter.last_updated_at'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'Edit',
            'method' => 'GET',
            'route' => 'admin.motocle.cms.dm.edit',
            'icon' => 'icon pencil-lg-icon',
        ]);

        // $this->addAction([
        //     'title' => 'Delete',
        //     'method' => 'POST', // use GET request only for redirect purposes
        //     'route' => 'admin.motocle.cms.dm.destroy',
        //     'confirm_text' => trans('newsletter::app.cms.newsletter.confirm_delete'),
        //     'icon' => 'icon trash-icon'
        // ]);

        $this->addAction([
            'title' => 'Delete',
            'method' => 'MODAL', // use GET request only for redirect purposes
            'route' => 'admin.motocle.cms.dm.destroy',
            'confirm_text' => trans('newsletter::app.cms.newsletter.confirm_delete'),
            'icon' => 'icon trash-icon'
        ]);

        $this->enableAction = true;
    }
}
