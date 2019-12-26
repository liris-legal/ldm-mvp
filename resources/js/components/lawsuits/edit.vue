<template>
	<div class="container-fluid lawsuit-create clearfix">
		<v-row>
			<v-col class="col-12 header-content">
				<h2 class="title-name text-size-30">新件を作成</h2>
				<h3 class="description"/>
			</v-col>
		</v-row>
		<v-form class="form-group clearfix">
			<v-container class="form-group-content">
				<v-row class="ma-0">
					<v-col cols="12 row form-control">
						<v-col class="col-3 pa-0 label"><label class="font-weight-600">事件種類</label></v-col>
						<v-col class="col-9 pa-2 input">民事事件</v-col>
					</v-col>
					<v-col cols="12" class="row form-control">
						<v-col class="col-3 pa-0 label"><label for="number-lawsuit" class="font-weight-600">事件番号</label></v-col>
						<v-col class="col-9 pa-0 input"><input v-model="number" id="number-lawsuit" type="text" class="input-form-group col-md-12"></v-col>
					</v-col>
					<v-col cols="12" class="row form-control">
						<v-col class="col-3 pa-0 label"><label for="name-lawsuit" class="font-weight-600">事件名</label></v-col>
						<v-col class="col-9 pa-0 input"><input v-model="name" id="name-lawsuit" type="text" class="input-form-group col-md-12"></v-col>
					</v-col>
					<v-col cols="12" class="row form-control">
						<v-col class="col-3 pa-0 label"><label for="courts-lawsuit" class="font-weight-600">裁判所・部署</label></v-col>
						<v-col class="col-9 pa-0 input"><input v-model="courts" id="courts-lawsuit" type="text" class="input-form-group col-md-12"></v-col>
					</v-col>
					
					<v-col cols="12" class="row form-control" v-for="(plaintiff, i) in plaintiffs" :key="plaintiff.i">
						<v-col class="col-3 pa-0 label"><label :for="'plaintiff-lawsuit' + i" class="font-weight-600">原告{{ convertString('plaintiffs', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="plaintiffs.value = plaintiff.value" :id="'plaintiff-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('plaintiffs')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-on:click="removeValue('plaintiffs', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
						</v-col>
					</v-col>
					
					<v-col cols="12" class="row form-control" v-for="(plaintiff_representative, i) in plaintiff_representatives" :key="plaintiff_representative.i">
						<v-col class="col-3 pa-0 label"><label :for="'plaintiff-representative-lawsuit' + i" class="font-weight-600">原告代理人{{ convertString('plaintiff_representative', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="plaintiff_representatives.value = plaintiff_representative.value" :id="'plaintiff-representative-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('plaintiff_representatives')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-on:click="removeValue('plaintiff_representatives', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
						</v-col>
					</v-col>
					
					<v-col cols="12" class="row form-control" v-for="(defendant, i) in defendants" :key="defendant.i">
						<v-col class="col-3 pa-0 label"><label :for="'defendant-lawsuit' + i" class="font-weight-600">被告{{ convertString('defendants', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="defendants.value = defendant.value" :id="'defendant-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('defendants')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-on:click="removeValue('defendants', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
						</v-col>
					</v-col>
					
					<v-col cols="12" class="row form-control" v-for="(defendant_representative, i) in defendant_representatives" :key="defendant_representative.i">
						<v-col class="col-3 pa-0 label"><label :for="'defendant-representative-lawsuit' + i" class="font-weight-600">被告代理人{{ convertString('defendant_representatives', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="defendant_representatives.value = defendant_representative.value" :id="'defendant-representative-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('defendant_representatives')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-on:click="removeValue('defendant_representatives', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
						</v-col>
					</v-col>
					
					<v-col cols="12" class="row form-control" v-for="(other_party, i) in other_parties" :key="other_party.i">
						<v-col class="col-3 pa-0 label"><label :for="'other-party-lawsuit' + i" class="font-weight-600">その他当事者{{ convertString('other_parties', ++i) }}</label></v-col>
						<v-col class="col-9 pa-0 input">
							<input v-model="other_parties.value = other_party.value" :id="'other-party-lawsuit' + i" type="text" class="input-form-group col-md-12">
							<v-btn v-on:click="addValue('other_parties')" icon class="icon-add"><v-icon>add_circle_outline</v-icon></v-btn>
							<v-btn v-on:click="removeValue('other_parties', --i)" icon class="icon-clear"><v-icon>remove_circle_outline</v-icon></v-btn>
						</v-col>
					</v-col>
				</v-row>
				<v-row>
					<v-col class="text-center">
						<v-btn v-ripple class="col-8 mr-0-auto btn btn-primary pa-3 height-auto text-size-18 font-weight-600">登録</v-btn>
					</v-col>
				</v-row>
			</v-container>
		</v-form>
	</div>
</template>

<script>
  export default {
    name: "lawsuits-create",
    data() {
      return {
        number: '',
        name: '',
        courts: '',
        plaintiffs: [{ value: ''}],
        plaintiff_representatives: [{ value: ''}],
        defendants: [{ value: '' }],
        defendant_representatives: [{ value: '' }],
        other_parties: [{ value: '' }],
      }
    },
    methods: {
      /**
       * Add element input of the typeSubmitter
       * @param submitter - Is a string
       */
      addValue(submitter){
        switch(submitter) {
          case 'plaintiffs':
            this.plaintiffs.push({ value: '' });
            break;
          case 'plaintiff_representatives':
            this.plaintiff_representatives.push({ value: '' });
            break;
          case 'defendants':
            this.defendants.push({ value: '' });
            break;
          case 'defendant_representatives':
            this.defendant_representatives.push({ value: '' });
            break;
          case 'other_parties':
            this.other_parties.push({ value: '' });
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
          if(this.plaintiffs.length > 1){
            this.plaintiffs.splice(index, 1);
          }
        } else if(submitter === 'plaintiff_representatives'){
          if(this.plaintiff_representatives.length > 1){
            this.plaintiff_representatives.splice(index, 1);
          }
        } else if(submitter === 'defendants'){
          if(this.defendants.length > 1){
            this.defendants.splice(index, 1);
          }
        } else if(submitter === 'defendant_representatives'){
          if(this.defendant_representatives.length > 1){
            this.defendant_representatives.splice(index, 1);
          } else {

          }
        } else if(submitter === 'other_parties'){
          if(this.other_parties.length > 1){
            this.other_parties.splice(index, 1);
          } else {

          }
        } else {}
      },

      /**
       * Change display of value
       * @param submitter - Is a string
       * @param index - Is a number
       * @return {number||string}
       * */
      convertString(submitter, index) {
        if(submitter === 'plaintiffs'){
          if(this.plaintiffs.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'plaintiff_representatives'){
          if(this.plaintiff_representatives.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'defendants'){
          if(this.defendants.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'defendant_representatives'){
          if(this.defendant_representatives.length <= 1){
            return '';
          } else {
            return index;
          }
        } else if(submitter === 'other_parties'){
          if(this.other_parties.length <= 1){
            return '';
          } else {
            return index;
          }
        }
      }
    }
  }
</script>