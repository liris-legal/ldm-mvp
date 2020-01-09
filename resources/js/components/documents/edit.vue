<template>
  <div class="container-fluid document document--edit clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-18">
          名前を変更
        </h2>
        <h3 class="description"/>
      </v-col>
    </v-row>
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
                  v-model="submitter_id"
                  :items="submitters"
                  item-text="name"
                  item-value="id"
                  label="提出者"
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
                  for="document-type"
                  class="font-weight-600"
                >書面種類</label>
              </v-col>
              <v-col
                id="document-type"
                class="col-9 pa-0 input"
              >
                <v-select
                  v-model="type_document_id"
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
                <v-select v-if="type_document_id === 2"
                  v-model="document.name"
                  :items="nameEvidenceDocuments.filter(item => item.submitter_id === submitter_id)"
                  label="書面名"
                  item-text="name"
                  item-value="name"
                  single-line
                  outlined
                />
                <input v-else
                       id="document-name"
                       v-model="document.name"
                       type="text"
                       class="input-form-group col-md-12"
                >
              </v-col>
            </v-col>
            <v-col
              v-if="type_document_id === 2"
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
                  type="number"
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
              <v-btn
                v-ripple
                class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto text-size-18 font-weight-600"
                @click.native="postData"
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
    name: "Document-edit",
    props: {
      updateRoute: { required: true, type: String, default: ''},
      lawsuitId: {required: true,  type: String, default: ''},
      documentId: {required: true,  type: String, default: ''},
      typeDocuments: {required: true,  type: Array, default: () => []},
    },
    data() {
      return {
        document: {},
        type_document_id: 1,
        submitter_id: 1,
        submitters: [
          { id: 1, name: '原告' },
          { id: 2, name: '被告' },
          { id: 3, name: '裁判所' },
          { id: 4, name: 'その他' },
        ],
        nameEvidenceDocuments: [
          { id: 1, name: '証拠説明書', submitter_id: 1 },
          { id: 2, name: '甲号証', submitter_id: 1 },
          { id: 3, name: '証拠説明書', submitter_id: 2 },
          { id: 4, name: '乙号証', submitter_id: 2 },
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
       * postData is used to create document
       * @return {object}
       */
      postData() {
        /**
         * Create a new formData to store document
         * */
        let formData = new FormData();
        formData.append('name', this.document.name);
        formData.append('number', this.document.number);
        formData.append('type_document_id', this.type_document_id);
        formData.append('submitter_id', this.submitter_id);
        formData.append('created_at', this.date);
        formData.append("_method", "PATCH");

        axios.post(this.updateRoute, formData)
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
       * @function onChangeSubmitter
       * @description to handle change submitter
       */
      onChangeSubmitter(submitter_id) {
        console.log('changed: ' + submitter_id);
        if (submitter_id === 3 || submitter_id === 4) {
          this.type_document_id = 3;
          this.disabled = true;
        } else {
          this.disabled = false;
        }
      },
    },
    created() {
      /**
       * @function
       * @description fetch document data from API
       */
      axios.get('documents/' + this.documentId)
        .then(res => {
          this.document = res.data.data;
          this.type_document_id = this.document.type_document_id;
          this.submitter_id = this.document.submitter_id;
          this.date = new Date(this.document.created_at).toISOString().substr(0, 10);
        })
        .catch(error => {
          console.log(error);
        });
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
      submitter_id (val) {
        this.onChangeSubmitter(val);
      },
    },
  }
</script>

<style scoped>
  .form-control .input-form-group {
    min-height: 56px;
  }
</style>
