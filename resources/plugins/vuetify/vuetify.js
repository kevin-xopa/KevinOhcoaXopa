import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import * as labs from 'vuetify/labs/components'
import 'vuetify/styles'


import defaults from './defaults'
import { icons } from './icons'
import theme from './theme'


export default createVuetify({
  ssr: true,
  components: {
    ...labs,
    ...components
  },
  directives,
  defaults,
  icons,
  theme,
})
