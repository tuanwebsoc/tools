<?php
return array(
	'_root_'  => 'tools/index',  // The default route
	'_404_'   => 'tools/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
