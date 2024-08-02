<div class="form">
    <h1 class="titulo">Carrito</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            {{foreach carrito}}
            <tr>
                <td>{{id}}</td>
                <td>{{nombre}}</td>
                <td>{{precio}}</td>
                <td>{{cantidad}}</td>
                <td>{{subtotal}}</td>
            </tr>
            {{endfor carrito}}
        </tbody>
    </table>
    <div style="text-align: center;">
        {{foreach total}}
        <label for="total">Total: </label>
        <input type="number" name="total" id="total" value="{{tot}}" disabled>
        {{endfor total}}
    </div>
    <div class="paypal-container">
        <div id="paypal-button-container"></div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=ARxryGwfVCO-s0MwGlz8GUsrA1VGDiREqhqTXGJD1WLUzCh6d6ds45KUrcLLQUaJtUKinLIHZB7Pz9Jn"></script>
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
                    alert('Transacción completada: ' + details.payer.name.given_name);
                });
            }
        }).render('#paypal-button-container');
    </script>