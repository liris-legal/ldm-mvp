<template>
  <tr class="d-flex" @click="showLawsuit(lawsuit.id)">
    <td scope="col" class="col col-3">{{ lawsuit.number }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.name }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.courts_departments }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.defendants | parseName }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.defendant_representatives | parseName }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.plaintiffs | parseName }}</td>
    <td scope="col" class="col col-3">{{ lawsuit.plaintiff_representatives | parseName }}</td>
    <td scope="col" class="col col-3 d-flex pa-0 last-child-table">
      <div class="col-6">
        <div class="pl-3">-</div>
      </div>
      <v-spacer></v-spacer>
      <div class="col-6 text-right col-btn font-weight-600 text-size-20">
        <v-btn :id="'lawsuit-sub-menu-' + lawsuit.id" icon
               v-on:click.stop=""
               @click="toggle"
               v-click-outside="hidden"
        >
          ...
        </v-btn>
      </div>
      <v-list class="sub-menu" :class="{ 'activated': isActive}">
        <v-list-item :href="'lawsuits/' + lawsuit.id + '/edit'">
          <v-list-item-title>事件を変更</v-list-item-title>
        </v-list-item>
        <v-list-item @click="deleteLawsuit(index, lawsuit.id)">
          <v-list-item-title>事件を削除</v-list-item-title>
        </v-list-item>
      </v-list>
    </td>
  </tr>
</template>

<script>
  import ClickOutside from 'vue-click-outside'

  export default {
    name: "range-row-lawsuit",
    props: {
      lawsuit: {type: Object, required: true, default: () => {}},
      index: {type: Number, required: true, default: () => 0},
    },
    data() {
      return {
        activeIndex: undefined,
        i: 1,
        isActive: false
      }
    },
    methods: {
      /**
       * @function toggle
       * @description To display/hidden submenu
       */
      toggle: function () {
        const $activated = 'activated';
        const listTd = $('tr.d-flex td.last-child-table');
        // const listSubMenus = listTd.find('div[role=list]');

        // console.log(this.index);
        listTd.find('div.'+$activated).removeClass($activated);

        this.isActive = !this.isActive;
      },

      /**
       * @function hidden
       * @description To hidden submenu
       */
      hidden: function(){
        this.isActive = false
      },

      /**
       * @function showLawsuit
       * @description goto show lawsuit page
       */
      showLawsuit(lawsuit_id) {
        console.log('goto show page')
        // return window.location.href = 'lawsuits/' + lawsuit_id;
      },

      /**
       * deleteLawsuit: to delete lawsuit by id
       * */
      deleteLawsuit(index, lawsuit_id) {
        axios.delete('/lawsuits/' + lawsuit_id)
          .then(res => {
            console.log(res.data);
            // this.lawsuits.splice(index, 1);
            // window.location.href="/lawsuits";
          })
          .catch(err => { console.log(err);	});
      }
    },
    directives: {
      ClickOutside
    },
    filters: {
      /**
       * @function parseName
       * @description parse name in list Objects
       * @return string
       */
      parseName(arrays) {
        if (arrays.length <= 0) return '-';
        arrays = arrays.map(value => {return value.name});
        return arrays.join(', ');
      },
    }
  }
</script>

<style scoped>

</style>
