# Form-validation-php

# How to use it

## Include the files
You will need to include two things :

### Php
Add a require statement at the top of your html page to the `form-validation.php` file at the root of the form-validation folder, this file will then include all the needed files for the form-validation system to work properly.

### Header files
Add an include or require statement in the `header` section of your html page to the `include` file at the root of the form-validation folder, this file will add the css and js to your html page.

## HTML

### Form
To use the form validation with a form you need to set the action and method properties of the form and add the `onsubmit` property with the following : `onsubmit="validateForm(event, this)"`

### Field
To display errors correctly, you need to set and id with the name of the field and '-error' like for example : 
 - `rolNom` errors will be displayed with a class added to the element with id `rolNom-error`

Code example :

    <input type="text" class="form-control" id="rolNom-error" name="rolNom">

## PHP

Create a new instance of the `FormValidator` class with two parameters :

 - The first one is the form represented by an instance of the `Form` class. When creating a new instance of form you will need to give the two params arrays, for example : 
 `new  Form(get: $_GET, post: $_POST)`.
 
 - The second one is the array of `FormParam` passed as a variadic param. Here's an example : 
 ```
 ...array(
	new  FormParam(
		name: 'rolNom',
		method: FormSubmitMethod::POST,
		mandatory: true,
		allowedValueType: AllowedValueType::Regex,
		allowedValues: '/^.+/'
	),
	new  FormParam(
		name: 'permissions',
		method: FormSubmitMethod::POST,
		mandatory: true,
		allowedValueType: AllowedValueType::Array
	),
	new  FormParam(
		name: 'idRole',
		method: FormSubmitMethod::GET,
		mandatory: false,
		allowedValueType: AllowedValueType::Regex,
		allowedValues: '/^\d+/'
	)
)
```

## Example

Here's a full code example :
```
$formValidator = new  FormValidator(
	new  Form(get: $_GET, post: $_POST),
	...array(
		new  FormParam(
			name: 'rolNom',
			method: FormSubmitMethod::POST,
			mandatory: true,
			allowedValueType: AllowedValueType::Regex,
			allowedValues: '/^.+/'
		),
		new  FormParam(
			name: 'permissions',
			method: FormSubmitMethod::POST,
			mandatory: true,
			allowedValueType: AllowedValueType::Array
		),
		new  FormParam(
			name: 'idRole',
			method: FormSubmitMethod::GET,
			mandatory: false,
			allowedValueType: AllowedValueType::Regex,
			allowedValues: '/^\d+/'
		)
	)
);

$formResult = $formValidator->validate();

echo($formValidator->getJson());

die();
```
