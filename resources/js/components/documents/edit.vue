<template>
  <div class="container-fluid document document--edit clearfix">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name font-size-30">
          名前を変更
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
            <v-col
              class="col-3 pa-0 label"
            >
              <label
                for="document-number"
                class="font-weight-600"
              >書面番号</label>
            </v-col>
            <v-col
              id="document-number"
              class="col-9 pa-0 input"
            >
              <v-row class="ma-0 row-text-field">
                <v-col
                  cols="5"
                  class="pa-0"
                >
                  <v-select
                    v-model="document.number"
                    :items="numbers"
                    label="書面番号"
                    single-line
                    outlined
                    dense
                  />
                </v-col>

                <v-col
                  cols="1"
                  class="font-weight-600 px-1 text-center"
                >
                  の
                </v-col>

                <v-col
                  cols="6"
                  class="pa-0"
                >
                  <v-select
                    :items="numbers"
                    single-line
                    outlined
                    dense
                  />
                </v-col>
              </v-row>
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
                    v-on="on"
                    @blur="date = parseDate(dateFormatted)"
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
            <v-btn
              v-ripple
              class="col-sm-8 col-md-6 col-lg-4 mr-0-auto btn btn-primary pa-3 height-auto font-size-16 font-weight-600"
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
    name: "DocumentEdit",
    props: {
      updateRoute: { required: true, type: String, default: ''},
      lawsuitId: {required: true,  type: String, default: ''},
      documentId: {required: true,  type: String, default: ''},
      typeDocuments: {required: true,  type: Array, default: () => []},
      submitters: {required: true,  type: Array, default: () => []},
    },
    data() {
      return {
        document: {},
        numbers: new Array(100).join().split(',').map(function(item, index){ return ++index;}),
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
    },
    mounted() {
      console.log('create document mounted')
    },
    created() {
      /**
       * @function
       * @description fetch document data from API
       */
      axios.get('lawsuits/'+this.lawsuitId+'/documents/' + this.documentId)
        .then(res => {
          this.document = res.data.data;
          this.document.number = this.document.number ? parseInt(this.document.number) : this.document.number;
          this.type_document_id = this.document.type.id;
          this.submitter_id = this.document.submitter.id;
          this.date = new Date(this.document.created_at).toISOString().substr(0, 10);
        })
        .catch(err => {
          console.log(err);
          alert('Not found data!');
        });
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
        formData.append('lawsuit_id', this.lawsuitId);
        formData.append('type_document_id', this.type_document_id);
        formData.append('submitter_id', this.submitter_id);
        formData.append('created_at', this.date || '');
        formData.append("_method", "PATCH");

        axios.post(this.updateRoute, formData)
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

<style scoped>
  .row-text-field .col-number{
    max-width: 44.98%
  }
</style>
