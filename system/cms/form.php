<?php

namespace CMS;

class Form
{
	public static function buildFields($fields = [], $values = [], $group = FALSE)
	{
		$app = \Base::instance();
		$fieldset = [];
		$templates = self::loadTemplates();
		if (!empty($fields)) {
			foreach ($fields as $name => $params) {
				$type = $params['type'];
				if ($type && isset($templates[$type])) {
					$params['id'] = 'field_'.$app->hash($name.serialize($params));
					$params['name'] = $group ? $group.'['.$name.']' : $name;
					if (!isset($params['class'])) {
						$params['class'] = $type;
					}
					if (!isset($params['display'])) {
						$params['display'] = ucwords(preg_replace('/[-_\[\]]/',' ', $name));
					}
					if (is_array($values) && array_key_exists($name, $values)) {
						$params['value'] = $values[$name];
						if (is_bool($params['value'])) {
							$params['value'] = (int) $params['value'];
						}
					} else {
						$params['value'] = NULL;
					}
					// callback
					$namespace = '\\Addons\\Fields\\'.ucfirst($type).'\\Field';
					if (method_exists($namespace,'render')) {
						$field  = new $namespace();
						$params = $field->render($params);
					}
					// clean options
					if (isset($params['options'])) {
						$params['options'] = self::optionsArray($params['options'], $params['value']);
					}
					// parse field template and add to fieldset
					$fieldset[] = ($params + ['output' => \Klay\Parse::variables($templates[$type],$params)]);
				}
			}
		}
		return $fieldset;
	}

	public static function loadTemplates()
	{
		$temps = [];
		$files = glob(SYSTEM.'addons/fields/*/*.html');
		if (!empty($files)) {
			foreach ($files as $template) {
				$name = str_replace(SYSTEM.'addons/fields/','',dirname($template));
				$temps[$name] = file_get_contents($template);
			}
		}
		return $temps;
	}

	public static function optionsArray($opts, $value = null)
	{
		$options = [];
		if (!empty($opts)) {
			foreach ($opts as $k => $v) {
				$options[] = [
					'option' => $k,
					'label' => $v ? $v : $k,
					'is_selected' => $k === $value || is_array($value) && in_array($k, $value) ? TRUE : FALSE,
				];
			}
		}
		return $options;
	}
}
