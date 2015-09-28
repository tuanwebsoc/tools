<?php

class Model_items extends Orm\Model
{
	protected static $_table_name = 'it_ebooks_items';
	
	protected static $_primary_key = array('book_id');
	
	protected static $_properties = array(
		'book_id' => array(
			'label' => 'Book ID'
		),
		'category_id' => array(
			'label' => 'Category ID'
		),
		'book_id' => array(
			'label' => 'Book ID'
		),
		'data' => array(
			'label' => 'Data'
		),
		'created_date',
		'ordering',
	);
}