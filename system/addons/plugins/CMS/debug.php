<?php

namespace Addons\Plugins\CMS;

class Debug
{
	public function render($params)
	{
		return \Yaml::write(\Klay::dump());
	}
}
