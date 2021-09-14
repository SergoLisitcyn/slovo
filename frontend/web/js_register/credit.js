import { VueMediaQueryMixin } from './media.mixin.js'

Vue.use(VueMediaQueryMixin, {framework:'vuetify'});
new Vue({
  el: '#credit',
  data: {
      partners: partners
  },
  methods: {
    bestDeal: function (isBestDeal) {
        return {
            color: Number(isBestDeal) ? '#ffffff' : '#404041',
            backgroundColor: Number(isBestDeal) ? '#ff9800' : '#dce8e5'
        }
    }
  }
})
