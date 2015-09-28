<?php

class Controller_Tools extends \Controller_Base
{
	public function action_index()
	{
		$view = View::forge('tools/index');
		$this->template->content = $view;
	}
}
