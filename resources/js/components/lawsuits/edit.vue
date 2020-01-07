<template>
  <div class="container-fluid lawsuit-create clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          新件を作成
        </h2>
        <h3 class="description" />
      </v-col>
    </v-row>
    <v-form class="form-group clearfix">
      <v-container class="form-group-content">
        <v-row class="ma-0">
          <v-col cols="12 row form-control">
            <v-col class="col-3 pa-0 label">
              <label class="font-weight-600">事件種類</label>
            </v-col>
            <v-col class="col-9 pa-2 input">
              民事事件
            </v-col>
          </v-col>
          <v-col
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                for="number-lawsuit"
                class="font-weight-600"
              >事件番号</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                id="number-lawsuit"
                v-model.trim="lawsuit.number"
                type="text"
                class="input-form-group col-md-12"
              >
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'number') }}</small>
            </v-col>
          </v-col>
          <v-col
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                for="name-lawsuit"
                class="font-weight-600"
              >事件名</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                id="name-lawsuit"
                v-model.trim="lawsuit.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'name') }}</small>
            </v-col>
          </v-col>
          <v-col
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                for="courts-lawsuit"
                class="font-weight-600"
              >裁判所・部署</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                id="courts-lawsuit"
                v-model.trim="lawsuit.courts_departments"
                type="text"
                class="input-form-group col-md-12"
              >
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'courts_departments') }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(plaintiff, index) in lawsuit.plaintiffs"
            :key="'plaintiffs'+index"
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'plaintiff-lawsuit' + index"
                class="font-weight-600"
              >原告{{ countParties(lawsuit.plaintiffs, ++index) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'plaintiff-lawsuit' + index"
                v-model.trim="plaintiff.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties(lawsuit, 'plaintiffs')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.plaintiffs) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties(lawsuit, 'plaintiffs', --index)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'plaintiffs', --index) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(plaintiff_representative, index) in lawsuit.plaintiff_representatives"
            :key="'plaintiff_representatives' + index"
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'plaintiff-representative-lawsuit' + index"
                class="font-weight-600"
              >原告代理人{{ countParties(lawsuit.plaintiff_representatives, ++index) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'plaintiff-representative-lawsuit' + index"
                v-model.trim="plaintiff_representative.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties(lawsuit, 'plaintiff_representatives')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.plaintiff_representatives) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties(lawsuit, 'plaintiff_representatives', --index)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'plaintiff_representatives', --index) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(defendant, index) in lawsuit.defendants"
            :key="'defendant' + index"
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'defendant-lawsuit' + index"
                class="font-weight-600"
              >被告{{ countParties(lawsuit.defendants, ++index) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'defendant-lawsuit' + index"
                v-model.trim="defendant.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties(lawsuit, 'defendants')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.defendants) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties(lawsuit, 'defendants', --index)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'defendants', --index) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(defendant_representative, index) in lawsuit.defendant_representatives"
            :key="'defendant_representative' +index"
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'defendant-representative-lawsuit' + index"
                class="font-weight-600"
              >被告代理人{{ countParties(lawsuit.defendant_representatives, ++index) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'defendant-representative-lawsuit' + index"
                v-model.trim="defendant_representative.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties(lawsuit, 'defendant_representatives')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.defendant_representatives) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties(lawsuit, 'defendant_representatives', --index)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'defendant_representatives', --index) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(other_party, index) in lawsuit.other_parties"
            :key="'other_party' + index"
            cols="12"
            class="row form-control"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'other-party-lawsuit' + index"
                class="font-weight-600"
              >その他当事者{{ countParties(lawsuit.other_parties, ++index) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'other-party-lawsuit' + index"
                v-model.trim="other_party.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties( lawsuit, 'other_parties')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.other_parties) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties( lawsuit, 'other_parties', --index)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'other_parties', --index) }}</small>
            </v-col>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center">
            <v-btn
              v-ripple
              class="col-8 mr-0-auto btn btn-primary pa-3 height-auto text-size-18 font-weight-600"
              @click="postData"
            >
              保存
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </div>
</template>

<script>
  export default {
    name: "LawsuitEdit",
      props: {
        typeLawsuits: {required: true, type: Array, default: () => []},
        lawsuitId: {required: true, type: String, default: '0'},
      },
    data() {
      return {
        lawsuit: {},
        plaintiffs: [{'name': ''}],
        plaintiff_representatives: [{'name': ''}],
        defendants: [{'name': ''}],
        defendant_representatives: [{'name': ''}],
        other_parties: [{'name': ''}],
        errors: undefined,
      }
    },
    created() {
      /**
       * @function
       * @description fetch lawsuit data from API
       */
      axios.get('lawsuits/' + this.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          this.lawsuit.plaintiffs = this.lawsuit.plaintiffs.length > 0 ? this.lawsuit.plaintiffs : this.plaintiffs;
          this.lawsuit.plaintiff_representatives = this.lawsuit.plaintiff_representatives.length > 0 ? this.lawsuit.plaintiff_representatives : this.plaintiff_representatives;
          this.lawsuit.defendants = this.lawsuit.defendants.length > 0 ? this.lawsuit.defendants : this.defendants;
          this.lawsuit.defendant_representatives = this.lawsuit.defendant_representatives.length > 0 ? this.lawsuit.defendant_representatives : this.defendant_representatives;
          this.lawsuit.other_parties = this.lawsuit.other_parties.length > 0 ? this.lawsuit.other_parties : this.other_parties;
        })
        .catch(error => {
          console.log(error);
        });
    },
		mounted() {
      console.log('edit mounted');
    },
    methods:{
      /**
       * postData is used to edit lawsuit
       * @return {object} contains a message status and redirect url
       */
      postData() {
        /**
         * Create a new formData to store lawsuit
         * */
        let formData = new FormData();
        formData.append('type_lawsuit_id', this.lawsuit.type_lawsuit_id);
        formData.append('number', this.lawsuit.number);
        formData.append('name', this.lawsuit.name);
        formData.append('courts_departments', this.lawsuit.courts_departments);

        formData = this.convertObjectDataToArrayRequest(formData, 'plaintiffs');
        formData = this.convertObjectDataToArrayRequest(formData, 'plaintiff_representatives');
        formData = this.convertObjectDataToArrayRequest(formData, 'defendants');
        formData = this.convertObjectDataToArrayRequest(formData, 'defendant_representatives');
        formData = this.convertObjectDataToArrayRequest(formData, 'other_parties');
        formData.append("_method", "PATCH");

        axios.post('lawsuits/' + this.lawsuitId, formData)
          .then(res => {
            console.log(res.data);
            this.$store.dispatch('create_notification', res.data.message);
            // location.href = res.data.url;
          })
          .catch(err => {
            console.log(err.response.data);
            this.errors = err.response.data.errors;
          });
      },
    }
  }
</script>
