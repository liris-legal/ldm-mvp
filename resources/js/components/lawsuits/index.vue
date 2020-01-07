<template>
  <div class="container-fluid cases-page">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          民事事件
        </h2>
        <h3 class="description" />
      </v-col>
    </v-row>

    <div class="overflow overflow-x-auto">
      <div
        v-if="isShowDelete"
        class="overlay"
      />
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
                  lawsuit.number
                }}
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
                :class="{'unset-relative': isShowDelete}"
              >
                <div class="col-6">
                  <div class="">
                    {{ lawsuit.other_parties | parseName }}
                  </div>
                </div>
                <v-spacer />
                <div class="col-6 text-right col-btn font-weight-600 text-size-20">
                  <v-btn
                    :id="'lawsuit-sub-menu-' + lawsuit.id"
                    v-click-outside="hidden"
                    icon
                    @click="showSubmenu(index)"
                    @click.stop=""
                  >
                    ...
                  </v-btn>
                </div>
                <v-list
                  class="sub-menu"
                  :class="{ 'actived': activeIndex === index}"
                >
                  <v-list-item
                    :href="'lawsuits/' + lawsuit.id + '/edit'"
                    @click.stop=""
                  >
                    <v-list-item-title>
                      事件を変更
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item
                    @click="deleteLawsuit(lawsuit.id)"
                    @click.stop=""
                  >
                    <v-list-item-title>
                      事件を削除
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <app-delete-item
      v-if="isShowDelete"
      :data-type="lawsuits"
      message="事件を削除してもよろしいですか"
      :data="dataReceived"
      @cancelSubmit="isShowDelete = $event"
    />
  </div>
</template>

<script>
  import ClickOutside from 'vue-click-outside';

  export default {
    name: "LawsuitsIndex",
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
    },
    data() {
      return {
        activeIndex: undefined,
        count: 1,
        isShowDelete: false,
        dataReceived: null,
        lawsuits: {}
      }
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

      /**
       * @function showSubmenu
       * @description show a sub-menu
       */
      showSubmenu(index) {
        this.count++;
        if(this.count % 2 === 0){
          this.activeIndex = index;
        } else {
          this.activeIndex = undefined;
        }
      },

      /**
       * @function deleteLawsuit
       * @description delete a lawsuit
       */
      deleteLawsuit(lawsuit_id){
        this.isShowDelete = true;
        this.count = 1;
        this.activeIndex = undefined;
        this.dataReceived = lawsuit_id;
      },

      /**
       * @function hidden
       * @description To hidden a sub-menu
       */
      hidden() {
        this.count = 1;
        this.activeIndex = undefined;
        this.isShowDelete = false;
      },
    }
  }
</script>
<style lang="scss">
  .unset-relative{
    position: unset !important;
    pointer-events: none;
  }
</style>
