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
          <template v-for="(lawsuit, index) in lawsuits">
            <tr
              :key="lawsuit.id"
              class="d-flex"
              @click="showLawsuit(lawsuit.id)"
            >
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.created_at_wareki
                }}{{
                  lawsuit.number
                }}号
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.name
                }}
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.courts_departments
                }}
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.defendants | parseName
                }}
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.defendant_representatives | parseName
                }}
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.plaintiffs | parseName
                }}
              </td>
              <td
                scope="col"
                class="col col-3"
              >
                {{
                  lawsuit.plaintiff_representatives | parseName
                }}
              </td>
              <td
                scope="col"
                class="col col-3 d-flex pa-0 last-child-table"
              >
                <div class="col-md-6 col-lg-6">
                  {{ lawsuit.other_parties | parseName }}
                </div>
                <v-spacer />
                <sub-menu
                  :sub-link="'lawsuits/' + lawsuit.id + '/edit'"
                  :sub-id="lawsuit.id"
                  :sub-type="'lawsuits'"
                  :sub-message="'事件を削除してもよろしいですか？'"
                />
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import subMenu from "../globals/sub-menu"
  export default {
    name: "LawsuitsIndex",
    data() {
      return {
        lawsuits: {},
      }
    },
    components:{
      subMenu
    },
    created() {
      axios.get('lawsuits')
        .then(res => {return this.lawsuits = res.data.data;})
        .catch(error => {return error.response})
    },
    methods: {
      /**
       * @function showLawsuit
       * @description goto show lawsuit page
       */
      showLawsuit(lawsuit_id) {
        location.href = 'lawsuits/' + lawsuit_id;
      },
    }
  }
</script>
