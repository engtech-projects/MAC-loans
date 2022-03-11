// Currency text format value
    $(".currencyText").on("focus", function(){
        if((parseFloat(this.value) - parseInt(this.value)) == 0){
            this.value = parseFloat(this.value).toFixed(0)
        }
    });
    $(".currencyText").on("blur", function(){
        if(this.value){
            this.value = parseFloat(this.value).toFixed(2)
        }else{
            this.value = parseFloat(0).toFixed(2)
        }
    });
// END Currency text format value
