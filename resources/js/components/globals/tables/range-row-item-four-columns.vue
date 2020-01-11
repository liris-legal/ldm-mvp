<template>
  <tr
    v-if="document"
    v-ripple
    class="range--row-item-four-columns d-flex pa-0"
    @click="redirectToLink(1)"
  >
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    >
      <div class="name">
        {{document.name}}
      </div>
    </td>
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    >
      <div class="name">
        {{document.submitter.name}}
      </div>
    </td>
    <td
      scope="col"
      class="col col-4 d-flex pt-2 pb-2 last-column"
      :class="{'unset-relative': isShowDelete}"
    >
      <div class="col-6 pa-0">
        <div class="name">
          {{document.created_at_wareki}}
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
      class="col col-4 pt-2 pb-2"
    >
      <div class="name">
        データが見つかりません！
      </div>
    </td>
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    />
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    />
  </tr>
</template>

<script>
  export default {
    name: "RangeRowItemFourColumns",
    props: {
      lawsuitId: {required: false, type: Number, default: () => 0},
      document: {required: false, type: Object, default: () => {}},
      subMenu: {required: false, type: Boolean, default: () => true},
    },
    data() {
      return {
        isShowDelete: false,
        isShowSubmenu: false,
      }
    },
    methods: {
      /**
       * @function redirectToLink
       * @description redirect to a link
       */
      redirectToLink() {
        // return window.location.href = '#';
      },

      /**
       * @function deleteLawsuit
       * @description delete a lawsuit
       */
      deleteLawsuit(lawsuit_id){
        this.isShowDelete = true;
        this.count = 1;
        this.activeIndex = undefined;
        this.dataReceived = lawsuit_id;
      },

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
<style lang="scss">
  .unset-relative{
    position: unset !important;
    pointer-events: none;
  }
</style>
