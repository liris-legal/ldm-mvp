<template>
  <div class="range-alert">
    <div class="col-5">
      <!-- dynamic component -->
      <transition
        name="fade"
        mode="out-in"
        appear
      >
        <v-alert
          v-if="notification"
          dismissible
          :value="true"
          :type="notification.type"
        >
          {{ notification.message }}
        </v-alert>
      </transition>
    </div>
  </div>
</template>

<script>
  export default {
    name: "RangeAlerts",
    props: {
      notification: { type: Object, required: true, default: () => {} },
    },
    data () {
      return {
        type: 'true',
      }
    },
    mounted() {
      console.log('notification mounted');
      setTimeout(this.cleanNotification, 5000)
    },
    methods: {
      cleanNotification(){
        if (this.notification) {
          this.$store.dispatch('delete_notification');
          console.log('removed notification')
        }
      }
    }
  }
</script>

<style scoped>
  .range-alert {
    position: absolute;
    display: block;
    margin: 0 auto;
    width: 100%;
    transform: translate(30%, 2em);
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    transition: opacity .5s;
  }
</style>
