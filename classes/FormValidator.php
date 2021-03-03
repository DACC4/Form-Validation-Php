<?php 
    class FormValidator
    {
        public Form $form;
        public array $params;
        private bool $validated = false;
        private array $errorsArray = array();

        public function __construct(Form $form, FormParam ...$params){
            $this->form = $form;
            $this->params = $params;
        }

        public function validate() : bool{
            foreach ($this->params as $param) {
                /*
                    Check mandatory
                */
                //TODO : Check conditional mandatory
                if ($param->mandatory) {
                    if (empty($this->getArray($param->method)[$param->name])) {
                        $this->errorsArray[$param->name] = "empty or missing";
                        continue;
                    }
                }elseif (!isset($this->getArray($param->method)[$param->name])) {
                    continue;
                }

                //Get value from the good array
                $formValue = $this->getArray($param->method)[$param->name];

                /*
                    Check values
                */
                switch ($param->allowedValueType) {
                    case AllowedValueType::List:
                        $values = $param->allowedValues;

                        if (!in_array($formValue, $values)) {
                            $this->errorsArray[$param->name] = "value not allowed";
                        }

                        break;

                    case AllowedValueType::Regex:
                        $pattern = $param->allowedValues;

                        if (!preg_match($pattern, $formValue)) {
                            $this->errorsArray[$param->name] = "value not allowed";
                        }

                        break;

                    case AllowedValueType::Array:
                        if (!is_array($formValue)) {
                            $this->errorsArray[$param->name] = "value not allowed";
                        }

                        break;

                    case AllowedValueType::All:
                        //All values are allowed
                        break;

                    default:
                        throw new Exception('Unknown allowed value type (' . $param->name . ')');
                        break;
                }
            }

            //Define result
            $this->validated = empty($this->errorsArray);

            //Return result
            return $this->validated;
        }

        public function getJson() : string{
            return json_encode(array(
                'errors' => $this->errorsArray,
                'result' => $this->validated
            ));
        }

        function getArray(int $type) : array{
            switch ($type) {
                case FormSubmitMethod::GET:
                    return $this->form->get;
                    break;

                case FormSubmitMethod::POST:
                    return $this->form->post;
                    break;
                
                default:
                    throw new Exception("Method not supported", 1);
                    break;
            }
        }
    }
?>