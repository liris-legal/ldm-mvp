<template>
  <tr
    v-ripple
    class="documents-four-columns d-flex pa-0"
    @click="redirectToLink(1)"
  >
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    >
      <div class="name">
        lawsuit
      </div>
    </td>
    <td
      scope="col"
      class="col col-4 pt-2 pb-2"
    >
      <div class="name">
        原告
      </div>
    </td>
    <td
      scope="col"
      class="col col-4 d-flex pt-2 pb-2 last-column"
      :class="{'unset-relative': isShowDelete}"
    >
      <div class="col-6 pa-0">
        <div class="name">
          2019年12月31日
        </div>
      </div>
      <v-spacer />
      <div class="col-6 pa-0 text-right col-btn font-weight-600 text-size-20">
        <v-btn
          v-click-outside="hidden"
          icon
          @click="isShowSubmenu = !isShowSubmenu"
          @click.stop=""
        >
          ...
        </v-btn>
      </div>
      <v-list
        class="sub-menu"
        :class="{ 'actived': isShowSubmenu}"
      >
        <v-list-item href="#">
          <v-list-item-title>名前を変更</v-list-item-title>
        </v-list-item>
        <v-list-item @click.stop="">
          <v-list-item-title>ファイルを削除</v-list-item-title>
        </v-list-item>
      </v-list>
    </td>
  </tr>
</template>

<script>
  /**
   * Index: Clicks Outside an Element
   */
  import ClickOutside from 'vue-click-outside';
  export default {
    name: "Index",
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
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
