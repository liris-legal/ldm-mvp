<template>
  <div class="container-fluid document document--create clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name font-size-30">
          ファイルをアップロード
        </h2>
        <h3 class="description" />
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
                dense
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
                dense
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
            <v-col
              id="document-name"
              class="col-9 pa-0 input"
            >
              <v-select
                v-if="type_document_id === 2"
                v-model="document.name"
                :items="nameEvidenceDocuments.filter(item => item.submitter_id === submitter_id)"
                label="書面名"
                item-text="name"
                item-value="name"
                single-line
                outlined
                dense
              />
              <v-text-field
                v-else
                v-model="document.name"
                class="col-md-12"
                dense
                single-line
                outlined
                required
              />
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'name') }}</small>
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
            <v-col
              id="document-number"
              class="col-9 pa-0 input"
            >
              <v-text-field
                v-model="document.number"
                type="number"
                class="col-md-12"
                single-line
                outlined
                dense
                required
              />
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
                    v-model="dateFormatted"
                    class="selector"
                    append-icon="event"
                    outlined
                    dense
                    @blur="date = parseDate(dateFormatted)"
                    v-on="on"
                  />
                </template>
                <v-date-picker
                  v-model="date"
                  locale="ja-jp"
                  :first-day-of-week="1"
                  :max="getEndDate"
                  no-title
                  @input="datePicker = false"
                />
              </v-menu>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'created_at') }}</small>
              <small
                v-if="errors"
                class="has-error"
              >{{ catchError(errors, 'file') }}</small>
            </v-col>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center">
            <v-file-input
              id="file-upload"
              v-model="file"
              type="file"
              accept=".pdf,.doc,.docx"
              style="display:none"
              show-size
              :rules="rules"
            />
            <v-btn
              v-ripple
              class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto font-size-16 font-weight-600"
              @click="openFileDialog"
            >
              アップロード
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
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
      submitters: {required: true,  type: Array, default: () => []},
    },
    data() {
      return {
        document: {
          number: '',
          name: '',
        },
        type_document_id: 1,
        submitter_id: 1,
        nameEvidenceDocuments: [
          { id: 1, name: '証拠説明書', submitter_id: 1 },
          { id: 2, name: '甲号証', submitter_id: 1 },
          { id: 3, name: '証拠説明書', submitter_id: 3 },
          { id: 4, name: '乙号証', submitter_id: 3 },
        ],
        date: new Date().toISOString().substr(0, 10),
        dateFormatted: this.formatDate(new Date().toISOString().substr(0, 10)),
        datePicker: false,
        disabled: false,
        file: null,
        rules: [
          value => !value || value.size < 2048000000 || 'File size should be less than 2048 MB!',
        ],
        errors: []
      }
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
      file (val){
        if (val) this.postData();
        this.clearFile();
      },
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
       * @function clearFile
       * @description to clear selected file
       */
      clearFile() {
        this.file = null;
        document.getElementsByClassName(' v-input__icon--clear')[0].children[0].click()
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
        formData.append('type_document_id', this.type_document_id);
        formData.append('submitter_id', this.submitter_id);
        formData.append('created_at', this.date);

        axios.post(this.storeRoute, formData)
          .then(res => {
            console.log(res);
            this.$store.dispatch('create_notification', res.data.message);
            setTimeout(function(){ location.href = res.data.url; }, 3000);
          })
          .catch(err => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
      },

      /**
       * @function onChangeSubmitter
       * @description to handle change submitter
       */
      onChangeSubmitter(submitter_id) {
        console.log('changed: ' + submitter_id);
        if (this.submitters.find(s => s.id === submitter_id && (s.description === 'court' || s.description === 'other_party'))) {
          this.type_document_id = 3;
          this.disabled = true;
        } else {
          this.disabled = false;
        }
      },
    },
  }
</script>

