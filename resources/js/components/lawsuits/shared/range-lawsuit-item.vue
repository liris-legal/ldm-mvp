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
      {{ lawsuit.number }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{ lawsuit.name }}
    </td>
    <td
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      {{ lawsuit.courts_departments }}
    </td>

    <td
      v-for="maxIndex in plaintiffsLength"
      :key="'plaintiff-'+maxIndex"
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.plaintiffs[--maxIndex]">
        {{ lawsuit.plaintiffs[maxIndex].name }}
      </template>
      <template v-else>
        -
      </template>
    </td>

    <td
      v-for="maxIndex in plaintiffRepresentativesLength"
      :key="'plaintiff-reps-'+maxIndex"
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.plaintiff_representatives[--maxIndex]">
        {{ lawsuit.plaintiff_representatives[maxIndex].name }}
      </template>
      <template v-else>
        -
      </template>
    </td>

    <td
      v-for="maxIndex in defendantsLength"
      :key="'defendant-'+maxIndex"
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.defendants[--maxIndex]">
        {{ lawsuit.defendants[maxIndex].name }}
      </template>
      <template v-else>
        -
      </template>
    </td>

    <td
      v-for="maxIndex in defendantRepresentativesLength"
      :key="'defendant-reps-'+maxIndex"
      scope="col"
      class="col col-3"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.defendant_representatives[--maxIndex]">
        {{ lawsuit.defendant_representatives[maxIndex].name }}
      </template>
      <template v-else>
        -
      </template>
    </td>

    <td
      v-for="(maxIndex, index) in otherPartiesLength"
      :key="'other-party-'+maxIndex"
      scope="col"
      class="col col-3 d-flex pa-0 last-child-table"
      :class="{'x-overlays': overlay}"
    >
      <template v-if="lawsuit.other_parties[--maxIndex]">
        <div class="col-md-6 col-lg-6">
          {{ lawsuit.other_parties[maxIndex].name }}
        </div>
      </template>
      <template v-else>
        <div class="col-md-6 col-lg-6">
          -
        </div>
      </template>
      <template
        v-if="index+1 === otherPartiesLength"
      >
        <v-spacer />
        <sub-menu
          :key="'lawsuits-sub-menu-'+lawsuit.id"
          :sub-link="'lawsuits/' + lawsuit.id + '/edit'"
          :sub-id="lawsuit.id"
          :sub-type="'lawsuits'"
          :sub-message="'事件を削除してもよろしいですか？'"
          @update:overlay="overlay = $event"
        />
      </template>
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
      plaintiffsLength: {required: true, type: Number, default: () => 0},
      plaintiffRepresentativesLength: {required: true, type: Number, default: () => 0},
      defendantsLength: {required: true, type: Number, default: () => 0},
      defendantRepresentativesLength: {required: true, type: Number, default: () => 0},
      otherPartiesLength: {required: true, type: Number, default: () => 0},
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
