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
      {{ lawsuit.number | truncate(15, '...')}}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{ lawsuit.name | truncate(15, '...')}}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{ lawsuit.courts_departments | truncate(15, '...') }}
    </td>

    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <range-lawsuit-item-col
        :lawsuit="lawsuit"
        party="plaintiffs"
      />
    </td>

    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <range-lawsuit-item-col
        :lawsuit="lawsuit"
        party="plaintiff_representatives"
      />
    </td>

    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <range-lawsuit-item-col
        :lawsuit="lawsuit"
        party="defendants"
      />
    </td>

    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <range-lawsuit-item-col
        :lawsuit="lawsuit"
        party="defendant_representatives"
      />
    </td>

    <td
      scope="col"
      class="col col-3 d-flex pa-0 last-child-table"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.other_parties.length">
        <div class="col-md-6 col-lg-6">
          {{ lawsuit.other_parties[0].name | truncate(15, '...') }}
          <v-badge
            :content="lawsuit.other_parties.length"
            color="blue lighten-3"
            offset-x="0"
            offset-y="8"
          >
            他
          </v-badge>
        </div>
      </template>
      <template v-else>
        <div class="col-md-6 col-lg-6">
          -
        </div>
      </template>
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
  import rangeLawsuitItemCol from "./range-lawsuit-item-col"

  export default {
    name: "RangeLawsuitItem",
    components:{ rangeLawsuitItemCol },
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
  td /deep/.v-badge__badge{
    color: initial;
  }
</style>
