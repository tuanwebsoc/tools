<?php

abstract class Controller_Common extends Controller_Base
{    
    protected static $MODEL_NAME = 'Model_Company_Grades';
    protected static $MODEL_OPTION_INDEX = array();
    protected static $MODEL_OPTION_INDEX_COUNT = array();
    protected static $MODEL_OPTION_VIEW = array();
    protected static $MODEL_OPTION_EDIT = array();
    protected static $MODEL_OPTION_DELETE = array();
    
    protected static $IS_PAGINATION = true;
    protected static $RESULT_PER_PAGE = 10;
    
    protected static $LIST_VIEW_PATH = 'company/settings/grades/list';
    protected static $VIEW_VIEW_PATH = 'company/settings/grades/view';
    protected static $EDIT_VIEW_PATH = 'company/settings/grades/edit';
    protected static $NEW_VIEW_PATH = 'company/settings/grades/new';
    
    public static function url_view($id){
        return '/company/settings/grades/view/' . $id;
    }
    
    public static function url_edit($id){
        return '/company/settings/grades/edit/' . $id;
    }
    
    public static function url_list(){
        return '/company/settings/grades';
    }
    
    public static function url_new(){
        return '/company/settings/grades/new';
    }
    
    public static function url_delete($id){
        return '/company/settings/grades/delete/' . $id;
    }
    
    public static function get_title_list()
    {
        return __('List', 'TEXT');
    }
    
    public static function get_title_view()
    {
        return __('View', 'TEXT');
    }
    
    public static function get_title_edit()
    {
        return __('Edit', 'TEXT');
    }
    
    public static function get_title_new()
    {
        return __('New', 'TEXT');
    }
    
    public static function msg_form_expire()
    {
        return __('Form has expired. Please submit again.', 'TEXT');
    }
    
    public static function msg_failed_save()
    {
        return __('Failed to save data.', 'TEXT');
    }
    
    public static function msg_invalid_field()
    {
        return __('Some data field is invalid.', 'TEXT');
    }
    
    protected static function msg_flash_edit_success($model){
        return __("Edited successfully", 'TEXT').__('DOT');
    }
    
    protected static function msg_flash_delete_success($model){
        return __("Deleted successfully", 'TEXT').__('DOT');
    }
    
    protected static function msg_flash_new_success($model){
        return __("Created successfully", 'TEXT').__('DOT');
    }
    
    protected static function afterCreateFieldSet(&$fieldset, &$model){}

    protected static function afterModelSetData(&$model, $data){}
    
    protected static function afterModelSaveData(&$model, $data){
        return true;
    }
    
    protected function afterSetView($view,$model){}

    public function get_index()
    {
        $modelName = static::$MODEL_NAME;
        
        if (static::$IS_PAGINATION){
            $paginationConfig = array(
                'total_items' => $modelName::count(static::$MODEL_OPTION_INDEX_COUNT),
                'per_page' => static::$RESULT_PER_PAGE,
                'uri_segment' => 'page',
            );
            $pagination = \Pagination::forge('pagination', $paginationConfig);
            static::$MODEL_OPTION_INDEX['row_offset'] = $pagination->offset;
            static::$MODEL_OPTION_INDEX['rows_limit'] = $pagination->per_page;            
        }
        
        $models = $modelName::find('all', static::$MODEL_OPTION_INDEX);

        $view = \View::forge(static::$LIST_VIEW_PATH);
        $view->set('models', $models);
        $this->template->title = static::get_title_list();
        $this->template->content = $view;
        $this->afterSetView($view,$models);
    }
    public function get_view($id)
    {
        $modelName = static::$MODEL_NAME;
        $model = $modelName::find($id, static::$MODEL_OPTION_VIEW);
        if (empty($model)){
            \Response::redirect(static::url_list());
        }
        
        $view = \View::forge(static::$VIEW_VIEW_PATH);
        $view->set('model', $model);
        $this->template->title = static::get_title_view();
        $this->template->content = $view;
        $this->afterSetView($view,$model);        
    }
    
