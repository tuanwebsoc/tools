<?php
// __PATCH 
/**
 * 独自バリデーション.
 */
class validation extends Fuel\Core\Validation
{

	/**
	 * [PATCHED] Run validation
     * Call input_format for input value
	 *
	 * Performs validation with current fieldset and on given input, will try POST
	 * when input wasn't given.
	 *
	 * @param   array  input that overwrites POST values
	 * @param   bool   will skip validation of values it can't find or are null
	 * @return  bool   whether validation succeeded
	 */
	public function run($input = null, $allow_partial = false, $temp_callables = array())
	{
		if (is_null($input) and \Input::method() != 'POST')
		{
			return false;
		}

		// Backup current state of callables so they can be restored after adding temp callables
		$callable_backup = $this->callables;

		// Add temporary callables, reversed so first ends on top
		foreach (array_reverse($temp_callables) as $temp_callable)
		{
			$this->add_callable($temp_callable);
		}

		static::set_active($this);

		$this->validated = array();
		$this->errors = array();
		$this->input = $input ?: array();
		$fields = $this->field(null, true);
		foreach($fields as $field)
		{
			static::set_active_field($field);

			// convert form field array's to Fuel dotted notation
			$name = str_replace(array('[',']'), array('.', ''), $field->name);

			$value = $this->input($name);
            // PATCH:  format input
            $input_format = $field->get_attribute('input_format');
            if (isset($input_format)){
                $value = call_user_func($input_format,$value);
            }
            
			if (($allow_partial === true and $value === null)
				or (is_array($allow_partial) and ! in_array($field->name, $allow_partial)))
			{
				continue;
			}
			try
			{
				foreach ($field->rules as $rule)
				{
					$callback  = $rule[0];
					$params    = $rule[1];
					$this->_run_rule($callback, $value, $params, $field);
				}
				if (strpos($name, '.') !== false)
				{
					\Arr::set($this->validated, $name, $value);
				}
				else
				{
					$this->validated[$name] = $value;
				}
			}
			catch (Validation_Error $v)
			{
				$this->errors[$field->name] = $v;

				if($field->fieldset())
				{
					$field->fieldset()->Validation()->add_error($field->name, $v);
				}
			}
		}

		static::set_active();
		static::set_active_field();

		// Restore callables
		$this->callables = $callable_backup;

		return empty($this->errors);
	}
    
    /**
     * 電話番号チェック.
     *
     * @access public
     *
     * @param mixed $val 入力値
     *
     * @return bool チェック結果
     */
    public static function _validation_valid_tel($val)
    {
        $is_valid = false;

        mb_regex_encoding('UTF-8');
        $pattern = '/^0[0-9]{1,3}\-[0-9]{2,4}\-[0-9]{4}$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    /**
     * 時間チェック.
     *
     * 「H:i」形式
     *
     * @access public
     *
     * @param mixed $val 入力値
     *
     * @return bool チェック結果
     */
    public static function _validation_valid_time($val)
    {
        mb_regex_encoding('UTF-8');
        $pattern = '/^([1-9]{1}|0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}|):'
            . '(0[0-9]{1}|[1-5]{1}[0-9]{1})$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    /**
     * 郵便番号チェック.
     *
     * @access public
     *
     * @param mixed $val 入力値
     *
     * @return bool チェック結果
     */
    public static function _validation_valid_zip($val)
    {
        $is_valid = false;
        //if not required so empty OK
        if($val){
            mb_regex_encoding('UTF-8');
            $pattern = '/^[0-9]{3}-?[0-9]{4}$/';
            $is_valid = (bool) preg_match($pattern, $val);
        }else{
            return true;
        }
        return $is_valid;
    }

    /**
     * カタカナチェック.
     *
     * @access public
     *
     * @param mixed $val 入力値
     *
     * @return bool チェック結果
     */
    public static function _validation_valid_kana($val)
    {
        $is_valid = false;

        mb_regex_encoding('UTF-8');
        $pattern = '/^[ァ-ヶー]+$/u';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    public static function _validation_unique($val, $options)
    {
        $model = self::active()->callables()[0];
        // Get the table and field separately
        list($table, $field) = explode('.', $options);
        
        if(! $model->is_new() && $model->{$field} == $val){
            return true;
        }
        
        if (!is_string($options)) {
            throw new \InvalidArgumentException('Parameter $options must be either an associative string of [table.field].');
        }

        // Create the query
        $query = \DB::select($field)->from($table)->where($field, '=', $val);

        // Execute query
        $result = $query->execute();

        // No results?
        if ( $result->count() == 0)
        {
            // Then it's unique
            return true;
        }

        if(! $model->is_new()){
            self::active()->fieldset()->field($field)->set_value($model->{$field});
        }

        // Set the message
//        \Validation::active()->set_message('unique', 'An item with value ' . $val . ' already exists.');

        // And invaldiate it since the value is not unique
        return false;
    }

    public static function _validation_check_password($val, $option)
    {
        $model = $option['model'];
        $employee = Model_Employee::find($model->employee_id);
        if(\Auth::hash_password(trim($val)) === $employee->hashed_password) {
            return true;
        }
        
        return false;
    }
    
    public function _validation_new_password($val, $field)
    {
        if ($this->input($field) !== $val) {
            return true;
        }
        
        return false;
    }

    public function _validation_unique_employee_no($val)
    {
        $check = true;
        $company_id = \Input::post("company_id", 0);
        $employee_id = \Input::post("employee_id", 0);

        // Query to check
        $result = DB::select("*")
            ->from("employees")
            ->where(array(
                "company_employee_no" => $val,
                "company_id" => $company_id
            ))->execute()->current();

        if ($result["employee_id"] != $employee_id && $result["employee_id"] != null)
        {
            return false;
        }
        
        return true;
    }

    public function _validation_unique_login_code($val)
    {
        $company_id = \Input::post("company_id", 0);
        $employee_id = \Input::post("employee_id", 0);

        // Query to check
        $result = DB::select("*")
        ->from("employees")
        ->where(array(
                "login_code" => $val,
                "company_id" => $company_id
        ))->execute()->current();

        if ($result !== null && $result["employee_id"] != $employee_id)
        {
            return false;
        }

        return true;
    }
}
