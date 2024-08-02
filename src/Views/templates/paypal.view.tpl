<script src="https://www.paypal.com/sdk/js?client-id=AVSG1dZyNCxOKG1m6gFxyXPUtrTtySJ74C0msPoLR8B6YijgJpbFm5VmzpZZILwPvQjG0XPI97yEFt-T&locale=es_ES"></script>

<input type="number" name="total" id="total" value="135">

<div id="paypal-button-container"></div>

<script>
    paypal.Buttons({
        style: {
            layout: 'horizontal',
            color:  'gold',
            shape:  'rect',
            label:  'pay'
        },
        createOrder: function(data, actions) {
            var total = document.getElementById('total').value;
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: 'USD',
                        value: total
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaccion de: John Doe');
            });
        }
    }).render('#paypal-button-container');
</script>
