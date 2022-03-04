<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">{{title}}</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table class="table table-stripped" id="clientsList">
			<thead>
				<th>Account #</th>
				<th>Client Name</th>
				<th>Contact Number</th>
				<th>Address</th>
			</thead>
			<tbody>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
				<tr>
					<td>183</td>
					<td><a :href="url">John Doe</a></td>
					<td>09854212121</td>
					<td>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
	props:['title', 'url']
}
</script>