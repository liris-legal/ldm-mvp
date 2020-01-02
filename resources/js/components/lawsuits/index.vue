<template>
  <div class="container-fluid cases-page">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">民事事件</h2>
        <h3 class="description"/>
      </v-col>
    </v-row>
    
    <div class="overflow overflow-x-auto">
      <div v-if="isShowDelete" class="overlay"></div>
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
        <template v-for="(lawsuit, index) in lawsuits">
          <tr class="d-flex" @click="redirectToLink(lawsuit.id)" :key="lawsuit.id">
            <td scope="col" class="col col-3">{{ lawsuit.number }}</td>
            <td scope="col" class="col col-3">{{ lawsuit.name }}</td>
            <td scope="col" class="col col-3">{{ lawsuit.courts_departments }}</td>
            <td scope="col" class="col col-3">{{ convertString(lawsuit.defendants) }}</td>
            <td scope="col" class="col col-3">{{ convertString(lawsuit.defendant_representatives) }}</td>
            <td scope="col" class="col col-3">{{ convertString(lawsuit.plaintiffs) }}</td>
            <td scope="col" class="col col-3">{{ convertString(lawsuit.plaintiff_representatives) }}</td>
            <td scope="col" class="col col-3 d-flex pa-0 last-child-table" :class="{'unset-relative': isShowDelete}">
              <div class="col-6"><div class="pl-3">-</div></div>
              <v-spacer></v-spacer>
              <div class="col-6 text-right col-btn font-weight-600 text-size-20">
                <v-btn :id="'lawsuit-sub-menu-' + lawsuit.id" icon @click="showSubmenu(index)" v-on:click.stop="" v-click-outside="hidden">...</v-btn>
              </div>
              <v-list class="sub-menu" :class="{ 'actived': activeIndex === index}">
                <v-list-item @click="renameLawsuit(lawsuit.id)" v-on:click.stop="">
                  <v-list-item-title>名前を変更</v-list-item-title>
                </v-list-item>
                <v-list-item @click="deleteLawsuit(lawsuit.id)" v-on:click.stop="">
                  <v-list-item-title>ファイルを削除</v-list-item-title>
                </v-list-item>
              </v-list>
            </td>
          </tr>
          <app-delete-item :dataType="'lawsuits'" v-on:cancelSubmit="isShowDelete = $event"  v-if="isShowDelete" :data="dataReceived" />
        </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  /**
   * Index: Clicks Outside an Element
   */
  import ClickOutside from 'vue-click-outside';
  export default {
    name: "Index",
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
       * @function redirectToLink
       * @description redirect to a link
       */
      redirectToLink(lawsuit_id) {
        return window.location.href = 'lawsuits/' + lawsuit_id;
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
       * @function convertString
       * @description convert array to string
       * @return string
       */
      convertString(arrays){
        if(arrays.length > 0){
          let values = arrays.map(value => { return value.name });
          return values.join(', ');
        } else {
          return '-'
        }
        
      },
  
      renameLawsuit(lawsuit_id){
        return window.location.href = 'lawsuits/' + lawsuit_id + '/edit/';
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
