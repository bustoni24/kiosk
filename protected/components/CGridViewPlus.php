<?php
 
Yii::import('zii.widgets.grid.CGridView');
 
class CGridViewPlus extends CGridView {
 
    public $addingHeaders = array();
 
    public function renderTableHeader() {
        //if (!empty($this->addingHeaders))
            $this->multiRowHeader();
 
        //parent::renderTableHeader();
    }
 
    protected function multiRowHeader() {
        echo CHtml::openTag('thead') . "\n";
       // foreach ($this->addingHeaders as $row) {
            $this->addHeaderRow(); //$row
        //}
        echo CHtml::closeTag('thead') . "\n";
    }
 
 	// each cell value expects array(array($text,$colspan,$options), array(...))
    protected function addHeaderRow($row = "") {
        // add a single header row
        echo '<tr style="background-color: #49afcd;color: #fff;" role="row">
            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 92px;" class="sorting_disabled" colspan="1">Tanggal</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 92px;" class="sorting_disabled" colspan="1">Nama Barang</th>
            <th colspan="2" style="text-align: center;vertical-align: middle;" rowspan="1">Diterima</th>
            <th colspan="2" style="text-align: center;vertical-align: middle;" rowspan="1">Dikeluarkan</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 71px;" class="sorting_disabled" colspan="1">Saldo</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 101px;" class="sorting_disabled" colspan="1">Exp date</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 132px;" class="sorting_disabled" colspan="1">Keterangan</th>
            </tr>
            <tr style="background-color: #49afcd;color: #fff;" role="row">
            <th style="text-align: center; vertical-align: middle; width: 107px;" class="sorting_disabled" rowspan="1" colspan="1">No. Bukti</th>
            <th style="text-align: center; vertical-align: middle; width: 112px;" class="sorting_disabled" rowspan="1" colspan="1">Kuantitas</th>
            <th style="text-align: center; vertical-align: middle; width: 107px;" class="sorting_disabled" rowspan="1" colspan="1">No. Bukti</th>
            <th style="text-align: center; vertical-align: middle; width: 113px;" class="sorting_disabled" rowspan="1" colspan="1">Kuantitas</th></tr>';
    }
 
}
?> 

