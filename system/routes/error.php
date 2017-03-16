<?php

namespace Routes;

class Error
{
	public function renderError($app)
	{
		ob_start();
		echo \Klay\Theme::assemble($app->get('THEME'), 'layouts/error.html', NULL, $app->get('ERROR'));
		echo ob_get_clean();
		\Klay::instance()->finish();
	}
}
