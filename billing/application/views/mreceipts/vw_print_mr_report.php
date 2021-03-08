<!DOCTYPE html>
<html>
<head>
<title>Suraha | Report</title>
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
<body>
<center>

  <div style="border: 2px solid gray; border-radius: 8px; width: auto;">
      <?php if(!empty($mr_data)){ ?>

       <a onClick="window.print();return false" style="border-style: groove;">Money Receipt Report</a><br><br>
       <h2 style="margin:0;">SURAHA NURSING HOME PVT. LTD.</h2>
      <b>From: </b><?php echo $from_date; ?> &middot; <b>To:</b> <?php echo $to_date; ?> <br>
      <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')!=1) {?>
        &middot; <b>Created by: </b><?php echo $created_user; ?> &middot;
      <?php } ?>
   <?php }  else{ }?>
  <br><br>

        <table cellspacing="0" cellpadding="3" border="1" style="text-align:center;">

                <thead>
                  <tr class="textcen">
                  <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
					?>
                     <th scope="col"  colspan="7">Report</th>
                  <?php } else{ ?>
                  <th scope="col"  colspan="6">Report</th>
                  <?php } ?>
                   </tr>
                  <tr class="textcen">
                    <th>Sl</th>
                    <th>Date</th>
                    <th>Bill No</th>
                    <th>Patient's Name</th>
                    <th>Dr's Name</th>
                    <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
					?>
					    <th>Billed by</th>
					<?php } ?>
                    <th>Received Rs.</th>

                  </tr>
                </thead>
                  <tbody class="textcen">
                    <?php
                    if(!empty($mr_data)){
                      //print_obj($mr_data);die;
                      $sl=1;
                      foreach($mr_data as $key => $val){
                        ?>
                        <tr>
                          <td><?php echo $sl; ?></td>
                          <td><?php echo $val['created_dtime']; ?></td>
                          <td><?php echo $val['mr_bill_no']; ?></td>
                          <td><?php echo $val['patient_name']; ?></td>
                          <td><?php echo $val['doctor_name']; ?></td>
                          <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
                          ?>
                            <td><?php echo $val['created_user']; ?></td>
                          <?php } ?>
                          <td><?php echo $val['received_rs']; ?></td>
                        </tr>
                        <?php
                        $sl++;
                        }
                      ?>

                      <tr style="text-align:center; font-size: 15px;">
                      <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
					    ?>
                            <td colspan="6"><b>Grand Total:</b></td>
                        <?php } else{ ?>
                            <td colspan="5"><b>Grand Total:</b></td>
                        <?php }?>
                        <td><?php echo $grand_tot; ?></td>
                      </tr>
                      <?php
                    }
                    else{
                      ?>
                      <tr><td colspan="5">No data found</td></tr>
                    <?php
                      }
                    ?>
                  </tbody>
        
       </table>
		<br /> <small align="center">This is a computer generated report.</small>
    </div>
</center>
</body>
</html>	