/**
 * Global Filters Mixin
 */
export const filters = {
  /**
   * parse list object and convert to string
   *
   * @function parseName
   * @description parse name in list Objects
   * @return string
   */
  parseName(arrays) {
    if (arrays === undefined || arrays.length <= 0) return '-';
    arrays = arrays.map(value => {return value.name});
    return arrays.join('、 ');
  },
  /**
   * truncate the text
   *
   * @function parseName
   * @ref https://stackoverflow.com/a/52791399
   * @return string
   */
  truncate: function (text, length, suffix = '') {
    if (text && text.length > length) {
      return text.substring(0, length) + suffix;
    } else {
      return text;
    }
  },
};
