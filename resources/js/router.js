/**
 * Each route should map to a component. The "component" can
 * either be an actual component constructor created via
 * `Vue.extend()`, or just a component options object.
 *
 */
import TypeLawsuitsIndex from './components/type-lawsuits/index.vue';
import LawsuitsIndex from './components/lawsuits/index.vue';
import LawsuitsShow from './components/lawsuits/show.vue';
import LawsuitsCreate from './components/lawsuits/create.vue';
import LawsuitsEdit from './components/lawsuits/edit.vue';
import DocumentsCreate from './components/documents/create.vue';

export const router = [
  { path: '/type-lawsuits', name:'typeLawsuitsIndex', component: TypeLawsuitsIndex },
  { path: '/lawsuits', name:'lawsuitsIndex', component: LawsuitsIndex },
  { path: '/lawsuits/create', name:'lawsuitsCreate', component: LawsuitsCreate },
  { path: '/lawsuits/:lawsuitId', name:'lawsuitsShow', component: LawsuitsShow },
  { path: '/lawsuits/:lawsuitId/edit', name:'lawsuitsEdit', component: LawsuitsEdit },
  { path: '/lawsuits/:lawsuitId/documents/create', name:'documentsCreate', component: DocumentsCreate },
];
