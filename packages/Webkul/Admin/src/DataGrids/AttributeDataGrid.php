<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class AttributeDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('attributes')
            ->select('id')
            ->addSelect('id', 'code', 'admin_name', 'type', 'value_per_channel');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'code',
            'label'      => trans('admin::app.datagrid.code'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'admin_name',
            'label'      => trans('admin::app.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => trans('admin::app.type'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
            'wrapper' => function ($value) {
                return trans('admin::app.catalog.attributes.' . $value->type);
            }
        ]);

        $this->addColumn([
            'index'      => 'value_per_channel',
            'label'      => trans('admin::app.channel-based'),
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper'    => function($value) {
                if ($value->value_per_channel == 1) {
                    return trans('admin::app.datagrid.true');
                } else {
                    return trans('admin::app.datagrid.false');
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'admin.catalog.attributes.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'  => trans('admin::app.datagrid.delete'),
            'method' => 'POST',
            'route'  => 'admin.catalog.attributes.delete',
            'icon'  => 'icon trash-icon',
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'action' => route('admin.catalog.attributes.massdelete'),
            'label'  => trans('admin::app.datagrid.delete'),
            'index'  => 'admin_name',
            'method' => 'DELETE',
        ]);
    }

    public function getCollection()
    {
        $parsedUrl = $this->parseUrl();

        if (isset($parsedUrl['search']['all']) && strlen(trim($parsedUrl['search']['all'])) > 0) {
            $matchingTypes = [];
            $matchingTypes[] = $parsedUrl['search']['all'];

            $attributeTypes = [
                'text',
                'textarea',
                'price',
                'boolean',
                'select',
                'multiselect',
                'datetime',
                'date',
                'image',
                'file',
                'checkbox'
            ];

            foreach ($attributeTypes as $attributeType) {
                if (strpos(trans('admin::app.catalog.attributes.' . $attributeType), $parsedUrl['search']['all']) !== false) {
                    $matchingTypes[] = $attributeType;
                }
            }

            $parsedUrl['search']['all'] = $matchingTypes;
        }

        foreach ($parsedUrl as $key => $value) {
            if ( $key == 'locale') {
                if ( ! is_array($value)) {
                    unset($parsedUrl[$key]);
                }
            } elseif ( ! is_array($value)) {
                unset($parsedUrl[$key]);
            }
        }

        if (count($parsedUrl)) {
            $filteredOrSortedCollection = $this->sortOrFilterCollection($this->collection = $this->queryBuilder, $parsedUrl);

            if ($this->paginate) {
                if ($this->itemsPerPage > 0)
                    return $filteredOrSortedCollection->orderBy($this->index, $this->sortOrder)->paginate($this->itemsPerPage)->appends(request()->except('page'));
            } else {
                return $filteredOrSortedCollection->orderBy($this->index, $this->sortOrder)->get();
            }
        }

        if ($this->paginate) {
            if ($this->itemsPerPage > 0) {
                $this->collection = $this->queryBuilder->orderBy($this->index, $this->sortOrder)->paginate($this->itemsPerPage)->appends(request()->except('page'));
            }
        } else {
            $this->collection = $this->queryBuilder->orderBy($this->index, $this->sortOrder)->get();
        }

        return $this->collection;
    }

    private function parseUrl()
    {
        $parsedUrl = [];
        $unparsed = url()->full();

        $route = request()->route() ? request()->route()->getName() : "";

        if ($route == 'admin.datagrid.export') {
            $unparsed = url()->previous();
        }

        if (count(explode('?', $unparsed)) > 1) {
            $to_be_parsed = explode('?', $unparsed)[1];

            parse_str($to_be_parsed, $parsedUrl);
            unset($parsedUrl['page']);
        }

        $this->itemsPerPage = isset($parsedUrl['perPage']) ? $parsedUrl['perPage']['eq'] : $this->itemsPerPage;

        unset($parsedUrl['perPage']);

        return $parsedUrl;
    }
}
