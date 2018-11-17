export default {
  id: {
    label: 'Id',
    render: (data, type, row) => `<a href='#/edit/${data}'>${data}</a>`
  },
  title: {
    label: 'Title',
    render: (data, type, row) => `<a href="${row.url}">${data}</a>`
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
    label: 'Type <select class="column_search"><option value="" default>All</option><option value="rss">RSS</option><option value="podcast">Podcast</option></select>',
    sortable: false
  },
  created_at: {
    label: 'Created At',
    render: (data) => (new Date(data)).toLocaleDateString()
  },
  updated_at: {
    label: 'Updated At',
    render: (data) => (new Date(data)).toLocaleDateString()
  }
}