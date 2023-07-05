const theme = {
  defaultTheme: 'dark',
  themes: {
    light: {
      dark: false,
      colors: {
        'primary': '#08A7D0',
        'secondary': '#8A8D93',
        'on-secondary': '#000',
        'success': '#009688',
        'info': '#16B1FF',
        'warning': '#F6B032',
        'error': '#E4352B',
        'delete': '#E4352B',
        'on-primary': '#FFFFFF',
        'on-success': '#FFFFFF',
        'on-warning': '#FFFFFF',
        'background': '#dddddd',
        'on-background': '#3A3541',
        'surface': '#D8D8D8',
        'on-surface': '#3A3541',
        'yellow': '#F6B032',
        'red': '#E4352B',
        'blue': '#08A7D0',
        'graphite': '#71706F',
        'tool_bar': '#08A7D0',
        'panel_login': '#12ebbd',
        'vertical_menu': '#E4352B',
        'color_paginate': '#F6B032',
        'loading': '#08A7D0',
        'filter_button': '#FF206C',
        'view_tree': '#490780'
      },
      variables: {
        'border-color': '#3A3541',
        'medium-emphasis-opacity': 0.68,
        // Shadows
        'shadow-key-umbra-opacity': 'rgba(var(--v-theme-on-surface), 0.08)',
        'shadow-key-penumbra-opacity': 'rgba(var(--v-theme-on-surface), 0.12)',
        'shadow-key-ambient-opacity': 'rgba(var(--v-theme-on-surface), 0.04)',
      },
    },
    dark: {
      dark: true,
      colors: {
        'primary': '#0A8196',
        'secondary': '#8A8D93',
        'on-secondary': '#fff',
        'success': '#00BAA9',
        'info': '#16B1FF',
        'warning': '#F09005',
        'error': '#CA2020',
        'delete': '#CC1423',
        'on-primary': '#FFFFFF',
        'on-success': '#FFFFFF',
        'on-warning': '#FFFFFF',
        'background': '#000000',
        'on-background': '#E7E3FC',
        'surface': '#0B3661',
        'on-surface': '#E7E3FC',
        'yellow': '#F09005',
        'red': '#CC1423',
        'blue': '#0A8196',
        'graphite': '#4C4848',
        'tool_bar': '#0A8196',
        'panel_login': '#13B492',
        'vertical_menu': '#CC1423',
        'color_paginate': '#F6B032',
        'loading': '#0A8196',
        'filter_button': '#e91e63',
        'view_tree': '#A04CE7'
      },
      variables: {
        'border-color': '#E7E3FC',
        'medium-emphasis-opacity': 0.68,

        // Shadows
        'shadow-key-umbra-opacity': 'rgba(20, 18, 33, 0.08)',
        'shadow-key-penumbra-opacity': 'rgba(20, 18, 33, 0.12)',
        'shadow-key-ambient-opacity': 'rgba(20, 18, 33, 0.04)',
      },
    },
  },
}
export default theme
