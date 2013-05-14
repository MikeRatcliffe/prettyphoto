<?php

/**
 * Create a block with arbitrary content.
 *
 */
class PrettyPhoto extends Plugin
{
	public function configure()
	{
		$form = new FormUI(__CLASS__);
		$form->append('checkbox', 'hide_social', __CLASS__ . 'hide_social', _t('Hide social area in fullsize image view', __CLASS__));
		$form->append('submit', 'submit', _t('Save'));
		return $form;
	}
	
	public function action_template_header($theme)
	{
		Plugins::act('add_prettyphoto_template');
	}

	public function action_add_prettyphoto_template()
	{
		$social_string = (Options::get(__CLASS__ . 'hide_social', false)) ? "{social_tools:false}" : "";

		Stack::add( 'template_header_javascript', Site::get_url('vendor') . '/jquery.js', 'jquery' );
		Stack::add( 'template_stylesheet', array($this->get_url() . '/css/prettyPhoto.css', 'screen' ) );
		Stack::add( 'template_header_javascript', $this->get_url() . '/js/jquery.prettyPhoto.js', 'prettyphoto', 'jquery' );
		
		$init_string = "$(document).ready(function(){ $(\"a[rel^='prettyPhoto']\").prettyPhoto(" . $social_string . ");});";
		Stack::add( 'template_header_javascript', $init_string, 'prettyphoto_init', 'prettyphoto' );
	}

	public function action_add_prettyphoto_admin()
	{
		Stack::add('admin_stylesheet', array($this->get_url() . '/css/prettyPhoto.css', 'screen'));
		Stack::add('admin_header_javascript', $this->get_url() . '/js/jquery.prettyPhoto.js', 'prettyphoto', 'jquery');
	}
}

?>
