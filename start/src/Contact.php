<?php

namespace CT275\Labs;

class Contact
{
	private $db;

	private $id = -1;
	public $name;
	public $phone;
	public $notes;
	public $created_at;
	public $updated_at;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['name'])) {
			$this->name = trim($data['name']);
		}

		if (isset($data['phone'])) {
			$this->phone = preg_replace('/\D+/', '', $data['phone']);
		}

		if (isset($data['notes'])) {
			$this->notes = trim($data['notes']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->name) {
			$this->errors['name'] = 'Invalid name.';
		}

		if (strlen($this->phone) < 10 || strlen($this->phone) > 11) {
			$this->errors['phone'] = 'Invalid phone number.';
		}

		if (strlen($this->notes) > 255) {
			$this->errors['notes'] = 'Notes must be at most 255 characters.';
		}

		return empty($this->errors);
	}
}
