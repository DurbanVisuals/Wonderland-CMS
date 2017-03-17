<?php

namespace Addons\Plugins\CMS;

class Structure
{
	public function render($params, $content)
	{
		$from   = $params['from'] ? $params['from'] : '/';
		$segs   = explode('/',$from);
		$search = implode('/*',$segs).'*.md';
		$fields = $params['include'] ? \Base::instance()->split($params['include']) : ['title'];

		$pages  = \CMS\Content::routeStructure($search,$fields);

		$output = '';
		if (!empty($pages)) {
			foreach ($pages as $page) {
				if (!isset($page['visible']) || ($page['visible'] === TRUE)) {
					$page['active'] = ($page['route'] === \Base::instance()->get('PATH')) ? 'active' : FALSE;
					$output .= \Klay\Parse::template($content, $page, '\\Klay\\Theme::callback');
				}
			}
		}
		return $output;
	}
}
