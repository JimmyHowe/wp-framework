<?php

namespace JHDC;

class MenuPage
{
	protected $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null;

	/**
	 * MenuPage constructor.
	 *
	 * @param        $page_title
	 * @param        $menu_title
	 * @param        $capability
	 * @param        $menu_slug
	 * @param string $function
	 * @param string $icon_url
	 * @param null   $position
	 */
	public function __construct( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position )
	{
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug  = $menu_slug;
		$this->function   = $function;
		$this->icon_url   = $icon_url;
		$this->position   = $position;
	}

	/**
	 * @return mixed
	 */
	public function getPageTitle()
	{
		return $this->page_title;
	}

	/**
	 * @param mixed $page_title
	 */
	public function setPageTitle( $page_title )
	{
		$this->page_title = $page_title;
	}

	/**
	 * @return mixed
	 */
	public function getMenuTitle()
	{
		return $this->menu_title;
	}

	/**
	 * @param mixed $menu_title
	 */
	public function setMenuTitle( $menu_title )
	{
		$this->menu_title = $menu_title;
	}

	/**
	 * @return mixed
	 */
	public function getCapability()
	{
		return $this->capability;
	}

	/**
	 * @param mixed $capability
	 */
	public function setCapability( $capability )
	{
		$this->capability = $capability;
	}

	/**
	 * @return mixed
	 */
	public function getMenuSlug()
	{
		return $this->menu_slug;
	}

	/**
	 * @param mixed $menu_slug
	 */
	public function setMenuSlug( $menu_slug )
	{
		$this->menu_slug = $menu_slug;
	}

	/**
	 * @return string
	 */
	public function getFunction()
	{
		return $this->function;
	}

	/**
	 * @param string $function
	 */
	public function setFunction( $function )
	{
		$this->function = $function;
	}

	/**
	 * @return string
	 */
	public function getIconUrl()
	{
		return $this->icon_url;
	}

	/**
	 * @param string $icon_url
	 */
	public function setIconUrl( $icon_url )
	{
		$this->icon_url = $icon_url;
	}

	/**
	 * @return null
	 */
	public function getPosition()
	{
		return $this->position;
	}

	/**
	 * @param null $position
	 */
	public function setPosition( $position )
	{
		$this->position = $position;
	}
}