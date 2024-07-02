<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://dmedina.cloud
 * @since      1.0.0
 *
 * @package    Iqrealestate
 * @subpackage Iqrealestate/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iqrealestate
 * @subpackage Iqrealestate/admin
 * @author     Daniel Medina <dmedina83@gmail.com>
 */
class Iqrealestate_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $prefix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->prefix ="iqrealestate_";
	}

	/**
	 * Registra el post Type
	 */

	 public function register_post_type()
	 {
 
		 $customPostTypeArgs = array(
 
			 'label' =>  __('Proyectos', 'iqrealestate'),
			 'labels' =>
			 array(
				 'name' => __('Proyectos', 'iqrealestate'),
				 'singular_name' => 'Proyecto',
				 'add_new' => 'Agregar Proyecto',
				 'add_new_item' => 'Agregar Nuevo Proyecto',
				 'edit_item' => 'Editar Proyecto',
				 'new_item' => 'Nuevo Proyecto',
				 'view_item' => 'Ver Proyecto',
				 'view_items' => 'Ver Proyecto',
				 'search_items' => 'Buscar Proyecto',
				 'not_found' => 'No se encontraron proyectos',
				 'not_found_in_trash' => 'No se encontraron proyectos en la papelera',
				 'menu_name' => 'Proyectos',
				 'name_admin_bar' => 'Proyectos',
			 ),
			 'public' => true,
			 'publicly_queryable' => true,
			 'description' => 'Proyectos IQ Real Estate',
			 'exclude_from_search' => false,
			 'show_ui' => true,
			 //'show_in_menu'=>$this->plugin_name,
			 'menu_position' => 5,
			 'menu_icon' => "dashicons-building",
			 'show_in_rest' => true,
			 'supports' => array('title', 'thumbnail', 'custom_fields', 'excerpt'),
 
			 'taxonomies' => array('iq_location','iq_type'),
			 'has_archive' => 'proyectos',
			 'rewrite'  => array('slug' => 'proyecto', 'with_front' => true),
 
		 );
 
		 // Post type, $args - the Post Type string can be MAX 20 characters
		 register_post_type('iq_realestate', $customPostTypeArgs);
	 }
 
 
 
	 public function register_taxonomies()
	 {
 
 
		 /**
		  * TIPO DE PROYECTO
		  */
		 register_taxonomy(
			 'iq_type',
			 'iq_realestate',
			 array(
				 'labels' => array(
					 'name' => 'Tipo de proyecto',
					 'add_new_item' => 'Agregar nuevo tipo',
					 'new_item_name' => "Nuevo tipo",
				 ),
				 'show_ui' => true,
				 'show_tagcloud' => false,
				 'hierarchical' => true,
				 'show_in_rest'       => true,
				 'show_admin_column' => true, //see this line
				 'rewrite' =>  array("slug" => "tipo-de-proyecto")
			 )
		 );
 
		 /**
		  * Ubicación
		  */
		 register_taxonomy(
			 'iq_location',
			 'iq_realestate',
			 array(
				 'labels' => array(
					 'name' => __('Ubicación', 'iqrealestate'),
					 'add_new_item' => 'Agregar nueva ubicación',
					 'new_item_name' => "Nueva ubicación",
				 ),
				 'show_ui' => true,
				 'show_tagcloud' => false,
				 'hierarchical' => true,
				 'show_in_rest'       => true,
				 'show_admin_column' => true, //see this line
				 'rewrite' =>  array("slug" => "ubicacion")
			 )
		 );

		 		 /**
		  * Ubicación
		  */
		  register_taxonomy(
			'iq_category',
			'iq_realestate',
			array(
				'labels' => array(
					'name' => __('Categoría', 'iqrealestate'),
					'add_new_item' => 'Agregar nueva categoría',
					'new_item_name' => "Nueva categoría",
				),
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => true,
				'show_in_rest'       => true,
				'show_admin_column' => true, //see this line
				'public' => false, // Oculta los archivos públicos
				'publicly_queryable' => false, // Asegura que no se puedan hacer consultas públicas
				'show_in_nav_menus' => false // No se muestra en los menús de navegación		
				)
		);
	 }
 
	 public function add_metaboxes($metaboxes, $prefix)
	 {

		$prefix = $this->prefix;
 
		 $id = $prefix . 'metabox';
  
		 $article_fields = array(
			 $prefix . 'desarrollador' => array(
				 'name' => 'Desarrollador',
				 'desc' => 'Escribe el nombre del desarrollador del proyecto',
				 'id'   => $prefix . 'desarrollador',
				 'type' => 'text',
				 'default' => '',
				 // 'show_on_cb' => array($this,'show_if_category'),
				//  'sanitization_cb' => array('Wa_Theme_Manager', 'accept_html_values_sanitize'),
 
				 'attributes' => array(
					 "style"=>"width:100%",
				 ),
				 'tab_icon' => 'dashicons-index-card',
				 'tab_name' => 'Información general del proyecto',
				 'tab_id' => 'info',
 
			 ),
			 $prefix . 'gla' => array(
				 'name' => 'GLA Centro Comercial',
				 'desc' => '',
				 'id'   => $prefix . 'gla',
				 'type' => 'text',
				 'default' => '',
 
				 'attributes' => array(
					 "style"=>"width:100%",
				 ),
				 'tab_id' => 'info',
 
			 ),
			 $prefix . 'estacionamiento' => array(
				'name' => 'Estacionamiento',
				'desc' => '',
				'id'   => $prefix . 'estacionamiento',
				'type' => 'text',
				'default' => '',

				'attributes' => array(
					"style"=>"width:100%",
				),
				'tab_id' => 'info',

			),
			$prefix . 'arquitectura' => array(
				'name' => 'Arquitectura',
				'desc' => '',
				'id'   => $prefix . 'arquitectura',
				'type' => 'text',
				'default' => '',

				'attributes' => array(
					"style"=>"width:100%",
				),
				'tab_id' => 'info',
			),
			$prefix . 'comercializacion' => array(
				'name' => 'Comercialización',
				'desc' => '',
				'id'   => $prefix . 'comercializacion',
				'type' => 'text',
				'default' => '',

				'attributes' => array(
					"style"=>"width:100%",
				),
				'tab_id' => 'info',
			),
			$prefix . 'locales' => array(
				'name' => 'Locales',
				'desc' => '',
				'id'   => $prefix . 'locales',
				'type' => 'text',
				'default' => '',

				'attributes' => array(
					"style"=>"width:100%",
				),
				'tab_id' => 'info',
			),
			$prefix . 'residencial' => array(
				'name' => 'Residencial',
				'desc' => '',
				'id'   => $prefix . 'residencial',
				'type' => 'text',
				'default' => '',

				'attributes' => array(
					"style"=>"width:100%",
				),
				'tab_id' => 'info',
			),
			 
			 $prefix . 'address' => array(
				 'name'          => __('Dirección', 'cmb2'),
				 'id'            => $prefix . 'address',
				 'type'          => 'text',
				 'desc'            => 'Escribe la dirección completa del desarrollo',
				 'tab_icon' => 'dashicons-location',
				 'tab_name' => 'Ubicación',
				 'tab_id' => 'location',
				 ),

				 $prefix . 'geolocation' => array(
					'name'          => __('Geolocalización', 'cmb2'),
					'id'            => $prefix . 'geolocation',
					'desc' => 'Arrastra el marcador a la ubicación',
					'type' => 'pw_map',
					'split_values' => true, // Save latitude and longitude as two separate fields
					'tab_id' => 'location',
					),

				 $prefix . 'phone_numbers' => array(
						 'name' => 'Teléfonos de contacto',
						 'desc' => 'Escribe los teléfonos de contacto',
						 'id'   => $prefix . 'phone_numbers',
						 'type' => 'text',
						 'repeatable' => true,
						 'text' => array(
							'add_row_text' => 'Agregar teléfono',
						),
						 'tab_icon' => 'dashicons-phone',
						 'tab_name' => 'Datos de contacto',
						 'tab_id' => 'contacto',
				 ), 
				 $prefix . 'email' => array(
					'name' => 'Correo',
					'desc' => 'Escribe el correo de contacto',
					'id'   => $prefix . 'email',
					'type' => 'text_email',
					'tab_id' => 'contacto',
			), 
			$prefix . 'images' => array(
				'name' => 'Galería de imágenes',
				'desc' => 'Selecciona más imágenes del proyecto',
				'id'   => $prefix . 'images',
				'type'    => 'file_list',
				'text'    => array(
					'add_upload_file_text' => 'Agregar imágen' // Change upload button text. Default: "Add or Upload File"
				),
				// query_args are passed to wp.media's library query.
			   'query_args' => array( 'type' => 'image' ), // Only images attachment

				'text' => array(
					'add_upload_files_text' => 'Agregar Imágenes', // default: "Add or Upload Files"
					'remove_image_text' => 'Eliminar imagen', // default: "Remove Image"
					'file_text' => 'Logo:', // default: "File:"
					'file_download_text' => 'Descargar', // default: "Download"
					'remove_text' => 'Eliminar', // default: "Remove"
				),
				'preview_size' => 'large', // Image size to use when previewing in the admin
				'tab_icon' => 'dashicons-format-gallery',
				'tab_name' => 'Galería de imágenes',
				'tab_id' => 'images',
			), 
			$prefix . 'brochure_type' => array(
				'name' => '¿Tipo de folleto?',
				'desc' => 'Selecciona el tipo de folleto',
				'id'   => $prefix . 'brochure_type',
				'type' => 'select',
				'options'          => array(
					'file' => __( 'Archivo', 'cmb2' ),
					'embed'   => __( 'Embed', 'cmb2' ),
				),
				'tab_icon' => 'dashicons-embed-generic',
				'tab_name' => 'Extras',
				'tab_id' => 'extras',
		), 
		$prefix . 'brochure_file' => array(
			'name' => 'Archivo del folleto',
			'desc' => 'Selecciona el archivo PDF del folleto',
			'id'   => $prefix . 'brochure_file',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Agregar archivo' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				// 'type' => array(
				// 	'image/gif',
				// 	'image/jpeg',
				// 	'image/png',
				// ),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin
			'attributes'    => array(
				'data-conditional-id'     => $prefix . 'brochure_type',
				'data-conditional-value'  => 'file',
			),
			'tab_id' => 'extras',
	), 
	$prefix . 'tour_embed' => array(
		'name' => 'Código del tour virtual',
		'desc' => 'Inserta el código embed del tour virtual',
		'id'   => $prefix . 'tour_embed',
		'type'    => 'textarea_code',
		'options' => array( 'disable_codemirror' => true ),
		// Optional:
		'tab_id' => 'extras',
), 

$prefix . 'brands_logos' => array(
	'name' => 'Principales comercios',
	'desc' => 'Selecciona los logos de los comercios',
	'id'   => $prefix . 'brands_logos',
	'type'    => 'file_list',
	'text'    => array(
		'add_upload_file_text' => 'Agregar logo' // Change upload button text. Default: "Add or Upload File"
	),
	// query_args are passed to wp.media's library query.
	'query_args' => array(
		// 'type' => 'application/pdf', // Make library only display PDFs.
		// Or only allow gif, jpg, or png images
		'type' => array(
			'image/gif',
			'image/jpeg',
			'image/png',
			'image/svg+xml',  // Agregar SVG

		),
	),
	'text' => array(
		'add_upload_files_text' => 'Agregar logos', // default: "Add or Upload Files"
		'remove_image_text' => 'Eliminar imagen', // default: "Remove Image"
		'file_text' => 'Logo:', // default: "File:"
		'file_download_text' => 'Descargar', // default: "Download"
		'remove_text' => 'Eliminar', // default: "Remove"
	),
    'preview_size' => array( 100, 100 ), // Tamaño de la vista previa de la imagen
	'tab_id' => 'comercios',
	'tab_icon' => 'dashicons-images-alt2',
	'tab_name' => 'Principales Comercios',
), 


		 );
 
 
		 $_metabox = array(
			 'id'            => $id,
			 'title'         => esc_html__('Información del proyecto', 'cmb2'),
			 'object_types'  => array('iq_realestate'),  //get_post_types(array('public' => true), 'names')array('post', 'page'), // Post type
			 'context'    => 'normal',
			 'priority'   => 'high',
			 'vertical_tabs' => false,
			 'has_tabs' => true,
			 'wa_metabox_fields' => apply_filters("wa_theme_get_{$id}_fields", $article_fields, $prefix),
		 );
		 $metaboxes[$id] = $_metabox;
 
		 return $metaboxes;
	 }
 
// 
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iqrealestate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iqrealestate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iqrealestate-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iqrealestate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iqrealestate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iqrealestate-admin.js', array( 'jquery' ), $this->version, false );

	}

}
