<template>
  <div class="container-fluid document-create clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          ファイルをアップロード
        </h2>
        <h3 class="description"/>
      </v-col>
    </v-row>
    <v-app>
      <v-form
        class="form-group clearfix"
        method="POST"
      >
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
                      class="selector"
                      v-model="dateFormatted"
                      @blur="date = parseDate(dateFormatted)"
                      append-icon="event"
                      outlined
                      v-on="on"
                    />
                  </template>
                  <v-date-picker
                    v-model="date"
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
      </v-form>
    </v-app>
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
        },
        submitters: [
          { id: 1, name: '原告' },
          { id: 2, name: '被告' },
          { id: 3, name: '裁判所' },
          { id: 4, name: 'その他' },
        ],
        date: new Date().toISOString().substr(0, 10),
        dateFormatted: this.formatDate(new Date().toISOString().substr(0, 10)),
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
        if (files.length > 0) {
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
        formData.append('created_at', this.date);

        axios.post(this.storeRoute, formData)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
      },

      /**
       * @function formatDate
       * @description to format japanese date YYYY年MM月DD日
       * @return string|null
       */
      formatDate(date) {
        if (!date) return null;

        const [year, month, day] = date.split('-');
        return `${year}年${month}月${day}日`
      },
      /**
       * @function parseDate
       * @description format japanese date YYYY年MM月DD日 to ISO Date YYYY-MM-DD
       * @return string|null
       */
      parseDate (date) {
        if (!date) return null;

        const year = date.split('年')[0];

        date = date.replace(year+'年', '');
        const month = date.split('月')[0];

        date = date.replace(month+'月', '');
        const day = date.split('日')[0];

        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
      /**
       * @function onSelectSubmitter
       * @return string|null
       */
      onSelectSubmitter() {
        console.log('selected: ' + this.document.submitter_id);
        if (this.document.submitter_id === 3 || this.document.submitter_id === 4) {
          this.document.type_document_id = 3;
          this.disabled = true;
        } else {
          this.disabled = false;
        }
      },
    },
    computed: {
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
    },
    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      },
    },
  }
</script>

<style scoped>
  .form-control .input-form-group {
    min-height: 56px;
  }
</style>
