<template>
  <ais-instant-search
    :search-client="searchClient"
    index-name="permissions"
    :class-names="{
      'ais-InstantSearch': 'position-relative',
    }"
  >
    <ais-search-box>
     <div slot-scope="{ currentRefinement, isSearchStalled, refine }">
      <input
        @keyup="changes"
        placeholder="Search Permission"
        class="form-control form-control-alternative"
        type="search"
        v-model="currentRefinement"
        @input="refine($event.currentTarget.value)"
      >
      <span :hidden="!isSearchStalled">Loading...</span>
    </div>
   </ais-search-box>
    <ais-hits
    v-if="query"
    :class-names="{
        'ais-Hits': 'position-absolute mt-1',
        'ais-Hits-list': 'list-group',
        'ais-Hits-item': 'list-group-item'
      }"
    >
      <template
        slot="item"
        slot-scope="{ item }"
      >
        <a class="name-link" :href="'/user-management/permission/'+item.id+'/edit'">{{ item.name }}</a>
      </template>
    </ais-hits>
  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite'
import _ from 'lodash'
export default {
  data() {
    return {
      searchClient: algoliasearch(
        process.env.MIX_ALGOLIA_APP_ID,
        process.env.MIX_ALGOLIA_SEARCH
      ),
      query: false
    }
  },

  methods: {
    changes(event) {
      this.query = !_.isEmpty(event.currentTarget.value)
    }
  }
};
</script>

<style lang="scss" scoped>
.ais-InstantSearch {
  .ais-Hits{
    width: 100%;
  }
}

.name-link {
  display: block;
}
</style>
