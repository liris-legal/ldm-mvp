<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      min-width="358"
      max-width="360"
      min-height="242"
      max-height="250"
    >
      <v-card>
        <v-card-title class="headline">
          {{ title }}
        </v-card-title>
        <v-card-text>{{ message }}</v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-col
            class="text-center"
            cols="6"
            sm="6"
          >
            <v-btn
              class="dark--text"
              @click="dialog = false"
            >
              キャンセル
            </v-btn>
          </v-col>

          <v-col
            class="text-center"
            cols="6"
            sm="6"
          >
            <v-btn
              color="red"
              @click="handleDeleteSubmit"
            >
              削除
            </v-btn>
          </v-col>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import eventBus from "../../eventBus";
  import {mapState} from "vuex";
  /**
   * modal is global component be used to delete data
   */
  export default {
    name: "AppModal",
    data() {
      return {
        dialog: false,
        title: '削除',
        data: 0,
        dataType: 'types',
        message: 'ファイルを削除してもよろしいですか？',
      }
    },
    computed: {
      ...mapState(['user']),
    },
    created() {
      // Listening the event modal-delete
      eventBus.$on('modal-delete', this.handler);
    },
    destroyed() {
      // Stop listening the event modal-delete with handler
      eventBus.$off('modal-delete', this.handler);
    },
    methods: {
      /**
       * @function handler
       * @description parse payload data
       */
      handler(e){
        this.dialog = true;
        this.data = e.data;
        this.dataType = e.dataType;
        this.message = e.message || this.message;
      },

      /**
       * @function handleDeleteSubmit
       * @description handleDeleteSubmit is handle function to delete data of item
       */
      handleDeleteSubmit() {
        this.dialog = false;
        axios.delete('users/'+this.user.id+'/'+this.dataType +'/' + this.data)
        .then(res => {
          this.$store.dispatch('create_notification', res.data.message);
          setTimeout(function(){ location.href = res.data.url; }, 3000);
        })
        .catch(error => {
          console.log(error);
          this.errors = error.response.data.errors
        })
      }
    },
  }
</script>

<style scoped>
  .v-card__actions{
    padding: 1em;
  }
  .theme--light.v-btn{
    color: #fff;
    font-weight: 600;
    min-width: 90%
  }
  .v-btn.dark--text{
    color: #000;
  }
</style>
