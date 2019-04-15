<?php

namespace JHDC\Admin;

class WordPressSubMenu extends WordPressMenu
{
	function __construct( $options, WordPressMenu $parent )
	{
		parent::__construct($options);
		$this->parent_id = $parent->settings_id;
	}
}