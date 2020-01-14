/**
 * Global Mixin
 */
import {methods} from "./methods";
import {filters} from "./filters";
/**
 * package: Clicks Outside an Element
 */
import ClickOutside from 'vue-click-outside';

export const mixin = {
  methods: methods,
  filters: filters,
  directives: {
    /**
     * ClickOutside: Clicks Outside an Element
     */
    ClickOutside
  },
  computed: {
    getEndDate() {
      return new Date().toISOString().slice(0,10)
    }
  },
};
