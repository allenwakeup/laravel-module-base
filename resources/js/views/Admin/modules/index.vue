<template>
    <div>
        <div class="admin_table_page_title">模块化列表</div>
        <div class="unline underm"></div>

        <div class="admin_table_list">
            <a-table
                :size="sysSize"
                :components="resizeableTitleComponents"
                :columns="getCachedTableColumns(table.columns)"
                :data-source="table.data"
                :scroll="{ y: sysWindowHeight - 280 }"
                :loading="table.loading"
                :pagination="false"
                :row-selection="{ columnWidth: 25, selectedRowKeys: table.selectedRowKeys, onChange: handleTableRowKeysChange }"
                :row-key="table.rowId"
                @change="handleTableChange">

                <template slot="title" slot-scope="currentPageData">

                    <search
                        :search-config="search.fields"
                        :auto-params="search.params"
                        @searchParams="handleTableSearchParams"
                        :export-config="exporting"
                        @handleExport="handleTableExport"/>

                    <div class="admin_table_handle_btn">
                        <a-button @click="$router.push($moduleUrl('modules/form'))" type="primary" :size="sysSize" icon="plus">添加</a-button>
                        <a-button v-if="!$isEmpty(table.actions.remove)" class="admin_delete_btn" :size="sysSize" type="danger" icon="delete" @click="handleRemoveTableRows">批量删除</a-button>
                    </div>
                </template>

                <span slot="action" slot-scope="rows">
                    <a-button type="link" icon="edit" :size="sysSize" @click="$router.push($moduleUrl('modules/form/'+rows.id))">编辑</a-button>
                </span>
            </a-table>
            <div class="admin_pagination" v-if="table.total > 0">
                <a-pagination v-model="table.params.page" :size="sysSize" :page-size-options="table.pageSizeOptions" :total="table.total" :show-total="total => `共 ${total} 条`" @change="handleTablePageChange" show-less-items show-size-changer show-quick-jumper :page-size="table.params.per_page" @showSizeChange="handleTablePageSizeChange"/>
            </div>
        </div>
    </div>
</template>

<script>

import Search from '@/components/admin/search'
import { MixinList, MixinStore } from '@/plugins/mixins/admin'

export default {
    mixins: [ MixinList, MixinStore ],
    components: { Search },
    props: {},
    data() {
        return {
            table: {
                actions: {
                    list: this.$api.adminModules,
                    remove: this.$api.adminModules
                },
                columns: [
                    {title:'#',dataIndex:'id',width: 80, key: 'id', ellipsis: true},
                    {title:'名称',dataIndex:'name', width: 80, key: 'name', ellipsis: true},
                    {title:'别名',dataIndex:'alias', width: 80, key: 'alias', ellipsis: true},
                    {title:'描述',dataIndex:'description', width: 180, key: 'description', ellipsis: true},
                    {title:'优先级',dataIndex:'priority', width: 80, key: 'priority', ellipsis: true},
                    {title:'版本号',dataIndex:'version', width: 80, key: 'version', ellipsis: true},
                    {title:'安装路径',dataIndex:'path', width: 180, key: 'path', ellipsis: true},
                    {title:'类型',dataIndex:'type', width: 80, key: 'type', ellipsis: true},
                    {title:'排序',dataIndex:'sort', width: 80, key: 'sort', ellipsis: true},
                    {title:'状态',dataIndex:'status', width: 80, key: 'status', ellipsis: true},
                    {title:'创建时间',dataIndex:'created_at', width: 80, key: 'created_at', ellipsis: true},
                    {title:'更新时间',dataIndex:'updated_at', width: 80, key: 'updated_at', ellipsis: true},
                    {title: '操作', scopedSlots: {customRender: 'action'}, width: 100, key: 'action'},
                ],
            },
            search: {
                fields: [
                    {
                        label: '名称',
                        name: 'name',
                        type: 'text'
                    }
                ]
            },

            loading_status: {}
        }

    },
    watch: {},
    computed: {},
    methods: {

        onload(){

            // 加载混入中的表格数据
            this.loadTableData();
        }
    },
    created() {
        this.onload();
    },
    mounted() {}
};
</script>
<style lang="scss" scoped>

</style>

