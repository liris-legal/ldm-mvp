<template>
  <tr
    class="d-flex lawsuit--item"
    @click="showLawsuit"
  >
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
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
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.name
      }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.courts_departments
      }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.defendants | parseName
      }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.defendant_representatives | parseName
      }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.plaintiffs | parseName
      }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{
        lawsuit.plaintiff_representatives | parseName
      }}
    </td>
    <td
      scope="col"
      class="col col-3 d-flex pa-0 last-child-table"
      :class="{'x-overlays': overlay}"
    >
      <div class="col-md-6 col-lg-6">
        {{ lawsuit.other_parties | parseName }}
      </div>
      <v-spacer />
      <sub-menu
        :key="'lawsuits-sub-menu-'+lawsuit.id"
        :sub-link="'lawsuits/' + lawsuit.id + '/edit'"
        :sub-id="lawsuit.id"
        :sub-type="'lawsuits'"
        :sub-message="'事件を削除してもよろしいですか？'"
        @update:overlay="overlay = $event"
      />
    </td>
    <v-overlay
      :z-index="zIndex"
      :value="overlay"
    />
  </tr>
</template>

<script>
  export default {
    name: "RangeLawsuitItem",
    props: {
      lawsuit: {required: true, type: Object, default: () => {}},
    },
    data() {
      return {
        overlay: false,
        zIndex: 8,
      }
    },
    watch: {
      overlay(val){
        if (val){
          for(let i = 0; i < lawsuitItems.length; i++)
            lawsuitItems[i].classList.add("cursor-unset");
        }else{
          for(let i = 0; i < lawsuitItems.length; i++)
            lawsuitItems[i].classList.remove("cursor-unset");
        }
      }
    },
    mounted() {
      window.lawsuitItems = document.getElementsByClassName('lawsuit--item');
    },
    methods: {
      /**
       * @function showLawsuit
       * @description goto show lawsuit page
       */
      showLawsuit() {
        location.href = 'lawsuits/' + this.lawsuit.id;
      },
    },
  }
</script>

<style scoped>
  .x-overlays {
    z-index: 10;
    position: relative;
    background-color: #FFF;
  }
  .cursor-unset {
    cursor: unset !important;
  }
</style>
