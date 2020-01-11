<template>
  <tr
    v-if="document"
    v-ripple
    class="range--row-item d-flex pa-0"
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
        {{document.submitter.name}}
      </div>
    </td>
    <td
      scope="col"
      class="col d-flex last-column"
      :class="[{'unset-relative': isShowDelete}, className]"
    >
      <div class="col-6 pa-0">
        <div class="name">
          {{ document.created_at_wareki }}
        </div>
      </div>
      <v-spacer />
      <template v-if="subMenu">
        <div class="col-6 pa-0 text-right col-btn font-weight-600 font-size-20">
          <v-btn
            v-click-outside="hidden"
            icon
            @click="isShowSubmenu = !isShowSubmenu"
            @click.stop=""
          >
            <v-icon>more_horiz</v-icon>
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
      <template v-else>
        <div class="col-6 pa-0 text-right col-btn font-weight-600 font-size-20">
          <v-btn
            disabled
            icon
          >
            <v-icon>more_horiz</v-icon>
          </v-btn>
        </div>
      </template>
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
  export default {
    name: "RangeRowItem",
    props: {
      lawsuitId: {required: false, type: Number, default: () => 0},
      document: {required: false, type: Object, default: () => {}},
      documentName: {required: false, type: String, default: () => ''},
      subMenu: {required: false, type: Boolean, default: () => true},
      numberColumns: {required: false, type: Number, default: () => 2},
    },
    data() {
      return {
        isShowSubmenu: false,
        isShowDelete: false,
        className: 'col-6'
      }
    },
    created() {
      this.className = 'col-' + (12/this.numberColumns);
    },
    mounted() {
      // console.log('range-row-item mounted');
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
    }
  }
</script>

<style scoped>

</style>
