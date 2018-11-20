export default {
  title: {
    label: 'Title'
  },
  tagged: {
    label: 'Tags',
    searchable: false,
    sortable: false,
    render: (data) => data.map(
      (tag) => {
        return `<a href='#/?tag=${tag.tag_slug}'>${tag.tag_slug}</a>`
      }
    ).join(', ')
  },
  type: {
    label: `Type <select class="column_search">
      <option value="" default>All</option>
      <option value="rss">RSS</option>
      <option value="podcast">Podcast</option>
    </select>`,
    sortable: false
  },
  status: {
    label: 'Online',
    template: '{{ data ? "yes" : "no" }}'
  },
  created_at: {
    label: 'Created At',
    render: (data) => (new Date(data)).toLocaleDateString()
  },
  updated_at: {
    label: 'Updated At',
    render: (data) => (new Date(data)).toLocaleDateString()
  },
  actions: {
    label: 'Actions',
    template: `<div class="action">
      <a title="Preview" href="javascript:void(0);" data-action="preview"><font-awesome-icon icon="eye" /></a>
      <a title="Feed Link" :href="row.url" target="_blank"><font-awesome-icon icon="link" /></a>
      <a title="Edit" :href='"#/edit/" + row.id'><font-awesome-icon icon="pen" /></a>
    </div>`
  }
}