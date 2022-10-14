<?php
if (! class_exists('youtube_recommendation_admin')){

	class youtube_recommendation_admin {
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
	   add_filter('puglin_action_links' .$this->plugin_basename, array($this, 'add_ettings_link'));
    }


       // adiciona  a pagina do puglin
		public function add_plugin_page() {
			add_options_page(
			  __('Settings','recommend'),
			  __('Recommend','recommend'),
			  'manege_options',
			  $this->plugin_slug,
			  array ($this, 'create_admin_page')
			);
		}

		//criar pagina do addministrador
		public function create_admin_page(){
		?>
         <div class="wrap">
	         <h1><?php echo __('Recommend','recommend') ?></h1>
	         <form method="post" action="options.php">
		         <?php
		         settings_field('yt_rec_options');
				 do_settings_selection('yt_rec_admin');
				 submit_button();
		         ?>
	         </form>
         </div>
         <?php
		}


		public function page_init(){
		 register_settings(
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



		}














	} //construct
 } //condição