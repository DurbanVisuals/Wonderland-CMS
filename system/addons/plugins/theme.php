<?php

namespace Addons\Plugins\CMS;

class Theme
{
	public function __construct()
	{
		$this->app = \Base::instance();
	}

	public function css($params)
	{
		$src = $params['src'];
		$base = $this->app->matches('http*',$src) ? NULL : '/'.$this->app->get('THEME').'css/';
		$tag = '<link rel="stylesheet" href="'.$base.'%s"%s>';
		unset($params['src']);
		if (!empty($params)) {
			$extra = '';
			foreach ($params as $key => $value) {
				$extra .= ' '.$key.'="'.$value.'"';
			}
		} else {
			$extra = NULL;
		}
		return sprintf($tag,$src,$extra);
	}

	public function js($params)
	{
		$src = $params['src'];
		$base = $this->app->matches('http*',$src) ? NULL : '/'.$this->app->get('THEME').'js/';
		$tag = '<script src="'.$base.'%s"%s></script>';
		unset($params['src']);
		if (!empty($params)) {
			$extra = '';
			foreach ($params as $key => $value) {
				$extra .= ' '.$key.'="'.$value.'"';
			}
		} else {
			$extra = NULL;
		}
		return sprintf($tag,$src,$extra);
	}
}
