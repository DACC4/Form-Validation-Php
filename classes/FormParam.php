<?php 
    class FormParam
    {
        public string $name;
        public int $method;

        public bool $mandatory = false;
        public ?FormParam $conditionalMandatory = null;

        public int $allowedValueType = AllowedValueType::All;
        public $allowedValues = '';

        public function __construct(String $name, int $method, Bool $mandatory, ?FormParam $conditionalMandatory = null, int $allowedValueType = AllowedValueType::All, $allowedValues = ''){
            $this->name = $name;
            $this->method = $method;
            $this->mandatory = $mandatory;
            $this->conditionalMandatory = $conditionalMandatory;
            $this->allowedValueType = $allowedValueType;
            $this->allowedValues = $allowedValues;
        }
    }
?>