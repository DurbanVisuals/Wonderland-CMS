<?php

namespace CMS;

class Theme
{
	public static function assemble($theme, $layout, $template = NULL, $data = [])
	{
		$app = \Base::instance();

		if ($temp = $app->read($theme.$template)) {
			$template = \CMS\Parse::template(trim($temp), $data, '\\Klay\\Theme::callback', \Klay::dump());
		}

		if ($layout = $app->read($theme.$layout)) {
			$data['_template'] = $template ? $template : 'No Layout Content';
			$output = \CMS\Parse::template(trim($layout), $data, '\\Klay\\Theme::callback', \Klay::dump());
		}

		unset($data['_template']);

		\Klay::set($data);

		echo '<pre>';
		print_r(\CMS::dump());
		echo '</pre>';

		return \Lex\Parser::injectNoParse($output);
	}

	public static function callback($name, $params, $content = NULL)
	{
		$plugin = explode(':',$name);
		$method = 'render';
		$namespace = '\\Addons\\Plugins\\'.ucfirst($plugin[0]);
		if (isset($plugin[1])) {
			$namespace .= '\\'.ucfirst($plugin[1]);
		}
		if (isset($plugin[2])) {
			$method = $plugin[2];
		}
		if (method_exists($namespace,$method)) {
			$class = new $namespace();
			return $class->{$method}($params,$content);
		}

		return $content;
	}
}
