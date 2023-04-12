
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "CPD EVALUATION";
?>


<div sheet-name="<?php echo $sheet1; ?>">
    <?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => true,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
    $styleArray1 = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => false,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >
    Report Name : LIST OF EVALUATION REPORT
    </div>

    <div  cell="A2" range="A2:J2"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONTUNING PROFESSIONAL DEVELOPMENT MODULE</div>
    <div cell="A3" range="A3:J3"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div cell="A5">
        <?php
        $data_evaluation = $this->dataStore('CPDEVALUATION');
        $data_feedback = $this->dataStore('CPDEVALUATIONFEEDBACK');
        $newArray = array();
        $newArrayfeedback = array();
        $comname = "";
        $SPEAKER ="";
        $VENUE = "";
        $CONTENTS = "";
        $REFRESHMENT = "";
        $OVERALL = "";
        foreach($data_feedback as $rowFeedback)
        {
                if($rowFeedback['ITEM'] == 'SPEAKER'){
                    $SPEAKER = $rowFeedback['RATING'];
                }
               if($rowFeedback['ITEM'] == 'VENUE'){
                    $VENUE = $rowFeedback['RATING'];
                }
                if($rowFeedback['ITEM'] == 'CONTENTS'){
                    $CONTENTS = $rowFeedback['RATING'];
                }
                if($rowFeedback['ITEM'] == 'REFRESHMENT'){
                    $REFRESHMENT = $rowFeedback['RATING'];
                }
                if($rowFeedback['ITEM'] == 'OVERALL'){
                    $OVERALL = $rowFeedback['RATING'];
                }
             $newArrayfeedback[$rowFeedback['PROG_DETAILS_ID']] =  array(
                'PROG_DETAILS_ID' => $rowFeedback['PROG_DETAILS_ID'],
                'SPEAKER' => $SPEAKER,
                'VENUE' => $VENUE,
                'CONTENTS' => $CONTENTS,
                'REFRESHMENT' => $REFRESHMENT,
                'OVERALL' => $OVERALL,
                );
        }
        $SPEAKER1 ="";
        $VENUE1 = "";
        $CONTENTS1 = "";
        $REFRESHMENT1 = "";
        $OVERALL1 = "";
        foreach($data_evaluation as $row)
        {
            if($row['CATEGORY'] == 2)
            {
               $comname =  $row['COMPANY'];
            }
            else{
                $comname = $row['COMPANY1'];
            }
            foreach($newArrayfeedback as $dj){
                if( $dj['PROG_DETAILS_ID'] == $row['PROG_DETAILS_ID']){
                    $SPEAKER1 =  $dj['SPEAKER'];
                    $VENUE1 =  $dj['VENUE'];
                    $CONTENTS1 =  $dj['CONTENTS'];
                    $REFRESHMENT1 =  $dj['REFRESHMENT'];
                    $OVERALL1 =  $dj['OVERALL'];
                }
            }
                $newArray[] =  array('COMPANY' => $comname,
                                   'PROGRAM ID' => $row['PROG_CODE'],
                                   'PROGRAM TITLE' => $row['PROG_TITLE'],
                                   'DATE' => $row['PROG_DATE_START'],
                                   'VENUE' => $row['VENUE'],
                                   'SPEAKER/TRAINER' => $row['SPEAKER'],
                                   'PROGRAM CONTENT/TOPIC' => $CONTENTS1,
                                   'SPEAKER' => $SPEAKER1,
                                   'REFRESHMENT' => $REFRESHMENT1,
                                   'OVERALL' => $OVERALL1,
                                   'VENUE1' => $VENUE1,
                                 );
        }
        
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArray, $newMeta);
        Table::create(array(
            "dataSource" => $ds,
            "columns"=>array(
                "COMPANY"=>array(
                    "label"=>"COMPANY",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM ID"=>array(
                    "label"=>"PROGRAMID",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM TITLE"=>array(
                    "label"=>"TITLE",
                    "type"=>"string",
                    "searchable" => true,
                    // "cssStyle" =>'text-align:right',
                ),
                 "DATE"=>array(
                  "label"=>"DATE",
                  "type"=>"datetime",
                  "format"=>"Y-m-d H:i:s",
                  "displayFormat"=>"Y-m-d H:i:s"
                ),
             "VENUE"=>array(
                    "label"=>"VENUE",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "SPEAKER/TRAINER"=>array(
                    "label"=>"SPEAKER/TRAINER",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM CONTENT/TOPIC"=>array(
                    "label"=>"CONTENT/TOPIC",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "SPEAKER"=>array(
                    "label"=>"SPEAKER",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "REFRESHMENT"=>array(
                    "label"=>"REFRESHMENT",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "VENUE1"=>array(
                    "label"=>"VENUE",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "OVERALL"=>array(
                    "label"=>"OVERALL",
                   // "searchable" => true,
                    "type"=>"number",
                ),
            ),
        ));
        ?>
    </div>

</div>

