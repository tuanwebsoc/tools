<?php

// __PATCH 
/**
 * フィールドセットの拡張。.
 */
class fieldset extends Fuel\Core\Fieldset
{

    /**
     * バリデーションエラーが発生した場合でもvalidatedされた値を返すようにする.
     *
     * @param mixed $field
     * @access public
     */
    public function validated($field = null)
    {
        $value = $this->fieldset()->validation()->validated($this->name);

        if ($this->error()) {
            $value = $this->input();
        }

        return $value;
    }
    
	/**
	 * Set all fields to the input from get or post (depends on the form method attribute)
	 *
	 * @return  Fieldset      this, to allow chaining
	 */
	public function repopulate()
	{
		$fields = $this->field(null, true);
		foreach ($fields as $f)
		{
			// Don't repopulate the CSRF field
			if ($f->name === \Config::get('security.csrf_token_key', 'fuel_csrf_token'))
			{
				continue;
			}

			if (($value = $f->input()) !== null)
			{
                $input_format = $f->get_attribute('input_format');
                if (isset($input_format)){
                    $value = call_user_func($input_format,$value);
                }
				$f->set_value($value, true);
			}
		}

		return $this;
	}
    
    
	/**
	 * Enable or disable the tabular form feature of this fieldset
	 *
	 * @param  string  Model on which to define the tabular form
	 * @param  string  Relation of the Model on the tabular form is modeled
	 * @param  array  Collection of Model objects from a many relation
	 * @param  int  Number of empty rows to generate
	 *
	 * @return  Fieldset  this, to allow chaining
	 */
	public function set_tabular_form($model, $relation, $parent, $blanks = 1)
	{
		// make sure our parent is an ORM model instance
		if ( ! $parent instanceOf \Orm\Model)
		{
			throw new \RuntimeException('Parent passed to set_tabular_form() is not an ORM model object.');
		}

		// validate the model and relation
		// fetch the relations of the parent model
		$relations = call_user_func(array($parent, 'relations'));
		if ( ! array_key_exists($relation, $relations))
		{
			throw new \RuntimeException('Relation passed to set_tabular_form() is not a valid relation of the ORM parent model object.');
		}

		// check for compound primary keys
		try
		{
			// fetch the relations of the parent model
			$primary_key = call_user_func($model.'::primary_key');

			// we don't support compound primary keys
			if (count($primary_key) !== 1)
			{
			throw new \RuntimeException('set_tabular_form() does not supports models with compound primary keys.');
			}

			// store the primary key name, we need that later
			$primary_key = reset($primary_key);
		}
		catch (\Exception $e)
		{
			throw new \RuntimeException('Unable to fetch the models primary key information.');
		}

		// store the tabular form class name
		$this->tabular_form_model = $model;

		// and the relation on which we model the rows
		$this->tabular_form_relation = $relation;

		// load the form config if not loaded yet
		\Config::load('form', true);

		// load the config for embedded forms
		$this->set_config(array(
			'form_template' => \Config::get('form.tabular_form_template', "<table>{fields}</table>\n"),
			'field_template' => \Config::get('form.tabular_field_template', "{field}")
		));

		// add the rows to the tabular form fieldset
        $childModels = $parent->{$relation};
        if (!is_array($childModels)){
            $childModels = array($childModels);
        }
		foreach ($childModels as $row)
		{
			// add the row fieldset to the tabular form fieldset
			$this->add($fieldset = \Fieldset::forge($this->tabular_form_relation.'_row_'.$row->{$primary_key}));

			// and add the model fields to the row fielset
			$fieldset->add_model($model, $row)->set_fieldset_tag(false);
			$fieldset->set_config(array(
				'form_template' => \Config::get('form.tabular_row_template', "<table>{fields}</table>\n"),
				'field_template' => \Config::get('form.tabular_row_field_template', "{field}")
			));
			$fieldset->add($this->tabular_form_relation.'['.$row->{$primary_key}.'][_delete]', '', array('type' => 'checkbox', 'value' => 1));
		}

		// and finish with zero or more empty rows so we can add new data
		if ( ! is_numeric($blanks) or $blanks < 0)
		{
			$blanks = 1;
		}
		for ($i = 0; $i < $blanks; $i++)
		{
			$this->add($fieldset = \Fieldset::forge($this->tabular_form_relation.'_new_'.$i));
			$fieldset->add_model($model)->set_fieldset_tag(false);
			$fieldset->set_config(array(
				'form_template' => \Config::get('form.tabular_row_template', "<tr>{fields}</tr>"),
				'field_template' => \Config::get('form.tabular_row_field_template', "{field}")
			));
			$fieldset->add($this->tabular_form_relation.'_new['.$i.'][_delete]', '', array('type' => 'checkbox', 'value' => 0, 'disabled' => 'disabled'));

			// no required rules on this row
			foreach ($fieldset->field() as $f)
			{
				$f->delete_rule('required', false)->delete_rule('required_with', false);
			}
		}

		return $this;
	}
    
}
