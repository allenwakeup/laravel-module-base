<template>
    <div class="qingwu">
        <div class="admin_table_page_title">模块化列表</div>
        <div class="unline underm"></div>

        <div class="admin_table_list">
            <a-table
                    :columns="columns"
                    :data-source="list"
                    :pagination="false"
                    :row-selection="{ selectedRowKeys: selectedRowKeys, onChange: onSelectChange }"
                    row-key="id">
                <template slot="title" slot-scope="currentPageData">
                    <search :search-config="search" @searchParams="onSearchParams"/>
                    <div class="admin_table_handle_btn">
                        <a-button @click="$router.push('/Admin/goodcatch/admin/modules/form')" type="primary" icon="plus">添加</a-button>
                        <a-button class="admin_delete_btn" type="danger" icon="delete" @click="del">批量删除</a-button>
                    </div>
                </template>

                <span slot="action" slot-scope="rows">
                    <a-button icon="edit" @click="$router.push('/Admin/goodcatch/admin/modules/form/'+rows.id)">编辑</a-button>
                </span>
            </a-table>
            <div class="admin_pagination" v-if="total>0">
                <a-pagination v-model="params.page" :page-size.sync="params.per_page" :total="total" @change="onChange" show-less-items />
            </div>
        </div>
    </div>
</template>

<script>

import Search from '@/components/admin/search'
export default {
    components: { Search },
    props: {},
    data() {
      return {
          params:{
              page:1,
              per_page:30,
          },
          total:0, //总页数
          search: [
              {
                  label: '名称',
                  name: 'name',
                  type: 'text'
              }
          ],
          list_loading: false,
          searchParams: {},
          selectedRowKeys:[], // 被选择的行
          columns:[
              {title:'#',dataIndex:'id',fixed:'left'},
              {title:'名称',dataIndex:'name'},
              {title:'别名',dataIndex:'alias'},
              {title:'描述',dataIndex:'description'},
              {title:'优先级',dataIndex:'priority'},
              {title:'版本号',dataIndex:'version'},
              {title:'安装路径',dataIndex:'path'},
              {title:'类型',dataIndex:'type'},
              {title:'排序',dataIndex:'sort'},
              {title:'状态',dataIndex:'status'},
              {title:'创建时间',dataIndex:'created_at'},
              {title:'更新时间',dataIndex:'updated_at'},
              {title:'操作',fixed:'right',scopedSlots: { customRender: 'action' }},
          ],
          list:[],
      };
    },
    watch: {},
    computed: {},
    methods: {
        // 查询条件
        onSearchParams(search) {
            this.searchParams = search;
            this.getList();
        },
        // 选择框被点击
        onSelectChange(selectedRowKeys) {
            this.selectedRowKeys = selectedRowKeys;
        },
        // 选择分页
        onChange(e){
            this.params.page = e;
        },
        // 删除
        del(){
            if(this.selectedRowKeys.length===0){
                return this.$message.error('未选择数据.');
            }
            this.$confirm({
                title: '你确定要删除选择的数据？',
                content: '确定删除后无法恢复.',
                okText: '是',
                okType: 'danger',
                cancelText: '取消',
                onOk:()=> {
                    let ids = this.selectedRowKeys.join(',');
                    this.$delete(this.$api.goodcatchModule+'/'+ids).then(res=>{
                        if(res.code === 200){
                            this.onload();
                            this.$message.success('删除成功');
                        }else{
                            this.$message.error(res.msg)
                        }
                    });

                },
            });
        },
        getList(){
            this.list_loading = true;
            const params = Object.assign({}, this.searchParams, this.params);
            this.$get(this.$api.goodcatchModule, params).then(res=>{
                if (res.code === 200){
                    this.total = res.data.total;
                    this.list = res.data.data;
                }
                this.list_loading = false;
            }, err=>{
                this.$message.error('数据加载失败');
                this.list_loading = false;
            });
        },
        onload(){
            this.getList();
        },
    },
    created() {
        this.onload();
    },
    mounted() {}
};
</script>
<style lang="scss" scoped>

</style>
