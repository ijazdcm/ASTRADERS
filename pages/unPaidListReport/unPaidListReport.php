<?php 
    include_once("./assets/css_links.php");
    //adding a database config file
    include_once ("./config.php");
   
   //section to fetch collection unpaidList report form databse 
   $sql = "SELECT * FROM collectionListView";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $collection_report_fecthed = $stmt->fetchAll(PDO::FETCH_ASSOC);
   //end section to fetch collection unpaidList report form databse  
   $total_balance=0;
   
    foreach ($collection_report_fecthed as $key => $collection) {
        
        $total_balance+=$collection['SALE_TOTAL_AMOUNT'];
        
    }
   
   
 ?>
<!-- styles for loader -->
<style>
  .lds-hourglass {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
  }
  .lds-hourglass:after {
    content: " ";
    display: block;
    border-radius: 50%;
    width: 0;
    height: 0;
    margin: 8px;
    box-sizing: border-box;
    border: 32px solid red;
    border-color: red transparent red transparent;
    animation: lds-hourglass 1.2s infinite;
  }
  @keyframes lds-hourglass {
    0% {
      transform: rotate(0);
      animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    }
    50% {
      transform: rotate(900deg);
      animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    100% {
      transform: rotate(1800deg);
    }
  }
  
</style>
<!--end styles for loader -->
<div class="content-wrapper" style="min-height: 1419.6px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="container">
                <!-- <div class="row">
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>FROM DATE:</label>
                            <div class="input-group date"  >
                                <input type="date" id="from_date_sale_report" class="form-control">
                                <div class="input-group-append" >
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>TO DATE:</label>
                            <div class="input-group date" >
                                <input type="date" class="form-control"  id="to_date_sale_report">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="report_total">TOTAL BALANCE AMOUNT</label>
                            <input type="text" class="form-control" id="sales_report_total" value="<?php echo $total_balance; ?>" placeholder="TOTAL BALANCE AMOUNT" disabled>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="report_total">CASH ON</label>
                            <input type="text" class="form-control" id="sales_report_on_cash" value="<?php echo $net_cash; ?>" placeholder="TOTAL" disabled>
                        </div>
                    </div>
                </div> -->
               <h3>UNPAID LIST REPORT</h3> 
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped" id="unpaidListReportTable">
                    <thead>
                        <tr role="row">
                            <th>S.NO</th>
                            <th>CUSTOMER ID</th>
                            <th>F-NAME</th>
                            <th>TOTAL AMOUNT</th>
                            <th>BALANCE AMOUNT</th>
                            <th>DUE DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="sales_report_insert">
                        <?php 
                       
                       $status="";
                       $unpaidFor="";
                      
                      foreach($collection_report_fecthed  as $sno=> $collection_list)
                      {
                           $date_today=date("Y-m-d");
                           $due_date=$collection_list['COLLECTION_ON_DATE'];
                        //    var_dump($due_date);
                            
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
                            

                       echo '<tr>
                        <td>'.++$sno.'</td>
                        <td>'.$collection_list['CUSTOMER_ID'].'</td>
                        <td>'.$collection_list['CUSTOMER_FIRST_NAME'].'</td>
                        <td>'.$collection_list['LN_TAB_TOTAL_AMOUNT'].'</td>
                        <td>'.$collection_list['COLLECTION_BALANCE_AMOUNT'].'</td>
                        <td>'.$collection_list['COLLECTION_ON_DATE'].'</td>
                        <td><span class="badge bg-'.$status.'">'.$unpaidFor.'</span></td>
                        </tr>';
                        
                      }
                     ?>
                    </tbody>
                </table>
            </div>
            <!-- /.content -->
        </div>
        <?php
  include_once("./assets/js_links.php");
?>