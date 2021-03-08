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
<body style="font-size: 15px;">
<center>
   <?php if(!empty($mr_data)){ ?>
  <div style="border: 2px solid gray; border-radius: 8px;width: auto;">
   

       <a onClick="window.print();return false" style="border-style: groove;">Money Receipt</a><br><br>
      <span>Date: <?php echo $mr_data[0]['created_dtime']; ?> &middot; Bill No: <?php echo $mr_data[0]['mr_bill_no']; ?></span><br>
       <h2 style="margin:0;">SURAHA NURSING HOME PVT. LTD.</h2>
      <b>Rameswarpur</b> &middot; <b>Kalna</b> &middot; <b>Purba Bardhaman</b> <br>
      Licence No.- <?php echo licence_no; ?> &middot; Dt.- <?php echo licence_date; ?><br>
      Estd.: 2009 &middot; Mobile: <?php echo bill_phone_no; ?><br>
      &middot; Govt. Approved &middot; 
      <br/><br/>
      <table cellspacing="0" cellpadding="3" border="1" style="text-align:center;">

        <thead>
        <?php if(!empty($mr_data)){ ?>

        <tr class="textcen">
            <th scope="col"  colspan="2">Money Receipt</th>
        </tr>

            <?php }  else{ ?>
            <th  colspan="2"><button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'moneyreceipts'; ?>'">Money Receipt</button></th>
            <?php } ?>
        </thead>
        <tbody class="textcen">
            
            <tr style="text-align:center;">
                <td><b>Receipt No:</b></td>
                <td><?php echo $mr_data[0]['mr_bill_no']; ?></td>
            </tr>

            <tr style="text-align:center;">
                <td><b>From: </b></td>
                <td><?php echo $mr_data[0]['patient_name']; ?></td>
            </tr>

            <tr style="text-align:center;">
                <td><b>Received Rs.:</b></td>
                <td> <?php echo round($mr_data[0]['received_rs']); ?>/-  <small>(Rupees <?php echo $mr_data[0]['in_words']; ?> Only)</small></td>
            </tr>

            <tr style="text-align:center;">
                <td><b>Under:</b></td>
                <td><?php echo ($mr_data[0]['doctor_name']!='')?$mr_data[0]['doctor_name']:'No doctor,'; ?> <?php echo $mr_data[0]['particulars']; ?></td>
            </tr>
           
        </tbody>

        </table>

      <p></p> <small align="center">This is a computer generated invoice, signature is not required.</small>
 
  </div><br>
  <?php }  else{ ?>
      <p>Requested receipt is not found!</p>
      <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'moneyreceipts'; ?>'">Money Receipts</button>
  <?php } ?>
          
                
		
</center>
</body>
</html>	