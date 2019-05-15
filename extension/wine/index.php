<?php include "component/header.php";?>
<div class="container-fluid">

<div class="row">
		<div class="col-md-4">
			<div class="col-md-12">

			<div class="form-group">
			<select class="form-control" name="type" id="type">
				<option value='customer'>Customer</option>
				<option value='internal'>Internal User</option>
				<option value='owner'>Owner</option>
			</select>
			</div>
			</div>
			<div class="col-md-12">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">RFS Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 rfs-balance">0</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
			</div>
			<br>
			<div class="col-md-12">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">TR Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 tr-balance">0</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
               
          
		 

		</div>

		<div class="col-md-8">
		<div class="panel">
		 <div class="panel-body">

			 <table class="table report-t table table-condensed table-striped">
				 <tbody>
					 <tr>
						 <td class='text-bold text-danger'>INFO</td>
						 <td class='text-right text-bold text-danger'>PRICE</td>
						 <td></td>
					 </tr>
					 <tr>
						 <td><span>Deposit/Gtd Card &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold deposit'>0</span><br></td>
						 <td>B</td>
					 </tr>
					 <tr>
						 <td><span>Recharge/Charge &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold charge'>0</span><br></td>
						 <td>B</td>
					 </tr>
					 <tr>
						 <td><span>Card refund/Deposit Refund &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold refund'>0</span><br></td>
						 <td>B</td>
					 </tr>
					 <tr>
						 <td><span>Consumption at Tap/TASTE &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold taste'>0</span><br></td>
						 <td>B</td>
					 </tr>
					 <tr>
						 <td><span>Administrative deposit earned/Terminated &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold earn'>0</span><br></td>
						 <td>B</td>
					 </tr>
					 <tr>
						 <td><span>TR Earn &nbsp; &nbsp; </span> </td>
						 <td class='text-right'><span class='text-bold tr-earn'>0</span><br></td>
						 <td>B</td>
					 </tr>
					
				 </tbody>

			 </table>
		 
		 </div>
		
	 </div> 
	 
	 	<div class="row">
			 <div class="col-md-12">
				 <span class='text-bold'><i class="fa fa-calendar" aria-hidden="true"></i> Filter By Date</span>
			 <input type="text" class='date text-center date_from' name="from_date" value='<?php echo date('01/01/2016'); ?>' >
			 <input type="text" class='date text-center date_to' name="to_date" value='<?php echo date('d/m/Y'); ?>'>
			<span class="badge badge-danger refresh pull-right pointer"><i class="fa fa-refresh" aria-hidden="true"></i> Reset Filter</span>
			 </div><br><br>
		 </div>
		
		</div>
	</div>




<!-- card Detail -->

<div class="row">

 <div class="col-md-12">
	 <div class="panel">
		 <div class="panel-heading">
			 Report Detail
		 </div>
		 <div class="panel-body">
			<div class="table-responsive">
			 <table class="table report-t table table-condensed table-striped table-bordered">
				 <tbody class='head'>
					<tr>
						<td class='text-bold text-success'>Card Buy Date</td>
						<td class='text-bold text-success'>
						<select class="card_id" style='width:100%; display:none'></select>
						</td>
						<td class='text-bold text-success'>
						<select class="card_owner" style='width:100%; display:none'></select>
						</td>
						<td class='text-center text-danger text-bold'>Taste</td>
						<td class='text-center text-danger text-bold'>Charge</td>
						<td class='text-center text-danger text-bold'>Deposit</td>
						<td class='text-center text-danger text-bold'>Refund</td>
						<td class='text-center text-danger text-bold'>Earn</td>
						<td class='text-center text-danger text-bold'>TR Earn</td>
					</tr>
				 </tbody>
				 <tbody id='detail_output'>
					
				 </tbody>

			 </table>
			 </div>
		 </div>
	 </div>
 </div>
</div>

</div>
<?php include "component/footer.php";
	  include "index_script.php";
?>
