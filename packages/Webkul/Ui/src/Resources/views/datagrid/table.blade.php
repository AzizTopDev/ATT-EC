<div class="table">
    <datagrid-filters></datagrid-filters>

    @if (isset($results['paginated']) && $results['paginated'])
        @include('ui::datagrid.pagination', ['results' => $results['records']])
    @endif

    @push('scripts')
        <script type="text/x-template" id="datagrid-filters">
            <div class="grid-container">
                <div class="filter-row-one" id="datagrid-filters">
                    <div class="search-filter">
                        <input type="search" id="search-field" class="control" placeholder="{{ __('ui::app.datagrid.search') }}" v-model="searchValue" v-on:keyup.enter="searchCollection(searchValue)" />

                        <div class="icon-wrapper">
                            <span class="icon search-icon search-btn" v-on:click="searchCollection(searchValue)"></span>
                        </div>
                    </div>
                </div>

                <div class="filter-row-two">
                    <span class="filter-tag" v-if="filters.length > 0" v-for="filter in filters" style="text-transform: capitalize;">
                        <span v-if="filter.column == 'sort'">@{{ filter.label }}</span>
                        <span v-else-if="filter.column == 'search'">検索条件</span>
                        <span v-else-if="filter.column == 'perPage'">perPage</span>
                        <span v-else>@{{ filter.label }}</span>
                        <span class="wrapper" v-if="filter.column == 'sort'">
                            <span v-if="filter.val == 'desc'">降順</span>
                            <span v-else>昇順</span>
                            <span class="icon cross-icon" v-on:click="removeFilter(filter)"></span>
                        </span>
                        <span class="wrapper" v-else>
                            <span>@{{ decodeURIComponent(filter.val) }}</span>
                            <span class="icon cross-icon" v-on:click="removeFilter(filter)"></span>
                        </span>
                    </span>
                </div>

                <table class="table">
                    @include('ui::datagrid.partials.mass-action-header')

                    @include('ui::datagrid.partials.default-header')

                    @include('ui::datagrid.body', ['records' => $results['records'], 'actions' => $results['actions'], 'index' => $results['index'], 'columns' => $results['columns'],'enableMassActions' => $results['enableMassActions'], 'enableActions' => $results['enableActions'], 'norecords' => $results['norecords']])
                </table>
            </div>
        </script>

        <script>
            Vue.component('datagrid-filters', {
                template: '#datagrid-filters',

                data: function() {
                    return {
                        filterIndex: @json($results['index']),
                        gridCurrentData: @json($results['records']),
                        massActions: @json($results['massactions']),
                        massActionsToggle: false,
                        massActionTarget: null,
                        massActionType: null,
                        massActionValues: [],
                        massActionTargets: [],
                        massActionUpdateValue: null,
                        url: new URL(window.location.href),
                        currentSort: null,
                        dataIds: [],
                        allSelected: false,
                        sortDesc: 'desc',
                        sortAsc: 'asc',
                        sortUpIcon: 'sort-up-icon',
                        sortDownIcon: 'sort-down-icon',
                        currentSortIcon: null,
                        isActive: false,
                        isHidden: true,
                        searchValue: '',
                        filterColumn: true,
                        filters: [],
                        columnOrAlias: '',
                        type: null,
                        columns : @json($results['columns']),
                        stringCondition: null,
                        booleanCondition: null,
                        numberCondition: null,
                        datetimeCondition: null,
                        stringValue: null,
                        booleanValue: null,
                        datetimeValue: '2000-01-01',
                        numberValue: 0,
                        stringConditionSelect: false,
                        booleanConditionSelect: false,
                        numberConditionSelect: false,
                        datetimeConditionSelect: false,
                        perPage: 10,
                    }
                },

                mounted: function() {
                    this.setParamsAndUrl();

                    if (this.filters.length) {
                        for (let i = 0; i < this.filters.length; i++) {
                            if (this.filters[i].column == 'perPage') {
                                this.perPage = this.filters[i].val;
                            }
                        }
                    }
                },

                methods: {
                    getColumnOrAlias: function(columnOrAlias) {
                        this.columnOrAlias = columnOrAlias;

                        for(column in this.columns) {
                            if (this.columns[column].index == this.columnOrAlias) {
                                this.type = this.columns[column].type;

                                if (this.type == 'string') {
                                    this.stringConditionSelect = true;
                                    this.datetimeConditionSelect = false;
                                    this.booleanConditionSelect = false;
                                    this.numberConditionSelect = false;

                                    this.nullify();
                                } else if (this.type == 'datetime') {
                                    this.datetimeConditionSelect = true;
                                    this.stringConditionSelect = false;
                                    this.booleanConditionSelect = false;
                                    this.numberConditionSelect = false;

                                    this.nullify();
                                } else if (this.type == 'boolean') {
                                    this.booleanConditionSelect = true;
                                    this.datetimeConditionSelect = false;
                                    this.stringConditionSelect = false;
                                    this.numberConditionSelect = false;

                                    this.nullify();
                                } else if (this.type == 'number') {
                                    this.numberConditionSelect = true;
                                    this.booleanConditionSelect = false;
                                    this.datetimeConditionSelect = false;
                                    this.stringConditionSelect = false;

                                    this.nullify();
                                } else if (this.type == 'price') {
                                    this.numberConditionSelect = true;
                                    this.booleanConditionSelect = false;
                                    this.datetimeConditionSelect = false;
                                    this.stringConditionSelect = false;

                                    this.nullify();
                                }
                            }
                        }
                    },

                    nullify: function() {
                        this.stringCondition = null;
                        this.datetimeCondition = null;
                        this.booleanCondition = null;
                        this.numberCondition = null;
                    },

                    getResponse: function() {
                        label = '';

                        for(colIndex in this.columns) {
                            if(this.columns[colIndex].index == this.columnOrAlias) {
                                label = this.columns[colIndex].label;
                            }
                        }

                        if (this.type == 'string') {
                            this.formURL(this.columnOrAlias, this.stringCondition, encodeURIComponent(this.stringValue), label)
                        } else if (this.type == 'number') {
                            indexConditions = true;

                            if (this.filterIndex == this.columnOrAlias && (this.numberValue == 0 || this.numberValue < 0)) {
                                indexConditions = false;

                                alert('{{__('ui::app.datagrid.zero-index')}}');
                            }

                            if(indexConditions)
                                this.formURL(this.columnOrAlias, this.numberCondition, this.numberValue, label);
                        } else if (this.type == 'boolean') {
                            this.formURL(this.columnOrAlias, this.booleanCondition, this.booleanValue, label);
                        } else if (this.type == 'datetime') {
                            this.formURL(this.columnOrAlias, this.datetimeCondition, this.datetimeValue, label);
                        } else if (this.type == 'price') {
                            this.formURL(this.columnOrAlias, this.numberCondition, this.numberValue, label);
                        }
                    },

                    sortCollection: function(alias) {
                        label = '';

                        for(colIndex in this.columns) {
                            if(this.columns[colIndex].index == alias) {
                                matched = 0;
                                label = this.columns[colIndex].label;
                            }
                        }

                        this.formURL("sort", alias, this.sortAsc, label);
                    },

                    searchCollection: function(searchValue) {
                        label = 'Search';

                        this.formURL("search", 'all', searchValue, label);
                    },

                    // function triggered to check whether the query exists or not and then call the make filters from the url
                    setParamsAndUrl: function() {
                        params = (new URL(window.location.href)).search;

                        if (params.slice(1, params.length).length > 0) {
                            this.arrayFromUrl();
                        }

                        for(id in this.massActions) {
                            targetObj = {
                                'type': this.massActions[id].type,
                                'action': this.massActions[id].action
                            };

                            this.massActionTargets.push(targetObj);

                            targetObj = {};

                            if (this.massActions[id].type == 'update') {
                                this.massActionValues = this.massActions[id].options;
                            }
                        }
                    },

                    findCurrentSort: function() {
                        for(i in this.filters) {
                            if (this.filters[i].column == 'sort') {
                                this.currentSort = this.filters[i].val;
                            }
                        }
                    },

                    changeMassActionTarget: function() {
                        if (this.massActionType == 'delete') {
                            for(i in this.massActionTargets) {
                                if (this.massActionTargets[i].type == 'delete') {
                                    this.massActionTarget = this.massActionTargets[i].action;

                                    break;
                                }
                            }
                        }

                        if (this.massActionType == 'update') {
                            for(i in this.massActionTargets) {
                                if (this.massActionTargets[i].type == 'update') {
                                    this.massActionTarget = this.massActionTargets[i].action;

                                    break;
                                }
                            }
                        }

                        document.getElementById('mass-action-form').action = this.massActionTarget;
                    },

                    //make array of filters, sort and search
                    formURL: function(column, condition, response, label) {
                        var obj = {};

                        if (column == "" || condition == "" || response == "" || column == null || condition == null || response == null) {
                            alert('{{ __('ui::app.datagrid.filter-fields-missing') }}');

                            return false;
                        } else {
                            if (this.filters.length > 0) {
                                if (column != "sort" && column != "search") {
                                    filterRepeated = 0;

                                    for(j = 0; j < this.filters.length; j++) {
                                        if (this.filters[j].column == column) {
                                            if (this.filters[j].cond == condition && this.filters[j].val == response) {
                                                filterRepeated = 1;

                                                return false;
                                            } else if(this.filters[j].cond == condition && this.filters[j].val != response) {
                                                filterRepeated = 1;

                                                this.filters[j].val = response;

                                                this.makeURL();
                                            }
                                        }
                                    }

                                    if (filterRepeated == 0) {
                                        obj.column = column;
                                        obj.cond = condition;
                                        obj.val = response;
                                        obj.label = label;

                                        this.filters.push(obj);
                                        obj = {};

                                        this.makeURL();
                                    }
                                }

                                if (column == "sort") {
                                    sort_exists = 0;

                                    for (j = 0; j < this.filters.length; j++) {
                                        if (this.filters[j].column == "sort") {
                                            if (this.filters[j].column == column && this.filters[j].cond == condition) {
                                                this.findCurrentSort();

                                                if (this.currentSort == "asc") {
                                                    this.filters[j].column = column;
                                                    this.filters[j].cond = condition;
                                                    this.filters[j].val = this.sortDesc;

                                                    this.makeURL();
                                                } else {
                                                    this.filters[j].column = column;
                                                    this.filters[j].cond = condition;
                                                    this.filters[j].val = this.sortAsc;

                                                    this.makeURL();
                                                }
                                            } else {
                                                this.filters[j].column = column;
                                                this.filters[j].cond = condition;
                                                this.filters[j].val = response;
                                                this.filters[j].label = label;

                                                this.makeURL();
                                            }

                                            sort_exists = 1;
                                        }
                                    }

                                    if (sort_exists == 0) {
                                        if (this.currentSort == null)
                                            this.currentSort = this.sortAsc;

                                        obj.column = column;
                                        obj.cond = condition;
                                        obj.val = this.currentSort;
                                        obj.label = label;

                                        this.filters.push(obj);

                                        obj = {};

                                        this.makeURL();
                                    }
                                }

                                if (column == "search") {
                                    search_found = 0;

                                    for(j = 0; j < this.filters.length; j++) {
                                        if (this.filters[j].column == "search") {
                                            this.filters[j].column = column;
                                            this.filters[j].cond = condition;
                                            this.filters[j].val = response;
                                            this.filters[j].label = label;

                                            this.makeURL();
                                        }
                                    }

                                    for (j = 0;j < this.filters.length;j++) {
                                        if (this.filters[j].column == "search") {
                                            search_found = 1;
                                        }
                                    }

                                    if (search_found == 0) {
                                        obj.column = column;
                                        obj.cond = condition;
                                        obj.val = response;
                                        obj.label = label;

                                        this.filters.push(obj);

                                        obj = {};

                                        this.makeURL();
                                    }
                                }
                            } else {
                                obj.column = column;
                                obj.cond = condition;
                                obj.val = response;
                                obj.label = label;

                                this.filters.push(obj);

                                obj = {};

                                this.makeURL();
                            }
                        }
                    },

                    // make the url from the array and redirect
                    makeURL: function() {
                        newParams = '';

                        for(i = 0; i < this.filters.length; i++) {
                            if (this.filters[i].column == 'status') {
                                if (this.filters[i].val.includes("True")) {
                                    this.filters[i].val = 1;
                                } else if (this.filters[i].val.includes("False")) {
                                    this.filters[i].val = 0;
                                }
                            }

                            if (i == 0) {
                                newParams = '?' + this.filters[i].column + '[' + this.filters[i].cond + ']' + '=' + this.filters[i].val;
                            } else {
                                newParams = newParams + '&' + this.filters[i].column + '[' + this.filters[i].cond + ']' + '=' + this.filters[i].val;
                            }
                        }

                        var uri = window.location.href.toString();

                        var clean_uri = uri.substring(0, uri.indexOf("?")).trim();

                        window.location.href = clean_uri + newParams;
                    },

                    //make the filter array from url after being redirected
                    arrayFromUrl: function() {
                        var obj = {};
                        processedUrl = this.url.search.slice(1, this.url.length);
                        splitted = [];
                        moreSplitted = [];

                        splitted = processedUrl.split('&');

                        for(i = 0; i < splitted.length; i++) {
                            moreSplitted.push(splitted[i].split('='));
                        }

                        for(i = 0; i < moreSplitted.length; i++) {
                            col = moreSplitted[i][0].replace(']', '').split('[')[0];
                            cond = moreSplitted[i][0].replace(']', '').split('[')[1]
                            val = moreSplitted[i][1];

                            label = 'cannotfindthislabel';

                            obj.column = col;
                            obj.cond = cond;
                            obj.val = val;

                            if(col == "sort") {
                                label = '';

                                for(colIndex in this.columns) {
                                    if(this.columns[colIndex].index == obj.cond) {

                                        obj.label = this.columns[colIndex].label;
                                    }
                                }
                            } else if (col == "search") {
                                obj.label = 'Search';
                            } else {
                                obj.label = '';

                                for(colIndex in this.columns) {
                                    if (this.columns[colIndex].index == obj.column) {
                                        obj.label = this.columns[colIndex].label;

                                        if (this.columns[colIndex].type == 'boolean') {
                                            if (obj.val == 1) {
                                                obj.val = '{{ __('ui::app.datagrid.true') }}';
                                            } else {
                                                obj.val = '{{ __('ui::app.datagrid.false') }}';
                                            }
                                        }
                                    }
                                }
                            }

                            if (col != undefined && cond != undefined && val != undefined)
                                this.filters.push(obj);

                            obj = {};
                        }
                    },

                    removeFilter: function(filter) {
                        for(i in this.filters) {
                            if (this.filters[i].col == filter.col && this.filters[i].cond == filter.cond && this.filters[i].val == filter.val) {
                                this.filters.splice(i, 1);

                                this.makeURL();
                            }
                        }
                    },

                    //triggered when any select box is clicked in the datagrid
                    select: function() {
                        this.allSelected = false;

                        if (this.dataIds.length == 0) {
                            this.massActionsToggle = false;
                            this.massActionType = null;
                        } else {
                            this.massActionsToggle = true;
                        }
                    },

                    //triggered when master checkbox is clicked
                    selectAll: function() {
                        this.dataIds = [];

                        this.massActionsToggle = true;

                        if (this.allSelected) {
                            if (this.gridCurrentData.hasOwnProperty("data")) {
                                for (currentData in this.gridCurrentData.data) {

                                    i = 0;
                                    for(currentId in this.gridCurrentData.data[currentData]) {
                                        if (i==0)
                                            this.dataIds.push(this.gridCurrentData.data[currentData][this.filterIndex]);

                                        i++;
                                    }
                                }
                            } else {
                                for (currentData in this.gridCurrentData) {

                                    i = 0;
                                    for(currentId in this.gridCurrentData[currentData]) {
                                        if (i==0)
                                            this.dataIds.push(this.gridCurrentData[currentData][currentId]);

                                        i++;
                                    }
                                }
                            }
                        }
                    },

                    doAction: function(e) {
                        var element = e.currentTarget;

                        if (confirm('{{__('ui::app.datagrid.massaction.delete') }}')) {
                            axios.post(element.getAttribute('data-action'), {
                                _token : element.getAttribute('data-token'),
                                _method : element.getAttribute('data-method')
                            }).then(function(response) {
                                this.result = response;

                                if (response.data.redirect) {
                                    window.location.href = response.data.redirect;
                                } else {
                                    location.reload();
                                }
                            }).catch(function (error) {
                                location.reload();
                            });

                            e.preventDefault();
                        } else {
                            e.preventDefault();
                        }
                    },

                    captureColumn: function(id) {
                        element = document.getElementById(id);

                        console.log(element.innerHTML);
                    },

                    removeMassActions: function() {
                        this.dataIds = [];

                        this.massActionsToggle = false;

                        this.allSelected = false;

                        this.massActionType = null;
                    },

                    paginate: function(e) {
                        for (let i = 0; i < this.filters.length; i++) {
                            if (this.filters[i].column == 'perPage') {
                                this.filters.splice(i, 1);
                            }
                        }

                        this.filters.push({"column":"perPage","cond":"eq","val": e.target.value});

                        this.makeURL();
                    }
                }
            });
        </script>
    @endpush
</div>
