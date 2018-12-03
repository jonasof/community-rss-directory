export default (i18n) => ({
  title: {
    label: i18n.t('feeds.columns.title')
  },
  tagged: {
    label: i18n.t('feeds.columns.tags'),
    searchable: false,
    sortable: false,
    render: (data) => data.map(
      (tag) => {
        return `<a href='#/?tag=${tag.tag_slug}'>${tag.tag_slug}</a>`
      }
    ).join(', ')
  },
  type: {
    label: i18n.t('feeds.columns.type') + ` <select class="column_search">
      <option value="" default>${i18n.t('feeds.types.all')}</option>
      <option value="rss">${i18n.t('feeds.types.rss')}</option>
      <option value="podcast">${i18n.t('feeds.types.podcast')}</option>
    </select>`,
    sortable: false
  },
  status: {
    label: i18n.t('feeds.columns.online'),
    template: `<span v-if="data" class="online">${i18n.t('yes')}</span><span v-else class="offline">${i18n.t('no')}</span>`
  },
  created_at: {
    label: i18n.t('feeds.columns.created_at'),
    render: (data) => (new Date(data)).toLocaleDateString()
  },
  updated_at: {
    label: i18n.t('feeds.columns.updated_at'),
    render: (data) => (new Date(data)).toLocaleDateString()
  },
  actions: {
    label: i18n.t('feeds.columns.actions'),
    template: `<div class="action">
      <a title="${i18n.t('feeds.actions.preview')}" href="javascript:void(0);" data-action="preview"><font-awesome-icon icon="eye" /></a>
      <a title="${i18n.t('feeds.actions.link')}" :href="row.url" target="_blank"><font-awesome-icon icon="link" /></a>
      <a title="${i18n.t('feeds.actions.edit')}" :href='"#/edit/" + row.id'><font-awesome-icon icon="pen" /></a>
    </div>`
  }
})