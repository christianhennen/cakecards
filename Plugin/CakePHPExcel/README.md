CakePHPExcel
============

A plugin that makes exporting data to Excel (XLSX) spreadsheets easier than ever. This plugin is built off of [segy's CakePHP Helper](https://github.com/segy/PhpExcel) and the php library [PHPExcel](http://phpexcel.codeplex.com/).

Note: This plugin is for CakePHP 2.x

## Example Usage

### Load the PHPExcel vendor library

It's setup to work with Composer, so add the following to your composer.json file.

```
"PHPOffice/PHPExcel": "~1.7",
```

### Config/Bootstrap.php

Make sure your plugin CakePHPExcel is in the app/Plugin directory.

```
CakePlugin::load('CakePHPExcel');
```

Loading all plugins: If you wish to load all plugins at once, use the following line in your app/Config/bootstrap.php file

```
CakePlugin::loadAll();
```

### Controller

Add the helper to the controller that you'd like to use it with.

```
public $helpers = array('CakePHPExcel.PhpExcel'); 
```

### View

Create a view file and add the following information.

```
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
	array('label' => __('User'), 'width' => 'auto', 'filter' => true),
	array('label' => __('Type'), 'width' => 'auto', 'filter' => true),
	array('label' => __('Date'), 'width' => 'auto'),
	array('label' => __('Description'), 'width' => 50, 'wrap' => true),
	array('label' => __('Modified'), 'width' => 'auto')
);

// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

// data
foreach ($data as $d) {
	$this->PhpExcel->addTableRow(array(
		$d['User']['name'],
		$d['Type']['name'],
		$d['User']['date'],
		$d['User']['description'],
		$d['User']['modified']
	));
}

$this->PhpExcel->addTableFooter();
$this->PhpExcel->output();
```
