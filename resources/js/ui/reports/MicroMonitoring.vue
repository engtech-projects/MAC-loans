<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Micro Monitoring</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Date: </span>
				<input v-model="filter.date" type="month" class="form-control">
			</div>
			<!-- <div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input v-model="filter.date_to" type="date" class="form-control">
			</div> -->
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">MICRO MONITORING - BY CENTER</span>
					<div class="flex-1" style="padding-left:24px">
						<span class="text-primary-dark mr-10">Tuesday 12/21/2021</span>
						<span class="text-primary-dark">Time: 11:36 AM</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="mr-5">From:</span><span class="mr-16">12/14/2021</span>
					<span class="mr-5">To:</span><span>12/15/2021</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-45">
				<table class="table table-thin table-bordered tv-center mb-24">
					<thead style="font-size:12px">
						<tr>
							<th colspan="6">MICRO GROUP MONITORING</th>
							<th v-for="(w, i) in tranSched" :key="w.start" colspan="2">Week {{parseInt(i) + 1}}</th>
							<th rowspan="2">Total Amt.</th>
						</tr>
						<tr>
							<th>#</th>
							<th>Center</th>
							<th>No. Clients</th>
							<th>Active</th>
							<th>Areas of Ope.</th>
							<th>Sched</th>
							<th v-for="(s, i) in schedHeader" :key="i">{{s}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(m, i) in monitoring" :key="i" :class="m[0]==''?'td-nb text-bold bg-yellow-pale':''">
							<td v-for="(j, k) in m" :key="k">{{j}}</td>
						</tr>
						<!-- <tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr> -->
						<!-- <tr>
							<td>3</td>
							<td>Chemo</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Papaya</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Plum</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Chico</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Walnut</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>8</td>
							<td>Durian</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Physalis</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Longan</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Chemo</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Papaya</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Plum</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Chico</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Walnut</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>8</td>
							<td>Durian</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Physalis</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Longan</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Chemo</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Papaya</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Plum</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Chico</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Walnut</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>8</td>
							<td>Durian</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Physalis</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Longan</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Chemo</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Papaya</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Plum</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Chico</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Walnut</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>8</td>
							<td>Durian</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Physalis</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Longan</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Chemo</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Papaya</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Plum</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Chico</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Walnut</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>8</td>
							<td>Durian</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Physalis</td>
							<td>13</td>
							<td>7</td>
							<td>MJ Santos</td>
							<td>MONDAY</td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr>
						<tr class="td-nb text-bold bg-yellow-pale">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>3</td>
							<td>452</td>
							<td>1</td>
							<td>421</td>
							<td>3</td>
							<td>541</td>
							<td>5</td>
							<td>412</td>
							<td>7</td>
							<td>845</td>
							<td>5452</td>
						</tr> -->
					</tbody>
				</table>


				<table class="table table-thin td-nb td-br table-bordered tv-center">
					<thead>
						<tr>
							<th colspan="4">MICRO INDIVIDUAL COLLECTION MONITORING</th>
							<th>Week 1</th>
							<th>Week 2</th>
							<th>Week 3</th>
							<th>Week 4</th>
							<th>Week 5</th>
							<th rowspan="2">Total Amount Collected</th>
						</tr>
						<tr>
							<th>#</th>
							<th>Name of Client</th>
							<th>Areas of Ope.</th>
							<th>Schedule</th>
							<th>Dec 1-3</th>
							<th>Dec 8-10</th>
							<th>Dec 13-17</th>
							<th>Dec 20-24</th>
							<th>Dec 27-31</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Burias, Jeanette C.</td>
							<td>Bonbon</td>
							<td>THURSDAY</td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr class=" text-bold bg-yellow-pale">
							<td>SUBTOTAL</td>
							<td></td>
							<td></td>
							<td></td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
						<tr>
							<td style="padding:3px!important"></td>
						</tr>
						<tr class=" text-bold bg-green-mint">
							<td>TOTAL SUMMARY</td>
							<td></td>
							<td></td>
							<td></td>
							<td>200</td>
							<td>200</td>
							<td>500</td>
							<td>522</td>
							<td>451</td>
							<td>1873</td>
						</tr>
					</tbody>
				</table>
				<div class="d-flex flex-row justify-content-end mb-24">
					<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
					<a href="#" class="text-green text-md text-bold">Next Page</a>
				</div>
			</section>
			<section class="d-flex flex-row mb-72">
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
			<span class="flex-1"></span>
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
	props:['token', 'branch'],
	data(){
		return {
			transactions:{schedule:[],group:[]},
			filter:{
				date:'',
				branch_id:'',
			}
		}
	},
	methods:{
		async fetchTransactions(){
			await axios.post(this.baseURL() + 'api/report/micro', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.transactions = response.data.data;
				console.log(response.data.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	},
	computed:{
		tranSched:function(){
			var data = [];
			for(var i in this.transactions.schedule){
				if(this.transactions.schedule[i].start){
					data.push(this.transactions.schedule[i])
				}
			}
			return data;
		},
		schedHeader:function(){
			var sched = [];
			this.tranSched.forEach(t=>{
				sched.push('Active');
				sched.push(this.dateToHalfMonth(new Date(t.start)) + '.' + new Date(t.start).getDate() + '-' + new Date(t.end).getDate());
			})
			return sched;
		},
		groupTransaction:function(){
			var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
			var group = {};
			days.forEach(d=>{
				for(var i in this.transactions.group){
					if(d == i){
						group[d]=this.transactions.group[i];
					}
				}
			})
			console.log(group);
			return  group;
		},
		monitoring:function(){
			var data = [];
			for(var i in this.groupTransaction){
				var count = 1;
				var totalRow = ['','','','','',''];
				var c = 6;
				var coll = 0;
				for(var p in this.groupTransaction[i]){
					var row = [];
					var weekly = this.groupTransaction[i][p].weeklyData;
					var collection = 0
					row.push(count);
					row.push(p);
					row.push(this.groupTransaction[i][p].all.no_of_clients);
					row.push(this.groupTransaction[i][p].all.num_of_payments);
					row.push('');
					row.push(i.toUpperCase());
					for(var w in weekly){
						totalRow[c] = !totalRow[c]?0:totalRow[c];
						collection += parseFloat(weekly[w].total_paid);
						row.push(weekly[w].num_of_payments);
						totalRow[c] += parseFloat(weekly[w].num_of_payments);
						c++;
						row.push(weekly[w].total_paid);
						totalRow[c] += parseFloat(weekly[w].total_paid);
					}
					coll += collection;
					row.push(collection);
					count++;
					data.push(row);
				}
				totalRow[totalRow.length - 1] = coll;
				data.push(totalRow);
			}
			return data;
		}
	},
	watch:{
		'filter.date'(){
			this.fetchTransactions();
		}
	},
	mounted(){
		this.filter.branch_id = this.branch;
		this.filter.date = '2022-10';
	}
}
</script>