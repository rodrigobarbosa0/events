import './bootstrap';

body: JSON.stringify({
        token: token,
        payment_method_id: paymentMethod,
        email: email,
        event_id: {{ $event->id }}
    })