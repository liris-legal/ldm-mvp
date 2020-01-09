<template>
  <tr
    v-ripple
    class="range--row-item d-flex pa-0"
  >
    <td
      scope="col"
      class="col col-6 pt-2 pb-2"
    >
      <div class="name">
        {{document.name}}
      </div>
    </td>
    <td
      scope="col"
      class="col col-6 d-flex pt-2 pb-2 last-column"
      :class="{'unset-relative': isShowDelete}"
    >
      <div class="col-6 pa-0">
        <div class="name">
          {{document.created_at}}
        </div>
      </div>
      <template v-if="subMenu">
        <v-spacer />
        <div class="col-6 pa-0 text-right col-btn font-weight-600 text-size-20">
          <v-btn
            icon
            @click="isShowSubmenu = !isShowSubmenu"
            @click.stop=""
            v-click-outside="hidden"
          >
            ...
          </v-btn>
        </div>
        <v-list
          class="sub-menu"
          :class="{ 'actived': isShowSubmenu}"
        >
          <v-list-item
            :href="'/lawsuits/'+lawsuitId+'/documents/'+document.id+'/edit'"
            @click.stop=""
          >
            <v-list-item-title>名前を変更</v-list-item-title>
          </v-list-item>
          <v-list-item @click.stop="">
            <v-list-item-title>ファイルを削除</v-list-item-title>
          </v-list-item>
        </v-list>
      </template>
    </td>
  </tr>
</template>

<script>
  export default {
    name: "range-row-item",
    props: {
      lawsuitId: {required: false,  type: Number, default: () => 0},
      document: {required: true,  type: Object, default: () => {}},
      submitter: {required: false,  type: String, default: () => '#'},
      subMenu: {required: false,  type: Boolean, default: () => true},
    },
    data() {
      return {
        isShowSubmenu: false,
        isShowDelete: false,
      }
    },
    methods: {
      /**
       * @function hidden
       * @description To hidden a sub-menu
       */
      hidden() {
        this.isShowSubmenu = false;
        this.isShowDelete = false;
      },
    },
    mounted() {
      // console.log('range-row-item mounted');
    }
  }
</script>

<style scoped>

</style>
