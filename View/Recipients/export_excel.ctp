<?php
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Recipients'));

$recipientsHeadings = array(
    array('label' => __('Prename'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Surname'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Salutation'), 'width' => 'auto'),
    array('label' => __('Card text'), 'width' => 'auto'),
    array('label' => __('Card type'), 'width' => 'auto'),
    array('label' => __('E-Mail address'), 'width' => 'auto')
);
$this->PhpExcel->addTableHeader($recipientsHeadings, array('name' => 'Cambria', 'bold' => true));

foreach ($recipients as $recipient):

    $this->PhpExcel->addTableRow(array(
        $recipient['Recipient']['prename'],
        $recipient['Recipient']['surname'],
        $recipient['Recipient']['salutation'],
        $recipient['Text']['name'],


        $recipient['Card']['description'],
        $recipient['Recipient']['email']
    ));

endforeach;
unset($recipient);

$this->PhpExcel->addTableFooter();


$this->PhpExcel->xls->createSheet();
$this->PhpExcel->xls->setActiveSheetIndex(1);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Card texts'));
$this->PhpExcel->setRow(1);
$table = array(
    array('label' => __('Name'), 'width' => 'auto'),
    array('label' => __('Text'), 'width' => 'auto'),
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

foreach ($texts as $text):

    $this->PhpExcel->addTableRow(array(
        $text['Text']['name'],
        $text['Text']['text'],
    ));

endforeach;
unset($text);

$this->PhpExcel->addTableFooter();

$this->PhpExcel->xls->setActiveSheetIndex(0);

$this->PhpExcel->output(date("Y-m-d H:i:s") . '.xlsx');