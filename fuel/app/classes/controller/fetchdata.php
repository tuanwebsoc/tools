<?php

class Controller_Fetchdata extends \Controller_Base
{
	protected static $FETCH_VIEW_PATCH= "fetchdata/index";
	
	protected static $API_SEARCH = 'http://it-ebooks-api.info/v1/search/';
	protected static $API_BOOK = 'http://it-ebooks-api.info/v1/book/';
	
	public function action_index()
	{
		// Get all categories
		$categories = \Model_Categories::find('all');

		$datacategories = array();
		
		// Convert categories to arrays
		foreach ($categories as $k => $category)
		{
			$datacategories[$category->category_id] = $category->title;
		}
		
		$view = \View::forge(static::$FETCH_VIEW_PATCH);
		$view->set('categories', $datacategories, false);
		
		$this->template->content = $view;
	}
	
	public function action_fetch()
	{
		$category_id = \Input::post("category_id", 5);
		
		$category = \Model_Categories::find($category_id);
		
		$search_text = $category->search_text;
		
		// Get data thought on API it-books
		// create a Request_Curl object
		$curl = Request::forge(static::$API_SEARCH . $search_text, 'curl');
		$curl->execute();
		$result = $curl->response();
		
		header('Content-Type: application/json');
			echo $result;
		die;
	}
	
	public function action_saveitem($id = 0)
	{
		// Search detail data of 
		$curl = Request::forge(static::$API_BOOK . $id, 'curl');
		$curl->execute();
		$result = $curl->response();
		
		$decode = json_decode($result, true);
		
// 		$encode = json_encode($decode);
// 		var_dump($decode);die;
		
		$category_id = \Input::get('category_id', 0);
		
		// Check this ID already existed
		$book = \Model_Items::find($id);
		
		$datatemp = array();
		
		foreach ($decode as $k => $item)
		{
			if (strtolower($k) == "id")
			{
				$datatemp['book_id'] = $item;
			}
			else
			{
				$datatemp[strtolower($k)] = $item;
			}
		}
		
		$array = array();
		
		if ($book == null)
		{
			$data = array();
			$new_book = \Model_Items::forge();
			$data['book_id'] = $id;
			$data['category_id'] = $category_id;
			$data['data'] = $result;
			
			$new_book->set($data)->save();
			
			// Save to extend table
			$extend_item = \Model_Itemsextend::forge();
			$extend_item->set($datatemp)->save();
			
			$array['status'] = 1;
			$array['existed'] = 0;
		}
		else 
		{
			$array['status'] = 0;
			$array['existed'] = 1;
		}
		
		header('Content-Type: application/json');
			echo json_encode($array);
		die;
	}
}
