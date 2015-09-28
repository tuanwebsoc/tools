<?php

class Model_Categories extends Orm\Model
{
	protected static $_table_name = 'it_ebooks_categories';
	
	protected static $_primary_key = array('category_id');
	
	protected static $_properties = array(
		'category_id' => array(
			'label' => 'Cateogory ID'
		),
		'title' => array(
			'label' => 'Title'
		),
		'search_text' => array(
			'label' => 'Search text'
		),
		'created_date',
		'ordering',
	);
}