<?php

namespace Klay;

class Parse
{
	public static function template($html, $variables, $callback, $context = [])
    {
		$parser = new \Lex\Parser();
		$parser->scopeGlue(':');
		$parser->cumulativeNoParse(TRUE);
        return $parser->parse($html, ($context + $variables), $callback, \Klay::get('allow_php', FALSE));
    }

	public static function variables($html, $variables)
	{
		$parser = new \Lex\Parser();
		return $parser->parse($html, $variables, NULL);
	}
}
