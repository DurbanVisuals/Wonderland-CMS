<?php

namespace Klay;

class Content extends \Prefab
{

	public static function cleanPath($path)
	{
		return str_replace(['//','\\'],'/',$path);
	}

	public static function searchPath($pattern, $flags = 0)
	{
		$files = glob($pattern, $flags);
	    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	        $files = array_merge($files, self::searchPath($dir.'/'.basename($pattern), $flags));
	    }
	    return $files;
	}

	public static function getContent($path, $include = ['*'])
	{
		$app = \Base::instance();
		$file = file_get_contents($path);
		$keys = explode('---',$file);
		$segs = explode('/', $route);
		$regex = '/^content\/|\d{1}-|\d{2}-|\d{3}-|\d{4}-|index.md|.md/';
		$clean = preg_replace($regex,'',$path);
		$route = '/'.rtrim($clean,'/');
		$parts = explode('/',$route);
		$parent = str_replace('/'.end($parts),'',$route);
		$data = [
			'file' => $path,
			'type' => $app->matches('*'.$app->get('ENTRIES').'*',$path) ? 'entries' : 'pages',
			'alias' => end($parts) ? end($parts) : 'root',
			'access' => ['*'],
			'route' => $route,
			'parent' => str_replace('/'.trim($app->get('ENTRIES'),'/'),'',$parent),
			'layout' => \Klay::get('default_layout','default.html'),
			'template' => \Klay::get('default_template',NULL),
			'modified' => filemtime($path),
		];
		if ($keys[1]) {
			$data = array_merge($data, \Yaml::parse($keys[1]));
		}
		if ($keys[2] && in_array('*',$include) || in_array('content', $include)) {
			$parser = new \Parsedown();
			$data['content'] = $parser->text($keys[2]);
		}
		if (is_array($include) && !in_array('*', $include)) {
			foreach ($data as $key => $value) {
				if (!in_array($key, $include)) {
					unset($data[$key]);
				}
			}
		}
		return $data;
	}

	public static function loadRoute($route, $include = ['*'])
	{
		$app = \Base::instance();

		// create search path
		if ($route === '/') {
			$search = '/index.md';
		} else {
			$segs = explode('/',$route);
			$search = implode('/*',$segs).'/index.md';
		}
		// look for file path
		$search = glob(self::cleanPath($app->get('CONTENT').$search));
		if (!$search[0]) {
			return FALSE;
		} else {
			// merge data with file data
			$data = self::getContent($search[0], $include);
			// set access permissions
			\Access::instance()->allow($route,$data['access']);
			// return route data
			return $data;
		}
	}

	public static function routeStructure($from, $include = [], $nest = TRUE)
	{
		$app = \Base::instance();
		$from = self::cleanPath(\Base::instance()->get('CONTENT').$from);
		$paths = self::searchPath($from);
		foreach ($paths as $key => $path) {
			$regex = '/^content\/|\d{1}-|\d{2}-|\d{3}-|\d{4}-|index.md|.md/';
			$clean = preg_replace($regex,'',$path);
			$route = '/'.rtrim($clean,'/');
			$parts = explode('/',$route);
			$parent = str_replace('/'.end($parts),'',$route);
			$data = [
				'file' => $path,
				'type' => $app->matches('*'.$app->get('ENTRIES').'*',$path) ? 'entries' : 'pages',
				'alias' => end($parts) ? end($parts) : 'root',
				'route' => $route,
				'parent' => str_replace('/'.trim($app->get('ENTRIES'),'/'),'',$parent),
				'active' => $app->get('PATH') === $route ? TRUE : FALSE,
				'modified' => filemtime($path),
			];
			$paths[$route] = array_merge($data, self::getContent($path, (['title', 'access'] + $include)));
			unset($paths[$key]);
		}
		return $nest ? \Matrix::nest($paths) : $paths;
	}
}
