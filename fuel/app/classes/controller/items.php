<?php

class Controller_items extends \Controller_Common
{
    protected static $MODEL_NAME = 'Model_items';
    protected static $RESULT_PER_PAGE = 1000;
    protected static $LIST_VIEW_PATH = 'items/list';
    protected static $VIEW_VIEW_PATH = 'company/settings/grades/view';
    protected static $EDIT_VIEW_PATH = 'categories/form';
    protected static $NEW_VIEW_PATH = 'categories/form';

    public static function url_view($id){
        return Uri::base(false) . 'categories/';
    }
    
    public static function url_edit($id){
        return Uri::base(false). 'categories/edit/' . $id;
    }
    
    public static function url_list(){
        return Uri::base(false). 'categories/';
    }
    
    public static function url_new(){
        return Uri::base(false). 'categories/new';
    }
    
    public static function url_delete($id){
        return '/company/settings/grades/delete/' . $id;
    }
    
    public static function get_title_list()
    {
        return 'List salary grades';
    }
    
    public static function get_title_view()
    {
        return 'View salary grade';
    }
    
    public static function get_title_edit()
    {
        return 'Edit Category';
    }
    
    public static function get_title_new()
    {
        return 'New salary grade';
    }    
    
    public static function msg_form_expire()
    {
    	return 'Form has expired. Please submit again.';
    }
    
    protected static function msg_flash_edit_success($model){
        return 'success';
    }
    
    protected static function msg_flash_delete_success($model){
        return 'delete success';
    }
    
    protected static function msg_flash_new_success($model){
        return 'Create new success';
    }
    
    protected static function afterModelSetData(&$model, $data)
    {
    	$model->created_date = '0000-00-00 00:00';
    }
}
