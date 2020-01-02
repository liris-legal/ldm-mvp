<template>
	<div class="mixin-notification">
		<div class="notification-danger">
			<div class="notification-content">
				<div class="label-delete text-size-20">削除</div>
				<div class="text-size-18">{{ message }}</div>
			</div>
			<div class="row button-notification label-size-15">
				<div class="col-6 text-center button-content button-left">
					<button @click="handleCancelSubmit" class="btn btn-success full-width accept">キャンセル</button>
				</div>
				<div class="col-6 text-center button-content button-right">
					<button @click="handleDeleteSubmit" class="btn btn-danger full-width cancel">削除</button>
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
    name: "app-delete-an-item",
    props: {
      data: {Number, required: true},
      dataType: {type: String, required: false, default: ''},
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
    },
		mounted() {
      console.log(this.data)
    }
  }
</script>