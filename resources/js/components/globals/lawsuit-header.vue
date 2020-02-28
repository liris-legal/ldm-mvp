<template>
  <v-row class="lawsuit-header pa-3 pt-0 pb-0">
    <v-col class="col-lg-5 col-md-5 col-sm-6 col-xl-6">
      <p class="font-size-12 mb-0">
        {{ lawsuit.number }}
      </p>
      <v-skeleton-loader
        :loading="loading"
        height="33"
        width="500"
        type="heading"
      >
        <p class="font-size-22 pl-4 mb-0">
          <a
            :href="'/lawsuits/' + lawsuit.id"
          >
            {{ lawsuit.name }}
          </a>
        </p>
      </v-skeleton-loader>
    </v-col>
    <v-col class="col-lg-7 col-md-7 col-sm-6 col-xl-6 font-size-18">
      <p class="mb-0">
        <v-skeleton-loader
          :loading="loading"
          height="27"
          width="500"
          type="heading"
        >
          <a
            href="javascript:void(0)"
            @click="onClickHandle('plaintiffs')"
          >
            原告：{{ lawsuit.plaintiffs | parseParties }}
          </a>
        </v-skeleton-loader>
      </p>
      <p class="mb-0">
        <v-skeleton-loader
          :loading="loading"
          height="27"
          width="500"
          type="heading"
        >
          <a
            href="javascript:void(0)"
            @click="onClickHandle('defendants')"
          >
            被告：{{ lawsuit.defendants | parseParties }}
          </a>
        </v-skeleton-loader>
      </p>
      <!-- dialog popup table -->
      <v-card
        v-if="openPopup"
        id="popup-box"
        class="popup-box"
        dense
      >
        <v-card-title class="font-weight-bold font-size-18">
          <span>{{ nameParty }}ー覧</span>
          <v-btn
            icon
            @click="openPopup =! openPopup"
          >
            <v-icon>cancel</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider />
        <v-list dense>
          <v-list-item
            v-for="(party, index) in parties"
            :key="'popup-' + party.name"
          >
            <v-list-item-content>
              <v-list-item-title>{{ nameParty }}{{ ++index }} ({{ party.name }})</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
export default {
  filters:{
    parseParties(arrays){
      if (arrays === undefined || arrays.length <= 0) return '-';
      return arrays[0].name;
    }
  },
  props: {
    lawsuit: {type: Object, required: true, default: () => {}},
    loading: {type: Boolean, required: true, default: () => true}
  },
  data() {
    return {
      openPopup: false,
      parties: [],
      nameParty: '',
    }
  },
  methods: {
    /**
     * onClickHandle to open popup and get parties
     * @param party
     */
    onClickHandle(party) {
      this.openPopup = !this.openPopup;
      this.nameParty = party === 'plaintiffs' ? '原告' : '被告';
      this.parties = this.lawsuit[party];
    },
  }
}
</script>

<style lang="scss" scoped>
  p a{
    color: rgba(0,0,0,.87);
    text-decoration: none;
  }
  .v-skeleton-loader--is-loading{
    height: 30px
  }
  .v-card__title{
    padding: 8px;
  }
  .popup-box{
    position: absolute;
    top: 72px;
    left: 50%;
    min-width: 200px;
    max-width: 230px;
    z-index: 1;
    word-wrap: break-word;

    button {
      position: absolute;
      right: 8px;
    }
  }
</style>
