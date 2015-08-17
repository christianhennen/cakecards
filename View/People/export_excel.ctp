<?php

$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Recipients'));

$peopleHeadings = array(
    array('label' => __('ID'), 'width' => 'auto'),
    array('label' => __('Prename'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Surname'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Salutation'), 'width' => 'auto'),
    array('label' => __('Card type'), 'width' => 'auto'),
    array('label' => __('Card text'), 'width' => 'auto'),
    array('label' => __('E-Mail address'), 'width' => 'auto')
);
$this->PhpExcel->addTableHeader($peopleHeadings, array('name' => 'Cambria', 'bold' => true));

foreach ($people as $person):

    $this->PhpExcel->addTableRow(array(
        $person['Person']['id'],
        $person['Person']['prename'],
        $person['Person']['surname'],
        $person['Person']['salutation'],
        $person['CardText']['card_type_id'],
        $person['CardText']['id'],
        $person['Person']['email']
    ));

endforeach;
unset($person);

$this->PhpExcel->addTableFooter();


$this->PhpExcel->xls->createSheet();
$this->PhpExcel->xls->setActiveSheetIndex(1);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Card texts'));
$this->PhpExcel->setRow(1);
$table = array(
    array('label' => __('ID'), 'width' => 'auto'),
    array('label' => __('Text'), 'width' => 'auto'),
    array('label' => __('Type'), 'width' => 'auto')
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

foreach ($cardtexts as $cardtext):

    $this->PhpExcel->addTableRow(array(
        $cardtext['CardText']['id'],
        $cardtext['CardText']['text'],
        $cardtext['CardText']['card_type_id']
    ));

endforeach;
unset($cardtext);

$this->PhpExcel->addTableFooter();

$this->PhpExcel->xls->createSheet();
$this->PhpExcel->xls->setActiveSheetIndex(2);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Card types'));
$this->PhpExcel->setRow(1);
$table = array(
    array('label' => __('ID'), 'width' => 'auto'),
    array('label' => __('Description'), 'width' => 'auto'),
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

foreach ($cardtypes as $cardtype):

    $this->PhpExcel->addTableRow(array(
        $cardtype['CardType']['id'],
        $cardtype['CardType']['description'],
    ));

endforeach;
unset($cardtype);

$this->PhpExcel->addTableFooter();

$this->PhpExcel->xls->setActiveSheetIndex(0);

$this->PhpExcel->output(date("Y-m-d H:i:s") . '.xlsx');
?>
