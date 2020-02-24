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
        v-if="lawsuits"
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
            <range-lawsuit-headers
              v-for="index in plaintiffsLength"
              :key="'title-plaintiff-'+index"
              title="原告"
              :length="plaintiffsLength"
              :index="index"
            />
            <range-lawsuit-headers
              v-for="index in plaintiffRepresentativesLength"
              :key="'title-plaintiff-representative-'+index"
              title="原告代理人"
              :length="plaintiffRepresentativesLength"
              :index="index"
            />
            <range-lawsuit-headers
              v-for="index in defendantsLength"
              :key="'title-defendant-'+index"
              title="被告"
              :length="defendantsLength"
              :index="index"
            />
            <range-lawsuit-headers
              v-for="index in defendantRepresentativesLength"
              :key="'title-defendant-representative-'+index"
              title="被告代理人"
              :length="defendantRepresentativesLength"
              :index="index"
            />
            <range-lawsuit-headers
              v-for="index in otherPartiesLength"
              :key="'title-other-party-'+index"
              title="その他当事者"
              :index="index"
              :length="otherPartiesLength"
              :is-last="Boolean(true)"
            />
          </tr>
        </thead>
        <tbody>
          <range-lawsuit-item
            v-for="(lawsuit) in lawsuits"
            :key="'lawsuit-item'+lawsuit.id"
            :lawsuit="lawsuit"
            :plaintiffs-length="plaintiffsLength"
            :plaintiff-representatives-length="plaintiffRepresentativesLength"
            :defendants-length="defendantsLength"
            :defendant-representatives-length="defendantRepresentativesLength"
            :other-parties-length="otherPartiesLength"
          />
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
  import rangeLawsuitHeaders from "./shared/range-lawsuit-headers"
  export default {
    name: "LawsuitsIndex",
    components:{
      rangeLawsuitItem,
      rangeLawsuitHeaders
    },
    data() {
      return {
        lawsuits: null,
        plaintiffsLength: 0,
        plaintiffRepresentativesLength: 0,
        defendantsLength: 0,
        defendantRepresentativesLength: 0,
        otherPartiesLength: 0,
        overlay: true,
        opacity: 0.2
      }
    },
    created() {
      axios.get('lawsuits')
        .then(res => {
          this.lawsuits = res.data.data;
          this.plaintiffsLength = this.maxItem(this.lawsuits, 'plaintiffs');
          this.plaintiffRepresentativesLength = this.maxItem(this.lawsuits, 'plaintiff_representatives');
          this.defendantsLength = this.maxItem(this.lawsuits, 'defendants');
          this.defendantRepresentativesLength = this.maxItem(this.lawsuits, 'defendant_representatives');
          this.otherPartiesLength = this.maxItem(this.lawsuits, 'other_parties');
          this.overlay = false;
        })
        .catch(error => {
          this.overlay = true;
          console.log(error.response)
        }).finally(() => {
        this.overlay = false;
      })
    },
    methods:{
      maxItem(array, props){
        let maxLen = 1;
        for (let i = 0; i < array.length; i++)
          if (array[i][props].length > maxLen)
            maxLen = array[i][props].length;

        return maxLen;
      }
    }
  }
</script>

<style scoped></style>
