<?php

namespace Routes;

class Pages
{
	protected $page;

	protected $flash;

	protected $access;

	public function __construct($app, $params)
	{
		// flash instance
		$this->flash  = \Flash::instance();
		// access instance
		$this->access = \Access::instance();
		// load page
		$this->page = \Klay\Content::loadRoute($app->get('PATH'));
		// throw 404 if no content
		if (!$this->page) {
			$app->error(404);
		}

	}

	public function beforeRoute($app, $params)
	{
		ob_start();
		// check access before render
		$this->access->authorize($app->get('SESSION.groups'));
		// copy csrf to session
		$app->copy('CSRF','SESSION.csrf');
	}

	public function renderRoute($app, $params)
	{
		$data = $this->page;
		$layout = 'layouts/'.$this->page['layout'];
		$template = $this->page['template'] ? 'templates/'.$this->page['template'] : NULL;
		echo \CMS\Theme::assemble($app->get('THEME'), $layout, $template, $data);
	}

	public function afterRoute($app, $params)
	{
		echo ob_get_clean();
		// render route
		\Klay::instance()->finish();
	}
}
