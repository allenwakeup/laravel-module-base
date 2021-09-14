<template>
  <a-result status="404" title="404" sub-title="Sorry, the page you visited does not exist.">
    <template #extra>
      <a-button type="primary" @click="backToHome">
        返回首页
      </a-button>
    </template>
  </a-result>
</template>

<script>
export default {
  components: {
  },
  props: {},
  data() {
    return {

    };
  },
  watch: {},
  computed: {},
  methods: {

    backToHome(){


    },
  },
  created() {

  },
  mounted() {
  },
}
</script>

<style>

</style>