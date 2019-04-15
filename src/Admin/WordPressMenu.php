<?php

namespace JHDC\Admin;

class WordPressMenu extends WordPressSettings
{
	public $parent_id = null;

	public $options = [];

	protected $defaults = [
		'capability'  => 'manage_options',
		'description' => '',
		'function'    => '',
		'icon'        => 'dashicons-admin-generic',
		'id'          => '',
		'page_title'  => '',
		'parent'      => null,
		'position'    => null,
		'slug'        => '',
		'title'       => '',
	];

	/**
	 * WordPressMenu constructor.
	 *
	 * @param array $options
	 */
	function __construct( $options = [] )
	{
		$this->options = array_merge($this->defaults, $options);

		$this->settings_id = $this->options['slug'];

		if ( $this->options['title'] == '' )
		{
			$this->options['title'] = ucfirst($this->options['slug']);
		}

		if ( $this->options['page_title'] == '' )
		{
			$this->options['page_title'] = $this->options['title'];
		}

		add_action('admin_menu', [ $this, 'add_page' ]);

		add_action('wordpressmenu_page_save_' . $this->settings_id, [ $this, 'save_settings' ]);
	}

	/**
	 *
	 */
	public function add_page()
	{
		$functionToUse = $this->options['function'];

		if ( $functionToUse == '' )
		{
			$functionToUse = [ $this, 'create_menu_page' ];
		}

		if ( $this->parent_id != null )
		{
			add_submenu_page($this->parent_id, $this->options['page_title'], $this->options['title'],
				$this->options['capability'], $this->options['slug'], $functionToUse);
		}
		else
		{
			add_menu_page($this->options['page_title'], $this->options['title'], $this->options['capability'],
				$this->options['slug'], $functionToUse, $this->options['icon'], $this->options['position']);
		}
	}

	/**
	 * Create the menu page
	 *
	 * @return void
	 */
	public function create_menu_page()
	{
		$this->save_if_submit();
		$tab = 'general';
		if ( isset($_GET['tab']) )
		{
			$tab = $_GET['tab'];
		}
		$this->init_settings();
		?>
        <div class="wrap">
            <h2><?php echo $this->options['page_title'] ?></h2>
			<?php
			if ( ! empty($this->options['description']) )
			{
				?><p class='description'><?php echo $this->options['description'] ?></p><?php
			}
			$this->render_tabs($tab);
			?>
            <form method="POST" action="">
                <div class="postbox">
                    <div class="inside">
                        <table class="form-table">
							<?php $this->render_fields($tab); ?>
                        </table>
						<?php $this->save_button(); ?>
                    </div>
                </div>
            </form>
        </div>
		<?php
	}

	/**
	 * Save if the button for this menu is submitted
	 *
	 * @return void
	 */
	protected function save_if_submit()
	{
		if ( isset($_POST[ $this->settings_id . '_save' ]) )
		{
			do_action('wordpressmenu_page_save_' . $this->settings_id);
		}
	}

	/**
	 * Render the registered tabs
	 *
	 * @param string $active_tab the viewed tab
	 *
	 * @return void
	 */
	public function render_tabs( $active_tab = 'general' )
	{
		if ( count($this->tabs) > 1 )
		{
			echo '<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">';
			foreach ( $this->tabs as $key => $value )
			{
				echo '<a href="' . admin_url('admin.php?page=' . $this->options['slug'] . '&tab=' . $key) . '" class="nav-tab ' . ( ( $key == $active_tab ) ? 'nav-tab-active' : '' ) . ' ">' . $value . '</a>';
			}
			echo '</h2>';
			echo '<br/>';
		}
	}

	/**
	 * Render the save button
	 *
	 * @return void
	 */
	protected function save_button()
	{
		?>
        <button type="submit" name="<?php echo $this->settings_id; ?>_save" class="button button-primary">
			<?php _e('Save', 'textdomain'); ?>
        </button>
		<?php
	}

	/**
	 * Adding fields
	 *
	 * @param array  $array options for the field to add
	 * @param string $tab   tab for which the field is
	 */
	public function addField( $array, $tab = 'general' )
	{
		$allowed_field_types = [
			'text',
			'textarea',
			'wpeditor',
			'select',
			'radio',
			'checkbox',
		];
		// If a type is set that is now allowed, don't add the field
		if ( isset($array['type']) && $array['type'] != '' && ! in_array($array['type'], $allowed_field_types) )
		{
			return;
		}
		$defaults = [
			'name'        => '',
			'title'       => '',
			'default'     => '',
			'placeholder' => '',
			'type'        => 'text',
			'options'     => [],
			'description' => '',
		];
		$array    = array_merge($defaults, $array);
		if ( $array['name'] == '' )
		{
			return;
		}
		foreach ( $this->fields as $tabs )
		{
			if ( isset($tabs[ $array['name'] ]) )
			{
				trigger_error('There is alreay a field with name ' . $array['name']);

				return;
			}
		}
		// If there are options set, then use the first option as a default value
		if ( ! empty($array['options']) && $array['default'] == '' )
		{
			$array_keys       = array_keys($array['options']);
			$array['default'] = $array_keys[0];
		}
		if ( ! isset($this->fields[ $tab ]) )
		{
			$this->fields[ $tab ] = [];
		}
		$this->fields[ $tab ][ $array['name'] ] = $array;
	}

	/**
	 * Adding tab
	 *
	 * @param array $array options
	 */
	public function add_tab( $array )
	{
		$defaults = [
			'slug'  => '',
			'title' => '',
		];
		$array    = array_merge($defaults, $array);
		if ( $array['slug'] == '' || $array['title'] == '' )
		{
			return;
		}
		$this->tabs[ $array['slug'] ] = $array['title'];
	}
}