<template>
    <div class="d-flex flex-column" style="flex: 8">
        <div class="d-flex flex-row font-md mb-16">
            <span class="flex-2"></span>
            <div
                class="d-flex flex-row align-items-center mr-24"
                style="flex: 1"
            >
                <span class="mr-10">Date From: </span>
                <input type="date" class="form-control flex-1" />
            </div>
            <div class="d-flex flex-row align-items-center" style="flex: 1">
                <span class="mr-10">Date To: </span>
                <input type="date" class="form-control flex-1" />
            </div>
        </div>
        <div class="sep mb-45"></div>
        <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

        <section class="mb-72" id="performanceReport">
            <div class="d-flex flex-column mb-24">
                <div class="d-flex flex-row align-items-center">
                    <div class="flex-1 d-flex flex-column"></div>
                    <span
                        class="font-30 text-bold text-primary-dark text-center"
                        >Loan Interest Collected From Microfinance Unit</span
                    >
                    <div class="flex-1 d-flex justify-content-end">
                        <span class="text-primary-dark font-md"
                            >Tuesday 02/15/2021</span
                        >
                    </div>
                </div>
                <span class="text-center text-primary-dark text-bold"
                    >As of 12/12/2021</span
                >
                <span
                    class="text-center text-primary-dark text-bold font-md mb-5"
                    >Butuan Branch (001)</span
                >
            </div>
            <section class="d-flex flex-column mb-16 p-10 light-border">
                <div class="d-flex bg-yellow-verylight mb-5">
                    <span class="text-primary-dark font-20">CURRENT</span>
                </div>
                <div class="bb-dark-8"></div>
                <table class="table table-stripped mb-24">
                    <thead>
                        <th class="col-md-2">Account Officer</th>
                        <th class="text-center">
                            Outstanding Loan Portfolio (Beginning date range)
                        </th>
                        <th class="text-center">
                            Outstanding Loan Portfolio (End date range)
                        </th>
                        <th class="text-center">
                            Interest Income (During Period)
                        </th>
                        <th class="text-center">
                            Fees & Other Charges (During Period)
                        </th>
                        <th class="text-center">Total Revenue</th>
                        <th class="text-center">Yield %</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Aplayo, Marialyn M.</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                        <tr class="bg-skyblue text-bold">
                            <td>CURRENT SUB-TOTAL</td>
                            <td>2,171,211.00</td>
                            <td>2,171,211.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00%</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>

        <section class="d-flex flex-row mb-72">
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Prepared By:</span
            >
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Certified Corrected By:</span
            >
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Approved By:</span
            >
            <span class="flex-1"></span>
        </section>

        <div class="d-flex flex-row justify-content-end mb-45">
            <div class="d-flex flex-row-reverse">
                <a href="#" class="btn btn-default min-w-150">Print</a>
                <a href="#" class="btn btn-success min-w-150 mr-24"
                    >Download Excel</a
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        print: function () {
            var content = document.getElementById("printContent").innerHTML;
            var target = document.querySelector(".to-print");
            target.innerHTML = content;
            window.print();
        },
    },
};
</script>