    public function action_edit($id)
    {
        $modelName = static::$MODEL_NAME;
        $model = $modelName::find($id, static::$MODEL_OPTION_EDIT);
        if (empty($model)){
            throw new \HttpNotFoundException;
        }
        $fieldset = \Fieldset::forge()->add_model($modelName)->populate($model, true);// true means re-populate with input from Form
        static::afterCreateFieldSet($fieldset, $model);
        
        if (\Input::method() == 'POST') {
            if (!\Security::check_token()) {
                \Session::set_flash('error', static::msg_form_expire());
                return \Response::redirect(static::url_list());
            }    
           
            try{
                if ($fieldset->validation()->run()) {
                    $data = $fieldset->validation()->validated();
                    $model->set($data);
                    
                    // Hook up model after set
                    static::afterModelSetData($model, $data);
                    
                    $isMainSave = $model->save(false, true);//no casscade, use transaction
                    $isChildSave = static::afterModelSaveData($model, $data);
                    if ($isMainSave && $isChildSave) {
                        \Session::set_flash('success',  static::msg_flash_edit_success($model));
                        return \Response::redirect(static::url_view($id));
                    }else{
                        throw new Exception(static::msg_failed_save());
                    }
                }else{
                    throw new Exception(static::msg_invalid_field());
                }
            } catch (Exception $ex) {
                    \Session::set_flash('error', __(''));
                    \Session::set_flash('error', $ex->getMessage());
            }
        }
        $this->template->title = static::get_title_edit();
        $view = \View::forge(static::$EDIT_VIEW_PATH);
        $view->set('fieldset', $fieldset, false);
        $view->set('id', $id, false);
        $this->template->content = $view;
        $this->afterSetView($view,$model);        
    }
    
    public function action_new(){
        $fieldset = \Fieldset::forge()->add_model(static::$MODEL_NAME)->repopulate();
        static::afterCreateFieldSet($fieldset, $model);
        if (\Input::method() == 'POST') {
            if (!\Security::check_token()) {
                \Session::set_flash('error', static::msg_form_expire());
                return \Response::redirect(static::url_list());
            }
            $modelName = static::$MODEL_NAME;

            try{
                if ($fieldset->validation()->run()) {
                    $data = $fieldset->validation()->validated();
                    $model = $modelName::forge();
                    $model->set($data);
                    
                    // Hook up model after set
                    static::afterModelSetData($model, $data);
                    
                    $isMainSave = $model->save(false, true);//no casscade, use transaction
                    $isChildSave = static::afterModelSaveData($model, $data);
                    if ($isMainSave && $isChildSave) {
                        \Session::set_flash("success", static::msg_flash_new_success($model));
                        return \Response::redirect(static::url_view($model->{$modelName::primary_key()[0]}));
                    }else{
                        throw new Exception(static::msg_form_expire());
                    }
                }else{
                    throw new Exception(static::msg_invalid_field());
                }
            } catch (Exception $ex) {
                    \Session::set_flash('error', $ex->getMessage());
            }
        }
        
        $this->template->title = static::get_title_new();
        $view = \View::forge(static::$NEW_VIEW_PATH);
        $view->set('fieldset', $fieldset, false);
        $this->template->content = $view;
        $this->afterSetView($view,$model);        
    }
    
    public function action_delete($id){
        $modelName = static::$MODEL_NAME;
        $model = $modelName::find($id, static::$MODEL_OPTION_DELETE);
        
        if (empty($model)){
            throw new \HttpNotFoundException;
        }
        try{
            $model->delete(null, true);
            \Session::set_flash('success', static::msg_flash_delete_success($model));
        } catch (Exception $ex) {
                \Session::set_flash('error', $ex->getMessage());
                return \Response::redirect(static::url_list());
        }        
        return \Response::redirect(static::url_list());
    }
}