<?php

class Meteo_Widget extends WP_Widget
{
  public function __construct()
  {
    parent::__construct(
      'meteo_widget',
      'Météo Widget',
      array(
        'description' => __('Widget affichant la météo d\'une ville.'),
        'classname' => 'widget_meteo'
      )
    );

    add_action('wp_ajax_meteo_api', [$this, 'meteo_api']);
    add_action('wp_ajax_nopriv_meteo_api', [$this, 'meteo_api']);
  }

  public function meteo_api()
  {
    $locale = substr(get_locale(), 0, 2);
    $id = $this->id;
    $id_exploded = explode('-', $id);
    $id_number = $id_exploded[count($id_exploded) - 1];
    global $_GET;
    $ville = $_GET['ville'];
    $cle_api = get_option('widget_meteo_widget')[$id_number]['cle_api'];
    $unites = get_option('widget_meteo_widget')[$id_number]['unites'];
    $reponse_api = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=${cle_api}&lang=${locale}&units=${unites}", false, stream_context_create(['http' => ['ignore_errors' => true]]));
    echo $reponse_api;
    wp_die();
  }


  public function widget($args, $instance)
  {
    wp_enqueue_script('vue', get_stylesheet_directory_uri() . '/inc/meteo_widget/js/Vue.js', null, null, true);
    wp_enqueue_script('meteo_widget_vue', get_stylesheet_directory_uri() . '/inc/meteo_widget/js/init.js', null, null, true);
    wp_localize_script('meteo_widget_vue', 'php_vars', array('ville' => $instance['ville'], 'unites' => $instance['unites'], 'site_url' => get_site_url()));
    wp_enqueue_style('meteo_widget_style', get_stylesheet_directory_uri() . '/inc/meteo_widget/css/style.css', false, null);
?>
    <div id="weather">
      <div id="input_wrapper">
        <input type="text" v-model="villeACharger" @keydown.enter="loadMeteo">
        <button v-if="villeACharger" @click="loadMeteo"><?php _e('Charger'); ?></button>
        <button v-else @click="loadMeteo(e, '<?php echo $instance['ville'] ?>')"><?php _e('Réinitialiser'); ?></button>
      </div>
      <div id="weather_wrapper" v-if="loadingOk">
        <div class="weather_icon">
          <img :src="imageSrc" :alt="description" class="weather_icon_img" />
          <div class="weather_icon_text">{{ description }}</div>
        </div>
        <div class="temperature">
          <p>{{ temperature }}{{ unites }}</p>
        </div>
        <div class="weather_city">{{ ville }}</div>
      </div>
      <div v-else-if="loadingCityNotFound">
        <p><?php _e('Ville non trouvée.') ?></p>
      </div>
      <div v-else-if="loadingFailed">
        <p><?php _e('Chargement echoué.'); ?></p>
      </div>
      <div v-else>
        <p><?php _e('Chargement...') ?></p>
      </div>
    </div>
  <?php
  }

  public function form($instance)
  {
    if (isset($instance['ville'])) {
      $ville = $instance['ville'];
    } else {
      $ville = __('Strasbourg');
    }

    if (isset($instance['cle_api'])) {
      $cle_api = $instance['cle_api'];
    } else {
      $cle_api = '';
    }

    if (isset($instance['unites'])) {
      $unites = $instance['unites'];
    } else {
      $unites = 'metric';
    }
  ?>
    <p>
      <label for="<?php echo $this->get_field_name('ville'); ?>">
        <?php _e('Ville par défaut:'); ?>
      </label>
      <input id="<?php echo $this->get_field_id('ville'); ?>" name="<?php echo $this->get_field_name('ville'); ?>" type="text" value="<?php echo esc_attr($ville); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_name('cle_api'); ?>">
        <?php _e('Clé API:'); ?>
      </label>
      <input id="<?php echo $this->get_field_id('cle_api'); ?>" name="<?php echo $this->get_field_name('cle_api'); ?>" type="text" value="<?php echo esc_attr($cle_api); ?>" />
    </p>
    <p>
    <p><?php _e('Unités') ?></p>
    <input <?php echo $unites == 'metric' ? 'checked' : '' ?> type="radio" name="<?php echo $this->get_field_name('unites'); ?>" value="metric" id="<?php echo $this->get_field_id('unites'); ?>-metric">
    <label for="<?php echo $this->get_field_id('unites'); ?>-metric">
      <?php _e('Metriques') ?>
    </label>
    <br>
    <input <?php echo $unites == 'imperial' ? 'checked' : '' ?> type="radio" name="<?php echo $this->get_field_name('unites'); ?>" value="imperial" id="<?php echo $this->get_field_id('unites'); ?>-imperial">
    <label for="<?php echo $this->get_field_id('unites'); ?>-imperial">
      <?php _e('Impériales') ?>
    </label>
    <br>
    <input <?php echo $unites == 'standard' ? 'checked' : '' ?> type="radio" name="<?php echo $this->get_field_name('unites'); ?>" value="standard" id="<?php echo $this->get_field_id('unites'); ?>-standard">
    <label for="<?php echo $this->get_field_id('unites'); ?>-standard">
      <?php _e('Standardes') ?>
    </label>
    </p>
<?php
  }

  public function update($new_instance, $old_instance)
  {
    return $new_instance;
  }
}


function register_meteo_widget()
{
  register_widget('Meteo_Widget');
}
add_action('widgets_init', 'register_meteo_widget');
