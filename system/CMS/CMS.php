<?php

namespace CMS;

class CMS extends Prefab
{
	protected static $config  = [];

	protected static $exclude = ['database','environment'];

	public function __construct()
	{
		$app = Base::instance();
		// base config variables
		$config = [
			'app' => $app->get('PACKAGE'),
			'version' => $app->get('VERSION'),
			'debug' => TRUE,
			'csrf' => $app->get('CSRF'),
			'current_time' => $app->get('TIME'),
			'current_query_string' => $app->get('QUERY'),
			'current_url' => $app->get('PATH'),
			'current_uri' => $app->get('URI'),
			'permalink' => $app->get('REALM'),
			'is_ajax' => $app->get('AJAX'),
			'get' => !empty($app->get('GET')) ? $app->get('GET') : FALSE,
			'post' => !empty($app->get('POST')) ? $app->get('POST') : FALSE,
			'default_layout' => 'default.html',
			'error_layout' => 'default.html',
			'error_template' => 'errors.html',
		];
		// url segment variables
		foreach ($segs = explode('/',$app->get('PATH')) as $key => $value) {
			if ($value) {
				$config['segment_'.$key] = $value;
				if ($value === end($segs)) {
					$config['last_segment'] = $value;
				}
			}
		}
		// load user config
		$settings = Yaml::read(ROOT.'config/settings.yaml');
		// load environment
		if (!empty($settings['environment'])) {
			$environment = $settings['environment'];
			// loop environment aliases
			foreach ($environment as $env => $patterns) {
				if (!empty($patterns)) {
					// loop environment patterns
					foreach ($patterns as $pattern) {
						// test pattern agains domain
						if ($app->matches($pattern, $app->get('DOMAIN'))) {
							// add env configuration to config
							if (file_exists('config/environments/'.$env.'.yaml')) {
								// set env
								$config['env'] = $env;
								// parse config
								$settings += Yaml::read('config/environments/'.$env.'.yaml');
							}
						}
					}
				}
			}
		}
		// load translation
		if ($app->exists('LANGUAGE', $langs)) {
			if (!is_array($langs)) {
				$langs = $app->split($langs);
			}
			foreach ($langs as $lang) {
				if (file_exists('config/translations/'.$lang.'.yaml')) {
					// set lang
					$config['lang'] = $lang;
					// parse config
					$settings['translations'] = Yaml::read('config/translations/'.$lang.'.yaml');
				}
			}
		}
		// load theme config
		if (file_exists($app->get('THEME').'theme.yaml')) {
			$settings['theme'] = Yaml::read($app->get('THEME').'theme.yaml');
		}
		// merge configs
		self::$config = array_merge($config, $settings);
		// return for chaining
		return $this;
	}

	public static function set($key, $value = NULL)
	{
		// set each key val pair for an object or array to klay
		if (is_array($key) || is_object($key)) {
			foreach ($key as $k => $v) {
				self::$config[$k] = $v;
			}
		}
		// set key val pair to klay
		else {
			self::$config[$key] = $value;
		}
	}

	public static function get($key, $default = FALSE)
	{
		// return klay key or default
		return Matrix::value(self::$config, $key, $default);
	}

	public static function dump($exclude = [])
	{
		$app = Base::instance();
		$config = [];
		// merge global excludes w/ dump excludes
		$exclude = array_merge(self::$exclude, $exclude);
		// add non-excluded values to $config
		foreach (self::$config as $key => $value) {
			if (!in_array($key, $exclude)) {
				$config[$key] = $value;
			}
		}
		// return config array of non excluded items
		return $config;
	}

	public static function event($event, $value = NULL, $callback = NULL)
	{
		static $events;
		if ($callback !== NULL) {
			if ($callback) {
				$events[$event][] = $callback;
			} else {
				unset($events[$event]);
			}
		} elseif (isset($events[$event])) {
			foreach ($events[$event] as $function) {
				$value = call_user_func($function, $value);
			}
			return $value;
		}
	}

	public function start()
	{
		Falsum::handler(self::$config['debug']);
		// run application
		Base::instance()->run();
		// return for chaining
		return $this;
	}

	public function finish()
	{
		// abort application
		Base::instance()->abort();
		// return for chaining
		return $this;
	}
}
