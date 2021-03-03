# Form-validation

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

### Display result
You can create two divs to display the result of the form, one for success and one for error. They must have `form-validation-success` and `form-validation-error` as their id respectively. Example : 

```
<div id="form-validation-success">
    <div class="alert alert-success">Role saved</div>
</div>

<div id="form-validation-error">
    <div class="alert alert-danger">Error while saving role</div>
</div>
```

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
    new FormParam(
        name: 'idRole',
        method: FormSubmitMethod::GET,
        mandatory: false,
        allowedValueType: AllowedValueType::SQL,
        allowedValues: '1',
        sqlQuery: 'SELECT COUNT(*) FROM t_role WHERE idRole = :value'
    )
)
```

## Classes

### FormParam
The `FormParam` class constructor params are the following :
 - `name` [`string`]: The name of the parameter in get or post
 - `method` [`FormSubmitMethod`] : The submit method of the parameter (for example `POST`)
 - `mandatory` [`bool`]: Is the parameter mandatory or not
 - `conditionalMandatory` [`FormParam`]: [WIP] A parameter which if is in the form then is mandatory otherwise not mandatory
 - `allowedValueType` [`AllowedValueType`]: Allowed value type 
 - `allowedValues` [`string|array`]: All the allowed values, string or array depending on `allowedValueType`
 - `sqlQuery` [`string`]: SQL query to check param in DB, only used if `allowedValueType` is SQL. The query **must** only return **one** row and **one** column

### AllowedValueType
The following values exists :
 - `All` : All values are allowed (default)
 - `List` : Only a list of values are allowed (give array in `allowedValues`)
 - `Regex` : Match a regex (give regex in `allowedValues`)
 - `Array` : The value must an array, can be empty but must be an array
 - `SQL` : Check in database (give the query in `sqlQuery`)


### FormSubmitMethod
The following values exists :
 - `GET`
 - `POST`


### Env file
The `.env.php` file is used to set the credentials for the database in the case where SQL `AllowedValueType` is used.

 - `sqlHost` : Hostname or ip address of the database server
 - `sqlDatabase` : Name of the database
 - `sqlUser` : Username of the user used to connect to database
 - `sqlPassword` : Password of the user used to connect to database


## Example

Here's a full php code example :
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
		new FormParam(
            name: 'idRole',
            method: FormSubmitMethod::GET,
            mandatory: false,
            allowedValueType: AllowedValueType::SQL,
            allowedValues: '1',
            sqlQuery: 'SELECT COUNT(*) FROM t_role WHERE idRole = :value'
        )
	)
);

$formResult = $formValidator->validate();

echo($formValidator->getJson());

die();
```