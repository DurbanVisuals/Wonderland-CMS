<?php

namespace Addons\Plugins\CMS;

class Pages
{
	public function get($params, $content)
	{
		$app = \Base::instance();
		$include = $params['include'] ? $app->split($params['include']) : ['*'];
		$data = \CMS\Content::loadPage($params['route'],$include);
		if (!$data) {
			$data = [
				'no_content' => TRUE,
			];
		}
		return \CMS\Parse::template($content, $data, '\\Klay\\Theme::callback');
	}
}
