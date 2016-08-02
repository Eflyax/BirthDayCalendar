<?php


\Nette\Application\UI\Form::extensionMethod('addDatePicker', function(\Nette\Application\UI\Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\DatePicker($label, $cols, $maxLength);
});

\Nette\Application\UI\Form::extensionMethod('addDateTimePicker', function(\Nette\Application\UI\Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\DateTimePicker($label, $cols, $maxLength);
});

/*Nette\Object::extensionMethod('Nette\Forms\Container::addFormFiller', function($form, $name, $label = NULL){
    $form[$name] = new \FormFiller($label);
});*/

Nette\Object::extensionMethod('Nette\Forms\Container::addFormFiller', function($form, $name, $inputs = NULL, $form_name = null){
    $form[$name] = new \FormFiller($inputs, $form_name);
});


/*
Form::extensionMethod('addDateTimePicker', function(Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\DateTimePicker($label, $cols, $maxLength);
});

Form::extensionMethod('addTbDatePicker', function(Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\TbDatePicker($label, $cols, $maxLength);
});

Form::extensionMethod('addTbDateTimePicker', function(Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\TbDateTimePicker($label, $cols, $maxLength);
});*/

