const vuetifyMediaQuery = {
  xs: {
    max: 599
  },
  sm: {
    min: 600,
    max: 1023
  },
  md: {
    min: 1024,
    max: 1439
  },
  lg: {
    min: 1440,
    max: 1919
  },
  xl: {
    min: 1920
  },
  mobile: {
    max: 600
  }
};
const bootstrapMediaQuery = {
  xs: {
    max: 575
  },
  sm: {
    min: 576,
    max: 767
  },
  md: {
    min: 768,
    max: 991
  },
  lg: {
    min: 992,
    max: 1999
  },
  xl: {
    min: 1200
  },
  mobile: {
    max: 600
  }
};
export const VueMediaQueryMixin = {
  install(Vue, options) {
    Vue.mixin({
      // components: {
      //   vmqm
      // },
      data: function () {
        return {
          windowWidth: 0,
          windowHeight: 0,
          wXS: false,
          wSM: false,
          wMD: false,
          wLG: false,
          wXL: false,
          wMobile: false
        };
      },

      mounted() {
        this.$nextTick(function () {
          window.addEventListener("resize", this.getWindowWidth);
          window.addEventListener("resize", this.getWindowHeight);
          this.getWindowWidth();
          this.getWindowHeight();
        });
      },

      methods: {
        getWindowWidth(event) {
          let w = document.documentElement.clientWidth;
          this.windowWidth = w;
          let mediaQuery = {}; // default

          if (!options) mediaQuery = vuetifyMediaQuery; // vuetify

          if (options.framework === "vuetify") mediaQuery = vuetifyMediaQuery; // bootstrap

          if (options.framework === "bootstrap")
            mediaQuery = bootstrapMediaQuery;
          this.wXS = w <= mediaQuery.xs.max;
          this.wSM = w >= mediaQuery.sm.min && w <= mediaQuery.sm.max;
          this.wMD = w >= mediaQuery.md.min && w <= mediaQuery.md.max;
          this.wLG = w >= mediaQuery.lg.min && w <= mediaQuery.lg.max;
          this.wXL = w >= mediaQuery.xl.min;
          this.wMobile = w <= mediaQuery.mobile.max;
        },

        getWindowHeight(event) {
          let h = document.documentElement.clientHeight;
          this.windowHeight = h;
        }
      },

      beforeDestroy() {
        window.removeEventListener("resize", this.getWindowWidth);
        window.removeEventListener("resize", this.getWindowHeight);
      }
    });
  }
};
