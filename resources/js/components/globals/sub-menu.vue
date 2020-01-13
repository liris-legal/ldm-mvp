<template>
  <div class="range--sub-menu">
  <template v-if="subMenu">
    <div class="col-6 pa-0 text-right col-btn font-weight-600">
      <v-btn
        v-click-outside="hidden"
        icon
        @click.stop="showMenu()"
      >
        <v-icon>more_horiz</v-icon>
      </v-btn>
    </div>
    <v-list
      min-width="176"
      :elevation="5"
      class="sub-menu"
      :class="{ 'actived': activated}"
    >
      <v-list-item
        dense
        :href="subLink"
        @click.stop=""
      >
        <v-list-item-title>名前を変更</v-list-item-title>
      </v-list-item>
      <v-list-item dense @click.stop="sendEventDelete()">
        <v-list-item-title>{{ subType === 'documents' ? 'ファイル' : '事件'}}を削除</v-list-item-title>
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
  </div>
</template>

<script>
  import eventBus from "../../eventBus";

  export default {
    name: "sub-menu",
    props: {
      subMenu: {required: false, type: Boolean, default: () => true},
      subLink: {required: false, type: String, default: () => ''},
      subId: {required: false, type: Number, default: () => 0},
      subType: {required: false, type: String, default: () => ''},
      subMessage: {required: false, type: String, default: () => ''},
    },
    data() {
      return {
        activated: false,

      }
    },
    methods:{
      /**
       * @function sendEventDelete
       * @description To hidden a sub-menu
       */
      sendEventDelete(){
        this.activated = false;
        // Send the event on a channel (modal-delete) with a payload
        const payload = {data: this.subId, dataType: this.subType, message: this.subMessage};
        eventBus.$emit('modal-delete', payload)
      },

      /**
       * @function hidden
       * @description To hidden a sub-menu
       */
      hidden() {
        this.activated = false;
      },

      /**
       * @function showMenu
       * @description To show/hidden menu, remove `actived` other submenu
       */
      showMenu() {
        let activatedMenu = document.getElementsByClassName('sub-menu actived');
        if(activatedMenu.length > 0)
          activatedMenu[0].classList.remove('actived');

        this.activated = !this.activated;
      },
    }
  }
</script>

<style scoped>
  .v-btn{
    margin-top: 5px;
  }
</style>
