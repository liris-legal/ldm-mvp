<template>
	<div class="container-fluid cases-page">
		<v-row>
			<v-col class="col-12 header-content">
				<h2 class="title-name text-size-30">民事事件</h2>
				<h3 class="description"/>
			</v-col>
		</v-row>
		
		<div class="overflow overflow-x-auto">
			<table class="table">
				<thead>
					<tr class="title d-flex">
						<th scope="col" class="col col-3">事件番号</th>
						<th scope="col" class="col col-3">事件名</th>
						<th scope="col" class="col col-3">裁判所・部署</th>
						<th scope="col" class="col col-3">原告</th>
						<th scope="col" class="col col-3">原告代理人</th>
						<th scope="col" class="col col-3">被告</th>
						<th scope="col" class="col col-3">被告代理人</th>
						<th scope="col" class="col col-3 f-flex">
							<div class="col1">その他当事者</div>
							<v-spacer></v-spacer>
							<div></div>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="d-flex" @click="clickTR()" v-for="item in cases" :key="item.id">
						<td scope="col" class="col col-3">{{ item.number }}</td>
						<td scope="col" class="col col-3">{{ item.name }}</td>
						<td scope="col" class="col col-3">{{ item.courts_departments }}</td>
						<td scope="col" class="col col-3">{{ submitter(item.defendants) }}</td>
						<td scope="col" class="col col-3">FGHIJ法律事務所</td>
						<td scope="col" class="col col-3">KLMNO株式会社</td>
						<td scope="col" class="col col-3">PQRST法律事務所</td>
						<td scope="col" class="col col-3 d-flex pa-0 last-child-table">
							<div class="col-6"><div class="pl-3">-</div></div>
							<v-spacer></v-spacer>
							<div class="col-6 text-right col-btn font-weight-600 text-size-20">
								<v-btn icon v-on:click="clickBTN" v-on:click.stop="" v-click-outside="hidden">...</v-btn>
							</div>
							<v-list class="subs-menu" v-if="isActive">
								<v-list-item>
									<v-list-item-title>名前を変更</v-list-item-title>
								</v-list-item>
								<v-list-item>
									<v-list-item-title>ファイルを削除</v-list-item-title>
								</v-list-item>
							</v-list>
						</td>
					</tr>
				</tbody>
			</table>
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
      clickTR() {
        console.log('click me!')
			},
      clickBTN() {
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
      },
			submitter(submitter){
   
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