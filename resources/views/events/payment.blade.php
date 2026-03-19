@extends('layouts.main')

@section('title', $event->title)

@section('content')
<div class="col-md-8 offset-md-2">
    <h2>Pagamento do Evento</h2>
        <p><strong>Evento:</strong> {{ $event->title }}</p>
        <p><strong>Valor:</strong> R$ {{ number_format($event->price, 2, ',', '.') }}</p>

    <form id="payment-form">
        @csrf
        <div class="mb-3">
                <input type="email" id="email" class="form-control" placeholder="Seu e-mail" required>
            </div>

            <div class="mb-3">
                <input type="text" id="cardNumber" class="form-control" placeholder="Número do cartão" required>
            </div>

            <div class="mb-3">
                <input type="text" id="cardExpirationMonth" class="form-control" placeholder="Mês" required>
            </div>

            <div class="mb-3">
                <input type="text" id="cardExpirationYear" class="form-control" placeholder="Ano" required>
            </div>

            <div class="mb-3">
                <input type="text" id="securityCode" class="form-control" placeholder="CVV" required>
            </div>

            <div class="mb-3">
                <input type="text" id="cardholderName" class="form-control" placeholder="Nome no cartão" required>
            </div>

            <div class="mb-3">
                <select id="identificationType" class="form-control" required>
                    <option value="CPF">CPF</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="text" id="identificationNumber" class="form-control" placeholder="CPF" required>
            </div>

            <button type="submit" class="btn btn-primary">Pagar</button>
    </form>
        <div id="payment-result" class="mt-3"></div>
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}");

        const form = document.getElementById('payment-form');
        const resultDiv = document.getElementById('payment-result');

        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            try {
                const cardData = {
                    cardNumber: document.getElementById('cardNumber').value,
                    cardExpirationMonth: document.getElementById('cardExpirationMonth').value,
                    cardExpirationYear: document.getElementById('cardExpirationYear').value,
                    securityCode: document.getElementById('securityCode').value,
                    cardholderName: document.getElementById('cardholderName').value,
                    identificationType: document.getElementById('identificationType').value,
                    identificationNumber: document.getElementById('identificationNumber').value,
                };

                const tokenResponse = await mp.createCardToken(cardData);

                if (tokenResponse.error) {
                    resultDiv.innerHTML = 'Erro ao gerar token do cartão.';
                    console.log(tokenResponse);
                    return;
                }

                const token = tokenResponse.id;
                const email = document.getElementById('email').value;

                const response = await fetch("{{ url('/events/payment/process') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        token: token,
                        payment_method_id: tokenResponse.payment_method_id,
                        email: email,
                        event_id: {{ $event->id }}
                    })
                });

                const data = await response.json();

                if (data.error) {
                    resultDiv.innerHTML = 'Erro: ' + data.message;
                    return;
                }

                resultDiv.innerHTML = `
                    <p>Status: ${data.status}</p>
                    <p>ID do pagamento: ${data.payment_id}</p>
                `;
            } catch (error) {
                console.error(error);
                resultDiv.innerHTML = 'Erro ao processar pagamento.';
            }
        });
    </script>
@endsection
