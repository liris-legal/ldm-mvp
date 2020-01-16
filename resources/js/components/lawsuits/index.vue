<template>
  <div class="container-fluid lawsuit-index">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name font-size-30">
          民事事件
        </h2>
        <h3 class="description" />
      </v-col>
    </v-row>

    <div class="overflow-x-auto">
      <table class="table">
        <thead>
          <tr class="title d-flex">
            <th
              scope="col"
              class="col col-3"
            >
              事件番号
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              事件名
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              裁判所・部署
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              原告
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              原告代理人
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              被告
            </th>
            <th
              scope="col"
              class="col col-3"
            >
              被告代理人
            </th>
            <th
              scope="col"
              class="col col-3 f-flex"
            >
              <div class="col1">
                その他当事者
              </div>
              <v-spacer />
            </th>
          </tr>
        </thead>
        <tbody>
          <range-lawsuit-item
            v-for="(lawsuit) in lawsuits"
            :key="'lawsuit-item'+lawsuit.id"
            :lawsuit="lawsuit"
          />
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import rangeLawsuitItem from "../globals/tables/range-lawsuit-item"
  export default {
    name: "LawsuitsIndex",
    components:{
      rangeLawsuitItem,
    },
    data() {
      return {
        lawsuits: {},
      }
    },
    created() {
      axios.get('lawsuits')
        .then(res => {return this.lawsuits = res.data.data;})
        .catch(error => {return error.response})
    },
  }
</script>
