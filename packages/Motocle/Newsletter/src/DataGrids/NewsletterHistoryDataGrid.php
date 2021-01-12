<?php

namespace Motocle\Newsletter\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

class NewsletterHistoryDataGrid extends DataGrid
{
    protected $index = 'id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('newsletters')->select('id', 'name', 'subject', 'count', DB::raw('DATE_FORMAT(created_at, "%Y/%m/%d") as created_at'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('newsletter::app.cms.newsletter.sent_date'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

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
            'index' => 'count',
            'label' => trans('newsletter::app.cms.newsletter.count'),
            'type' => 'numeric',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'View',
            'method' => 'GET',
            'route' => 'admin.motocle.cms.dm.history.view',
            'icon' => 'icon eye-icon'
        ]);
    }
}
