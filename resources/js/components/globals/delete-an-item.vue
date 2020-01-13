<template>
  <div class="mixin-notification">
    <div class="notification-danger">
      <div class="notification-content">
        <div class="label-delete font-size-16">
          削除
        </div>
        <div class="">
          {{ message }}
        </div>
      </div>
      <div class="row button-notification">
        <div class="col-6 text-center button-content button-left">
          <button
            class="btn btn-success full-width cancel"
            @click="handleCancelSubmit"
          >
            キャンセル
          </button>
        </div>
        <div class="col-6 text-center button-content button-right">
          <button
            class="btn btn-danger full-width accept"
            @click="handleDeleteSubmit"
          >
            削除
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  /**
   * notification-delete is global only for delete a something
   */
  export default {
    name: "AppDeleteAnItem",
    props: {
      data: {type: Number, required: true, default: 0},
      dataType: {type: String, required: true, default: ''},
      message: {type: String, default: 'ファイルを削除してもよろしいですか？'}
    },
    methods: {
      /**
       * @function handleCancelSubmit
       * @description handleCancelSubmit is handle function to close notify
       */
      handleCancelSubmit() {
        this.$emit('cancelSubmit', false)
      },
      /**
       * @function handleDeleteSubmit
       * @description handleDeleteSubmit is handle function to delete data of item
       */
      handleDeleteSubmit() {
        axios.delete(this.dataType +'/' + this.data)
        .then(response => {
          localStorage.setItem(response.data.message.status, response.data.message.content);
          window.location.href = response.data.url;
        })
        .catch(error => {
          this.errors = error.response.data.errors.name
        })
      }
    }
  }
</script>
