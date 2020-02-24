import Router from 'vue-router'
import goTo from 'vuetify/es5/services/goto'

/**
 * Each route should map to a component. The "component" can
 * either be an actual component constructor created via
 * `Vue.extend()`, or just a component options object.
 *
 */
import Index from './components/home.vue';
import TypeLawsuitsIndex from './components/type-lawsuits/index.vue';
import LawsuitsIndex from './components/lawsuits/index.vue';
import LawsuitsShow from './components/lawsuits/show.vue';
import LawsuitsCreate from './components/lawsuits/create.vue';
import LawsuitsEdit from './components/lawsuits/edit.vue';
import DocumentsCreate from './components/documents/create.vue';
import DocumentsEdit from './components/documents/edit.vue';
import DocumentsIndex from './components/documents/index.vue';
import LawsuitsDocumentShow from './components/lawsuits/documents-show';

export default new Router({
  mode: 'history',
  scrollBehavior: (to, from, savedPosition) => {
    let scrollTo = 0;

    if (to.hash) {
      scrollTo = to.hash
    } else if (savedPosition) {
      scrollTo = savedPosition.y
    }

    return goTo(scrollTo)
  },
  routes: [
    { path: '/', name: 'index', component: Index },
    { path: '/type-lawsuits', name: 'typeLawsuitsIndex', component: TypeLawsuitsIndex },
    { path: '/lawsuits', name: 'lawsuitsIndex', component: LawsuitsIndex },
    { path: '/lawsuits/create', name: 'lawsuitsCreate', component: LawsuitsCreate },
    { path: '/lawsuits/:lawsuitId', name: 'lawsuitsShow', component: LawsuitsShow },
    { path: '/lawsuits/:lawsuitId/edit', name: 'lawsuitsEdit', component: LawsuitsEdit },
    { path: '/lawsuits/:lawsuitId/documents/create', name: 'documentsCreate', component: DocumentsCreate },
    { path: '/lawsuits/:lawsuitId/:submitter/:submitterId/documents', name: 'documentsIndex', component: DocumentsIndex },
    { path: '/lawsuits/:lawsuitId/documents/:documentId/edit', name: 'documentsEdit', component: DocumentsEdit },
    { path: '/lawsuits/:lawsuitId/documents', name: 'lawsuitsDocumentShow', component: LawsuitsDocumentShow },
  ],
})
