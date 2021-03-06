<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link href="<?=BASE?>assets/css/core.css" rel="stylesheet">
</head>
<body class="bg-white">
	<div class="container">
		<div class="card p-5">
			<div class="card-body">

				<div class="heading">
					<div class="mb-4">
						<img src="<?=BASE?>assets/images/favicon.png">
						<p class="d-inline-block">
							SmartPanel
						</p>
					</div>

					<div style="">
						<address style="text-align: right; padding: 10px;">
							SmartPanel <br>
							Address, Office Street <br>
							State, 1222 <br>
							Country
						</address>
					</div>
				</div>

				<div class="p-4 bg-light rounded mb-4">
					<h4>Invoice #123456</h4>
					<p>Date: Saturday, January 30th, 2021</p>
					<p class="mb-0">Due Date: Saturday, January 30th, 2021</p>
				</div>

				<div class="p-4 mb-4">
					<h4>Invoice To</h4>
					<p>Name: Taofeek Wahab</p>
					<p>Email: user@yahoo.com</p>
					<p class="mb-0">Phone: 0908637483922</p>
				</div>

				<table class="table table-striped mb-5">
					<thead>
						<tr>
							<th>
								Description
							</th>
							<th>
								Total
							</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore.
							</td>

							<td>
								$444444444
							</td>
						</tr>

						<tr>
							<td class="">
								<p>Sub Total</p>
							</td>
							<td>$555555 USD</td>
						</tr>

						<tr>
							<td>Client Total</td>
							<td>$555555 USD</td>
						</tr>

						<tr>
							<td>Total</td>
							<td>$555555 USD</td>
						</tr>
					</tbody>
				</table>

				<h4 class="mt-5">Transaction</h4>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>
								Date
							</th>
							<th>
								Gateway
							</th>
							<th>
								ID
							</th>
							<th>
								Amount
							</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>
								 Saturday, January 30th, 2021
							</td>

							<td>
								PayPal
							</td>

							<td>
								12345567889909876545666
							</td>

							<td>
								$34.000 USD
							</td>
						</tr>

						<tr>
							<td colspan="3">
								Balance
							</td>

							<td>
								$34.000 USD
							</td>
						</tr>
					</tbody>
				</table>


			</div>
		</div>
	</div>
</body>
</html>