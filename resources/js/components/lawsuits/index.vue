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
      <table
        class="table"
      >
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
              class="col col-3"
            >
              その他当事者
              <v-spacer />
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="lawsuits">
            <range-lawsuit-item
              v-for="(lawsuit) in lawsuits"
              :key="'lawsuit-item'+lawsuit.id"
              :lawsuit="lawsuit"
            />
          </template>
        </tbody>
      </table>
      <v-overlay
        :value="overlay"
        :opacity="opacity"
        :absolute="true"
      >
        <v-progress-circular
          indeterminate
          size="100"
        />
      </v-overlay>
    </div>
  </div>
</template>

<script>
  import rangeLawsuitItem from "./shared/range-lawsuit-item"
  import {mapState} from "vuex";
  export default {
    name: "LawsuitsIndex",
    components:{ rangeLawsuitItem },
    data() {
      return {
        lawsuits: null,
        overlay: true,
        opacity: 0.2
      }
    },
    computed: {
      ...mapState(['user']),
    },
    created() {
      axios.get('users/'+this.user.id+'/lawsuits')
        .then(res => {
          this.lawsuits = res.data.data;
          this.overlay = false;
        })
        .catch(error => {
          this.overlay = true;
          console.log(error.response)
        }).finally(() => {
        this.overlay = false;
      })
    },
  }
</script>

<style scoped></style>
