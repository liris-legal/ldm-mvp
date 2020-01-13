/**
 * Global Methods Mixin
 */
export const methods = {
  /**
   * Add a new item to an array
   * @param lawsuit an instance lawsuit object
   * @param parties type of parties
   */
  pushToParties(lawsuit, parties) {
    let item = {name: ''};
    return lawsuit[parties].push(item);
  },

  /**
   * Remove an item in parties
   * @param lawsuit an instance lawsuit object
   * @param parties type of parties
   * @param index - Ordinal number element input of the typeSubmitter
   * */
  removeItemFromParties(lawsuit, parties, index) {
    return lawsuit[parties].splice(index, 1);
  },

  /**
   * Counter item of parties add index to title
   * @param parties type of parties
   * @param index Ordinal number element of parties
   * @return {number||string}
   * */
  countParties(parties, index) {
    if (index)
      return parties.length <= 1 ? '' : index;
    else
      return parties.length
  },

  /**
   * Convert Object To Array
   * @param formData - an instance formData
   * @param key - an string key object
   * @return {Array}
   * */
  convertObjectDataToArrayRequest(formData, key){
    const partiesNullable = ['defendant_representatives', 'plaintiff_representatives', 'other_parties'];
    for (let i = 0; i < this.lawsuit[key].length; i++) {
      if ( partiesNullable.includes(key) && this.lawsuit[key][i].name.length === 0 )
        console.log('ignored');
      else
        formData.append(key+'[]', this.lawsuit[key][i].name);
    }
    return formData
  },

  /**
   * Handle error to show message
   *
   * @param errors - an instance errors
   * @param field_name - party name
   * @param index - index of item in parties
   * @return {string} an error message
   * */
  catchError(errors, field_name, index = NaN) {
    let errorMessage, key;
    key = !isNaN(index) ? field_name + "." + index : field_name;

    if (errors.hasOwnProperty(key)){
      errorMessage = errors[key];
      key = key === 'courts_departments' ? 'courts departments' : key;
      return errorMessage[0].replace(key, this.translateColumnName(field_name, 'en_ja'));
    }
  },

  /**
   * To translate party name
   * mode en_ja: translate from english (英語) to japanese (日本語)
   * mode ja_en: translate from japanese to english
   *
   * @param party - party name
   * @param mode - mode to translate
   * @return {string} a translated party name
   * */
  translateColumnName(party, mode) {
    const parties = {number: '事件番号', name: '事件名', courts_departments: '裁判所・部署', plaintiffs: '原告',
      plaintiff_representatives: '原告代理人', defendants: '被告', defendant_representatives: '被告代理人', other_parties: 'その他当事者'};

    return mode === 'en_ja' && parties.hasOwnProperty(party) ? parties[party] : party;
  },

  /**
   * To goBack previous url
   *
   * */
  goBack() {
    window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
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
};
