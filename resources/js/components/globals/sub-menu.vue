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
        v-click-outside="hidden"
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
        <v-list-item
          dense
          @click.stop="sendEventDelete()"
        >
          <v-list-item-title>{{ subType === 'documents' ? 'ファイル' : '事件' }}を削除</v-list-item-title>
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
    name: "SubMenu",
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
    watch: {
      activated(val){
        this.$emit('update:overlay', val);
      }
    },
    created() {
      // Listening the event menu-activated
      eventBus.$on('menu-activated', this.handler);
    },
    destroyed() {
      // Stop listening the event menu-activated with handler
      eventBus.$off('menu-activated', this.handler);
    },
    methods:{
      /**
       * @function handler
       * @description parse payload data
       */
      handler(payload){
        if (this.$options._parentVnode.key !== payload)
          this.activated = false;
      },
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
        this.activated = !this.activated;
        eventBus.$emit('menu-activated', this.$options._parentVnode.key);
      },
    }
  }
</script>

<style scoped>
  .v-btn{
    margin-top: 5px;
  }
</style>
