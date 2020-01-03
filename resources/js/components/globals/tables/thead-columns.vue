<template>
  <thead class="thead-columns">
    <tr class="d-flex">
      <th :class="th.class" v-for="th in thead" :key="th.id" scope="col" class="text-left">
        <div class="name font-weight-600">{{ th.label }}</div>
      </th>
    </tr>
  </thead>
</template>

<script>
  export default {
    name: "TheadColumns",
		props: {
      thead: { type: Array, required: true, default: function () { return [ { id: 1, label: 'Name', class: 'col-12' } ]} }
		}
  }
</script>
