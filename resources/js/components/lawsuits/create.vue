<template>
	<div class="container-fluid lawsuit-create clearfix">
		<v-row>
			<v-col class="col-12 header-content">
				<h2 class="title-name text-size-30">新件を作成</h2>
				<h3 class="description"/>
			</v-col>
		</v-row>
		<v-form class="form-group clearfix" method="POST">
			<v-container class="form-group-content">
				<v-row class="ma-0">
					<v-col cols="12 row form-control pa-2">
						<v-col class="col-3 pa-0 label"><label class="font-weight-600">事件種類</label></v-col>
						<v-col class="col-9 pa-2 input">{{type_lawsuits[0].name}}</v-col>
					</v-col>
					<v-col cols="12" class="row form-control pa-2">
						<v-col class="col-3 pa-0 label"><label for="number-lawsuit" class="font-weight-600">事件番号</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.number" id="number-lawsuit" type="text" class="input-form-group col-md-12">
							<small class="has-error" v-if="error">{{ error.errors.number[0] }}</small>
						</v-col>
					</v-col>
					<v-col cols="12" class="row form-control pa-2">
						<v-col class="col-3 pa-0 label"><label for="name-lawsuit" class="font-weight-600">事件名</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.name" id="name-lawsuit" type="text" class="input-form-group col-md-12">
							<small class="has-error" v-if="error">{{ error.errors.name[0] }}</small>
						</v-col>
					</v-col>
					<v-col cols="12" class="row form-control pa-2">
						<v-col class="col-3 pa-0 label"><label for="courts-lawsuit" class="font-weight-600">裁判所・部署</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.courts_departments" id="courts-lawsuit" type="text" class="input-form-group col-md-12">
							<small class="has-error" v-if="error">{{ error.errors.courts_departments[0] }}</small>
						</v-col>
					</v-col>

					<v-col cols="12" class="row form-control pa-2" v-for="(plaintiff, i) in lawsuit.plaintiffs" :key="plaintiff.i">
						<v-col class="col-3 pa-0 label"><label :for="'plaintiff-lawsuit' + i" class="font-weight-600">原告{{ convertString('plaintiffs', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.plaintiffs.name = plaintiff.name" :id="'plaintiff-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('plaintiffs')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-if="lawsuit.plaintiffs.length > 1" v-on:click="removeValue('plaintiffs', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
							<small class="has-error" v-if="error">{{ catchError('plaintiffs', --i) }}</small>
						</v-col>
					</v-col>

					<v-col cols="12" class="row form-control pa-2" v-for="(plaintiff_representative, i) in lawsuit.plaintiff_representatives" :key="plaintiff_representative.i">
						<v-col class="col-3 pa-0 label"><label :for="'plaintiff-representative-lawsuit' + i" class="font-weight-600">原告代理人{{ convertString('plaintiff_representatives', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.plaintiff_representatives.name = plaintiff_representative.name" :id="'plaintiff-representative-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('plaintiff_representatives')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-if="lawsuit.plaintiff_representatives.length > 1" v-on:click="removeValue('plaintiff_representatives', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
							<small class="has-error" v-if="error">{{ catchError('plaintiff_representatives', --i) }}</small>
						</v-col>
					</v-col>

					<v-col cols="12" class="row form-control pa-2" v-for="(defendant, i) in lawsuit.defendants" :key="defendant.i">
						<v-col class="col-3 pa-0 label"><label :for="'defendant-lawsuit' + i" class="font-weight-600">被告{{ convertString('defendants', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.defendants.name = defendant.name" :id="'defendant-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('defendants')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-if="lawsuit.defendants.length > 1" v-on:click="removeValue('defendants', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
							<small class="has-error" v-if="error">{{ catchError('defendants', --i) }}</small>
						</v-col>
					</v-col>

					<v-col cols="12" class="row form-control pa-2" v-for="(defendant_representative, i, rorr) in lawsuit.defendant_representatives" :key="defendant_representative.i">
						<v-col class="col-3 pa-0 label"><label :for="'defendant-representative-lawsuit' + i" class="font-weight-600">被告代理人{{ convertString('defendant_representatives', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.defendant_representatives.name = defendant_representative.name" :id="'defendant-representative-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('defendant_representatives')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-if="lawsuit.defendant_representatives.length > 1" v-on:click="removeValue('defendant_representatives', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
							<small class="has-error" v-if="error">{{ catchError('defendant_representatives', --i) }}</small>
						</v-col>
					</v-col>

					<v-col cols="12" class="row form-control pa-2" v-for="(other_party, i) in lawsuit.other_parties" :key="other_party.i">
						<v-col class="col-3 pa-0 label"><label :for="'other-party-lawsuit' + i" class="font-weight-600">その他当事者{{ convertString('other_parties', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="lawsuit.other_parties.name = other_party.name" :id="'other-party-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('other_parties')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-if="lawsuit.other_parties.length > 1" v-on:click="removeValue('other_parties', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
							<small class="has-error" v-if="error">{{ catchError('other_parties', --i) }}</small>
						</v-col>
					</v-col>
				</v-row>
				<v-row>
					<v-col class="text-center">
						<v-btn v-ripple class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto text-size-18 font-weight-600" v-on:click="postData">登録</v-btn>
					</v-col>
				</v-row>
			</v-container>
		</v-form>
	</div>
</template>

<script>
  export default {
    name: "lawsuits-create",
    props: {
      store_route: { required: true, type: String, default: 0},
      type_lawsuits: {required: true,  type: Array, default: []},
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
				error: {}|undefined
      }
    },
	methods: {
      /**
       * Add element input of the typeSubmitter
			 * @param submitter - Is a string
       */
      addValue(submitter){
        let item = { name: '' };
        switch(submitter) {
          case 'plaintiffs':
            this.lawsuit.plaintiffs.push(item);
            break;
          case 'plaintiff_representatives':
            this.lawsuit.plaintiff_representatives.push(item);
            break;
					case 'defendants':
								this.lawsuit.defendants.push(item);
								break;
					case 'defendant_representatives':
								this.lawsuit.defendant_representatives.push(item);
								break;
					case 'other_parties':
								this.lawsuit.other_parties.push(item);
								break;
							default: {}
						}
					},

      /**
       * Remove element input of the typeSubmitter
       * @param submitter - Is a string
       * @param {number} index - Ordinal number element input of the typeSubmitter
       * */
      removeValue(submitter, index) {
        if(submitter === 'plaintiffs'){
          if(this.lawsuit.plaintiffs.length > 1)
            this.lawsuit.plaintiffs.splice(index, 1);

        } else if(submitter === 'plaintiff_representatives'){
          if(this.lawsuit.plaintiff_representatives.length > 1){
            this.lawsuit.plaintiff_representatives.splice(index, 1);
          }
        } else if(submitter === 'defendants'){
          if(this.lawsuit.defendants.length > 1){
            this.lawsuit.defendants.splice(index, 1);
          }
				} else if(submitter === 'defendant_representatives'){
							if(this.lawsuit.defendant_representatives.length > 1){
								this.lawsuit.defendant_representatives.splice(index, 1);
							}
				} else if(submitter === 'other_parties'){
							if(this.lawsuit.other_parties.length > 1){
								this.lawsuit.other_parties.splice(index, 1);
							}
					}
				},

      /**
       * Change display of value
       * @param submitter - Is a string
       * @param index - Is a number
       * @return {number||string}
       * */
      convertString(submitter, index) {
        if(submitter === 'plaintiffs'){
          if(this.lawsuit.plaintiffs.length <= 1){
            return '';
					} else {
            return index;
					}
        } else if(submitter === 'plaintiff_representatives'){
          if(this.lawsuit.plaintiff_representatives.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'defendants'){
          if(this.lawsuit.defendants.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'defendant_representatives'){
          if(this.lawsuit.defendant_representatives.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'other_parties'){
          if(this.lawsuit.other_parties.length <= 1){
            return '';
          } else {
            return index;
          }
        }
      },

         /**
         * Convert Object Data To Array
          * @param formData - an instance formData
          * @param key - an string key object
         * @return {Array}
         * */
      convertObjectDataToArrayRequest(formData, key){
        for (let i = 0; i < this.lawsuit[key].length; i++) {
          formData.append(key+'[]', this.lawsuit.plaintiffs[i].name);
        }
        return formData
      },

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

        axios.post(this.store_route, formData)
          .then(res => {
            console.log(res);
            // localStorage.setItem(res.data.message.status, res.data.message.content);
            location.href = res.data.url;
          })
          .catch(err => {
            if(err.response.status === 422){
              return this.error = err.response.data;
						}
					});
      },
    },
    mounted() {
      this.civil_lawsuits = this.type_lawsuits.filter((lawsuit) => lawsuit.description.includes('civil') )[0];
      this.lawsuit.type_lawsuit_id = this.civil_lawsuits.id;
    }
  }
</script>
