
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Active Consultant";
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
    Report Name : ACTIVE CONSULTANTS REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
         $datacon = $this->dataStore('CONSULTANTACTIVEREPORT');
         $datatype = $this->dataStore('DISTRIBUTORTYPE');
         $datascheme = $this->dataStore('CONSULTANTSCHEME');
         $datalicense = $this->dataStore('CONSULTANTLICENSE');
         $newArrayDept = array();
         $newArrayApp = array();
         $newArrayScheme = array();
         foreach($datatype as $row2)
         {
             $newArrayDept[] = array(
                                'DISTID' => $row2['DIST_ID'],
                                'TYPENAME' => $row2['DIST_TYPE_NAME'],
             );
         }
      
         // foreach($datalicense as $row7)
         // {
         //     $newArrayScheme[] = array(
         //                        'DIST_NAME' => $row7['DIST_NAME'],
         //                        'CONSULTANT_TYPE_ID' => $row7['CONSULTANT_TYPE_ID'],
         //                        'CONSULTANT_ID' => $row7['CONSULTANT_ID'],
         //                        'DISTRIBUTOR_ID' => $row7['DISTRIBUTOR_ID'],
         //                        'REGDATE' => $row7['REGDATE'],
         //     );
         // }
        
         $newArrayCon = array();
         $uts = "";
         $prs = "";
         $consID = array();
         $conPRSID = array();
         $consStatusTag = array();
         foreach($datacon as $row)
         {
             
             $respectiveSchemeNames = array();
             $respectiveUTSDISTRIBUTOR = "";
             $respectivePRSDISTRIBUTOR = "";
             $respectiveUtsNames = array();
             $respectivePrsNames = array();
             $reqdateuts = "";
             $reqdateprs = "";
             $regdate = "";
             $regdate1 = "";
             foreach($datalicense as $object){
                 // echo "<pre>";
                 //    echo $object['CONSULTANT_ID'];
                 //     echo "</pre>";
                 if($row['CID'] == $object['CONSULTANT_ID']){
                     // Consultant Type
                     if($object['CONSULTANT_TYPE_ID'] == 1)
                     {
                         $respectiveUTSDISTRIBUTOR =  $object['DIST_NAME'];
                        
                       //$reqdateuts = $object['REGDATE'];
                        
                         
                         foreach($newArrayDept as $dj1){
                             if( $dj1['DISTID'] == $object['DISTRIBUTOR_ID']){
                                // echo $dj1['DISTID'];
                             $respectiveUtsNames[] = $dj1['TYPENAME'];
                             }
                            }
                           // $respectiveSchemeNames[] = "UTS";
      
                            foreach($datascheme as $dj){
                             if( $dj['SCHEMEID'] == $object['CONSULTANT_TYPE_ID']){
                                 $respectiveSchemeNames[] = $dj['TYPE_SCHEME'];
                            }
                         }
                     }
                     if($object['CONSULTANT_TYPE_ID'] == 2)
                     {
                         $respectivePRSDISTRIBUTOR =  $object['DIST_NAME'];
                         //$reqdateprs = $object['REGDATE'];
                        
                         foreach($newArrayDept as $dj1){
                             if( $dj1['DISTID'] == $object['DISTRIBUTOR_ID']){
                                // echo $dj1['DISTID'];
                             $respectivePrsNames[] = $dj1['TYPENAME'];
                             }
                            }
                           // $respectiveSchemeNames[] = "PRS";
                            foreach($datascheme as $dj){
                             if( $dj['SCHEMEID'] == $object['CONSULTANT_TYPE_ID']){
                                 $respectiveSchemeNames[] = $dj['TYPE_SCHEME'];
                            }
                         }
                     }
                     // Distributor Type
                    
      
                 }
             }
      
            if(isset($row['REGDATE'])){
               $regdate =  date("d-M-Y", strtotime($row['REGDATE']));
          }
             
      
             if($row['CMSRL'] == 1){
                 $status = "Completed";
             }
             else  if($row['CMSRL'] == 0){
                 $status =  "In-Progess";
             }
             else{
                 $status = "";
             }
                 $newArrayCon[] =  array( 
                                      //'ID' => $row['CID'],
                                      'NAME' => $row['CNAME'],
                                      'NRIC' => $row['NRIC'],
                                      'FIMM NO' => $row['FIMMNO'],
                                       'CONSULTANT TYPE' => implode(' & ', $respectiveSchemeNames),
                                       'UTS-DISTRIBUTOR' =>  $respectiveUTSDISTRIBUTOR,
                                       'UTS-TYPE' => implode(', ', $respectiveUtsNames),
                                       'UTS-REGISTRATION DATE(FIMM)' => $regdate,
                                       'UTS-REGISTRATION DATE(DISTRIBUTOR)' => $regdate, //$regdate,
                                       'PRS-DISTRIBUTOR' => $respectivePRSDISTRIBUTOR,
                                       'PRS-TYPE' => implode(', ', $respectivePrsNames),
                                       'PRS-REGISTRATION DATE(FIMM)' => $regdate,//$regdate1,
                                       'PRS-REGISTRATION DATE(DISTRIBUTOR)' => $regdate,//$regdate1,
                                       'CMSRL NO.' => $row['CMSRL_NO'],
                                       'AP STATUS' => $status,
                                       'AP EXPIRE' => $row['CMSRL_EXPIRE_DATE'],
                                       'CPD POINT' => $row['CPD_POINT'],
                                  );
           }
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "complexHeaders" => true,
            "headerSeparator" => "-",
            "options"=>array(
                "order"=>array(
                   array(0,"desc"), //Sort by first column desc
                  // array(1,"asc"), //Sort by second column asc
               ),
           ),
        ));
        ?>
    </div>

</div>

