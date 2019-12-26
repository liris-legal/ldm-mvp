<template>
	<div class="container-fluid cases-page">
		<v-row>
			<v-col class="col-12 header-content">
				<h2 class="title-name text-size-30">民事事件</h2>
				<h3 class="description"/>
			</v-col>
		</v-row>
		
		<div class="scroll-slide">
			<div class="list-case-wrapper pseudo-table">
				<div class="thead d-flex">
					<v-col class="d-flex col-12 bg-thead-table">
						<v-col class="col-3">
							<div class="name font-weight-600">事件番号</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">事件名</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">裁判所・部署</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">原告</div>
						</v-col>
					</v-col>
					
					<v-col class="d-flex col-12 bg-thead-table">
						<v-col class="col-3">
							<div class="name font-weight-600">原告代理人</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">被告</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">被告代理人</div>
						</v-col>
						<v-col class="col-3 d-flex pa-0">
								<div class="col-6">
									<div class="name font-weight-600">その他当事者</div>
								</div>
								<div class="col-6 text-right pa-0">
									<div class="name font-weight-600"></div>
								</div>
						</v-col>
					</v-col>
				</div>
				
				<div class="tbody">
					<a href="#" v-on:click="clickme" class="row-content d-flex">
						<v-col class="d-flex col-12 bg-tbody-table" v-ripple>
							<v-col class="col-3">
								<div class="name">事件番号</div>
							</v-col>
							<v-col class="col-3">
								<div class="name">事件名</div>
							</v-col>
							<v-col class="col-3">
								<div class="name">裁判所・部署</div>
							</v-col>
							<v-col class="col-3">
								<div class="name">原告</div>
							</v-col>
						</v-col>
						
						<v-col class="d-flex col-12 bg-tbody-table" v-ripple>
							<v-col class="col-3">
								<div class="name">原告代理人</div>
							</v-col>
							<v-col class="col-3">
								<div class="name">被告</div>
							</v-col>
							<v-col class="col-3">
								<div class="name">被告代理人</div>
							</v-col>
							<v-col class="col-3 d-flex pa-0">
								<div class="col-6">
									<div class="name4">その他当事者</div>
								</div>
								<div class="col-6 text-right pa-0">
									<v-btn icon v-on:click="clickButton" v-click-outside="hidden">...</v-btn>
									<v-list class="list-menu-top-bar" v-show="!isActive">
										<v-list-item>
											<v-list-item-title>module 1</v-list-item-title>
										</v-list-item>
										<v-list-item>
											<v-list-item-title>delete</v-list-item-title>
										</v-list-item>
									</v-list>
								</div>
							</v-col>
						</v-col>
					</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
  import ClickOutside from 'vue-click-outside'
  export default {
    name: "index",
		props: {
      cases: { type: Array, required: false, default: [] }
		},
		data() {
      return {
        isActive: false
			}
		},
    methods: {
      /**
       * @function hidden
       * @description To hidden a block
       */
      hidden() {
        this.isActive = false;
      },
      clickme() {
        console.log('click me!')
			},
			clickButton() {
        this.isActive = !this.isActive;
        console.log('click button!')
			},

      /**
       * @function checkRoute
       * @description Check route and active class when click on url
       * @return boolean
       */
      checkRoute($url) {
        return window.location.pathname === $url;
      }
    },
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
    },
		mounted() {
      console.log(this.cases)
    }
  }
</script>