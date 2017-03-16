<?php

namespace Addons\Plugins\CMS;

class Search
{
	public function simple($params, $content)
	{
		$app = \Base::instance('');
		if ($app->get('POST.trigger') === 'klay:search:simple') {
		}
	}

	public function results($params, $content)
	{
		return \Klay\Parse::template($content, $this->searchKeyword($params['keyword']), '\\Klay\\Theme::callback');
	}

	private function searchKeyword($keyword)
	{
		$results = [
			'count' => 0,
			'keyword' => $keyword,
			'matches' => []
		];
		$cache = new \Cache('folder=cache/search/');
		if ($cache->exists(md5($keyword), $cached)) {
			$results = array_merge($results, $cached);
		} else {
			$paths = \Klay\Content::routeStructure('*.md',[],FALSE);
			if (!empty($paths)) {
				foreach ($paths as $path) {
					$file = $path['file'];
					$data = file_get_contents($file);
					// search
					$pattern = preg_quote($keyword,'/');
					$pattern = "/^.*$pattern.*\$/m";
					if (preg_match_all($pattern, $data, $matches)) {
						$results['count'] = ($results['count'] + 1);
						$match = [
							'excerpt' => $matches[0][0],
						];

						$data = \Klay\Content::getContent($file,['alias','title','route']);

						$results['matches'][] = array_merge($match, $data);
					}
				}
			}
		}
		return $results;
	}
}
