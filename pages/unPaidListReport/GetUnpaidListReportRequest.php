<?php 
  include("../../config.php");
    //section for fetching Reports from databes by district adn area id
   if(isset($_POST["area_id"])&& isset($_POST['district_id']))
    { 
     $district_id=$_POST['district_id'];
     $area_id=$_POST['area_id'];
     $sql="SELECT *
     FROM `collectionListView` WHERE `DISTRICT_ID`=:dis_id AND `AREA_ID`=:ar_id AND `COLLECTION_ON_DATE`<CURRENT_DATE" ;
     $stmt=$conn->prepare($sql);
     $stmt->bindParam("dis_id",$district_id);
     $stmt->bindParam("ar_id",$area_id);
     $stmt->execute();
     $reports_by_district_fetch=$stmt->fetchAll(PDO::FETCH_ASSOC);
     $total_amount=0;
     $total_balance=0;
        foreach($reports_by_district_fetch as $sno=> $collection_list)
        {     
            $date_today=date("Y-m-d");
            $due_date=$collection_list['COLLECTION_ON_DATE'];
            $total_amount=$total_amount+$collection_list['LN_TAB_TOTAL_AMOUNT'];
            $total_balance=$total_balance+$collection_list['LN_TAB_BALANCE_AMOUNT'];
            $difference_date=round(abs(strtotime($date_today) - strtotime($due_date))/86400);
                                 if($difference_date<=7)
                                 {
                                     $status="success";
                                     $unpaidFor=$difference_date."-days";
                                 }
                                 elseif($difference_date<=14)
                                 {
                                     $status="info";
                                     $unpaidFor=$difference_date."-days";
                                 }
                                 elseif($difference_date<=21)
                                 {
                                     $status="warning";
                                     $unpaidFor=$difference_date."-days";
                                 }
                                 elseif($difference_date<=26)
                                 {
                                     $status="danger";
                                     $unpaidFor=$difference_date."-days";
                                 }
                                 else
                                 {
                                    $status="danger";
                                    $unpaidFor=$difference_date."-days";
                                 }
            $report.='
            <tr>
                        <td>'.++$sno.'</td>
                        <td>'.$collection_list['CUSTOMER_ID'].'</td>
                        <td>'.$collection_list['CUSTOMER_FIRST_NAME'].'</td>
                        <td>'.$collection_list['DISTRICT_NAME'].'</td>
                        <td>'.$collection_list['AREA_NAME'].'</td>
                        <td>'.$collection_list['LN_TAB_TOTAL_AMOUNT'].'</td>
                        <td>'.$collection_list['COLLECTION_BALANCE_AMOUNT'].'</td>
                        <td>'.$collection_list['COLLECTION_ON_DATE'].'</td>
                        <td><span class="badge bg-'.$status.'">'.$unpaidFor.'</span></td>
                        </tr>';
           
        }
        // var_dump($report);
        $data=["report"=>$report,"total"=>$total_amount,"balance"=>$total_balance];
        echo json_encode($data);
    }
    else
    {
        echo "NOT A VALID DISTRICT OR AREA";
    }