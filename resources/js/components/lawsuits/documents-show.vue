<template>
  <div class="container-fluid document document--index">
    <lawsuit-header :lawsuit="lawsuit" />
    <v-card>
      <v-tabs
        v-model="typeTab"
        background-color="transparent"
        color="primary"
        grow
        centered
        class="lawsuit-tabs"
      >
        <v-tab
          v-for="type in typeDocuments"
          :key="type.id"
        >
          {{ type.name }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="typeTab">
        <!-- ▽ 主張書面-->
        <v-tab-item>
          <v-container fluid>
            <v-tabs
              v-model="documentTab"
              class="document-tabs"
              color="basil"
            >
              <v-tab
                v-for="document in claimDocuments"
                :key="document.id"
              >
                {{ document.name }}
              </v-tab>
            </v-tabs>

            <v-tabs-items v-model="documentTab">
              <v-tab-item
                v-for="document in claimDocuments"
                :key="document.id"
              >
                <v-container fluid>
                  <v-card flat color="basil">
                    <v-card-text>{{ document }}</v-card-text>
                  </v-card>
                </v-container>
              </v-tab-item>
            </v-tabs-items>
          </v-container>
        </v-tab-item>
        <!-- △ 主張書面-->

        <!-- ▽ 証拠書面-->
        <v-tab-item>
          <v-container fluid>
            <v-tabs
              v-model="documentTab"
              background-color="transparent"
              color="primary"
              grow
              centered
              class="document-tabs"
            >
              <v-tab
                v-for="document in claimDocuments"
                :key="document.id"
              >
                {{ document.name }}
              </v-tab>
            </v-tabs>

            <v-tabs-items v-model="documentTab">
              <v-tab-item>
                <v-container fluid>
                  <v-row>
                    <v-col
                      v-for="i in 6"
                      :key="i"
                      cols="12"
                      md="4"
                    >
                      <v-img
                        :src="`https://picsum.photos/500/300?image=${i  * 5 + 10}`"
                        :lazy-src="`https://picsum.photos/10/6?image=${i  * 5 + 10}`"
                        aspect-ratio="1"
                      ></v-img>
                    </v-col>
                  </v-row>
                </v-container>
              </v-tab-item>
            </v-tabs-items>
          </v-container>
        </v-tab-item>
        <!-- △ 証拠書面-->

        <!-- ▽ その他の書面-->
        <v-tab-item>
          <v-container fluid>
            <v-tabs
              v-model="documentTab"
              background-color="transparent"
              color="primary"
              class="document-tabs"
            >
              <v-tab
                v-for="document in claimDocuments"
                :key="document.id"
              >
                {{ document.name }}
              </v-tab>
            </v-tabs>

            <v-tabs-items v-model="documentTab">
              <v-tab-item>
                <v-container fluid>
                  <v-row>
                    <v-col
                      v-for="i in 6"
                      :key="i"
                      cols="12"
                      md="4"
                    >
                      <v-img
                        :src="`https://picsum.photos/500/300?image=${i  * 5 + 10}`"
                        :lazy-src="`https://picsum.photos/10/6?image=${i  * 5 + 10}`"
                        aspect-ratio="1"
                      ></v-img>
                    </v-col>
                  </v-row>
                </v-container>
              </v-tab-item>
            </v-tabs-items>
          </v-container>
        </v-tab-item>
        <!-- △ その他の書面-->
      </v-tabs-items>
    </v-card>

  </div>
</template>
<script>
  export default {
    name: "LawsuitDocumentShow",
    props: {
      typeDocuments: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        submitter: '',
        submitterKana: '',
        theadLabels: [
          { id: 1, label: '書面名', class: 'col-6'},
          { id: 2, label: '提出日', class: 'col-6'},
        ],
        lawsuit: {},
        explainDocuments: [],
        evidenceDocuments: [],
        typeTab: null,
        documentTab: null,
        claimDocuments: [],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      }
    },
    created() {
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          this.claimDocuments = this.lawsuit.documents.filter(d => d.type.description === 'claim');
          console.log(this.claimDocuments)

          const evidenceDocument = this.lawsuit.documents.filter(d => d.submitter.description === this.submitter &&
           d.type.description === 'evidence' );

          const explainDocumentName = this.submitter === 'plaintiff' ? "甲号証" : "乙号証";
          this.evidenceDocuments = evidenceDocument.filter(d => d.name === explainDocumentName);
          this.explainDocuments = evidenceDocument.filter(d => d.name === '証拠説明書');
          })
        .catch(err => {console.log(err.response);});

      /**
       * parse params to get submitter
       *
       */
      this.submitter = this.$route.params.submitter;
      this.submitterKana = this.submitter === 'plaintiff' ? "甲" : "乙"
    },
    mounted() {
      // console.log(this.$route.name + ' mounted');
    }
  }
</script>

<style scoped>
  .lawsuit-tabs {
    max-width: 75%;
    margin: 0 auto;
  }
  .v-tab.v-tab--active{
    font-weight: 600;
  }
</style>
