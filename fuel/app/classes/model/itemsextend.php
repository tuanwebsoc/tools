<?php

class Model_Itemsextend extends Orm\Model
{
	protected static $_table_name = 'it_ebooks_items_extend';
	
	protected static $_primary_key = array('book_id');
	
	protected static $_properties = array(
		'book_id' => array(
			'label' => 'Book ID'
		),
		'title' => array(
			'label' => 'Title'
		),
		'subtitle' => array(
			'label' => 'Subtitle'
		),
		'description' => array(
			'label' => 'Description'
		),
		'author' => array(
			'label' => 'Author'
		),
		'isbn' => array(
			'label' => 'ISBN'
		),
		'year' => array(
			'label' => 'Year'
		),
		'page' => array(
			'label' => 'Page'
		),
		'publisher' => array(
			'label' => 'Publisher'
		),
		'image' => array(
			'label' => 'Image'
		),
		'download' => array(
			'label' => 'Download'
		)
	);
}