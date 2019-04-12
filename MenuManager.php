<?php

namespace JHDC;

class MenuManager
{
	protected $prefix = 'jhdc_';

	protected $menu_pages = [];

	protected $sub_menu_pages = [];

	/**
	 * @param $title
	 */
	public function addMenuPage( $title )
	{
		$title = 'Custom Menu Title';

		$menu_pages[] = function() use ($title)
		{
			add_menu_page(
				__( $title, 'textdomain' ),
				'custom menu',
				'manage_options',
				'custompage',
				'my_custom_menu_page',
				plugins_url( 'myplugin/images/icon.png' ),
				6
			);
		};
	}

	public function run()
	{
		foreach ($this->menu_pages as $key => $page)
		{
			add_action( 'admin_menu', function()
			{

			});
		}
	}
}