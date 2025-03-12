<template>
    <div>
        <div class="admin_table_page_title">
            <a-button type="link" @click="$router.back()" class="float_right" icon="arrow-left">返回</a-button>
            模块编辑
        </div>
        <div class="unline underm"></div>
        <div class="admin_form">
            <a-form-model ref="form" :model="form" :rules="rules" :label-col="{ span: 6 }"  :wrapper-col="{ span: 16 }" dusk="admin-form">
                <a-form-model-item label="名称">
                    <a-input v-model="info.name"></a-input>
                </a-form-model-item>
                <a-form-model-item label="别名">
                    <a-input v-model="info.alias"></a-input>
                </a-form-model-item>
                <a-form-model-item label="描述">
                    <a-input v-model="info.description"></a-input>
                </a-form-model-item>
                <a-form-model-item :wrapper-col="{ span: 12, offset: 5 }">
                    <a-button type="primary" @click="handleSubmit">提交</a-button>
                </a-form-model-item>
            </a-form-model>

        </div>
    </div>
</template>

<script>
import { MixinForm, MixinStore } from '@/plugins/mixins/admin'
export default {
    mixins: [ MixinForm, MixinStore ],
    components: {},
    props: {},
    data() {
      return {
          info:{
          },
          id:0,
      };
    },
    watch: {},
    computed: {},
    methods: {
        handleSubmit(){

            this.$refs.form.validate(valid => {

                const params = Object.assign({}, this.form);


                if(valid){
                    let api = this.$apiHandle(this.$api.adminModules,this.id);
                    if(api.status){
                        this.$put(api.url,params).then(res=>{
                            if(res.code === 200){
                                this.$message.success(res.msg);
                                this.sendMessageFormUpdated();
                                this.$router.back();
                                return this.$tabs.close();
                            }else{
                                return this.$message.error(res.msg)
                            }
                        })
                    }else{
                        this.$post(api.url,params).then(res=>{
                            if(res.code === 200 || res.code === 201){
                                this.$message.success(res.msg);
                                this.sendMessageFormUpdated();
                                this.$router.back();
                                return this.$tabs.close();
                            }else{
                                return this.$message.error(res.msg)
                            }
                        })
                    }
                } else {
                    this.$message.error('请按要求填写表单！');
                    return false;
                }
            });

        },
        getForm(){
            this.$get(this.$api.adminModules+'/'+this.id).then(res=>{
                if(res.code === 200 && !!res.data) {
                    this.form = res.data;
                }
            })
        },

        // 获取列表
        onload(){


            // 判断你是否是编辑
            if(!this.$isEmpty(this.$route.params.id)){
                this.id = this.$route.params.id;
                this.getForm();
            }
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

