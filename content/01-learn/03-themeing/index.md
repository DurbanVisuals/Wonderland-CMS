---
title: Themeing
template: learn.html
global_variables:
	-
		variable: app
		description: Name of your application
	-
		variable: version
		description: Application version
	-
		variable: csrf
		description: Current session csrf token
	-
		variable: current_time
		description: Current timestamp
	-
		variable: current_time
		description: Current timestamp
	-
		variable: current_query_string
		description: Current query string after the ?
	-
		variable: current_url
		description: Current route path without the query string
	-
		variable: current_uri
		description: Current route path including the query string
	-
		variable: permalink
		description: Current path including scheme and host
	-
		variable: is_ajax
		description: Current request was made by AJAX (true or false)
	-
		variable: get
		description: Current query string array key, val pairs
	-
		variable: post
		description: Current post request key, val pairs
	-
		variable: env
		description: Active environment name
	-
		variable: lang
		description: Active user language
	-
		variable: site_name
		description: Name of your website
	-
		variable: _template
		description: Content template output

content_variables:
	-
		variable: file
		description: Full path to content file
	-
		variable: type
		description: Type of content (pages or entries)
	-
		variable: alias
		description: Alias of the page
	-
		variable: access
		description: Array of allowed access groups
	-
		variable: route
		description: URL route to content
	-
		variable: parent
		description: URL route to content parent
	-
		variable: layout
		description: Content layout path
	-
		variable: template
		description: Content template path
	-
		variable: modified
		description: Content last modified timestamp
	-
		variable: title
		description: Content title
	-
		variable: content
		description: Converted markdown contents
---
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores enim rerum fugit assumenda explicabo similique voluptatum cum quaerat delectus illum sequi dignissimos nesciunt, voluptas aperiam, ducimus incidunt vitae molestiae omnis.
