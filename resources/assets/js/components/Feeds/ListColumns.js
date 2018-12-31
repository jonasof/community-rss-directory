export default (i18n) => ({
  icon_url: {
    label: ' ',
    searchable: false,
    sortable: false,
    render: (data) => {
      return data ? `<img src='${data}' width='24' height='24' referrerpolicy='no-referrer' />` : ``
    }
  },
  title: {
    label: i18n.t('feeds.columns.title'),
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
    template: `
      <span :class="data ? ['online'] : ['offline']">
        <span v-if="data">${i18n.t('yes')}</span>
        <span v-else>${i18n.t('no')}</span>

        <span class='float-right' :title="'${i18n.t('feeds.columns.last_status_check')}: ' + $options.filters.localdatetime(row.last_status && row.last_status.created_at)">
          <font-awesome-icon icon="info-circle" />
        </span>
      </span>
    `
  },
  created_at: {
    label: i18n.t('feeds.columns.created_at'),
    template: `{{ data | localdate }}`
  },
  updated_at: {
    label: i18n.t('feeds.columns.updated_at'),
    template: `{{ data | localdate }}`
  },
  actions: {
    label: i18n.t('feeds.columns.actions'),
    template: `<div class="action">
      <a title="${i18n.t('feeds.actions.preview')}" href="javascript:void(0);" data-action="preview"><font-awesome-icon icon="eye" /></a>
      <a title="${i18n.t('feeds.actions.link')}" href="javascript:void(0);" data-action="openFeed"><font-awesome-icon icon="link" /></a>
      <a title="${i18n.t('feeds.actions.edit')}" class='edit' :href='"#/edit/" + row.id'><font-awesome-icon icon="pen" /></a>
    </div>`
  }
})