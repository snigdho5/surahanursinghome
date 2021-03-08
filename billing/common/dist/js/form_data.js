
    function get_item_name(group_id,icount)

    {

        var mode="get_item_name_by_group";

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'get_dropdowns'; ?>",
            data: {"mode":mode,"group_id":group_id},
            
            success: function(d){ 
                $('#ddl_item_id'+icount).html('hi');
                
             }
            });



    }



    function get_item_rate(item_id,icount)

    {

        var mode="get_item_rate_by_name";

        jQuery.post("index_ajax",{"mode":mode,"item_id":item_id},function(data)

        {

           jQuery('#txt_rate'+icount).val(data.trim());

        });

    }



    function get_price(qty,icount)

    {

        var rate = $('#txt_rate'+icount).val();



        if(rate==''){

            alert('Please select item!!');

            $('#txt_qty'+icount).val('');

            return false;

        }

        else

        {

            var total_rate = '';

            var total_price = '';



            var price = parseFloat(qty)*parseFloat(rate);

            $('#txt_price'+icount).val(parseFloat(price));

        }

        

    }

function get_price2(rate,icount)

    {

        var qty = $('#txt_qty'+icount).val();


        if(qty==''){

            alert('Please select item!!');

            $('#txt_rate'+icount).val('');

            return false;

        }

        else

        {

            var total_rate = '';
            var total_price = '';
			
            var price = parseFloat(qty)*parseFloat(rate);
            $('#txt_price'+icount).val(parseFloat(price));
        }


    }
	
// 	function get_tot_price(){
// 	//var tot_price_p = parseFloat(tot_price_now)+parseFloat(price);
// 			var tot_price_p = 0.0;
// 			for(var i=1;i<=25;i++)
// 			{
// 				 tot_price_p = tot_price_p + $('#txt_price'+i).val();
// 			}
// 			$('#tot_price_now').val(parseFloat(tot_price_p));
// 	}


    function get_sale_invoice(){

        var group_id = '';
        var company_id = '';
        var item_id = '';
        var qty = '';
        var rate = '';
        var price = '';
        var bill_no = $('#hd_bill_no').val();
		var name = $('#cust_name').val();
		var address = $('#cust_address').val();


        for(var i=1;i<=25;i++)

        {

            group_id = group_id + $('#ddl_group_id'+i).val() + ",";

            company_id = company_id + $('#ddl_company_id'+i).val() + ",";

            item_id = item_id + $('#ddl_item_id'+i).val() + ",";

            qty = qty + $('#txt_qty'+i).val() + ",";

            rate = rate + $('#txt_rate'+i).val() + ",";

            price = price + $('#txt_price'+i).val() + ",";

        }



        var mode="insert_sales_bill_data";

        jQuery.post('index_ajax.php',{"name":name,"address":address,"mode":mode,"bill_no":bill_no,"group_id":group_id,"company_id":company_id,"item_id":item_id,"qty":qty,"rate":rate,"price":price},function(data)

        {

            

        });



        alert('Bill Successfully Saved !!!');

        window.open('sales_invoice.php?bill_no='+bill_no,'_blank','toolbar=yes,scrollbars=yes,resizable=yes,width=800,height=800');

        location.reload();



    }

