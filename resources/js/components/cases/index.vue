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
					<v-col class="d-flex col-12 half-width">
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
					
					<v-col class="d-flex col-12">
						<v-col class="col-3">
							<div class="name font-weight-600">原告代理人</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">被告</div>
						</v-col>
						<v-col class="col-3">
							<div class="name font-weight-600">被告代理人</div>
						</v-col>
						<v-col class="col-3 row">
							<div class="col-6">
								<div class="name font-weight-600">その他当事者</div>
							</div>
							<div class="col-6 text-right">
								<div class="name font-weight-600">...</div>
							</div>
						</v-col>
					</v-col>
				</div>
<!--				<div class="t-body">-->
<!--					<a href="#" class="document-link">-->
<!--						<v-row v-ripple>-->
<!--							<v-col :class="columnOfClass.class1">-->
<!--								<div class="name">{{ document.name }}</div>-->
<!--							</v-col>-->
<!--							<v-col :class="columnOfClass.class2">-->
<!--								<div class="date">{{ document.updated_at }}</div>-->
<!--							</v-col>-->
<!--						</v-row>-->
<!--					</a>-->
<!--				</div>-->
			</div>
		</div>
	</div>
</template>

<script>
  export default {
    name: "index",
		props: {
      cases: { type: Array, required: false, default: [] }
		},
		mounted() {
      console.log(this.cases)
    }
  }
</script>

<style scoped lang="scss">
	.scroll-slide {
		width: auto;
		overflow-x: scroll;
		overflow-y: visible;
		.pseudo-table{
			width: 100%;
			.thead {
				display: flex;
				width: 100%;
				.half-width{
					max-width: 100%;
				}
			}
		}
	}
	::-webkit-scrollbar {
		width: 0;
	}
</style>