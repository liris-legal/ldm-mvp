<template>
  <div class="container-fluid cases-page">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">民事事件</h2>
        <h3 class="description"/>
      </v-col>
    </v-row>

    <div class="overflow overflow-x-auto">
      <table class="table">
        <thead>
        <tr class="title d-flex">
          <th scope="col" class="col col-3">事件番号</th>
          <th scope="col" class="col col-3">事件名</th>
          <th scope="col" class="col col-3">裁判所・部署</th>
          <th scope="col" class="col col-3">原告</th>
          <th scope="col" class="col col-3">原告代理人</th>
          <th scope="col" class="col col-3">被告</th>
          <th scope="col" class="col col-3">被告代理人</th>
          <th scope="col" class="col col-3 f-flex">
            <div class="col1">その他当事者</div>
            <v-spacer></v-spacer>
            <div></div>
          </th>
        </tr>
        </thead>
        <tbody>
          <rangRowLawsuit v-for="(lawsuit, index) in lawsuits" :lawsuit="lawsuit" :index="index" :key="index" />
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import rangRowLawsuit from './range-row-lawsuit'

  export default {
    name: "Index",
    components: {
      rangRowLawsuit
    },
    props: {
      lawsuits: {type: Array, required: true, default: () => []}
    }
  }
</script>
<style lang="scss">
	.unset-relative{
		position: unset !important;
		pointer-events: none;
	}
</style>
