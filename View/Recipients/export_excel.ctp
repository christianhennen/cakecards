<?php
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
$this->PhpExcel->xls->getActiveSheet()->setTitle(__('Recipients'));

$recipientsHeadings = array(
    array('label' => __('ID'), 'width' => 'auto'),
    array('label' => __('Prename'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Surname'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Salutation'), 'width' => 'auto'),
    array('label' => __('Card type'), 'width' => 'auto'),
    array('label' => __('Card text'), 'width' => 'auto'),
    array('label' => __('E-Mail address'), 'width' => 'auto')
);
$this->PhpExcel->addTableHeader($recipientsHeadings, array('name' => 'Cambria', 'bold' => true));

foreach ($recipients as $recipient):

    $this->PhpExcel->addTableRow(array(
        $recipient['Recipient']['id'],
        $recipient['Recipient']['prename'],
        $recipient['Recipient']['surname'],
        $recipient['Recipient']['salutation'],
        $recipient['Text']['card_id'],
        $recipient['Text']['id'],
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
    array('label' => __('ID'), 'width' => 'auto'),
    array('label' => __('Text'), 'width' => 'auto'),
    array('label' => __('Type'), 'width' => 'auto')
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

foreach ($texts as $text):

    $this->PhpExcel->addTableRow(array(
        $text['Text']['id'],
        $text['Text']['text'],
        $text['Text']['card_id']
    ));

endforeach;
unset($text);

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

foreach ($cards as $card):

    $this->PhpExcel->addTableRow(array(
        $card['Card']['id'],
        $card['Card']['description'],
    ));

endforeach;
unset($card);

$this->PhpExcel->addTableFooter();

$this->PhpExcel->xls->setActiveSheetIndex(0);

$this->PhpExcel->output(date("Y-m-d H:i:s") . '.xlsx');