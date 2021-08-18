const defaultCity = php_vars.ville;
const unites = php_vars.unites;
const siteUrl = php_vars.site_url;

const MeteoApp = {
  data() {
    return {
      ville: undefined,
      description: undefined,
      temperature: undefined,
      imageSrc: undefined,
      loadingOk: false,
      loadingCityNotFound: false,
      loadingFailed: false,
      villeACharger: '',
    };
  },
  computed: {
    unites() {
      if (unites === 'metric') {
        return '°C';
      } else if (unites === 'imperial') {
        return '°F';
      } else {
        return 'K';
      }
    },
  },
  created() {
    this.loadMeteo({}, defaultCity);
    this.villeACharger = defaultCity;
  },

  methods: {
    async loadMeteo(e, ville) {
      if (this.villeACharger === '') {
        ville = defaultCity;
      }
      this.loadingOk = false;
      this.loadingFailed = false;
      this.loadingCityNotFound = false;
      const apiRequestUrl = ville
        ? `${siteUrl}/wp-admin/admin-ajax.php?ville=${ville}&action=meteo_api`
        : `${siteUrl}/wp-admin/admin-ajax.php?ville=${this.villeACharger}&action=meteo_api`;

      const apiResponseJson = await fetch(apiRequestUrl);
      const apiResponse = await apiResponseJson.json();
      if (apiResponse.cod === 200) {
        const weather = apiResponse.weather[0];
        this.ville = apiResponse.name;
        this.description = weather.description;
        this.temperature = Math.floor(apiResponse.main.temp);
        this.imageSrc = `http://openweathermap.org/img/wn/${weather.icon}@2x.png`;
        this.loadingOk = true;
      } else if (apiResponse.message === 'city not found') {
        this.loadingOk = false;
        this.loadingFailed = false;
        this.loadingCityNotFound = true;
      } else {
        this.loadingOk = false;
        this.loadingCityNotFound = false;
        this.loadingFailed = true;
      }
    },
  },
};
Vue.createApp(MeteoApp).mount('#weather');
