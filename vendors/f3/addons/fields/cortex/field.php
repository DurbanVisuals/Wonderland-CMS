<?php

namespace Addons\Fields\Cortex;

class Field
{
	public function render($params)
	{
		if (isset($params['table'])) {
			$filter = $params['filter'] ? $params['filter'] : [];
			$option = $params['column_option'] ? $params['column_option'] : '_id';
			$label = $params['column_label'] ? $params['column_label'] : $option;
			$table = new $params['table']();
			$results = $table->afind($filter,null,null,0);
			if (!empty($results)) {
				foreach ($results as $item) {
					$params['options'][$item[$option]] = $item[$label];
				}
			}
		}
		return $params;
	}
}
