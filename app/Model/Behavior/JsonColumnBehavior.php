<?php

/**
 * Be able to easily save and retrieve PHP arrays to/from a database's column
 *
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 */
class JsonColumnBehavior extends ModelBehavior {

	/**
	 * The default options for the behavior
	 *
	 * @var array
	 * @access public
	 */
	public $settings = array(
		'fields' => array()
	);

	/**
	 * Setup the behavior.
	 *
	 * @param object $model Reference to model
	 * @param array $settings Settings
	 * @return void
	 * @access public
	 */
	public function setup(Model $model, $settings = array()) {
		$this->settings = array_merge($this->settings, $settings);
	}

	/**
	 *
	 * @param object $model Reference to model
	 * @access public
	 */
	public function beforeSave(Model $model, $options = array()) {
		foreach ($this->settings['fields'] as $field) {
			if (isset($model->data[$model->alias][$field]))
				$model->data[$model->alias][$field] = $this->_encode($model->data[$model->alias][$field]);
		}
		return true;
	}

	/**
	 *
	 * @param object $model Reference to model
	 * @access public
	 */
	public function afterFind(Model $model, $results, $primary = false) {
		foreach ($results as $i => &$res) {
			foreach ($this->settings['fields'] as $field) {
				if (isset($res[$model->alias][$field]))
					$res[$model->alias][$field] = $this->_decode($res[$model->alias][$field]);
			}
		}
		return $results;
	}

	/**
	 * Encode json
	 *
	 * @param $data
	 * @return mixed
	 */
	protected function _encode($data) {
		return json_encode($data);
	}

	/**
	 * Decode json
	 *
	 * @param $data
	 * @return mixed
	 */
	protected function _decode($data) {
		$decode = json_decode($data);
		return is_object($decode) ? (array) $decode : $decode;
	}

}
