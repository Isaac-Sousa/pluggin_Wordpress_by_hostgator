<?php
if (! class_exists('Youtube_Recommendation_Admin')){

	class Youtube_Recommendation_Admin {
		private $options;
		private $plugin_basename;
		private $plugin_slug;
		private $json_filename;
		private $plugin_version;

    public function __construct($basename,$slug,$json_filename,$version){
	   $this->options             =get_option('yt_rec');
       $this->plugin_basename     =$basename;
	   $this->plugin_slug         =$slug;
	   $this->json_filename       =$json_filename;
	   $this->plugin_version      =$version;

	   add_action('admin_menu', array ($this, 'add_plugin_page'));
	   add_action('admin_init', array ($this, 'page_init'));
	   add_action('admin_footer_text', array ($this, 'page_footer'));
	   add_action('admin_notices', array ($this, 'show_notices'));

	   add_filter( "plugin_action_links_" . $this->plugin_basename, array( $this, 'add_settings_link' ) );
    }


       // adiciona  a pagina do puglin
		public function add_plugin_page() {
			add_options_page(
			  __('Settings','recommend'),
			  __('My Recommendation','recommend'),
			  'manage_options',
			  $this->plugin_slug,
			  array ($this, 'create_admin_page')
			);
		}

		/*
	     * add settings link
	     */
		public function add_settings_link( $links ) {
			$settings_link = '<a href="options-general.php?page='. $this->plugin_slug .'">' . __( 'Settings' ) . '</a>';
			array_unshift( $links, $settings_link );
			return $links;
		}

		public function show_notices() {
			$value = isset( $this->options['channel_id'] ) ? esc_attr( $this->options['channel_id'] ) : '';
			if ($value == '' || $value == null){
				?>
                <div class="error notice">
					<?php echo $channel_id ?>
                    <p><strong><?php echo __( 'Youtube Recommendation', 'recommend' ); ?></strong></p>
                    <p><?php echo __( 'Fill with your Youtube channel ID', 'recommend' ); ?></p>
                </div>
				<?php
			}
		}

		//criar pagina do administrador
		public function create_admin_page(){
		?>
         <div class="wrap">
	         <h1><?php echo __('Recommendation','recommend'); ?></h1>
	         <form method="post" action="options.php">
		         <?php
		         settings_fields('yt_rec_options');
				 do_settings_sections('yt_rec_admin');
				 submit_button();
		         ?>
	         </form>
         </div>
         <?php
		}


     /*
	  * page init
	  */

		public function page_init(){
		 register_setting(
			'yt_rec_options',
			'yt_rec',
			 array($this, 'sanitize')
		 );
		 add_settings_section('settings_section_id_1',
			 __('General Settings', 'recommend'),
			 null,
			 'yt_rec_admin'
		  );
		 add_settings_field(
			'channel_id',
			__('Channel_id', 'recommend'),
			array($this, 'channel_id_callback'),
			'yt_rec_admin',
			'settings_section_id_1'
		 );
		 add_settings_field(
			 'cache_expiration',
			 __('Cache Expiration','recommend'),
			 array($this, 'cache_expiration_callback'),
			 'yt_rec_admin',
			 'settings_section_id_1'
		 );
		 add_settings_section(
			'settings_section_id_2',
			__('Post Settings', 'recommend'),
			null,
			'yt_rec_admin'
		 );
		 add_settings_field(
			'show_position',
			__('Show in Posts', 'recommend'),
			array($this,'show_position_callback'),
			'yt_rec_admin',
			'settings_section_id_2'
		 );
		 add_settings_field(
			'layout',
			__('Layout','recommend'),
			array($this, 'show_layout_callback'),
			'yt_rec_admin',
			'settings_section_id_2'
		 );
		 add_settings_field(
			'limit',
			__('Videos in list', 'recomend'),
			array($this, 'limit_callback'),
			'yt_rec_admin',
			'settings_section_id_2'
		 );
		 add_settings_section(
			 'settings_section_id_3',
			 __('Customize Style', 'recommend'),
			 null,
			 'yt_rec_admin'
		 );
		 add_settings_field(
			 'custom_css',
			 __('Your CSS','recommend'),
			 array($this, 'custom_css_callback'),
			 'yt_rec_admin',
			 'settings_section_id_3'
		 );
		}


        //page footer
		public function page_footer(){
			return __('Plugin Version','recommend') .' '.  $this->plugin_version;
		}




        //Sanitize
		public function sanitize($input) {
			$new_input = array();
			if(isset($input['channel_id'] ) )
				$new_input['channel_id'] = sanitize_text_field($input['channel_id']);

			if(isset($input['cache_expiration'] ) )
				$new_input['cache_expiration'] = absint($input['cache_expiration']);

			if(isset($input['show_position'] ) )
				$new_input['show_position'] = sanitize_text_field($input['show_position']);

			if(isset($input['layout'] ) )
				$new_input['layout'] = sanitize_text_field($input['layout']);

			if(isset($input['limit'] ) )
				$new_input['limit'] = absint($input['limit']);

			if(isset($input['custom_css'] ) )
				$new_input['custom_css'] = sanitize_text_field($input['custom_css']);

			return $new_input;

		}

//		  Callbacks

		public function channel_id_callback(){
			$value = isset($this->options['channel_id']) ? esc_attr($this->options['channel_id']): '';
			?>
            <input type="text" id="channel_id" name="yt_rec['channel_id']" value="<?php echo $value ?>" class="regular_text" />
              <p class="description"><?php echo __('sample','recommend') ?>: UCFuIUoyHB12qpYa8Jpxoxow</p>
			  <p class="description"><a href="https://support.google.com/youtube/answer/3250431" target="_blank"><?php echo __('Find here your channel Id' , 'recommend') ?></a></p>
			<?php
		}
	    public function cache_expiration_callback(){
		    $upload_dir=wp_upload_dir();
		    $json_url= $upload_dir['baseurl'] . '/' . $this->plugin_slug . '/' . $this->json_filename;
            $value = isset($this->options['cache_expiration']) ? esc_attr($this->options['cache_expiration']): '1';
		    ?>
		    <input type="number" id="cache_expiration" min="1" name="yt_rec['cache_expiration']" value="<?php echo $value ?>" class="small_text" />
              <?php echo __('hours is the expiration time for cached data','recommend'); ?>
              <p class="description"<a href="<?php echo $json_url?>" target="_blank"><?php echo __('Test here', 'recommend'); ?></a>
            <?php
	   }
		public function show_position_callback() {
			$value = isset( $this->options['show_position'] ) ? esc_attr( $this->options['show_position'] ) : '';
			?>
            <fieldset>
                <legend class="screen-reader-text"><span><?php echo __('On posts show videos in position:' , 'recommend') ?></span></legend>
                <label><input type="radio" name="my_yt_rec[show_position]" value=""<?php echo ( $value == '' ) ? 'checked="checked"' : '' ?>> <?php echo __('Disable' , 'recommend') ?></label><br>
                <label><input type="radio" name="my_yt_rec[show_position]" value="after"<?php echo ( $value == 'after' ) ? 'checked="checked"' : '' ?>> <?php echo __('After' , 'recommend') ?></label><br>
                <label><input type="radio" name="my_yt_rec[show_position]" value="before"<?php echo ( $value == 'before' ) ? 'checked="checked"' : '' ?>> <?php echo __('Before' , 'recommend') ?></label>
            </fieldset>
			<?php
		}

		public function show_layout_callback() {
			$value = isset( $this->options['layout'] ) ? esc_attr( $this->options['layout'] ) : 'grid';
			?>
            <select name="my_yt_rec[layout]">
                <option value="grid"<?php echo ( $value == 'grid' ) ? 'selected="selected"' : '' ?>><?php echo __('Grid' , 'recommend') ?></option>
                <option value="list"<?php echo ( $value == 'list' ) ? 'selected="selected"' : '' ?>><?php echo __('List' , 'recommend') ?></option>
            </select>
			<?php
		}

		public function limit_callback() {
			$value = isset( $this->options['limit'] ) ? esc_attr( $this->options['limit'] ) : '3';
			?>
            <input type="number" id="limit" min="1" max="15" name="my_yt_rec[limit]" value="<?php echo $value ?>" class="small-text" />
            <p class="description"><?php echo __('Max' , 'recommend') ?> 15</p>
			<?php
		}

		public function custom_css_callback() {
			$value = isset( $this->options['custom_css'] ) ? esc_attr( $this->options['custom_css'] ) : '';
			?>
            <textarea id="custom_css" name="my_yt_rec[custom_css]" rows="10" cols="50" class="large-text code"><?php echo $value ?></textarea>
			<?php
		}


	} //construct
 } //condição