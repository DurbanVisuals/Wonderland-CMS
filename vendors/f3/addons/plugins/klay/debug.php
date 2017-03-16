<?php

namespace Addons\Plugins\Klay;

class Debug
{
	public function render($params)
	{
		return \Yaml::write(\Klay::dump());
	}
}
