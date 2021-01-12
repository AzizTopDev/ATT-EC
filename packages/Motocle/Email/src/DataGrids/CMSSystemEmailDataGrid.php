<?php

namespace Motocle\Email\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

class CMSSystemEmailDataGrid extends DataGrid
{
    protected $index = 'id'; //the column that needs to be treated as index column

    protected $sortOrder = 'asc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('system_emails')->select('id', 'type_label', DB::raw("CONCAT(sender_name, ' <', sender_email, '>') AS 'sender'"), 'subject');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $channels = app('Webkul\Core\Repositories\ChannelRepository');

        $locales = app('Webkul\Core\Repositories\LocaleRepository');

        $this->addColumn([
            'index' => 'type_label',
            'label' => trans('email::app.cms.email.email-type'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'subject',
            'label' => trans('email::app.cms.email.subject'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'sender',
            'label' => trans('email::app.cms.email.sender'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'Edit Email',
            'method' => 'GET',
            'route' => 'motocle.cms.email.admin.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);
    }
}
