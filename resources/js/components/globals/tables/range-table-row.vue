<template>
  <tr
    v-if="document"
    v-ripple
    class="range--row-item d-flex pa-0"
    @click="showLawsuitDocument(lawsuitId)"
  >
    <td
      scope="col"
      class="col"
      :class="className"
    >
      <div class="name">
        {{ documentName }}
      </div>
    </td>
    <td
      v-if="numberColumns === 3"
      scope="col"
      class="col col-4"
    >
      <div class="name">
        {{ document.submitter.name }}
      </div>
    </td>
    <td
      scope="col"
      class="col d-flex last-column"
    >
      <div class="col-6 pa-0">
        <div class="name">
          {{ document.created_at_wareki }}
        </div>
      </div>
      <v-spacer />
      <sub-menu
        :key="'sub-menu-'+document.id"
        :sub-menu="subMenu"
        :sub-link="'/lawsuits/'+lawsuitId+'/documents/'+document.id+'/edit'"
        :sub-id="document.id"
        :sub-type="'documents'"
      />
    </td>
  </tr>
  <tr
    v-else
    v-ripple
    class="range--row-item d-flex pa-0"
  >
    <td
      scope="col"
      class="col"
      :class="className"
    >
      <div class="name">
        データが見つかりません！
      </div>
    </td>
    <td
      v-if="numberColumns"
      scope="col"
      class="col col-4"
    />
    <td
      scope="col"
      class="col"
      :class="className"
    />
  </tr>
</template>

<script>
  import subMenu from "../sub-menu"
  export default {
    name: "RangeRowItem",
    components:{
      subMenu
    },
    props: {
      lawsuitId: {required: false, type: Number, default: () => 0},
      document: {required: false, type: Object, default: () => {}},
      documentName: {required: false, type: String, default: () => ''},
      subMenu: {required: false, type: Boolean, default: () => true},
      numberColumns: {required: false, type: Number, default: () => 2},
    },
    data() {
      return {
        className: 'col-6'
      }
    },
    created() {
      this.className = 'col-' + (12/this.numberColumns);
    },
    methods: {
      /**
       * @function showLawsuitDocument
       * @description goto show documents of lawsuit
       */
      showLawsuitDocument(lawsuit_id) {
        location.href = '/lawsuits/' + lawsuit_id + '/documents';
      },
    }
  }
</script>

<style scoped>

</style>
