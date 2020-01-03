/**
 * Each route should map to a component. The "component" can
 * either be an actual component constructor created via
 * `Vue.extend()`, or just a component options object.
 *
 */
import LawsuitsIndex from './components/lawsuits/index.vue';
import LawsuitsShow from './components/lawsuits/show.vue';

export const routes = [
  { path: '/lawsuits', name:'lawsuitIndex', component: LawsuitsIndex },
  { path: '/lawsuits/:lawsuitId', name:'lawsuitShow', component: LawsuitsShow },
]
