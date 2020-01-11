<template>
  <div class="container-fluid lawsuit-create clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name font-size-30">
          新件を作成
        </h2>
        <h3 class="description" />
      </v-col>
    </v-row>
    <v-form
      method="POST"
      class="form-group clearfix"
    >
      <v-container class="form-group-content">
        <v-row class="ma-0">
          <v-col cols="12 row form-control pa-2">
            <v-col class="col-3 pa-0 label">
              <label class="font-weight-600">
                事件種類
              </label>
            </v-col>
            <v-col class="col-9 pa-2 input">
              {{ typeLawsuits[0].name }}
            </v-col>
          </v-col>
          <v-col
            cols="12"
            class="row form-control pa-2"
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
                v-model="lawsuit.number"
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
            class="row form-control pa-2"
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
                v-model="lawsuit.name"
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
            class="row form-control pa-2"
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
                v-model="lawsuit.courts_departments"
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
            v-for="(plaintiff, i) in lawsuit.plaintiffs"
            :key="plaintiff.i"
            cols="12"
            class="row form-control pa-2"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'plaintiff-lawsuit' + i"
                class="font-weight-600"
              >原告{{ countParties(lawsuit.plaintiffs, ++i) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'plaintiff-lawsuit' + i"
                v-model="plaintiff.name"
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
                @click="removeItemFromParties(lawsuit, 'plaintiffs', --i)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'plaintiffs', --i) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(plaintiff_representative, i) in lawsuit.plaintiff_representatives"
            :key="plaintiff_representative.i"
            cols="12"
            class="row form-control pa-2"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'plaintiff-representative-lawsuit' + i"
                class="font-weight-600"
              >原告代理人{{ countParties(lawsuit.plaintiff_representatives, ++i) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'plaintiff-representative-lawsuit' + i"
                v-model="plaintiff_representative.name"
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
                @click="removeItemFromParties(lawsuit, 'plaintiff_representatives', --i)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'plaintiff_representatives', --i) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(defendant, i) in lawsuit.defendants"
            :key="defendant.i"
            cols="12"
            class="row form-control pa-2"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'defendant-lawsuit' + i"
                class="font-weight-600"
              >被告{{ countParties(lawsuit.defendants, ++i) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'defendant-lawsuit' + i"
                v-model="defendant.name"
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
                @click="removeItemFromParties(lawsuit, 'defendants', --i)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'defendants', --i) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(defendant_representative, i) in lawsuit.defendant_representatives"
            :key="defendant_representative.i"
            cols="12"
            class="row form-control pa-2"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'defendant-representative-lawsuit' + i"
                class="font-weight-600"
              >被告代理人{{ countParties(lawsuit.defendant_representatives, ++i) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'defendant-representative-lawsuit' + i"
                v-model="defendant_representative.name"
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
                @click="removeItemFromParties(lawsuit, 'defendant_representatives', --i)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'defendant_representatives', --i) }}</small>
            </v-col>
          </v-col>

          <v-col
            v-for="(other_party, i) in lawsuit.other_parties"
            :key="other_party.i"
            cols="12"
            class="row form-control pa-2"
          >
            <v-col class="col-3 pa-0 label">
              <label
                :for="'other-party-lawsuit' + i"
                class="font-weight-600"
              >その他当事者{{ countParties(lawsuit.other_parties, ++i) }}</label>
            </v-col>
            <v-col class="col-9 pa-0 input">
              <input
                :id="'other-party-lawsuit' + i"
                v-model="other_party.name"
                type="text"
                class="input-form-group col-md-12"
              >
              <v-btn
                icon
                class="icon-add"
                @click="pushToParties(lawsuit, 'other_parties')"
              >
                <v-icon>add_circle_outline</v-icon>
              </v-btn>
              <v-btn
                v-show="countParties(lawsuit.other_parties) > 1"
                icon
                class="icon-clear"
                @click="removeItemFromParties(lawsuit, 'other_parties', --i)"
              >
                <v-icon>remove_circle_outline</v-icon>
              </v-btn>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'other_parties', --i) }}</small>
            </v-col>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center">
            <v-btn
              v-ripple
              class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto font-size-18 font-weight-600"
              @click="postData"
            >
              登録
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </div>
</template>

<script>
  export default {
    name: "LawsuitsCreate",
    props: {
      storeRoute: {
        required: true,
        type: String,
        default: ''
      },
      typeLawsuits: {
        required: true,
        type: Array,
        default() {
          return []
        }
      },
    },
    data() {
      return {
        lawsuit: {
          type_lawsuit_id: 1,
          number: '',
          name: '',
          courts_departments: '',
          plaintiffs: [{ name: ''}],
          plaintiff_representatives: [{ name: ''}],
          defendants: [{ name: '' }],
          defendant_representatives: [{ name: '' }],
          other_parties: [{ name: '' }],
				},
        civil_lawsuits: {},
				errors: {}|undefined
      }
    },
    mounted() {
      this.civil_lawsuits = this.typeLawsuits.filter((lawsuit) => lawsuit.description.includes('civil') )[0];
      this.lawsuit.type_lawsuit_id = this.civil_lawsuits.id;
    },
	methods: {
     /**
     * postData is used to edit lawsuit
     * @return {object} contains a message status and redirect url
     */
      postData() {
        /**
         * Create a new formData to store menu
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

        axios.post(this.storeRoute, formData)
          .then(res => {
            console.log(res);
            this.$store.dispatch('create_notification', res.data.message);
            location.href = res.data.url;
          })
          .catch(err => {
            if(err.response.status === 422){
              this.errors = err.response.data.errors;
						}
					});
      },
    }
  }
</script>
