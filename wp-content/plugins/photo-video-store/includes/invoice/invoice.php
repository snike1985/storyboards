<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$invoice_content = '<section class="invoice">
<div class="text-center bg-info" style="background-color:#d9edf7">
	<div class="text-uppercase" style="text-align:center;text-transform:uppercase"><strong>' . $invoice . '</strong></div>
</div>
	<table border="0" cellpadding="0" cellaspacing="0" style="width:100%">
		<tr valign="top">
		<td style="width:50%"><img src="' . $invoice_logo . '"></td>
		<td style="width:50%;text-align:right">
			<address style="padding-top:15px;text-align:right">
                <strong>' . $invoice_company_name . '</strong><br>
                ' . $invoice_company_address1 . '<br>
                ' . $invoice_company_address2 . '<br><br>
               	' . $invoice_company_vat . '<br/>
             </address>
         </td>
      	</tr>
	</table>
	
	<hr />

	<table border="0" cellpadding="0" cellaspacing="0" style="width:100%">
		<tr valign="top">
		<td style="width:33%">
			<address>
                <strong>' . $invoice_client_name . '</strong><br>
                ' . $invoice_client_address . '<br>
               	' . $invoice_client_vat . '<br/>
             </address>
		</td>
		<td style="width:33%;text-align:center">
			<img src="' . $invoice_paid . '" style="width:120px">
		</td>
		<td style="width:33%;text-align:right">
			' . pvs_word_lang('Invoice Number') . ': ' . $invoice_number . '<br>
			' . pvs_word_lang('Invoice Date') . ': ' . $invoice_date . '<br>
			' . pvs_word_lang('Order Number') . ': ' . $invoice_order_number . '<br>
			' . pvs_word_lang('Invoice Amount') . ': ' . $invoice_amount . '		
		</td>
	</tr>
	</table>
	
	<hr />



          <div class="row">
            <div class="col-xs-12 table-responsive">
              ' . $invoice_items . '
            </div>
          </div>
          
          <p>' . $invoice_text . '</p>
          <hr />';

			if ($invoice_payment_flag) {
              $invoice_content .= '<p><b>' . pvs_word_lang('Payment') . ':</b><br>
              ' . $invoice_payment . '
              </p>
              <img src="' . pvs_plugins_url() . '/assets/images/credit_cards.gif" style="margin-bottom:5px">';
			}

        $invoice_content .= '</section>';
 ?>