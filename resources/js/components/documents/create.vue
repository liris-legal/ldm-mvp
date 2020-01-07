<template>
  <div class="container-fluid lawsuit-create clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          ファイルをアップロード
        </h2>
        <h3 class="description" />
      </v-col>
    </v-row>
    <v-form
      class="form-group clearfix"
      method="POST"
      enctype="multipart/form-data"
    >
      <v-app>
        <v-container class="form-group-content">
          <v-row class="ma-0">
            <v-col
              cols="12"
              class="row form-control pa-2"
            >
              <v-col class="col-3 pa-0 label">
                <label
                  for="submitter"
                  class="font-weight-600"
                >提出者</label>
              </v-col>
              <v-col
                id="submitter"
                class="col-9 pa-0 input"
              >
                <v-select
                  v-model="document.submitter_id"
                  :items="submitters"
                  item-text="name"
                  item-value="id"
                  label="提出者"
                  single-line
                  outlined
                  @change="onSelectSubmitter"
                />
              </v-col>
            </v-col>
            <v-col
              cols="12"
              class="row form-control pa-2"
            >
              <v-col class="col-3 pa-0 label">
                <label
                  for="document-type"
                  class="font-weight-600"
                >書面種類</label>
              </v-col>
              <v-col
                id="document-type"
                class="col-9 pa-0 input"
              >
                <v-select
                  v-model="document.type_document_id"
                  :items="typeDocuments"
                  :disabled="disabled"
                  item-text="name"
                  item-value="id"
                  label="書面種類"
                  single-line
                  outlined
                />
              </v-col>
            </v-col>
            <v-col
              cols="12"
              class="row form-control pa-2"
            >
              <v-col class="col-3 pa-0 label">
                <label
                  for="document-name"
                  class="font-weight-600"
                >書面名</label>
              </v-col>
              <v-col class="col-9 pa-0 input">
                <input
                  id="document-name"
                  v-model="document.name"
                  type="text"
                  class="input-form-group col-md-12"
                >
              </v-col>
            </v-col>
            <v-col
              v-show="!disabled"
              cols="12"
              class="row form-control pa-2"
            >
              <v-col class="col-3 pa-0 label">
                <label
                  for="document-number"
                  class="font-weight-600"
                >書面番号</label>
              </v-col>
              <v-col class="col-9 pa-0 input">
                <input
                  id="document-number"
                  v-model="document.number"
                  type="text"
                  class="input-form-group col-md-12"
                >
              </v-col>
            </v-col>
            <v-col
              cols="12"
              class="row form-control pa-2"
            >
              <v-col class="col-3 pa-0 label">
                <label
                  for="date"
                  class="font-weight-600"
                >提出日</label>
              </v-col>
              <v-col
                id="date"
                class="col-9 pa-0 input"
              >
                <v-menu
                  ref="datePicker"
                  v-model="datePicker"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="document.created_at"
                      append-icon="event"
                      outlined
                      v-on="on"
                    />
                  </template>
                  <v-date-picker
                    v-model="document.created_at"
                    locale="ja-jp"
                    :first-day-of-week="1"
                    no-title
                    @input="datePicker = false"
                  />
                </v-menu>
              </v-col>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="text-center">
              <input
                id="file-upload"
                type="file"
                style="display:none"
                @change="onFileChange"
              >
              <v-btn
                v-ripple
                class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto text-size-18 font-weight-600"
                @click.native="openFileDialog"
              >
                アップロード
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-app>
    </v-form>
  </div>
</template>

<script>
  export default {
    name: "DocumentCreate",
    props: {
      storeRoute: { required: true, type: String, default: ''},
      lawsuitId: {required: true,  type: String, default: ''},
      typeDocuments: {required: true,  type: Array, default: () => []},
    },
    data() {
      return {
        document: {
          number: '',
          name: '',
          type_document_id: 0,
          submitter_id: 0,
          created_at: new Date().toISOString().substr(0, 10),
        },
        submitters: [
          { id: 1, name: '原告' },
          { id: 3, name: '被告' },
          { id: 6, name: '裁判所' },
          { id: 5, name: 'その他' },
        ],
        datePicker: false,
        disabled: false,
        file: null,
        errors: []
      }
    },
    mounted() {
      console.log('create document mounted')
    },
    methods: {
      /**
       * @function openFileDialog
       * @description to open dialog select file
       */
      openFileDialog() {
        document.getElementById('file-upload').click();
      },

      /**
       * @function onFileChange
       * @description to handle file selected and auto send submit request to create document
       */
      onFileChange(e) {
        var self = this;
        var files = e.target.files || e.dataTransfer.files;
        if(files.length > 0){
          self.file = files[0];
        }
        this.postData();
      },
      /**
       * postData is used to create document
       * @return {object}
       */
      postData() {
        /**
         * Create a new formData to store document
         * */
        let formData = new FormData();
        formData.append('lawsuit_id', this.lawsuitId);
        formData.append('number', this.document.number);
        formData.append('name', this.document.name);
        formData.append('file', this.file);
        formData.append('type_document_id', this.document.type_document_id);
        formData.append('submitter_id', this.document.submitter_id);

        axios.post(this.storeRoute, formData)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            if(err.response.status === 422){
              this.errors = err.response.data.errors;
            }
          });
      },

      /**
       * @function formatDate
       * @description to format date YYYY-MM-DD
       * @return string|null
       */
      formatDate (date) {
        if (!date) return null;

        const [year, month, day] = date.split('-');
        return `${year}-${month}-${day}`
      },

      /**
       * @function onSelectSubmitter
       * @return string|null
       */
      onSelectSubmitter() {
        console.log('selected: ' + this.document.submitter_id);
        if (this.document.submitter_id === 3 || this.document.submitter_id === 4 ){
          this.document.type_document_id = 3;
          this.disabled = true;
        }else{
          this.disabled = false;
        }
      },
    }
  }
</script>

<style scoped>
  .form-control .input-form-group{
    min-height: 56px;
  }
  .v-text-field__details {
    display: none !important;
  }
</style>
