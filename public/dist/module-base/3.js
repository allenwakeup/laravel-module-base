(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{ECho:function(t,i,s){"use strict";s.r(i);s("sMBO");var e={components:{},props:{},data:function(){return{info:{},id:0}},watch:{},computed:{},methods:{handleSubmit:function(){var t=this;if(this.$isEmpty(this.info.name))return this.$message.error("名称不能为空");if(this.$isEmpty(this.info.alias))return this.$message.error("别名不能为空");var i=this.$apiHandle(this.$api.goodcatchModule,this.id);i.status?this.$put(i.url,this.info).then((function(i){return 200==i.code?(t.$message.success(i.msg),t.$router.back()):t.$message.error(i.msg)})):this.$post(i.url,this.info).then((function(i){return 200==i.code?(t.$message.success(i.msg),t.$router.back()):t.$message.error(i.msg)}))},get_info:function(){var t=this;this.$get(this.$api.goodcatchModule+"/"+this.id).then((function(i){t.info=i.data}))},onload:function(){this.$isEmpty(this.$route.params.id)||(this.id=this.$route.params.id,this.get_info())}},created:function(){this.onload()},mounted:function(){}},a=s("KHd+"),n=Object(a.a)(e,(function(){var t=this,i=t.$createElement,s=t._self._c||i;return s("div",{staticClass:"qingwu"},[s("div",{staticClass:"admin_table_page_title"},[s("a-button",{staticClass:"float_right",attrs:{icon:"arrow-left"},on:{click:function(i){return t.$router.back()}}},[t._v("返回")]),t._v("\n        模块编辑\n    ")],1),t._v(" "),s("div",{staticClass:"unline underm"}),t._v(" "),s("div",{staticClass:"admin_form"},[s("a-form-model",{attrs:{"label-col":{span:5},"wrapper-col":{span:12}}},[s("a-form-model-item",{attrs:{label:"名称"}},[s("a-input",{model:{value:t.info.name,callback:function(i){t.$set(t.info,"name",i)},expression:"info.name"}})],1),t._v(" "),s("a-form-model-item",{attrs:{label:"别名"}},[s("a-input",{model:{value:t.info.alias,callback:function(i){t.$set(t.info,"alias",i)},expression:"info.alias"}})],1),t._v(" "),s("a-form-model-item",{attrs:{label:"描述"}},[s("a-input",{model:{value:t.info.description,callback:function(i){t.$set(t.info,"description",i)},expression:"info.description"}})],1),t._v(" "),s("a-form-model-item",{attrs:{"wrapper-col":{span:12,offset:5}}},[s("a-button",{attrs:{type:"primary"},on:{click:t.handleSubmit}},[t._v("提交")])],1)],1)],1)])}),[],!1,null,"5513ffff",null);i.default=n.exports}}]);