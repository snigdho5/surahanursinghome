<!DOCTYPE html>
<html>
<head>
<title>Suraha | Receipt</title>
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().'common/assets/images/favicon.png';?>">
  <!--<style type="text/css" media="print">
  @page { 
        size: landscape;
    }
    body { 
        writing-mode: tb-rl;
    }
</style>-->
</head>
<body style="font-size: 15px;" >
<center>

  <div style="border: 2px solid gray; border-radius: 8px; width: auto;">
      <?php if(!empty($inv_data)){ ?>

       <a onClick="window.print();return false" style="border-style: groove;">Invoice Cum Money Receipt</a><br><br>
      <span>Date: <?php echo $inv_data[0]['created_dtime']; ?> &middot; Bill No: <?php echo $inv_data[0]['bill_no']; ?></span><br>
       <h2 style="margin:0;">SURAHA NURSING HOME PVT. LTD.</h2>
      <b>Rameswarpur</b> &middot; <b>Kalna</b> &middot; <b>Purba Bardhaman</b> <br>
      Licence No.- <?php echo licence_no; ?> &middot; Dt.- <?php echo licence_date; ?><br>
      Estd.: 2009 &middot; Mobile: <?php echo bill_phone_no; ?><br>
      &middot; Govt. Approved &middot;
   <?php }  else{ }?>
  <br><br>

        <table cellspacing="0" cellpadding="3" border="1" style="text-align:center;">

                <thead>
                   <?php if(!empty($inv_data)){ ?>

                   <tr class="textcen">
                     <th scope="col"  colspan="4">Invoice</th>
                   </tr>

                   <tr class="textcen">
                     <th scope="col"  colspan="2">Patient's Name:<br/> <span style="font-weight: normal;"><?php echo $inv_data[0]['patient_name']; ?></span></th>
                      <th scope="col"  colspan="1">Patient's Phone:<br/> <span style="font-weight: normal;"><?php echo $inv_data[0]['patient_phone']; ?></span></th>
                     <th scope="col"  colspan="1">Under:<br/> <span style="font-weight: normal;"><?php echo $inv_data[0]['doctor_name']; ?></span></th>
                   </tr>
                    <?php }  else{ ?>
                    <th  colspan="4"><button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'invoices'; ?>'">Invoices</button></th>
                    <?php } ?>
                  <tr class="textcen">
                    <th>Sl</th>
                    <th>Group</th>
                    <th>Item</th>
                    <th>Price</th>

                  </tr>
                </thead>
                  <tbody class="textcen">
                    <?php
                    if(!empty($inv_data)){
                      //print_obj($inv_data);die;
                      $sl=1;
                      foreach($inv_data as $key => $val){
                        ?>
                        <tr style="text-align:center;">
                          <td><?php echo $sl; ?></td>
                          <td><?php echo $val['group_name']; ?></td>
                          <td><?php echo $val['item_name']; ?></td>
                          <td><?php echo $val['price']; ?></td>
                        </tr>
                        <?php
                        $sl++;
                        }
                      ?>

                      <tr style="text-align:center;">
                        <td colspan="2"></td><td><b>Discount:</b></td>
                        <td colspan="3"><?php echo $dis_data['discount']; ?></td>
                      </tr>

                      <tr style="text-align:center;">
                        <td colspan="3"><b>Gross Total:</b></td>
                        <td><?php echo $dis_data['gross_amt']; ?></td>
                      </tr>

                      <tr style="text-align:center;">
                        <td colspan="2">#MR: <?php echo $inv_data[0]['mr_billno']; ?></td>
                        <td><b>Advance:</b></td>
                        <td><?php echo $dis_data['advance']; ?></td>
                      </tr>

                      <tr style="text-align:center;">
                        <td colspan="3"><b>Net Total:</b></td>
                        <td><?php echo $dis_data['net_amt']; ?><br/> <small>(Rupees <?php echo $dis_data['net_in_words']; ?> Only)</small></td>
                      </tr>
                      <?php
                    }
                    else{
                      ?>
                      <tr><td colspan="6">No data found</td></tr>
                    <?php
                      }
                    ?>
                  </tbody>
        
       </table>
		<br /> <small align="center">This is a computer generated invoice, signature is not required.</small>
    </div>
</center>
</body>
</html>	