<template>
    <div class="p-16 light-border">
		<table class="table table-stripped th-nbt">
			<thead>
				<th>Product Name</th>
				<th>Product Code</th>
				<th>Percentage</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-for="product in products" :key="product.product_id">
					<td>{{product.product_name}}</td>
					<td>{{product.product_code}}</td>
					<td>{{product.interest_rate}}%</td>
					<td class="text-green text-sm"><a href="#" class="text-green">{{product.status}}</a></td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
    export default {
		props:['api'],
		data(){
			return {
				products:[]
			}
		},
		methods: {
			fetchProducts: function(id){
				$.get(window.location.origin + '/api/products', function(data){
					this.products = data.data;
				}.bind(this));
			},
		},
        mounted() {
           this.fetchProducts();
        }
    }
</script>
