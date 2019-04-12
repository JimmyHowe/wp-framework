<?php

namespace JHDC\Admin;

class WordPressMenuTab
{
	public $slug;

	public $title;

	public $menu;

	function __construct( $options, WordPressMenu $menu )
	{
		$this->slug  = $options['slug'];
		$this->title = $options['title'];
		$this->menu  = $menu;
		$this->menu->add_tab($options);
	}

	/**
	 * Add field to this tab
	 *
	 * @param [type] $array [description]
	 */
	public function addField( $array )
	{
		$this->menu->addField($array, $this->slug);
	}
}