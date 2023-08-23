<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<form @submit.prevent="fetchReport">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Performance Report</span>
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input type="date" class="form-control">
			</div> -->
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Date: </span>
				<input v-model="filter.date" type="date" required class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center justify-content-start">
				<button class="btn btn-primary">Generate</button>
			</div>	
		</div>
		</form>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">PERFORMANCE REPORT</span>
					<!-- <div class="flex-1" style="padding-left:24px">
						<span class="text-primary-dark mr-10">Tuesday 12/21/2021</span>
						<span class="text-primary-dark">Time: 11:36 AM</span>
					</div> -->
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
                        <current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
                        <span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
                    </div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">All Branches</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="text-center text-primary-dark text-bold">As of {{filter.date?dateToMDY2(new Date(filter.date)).split('-').join('/'):'---'}}</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-45">
				<i v-if="!processedReports.length">No records found.</i>
				<div v-for="c,i in processedReports" :key="i">
					<span class="text-bold bg-yellow-light text-block" style="padding:2px 5px;">{{c.name.toUpperCase()}}</span>
					<table class="table td-nb table-stripped table-thin" style="font-size:13px">
						<thead>
							<tr>
								<th>Area</th>
								<th>Year</th>
								<th></th>
								<th>January</th>
								<th></th>
								<th>February</th>
								<th></th>
								<th>March</th>
								<th></th>
								<th>April</th>
								<th></th>
								<th>May</th>
								<th></th>
								<th>June</th>
								<th></th>
								<th>July</th>
								<th></th>
								<th>August</th>
								<th></th>
								<th>September</th>
								<th></th>
								<th>October</th>
								<th></th>
								<th>November</th>
								<th></th>
								<th>December</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="rows,j in c.rows" :key="j" :style="rows[0]!=''?'border-top:1px solid #dee2e6!important':''">
								<td v-for="row,k in rows" :key="k">{{row}}</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td v-for="ttl, l in c.total" :key="l">{{l>1&&l%2!=0?formatToCurrency(ttl):ttl}}</td>
							</tr>
						</tbody>
						<!-- <tbody>
							<tr>
								<td>Butuan</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Nasipit</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Gingoog</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td></td>
								<td>300,000.00</td>
								<td>2021</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>166000</td>
							</tr>
						</tbody> -->
					</table>
				</div>
				
				<!-- <div>
					<span class="text-bold bg-yellow-light text-block" style="padding:2px 5px;">BITAY</span>
					<table class="table td-nb table-stripped table-thin" style="font-size:13px">
						<thead>
							<tr>
								<th>Area</th>
								<th>No. of Account</th>
								<th>Year</th>
								<th>January</th>
								<th>February</th>
								<th>March</th>
								<th>April</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Butuan</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Nasipit</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Gingoog</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td></td>
								<td>300,000.00</td>
								<td>2021</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>166000</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div>
					<span class="text-bold bg-yellow-light text-block" style="padding:2px 5px;">PASTDUE</span>
					<table class="table td-nb table-stripped table-thin" style="font-size:13px">
						<thead>
							<tr>
								<th>Area</th>
								<th>No. of Account</th>
								<th>Year</th>
								<th>January</th>
								<th>February</th>
								<th>March</th>
								<th>April</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Butuan</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Nasipit</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Gingoog</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td></td>
								<td>300,000.00</td>
								<td>2021</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>166000</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div>
					<span class="text-bold bg-yellow-light text-block" style="padding:2px 5px;">LOAN RELEASE</span>
					<table class="table td-nb table-stripped table-thin" style="font-size:13px">
						<thead>
							<tr>
								<th>Area</th>
								<th>No. of Account</th>
								<th>Year</th>
								<th>January</th>
								<th>February</th>
								<th>March</th>
								<th>April</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Butuan</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Nasipit</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Gingoog</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td></td>
								<td>300,000.00</td>
								<td>2021</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>166000</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div>
					<span class="text-bold bg-yellow-light text-block" style="padding:2px 5px;">COLLECTION</span>
					<table class="table td-nb table-stripped table-thin" style="font-size:13px">
						<thead>
							<tr>
								<th>Area</th>
								<th>No. of Account</th>
								<th>Year</th>
								<th>January</th>
								<th>February</th>
								<th>March</th>
								<th>April</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Butuan</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Nasipit</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td>Gingoog</td>
								<td>500</td>
								<td>2020</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr>
								<td></td>
								<td>500</td>
								<td>2021</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr style="border-bottom:1px solid #dee2e6">
								<td></td>
								<td>500</td>
								<td>2022</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
								<td>2000</td>
							</tr>
							<tr class="bg-green-mint text-bold">
								<td></td>
								<td>300,000.00</td>
								<td>2021</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>14000</td>
								<td>166000</td>
							</tr>
						</tbody>
					</table>
				</div> -->
				
			
			</section>
		</section>

		<div class="d-flex flex-row-reverse mb-45">
			<a href="#" class="btn btn-default min-w-150">Print</a>
			<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch', 'token'],
	data(){
		return {
			loading:false,
			branch:{},
			filter:{
				date:null,
			},
			products:[],
			centers:[],
			aos:[],
			reports:[]
		}
	},
	methods:{
		async fetchReport(){
			this.loading = true;
			this.filter.branch_id = this.branch.branch_id;
			await axios.post(this.baseURL() + 'api/report/performance-report', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.reports = this.setData(response.data.data);
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		setData:function(data){
			data['past due'] = data['portfolio'];
			data['delinquent'] = data['portfolio'];
			return data;
		},
		addDummyData:function(data){
			for(var i in data){
				var year = 2024;
				data[i]['Nasipit'] = JSON.parse(JSON.stringify(data[i]["Butuan City"]));
				for(var j=0;j<5;j++){
					var ndata = data[i]['Nasipit']['2023'];
					data[i]['Nasipit'][year] = JSON.parse(JSON.stringify(ndata));
					year++;
				}
				data[i]['Gingoog'] = JSON.parse(JSON.stringify(data[i]["Butuan City"]));
				for(var j=0;j<3;j++){
					var ndata = data[i]['Gingoog']['2023'];
					data[i]['Gingoog'][year] = JSON.parse(JSON.stringify(ndata));
					year++;
				}
				for(var j=0;j<5;j++){
					var ndata = data[i]['Butuan City']['2023'];
					data[i]['Butuan City'][year] = JSON.parse(JSON.stringify(ndata));
					year++;
				}
			}
			return data;
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	},
	computed:{
		processedReports:function(){
			var sort = ['Portfolio','Delinquent','Past Due','Releases','Collection']
			var vars = {collection:'total_collection',
						portfolio:'total_portfolio',
						releases:'total_net_proceeds',
						'past due':'total_pastdue',
						delinquent:'total_delinquent'
						};
			var vars2 = {collection:'no_of_accounts',
						portfolio:'no_of_accounts',
						releases:'no_of_accounts',
						'past due':'no_of_pastdue',
						delinquent:'no_of_delinquent'
						};
			var clusters = [];
			for(let s in sort){
				for(let i in this.reports){
					if(i.toLocaleLowerCase() == sort[s].toLocaleLowerCase()){
						var cluster = {rows:[],name:i,total:['','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]};
						var report = this.reports[i];
						for(let j in report){
							var area = report[j];
							var count = 0;
							for(let k in area){
								var row = [];
								var mcount = 2;
								var year = area[k];
								row[0] = count==0?j.toUpperCase():'';
								row.push(k);
								for(let m in year){
									let month = year[m];
									row.push(month[vars2[i]]);
									row.push(this.formatToCurrency(month[vars[i]]));
									cluster.total[mcount]+=month[vars2[i]];
									cluster.total[mcount+1]+=month[vars[i]];
									mcount+=2;
								}
								cluster.rows.push(row);
								count++;
							}
						}
						clusters.push(cluster);
					}
				}
			}
			return clusters;
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
}
</script>