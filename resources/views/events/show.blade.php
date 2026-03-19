@extends('layouts.main')

@section('title', $event->title)

@section('content')
    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-fluid">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $event->title }}</h1>
                <p class="events-city"><ion-icon name="location-outline"></ion-icon>{{ $event->city}}</p>
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon>{{ count($event->users) }} participantes</p>
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon>{{ $eventOwner['name'] }}</p>
                <p class="event-price"><ion-icon name="card-outline"></ion-icon>valor do ingresso: R$ {{ number_format($event->price, 2, ',', '.') }}</p>
                @if (!$hasUserJoined)
                        <a href="{{ url('/events/payment/' . $event->id) }}" class="btn btn-primary">
                                Confirmar Presença
                        </a>
                @else
                    <p class="already-joined-msg">Você já está participando deste evento!</p>
                @endif
                <h3>O evento conta com:</h3>
                <ul id="items-list">
                    @foreach($event->items as $item)
                        <li><ion-icon name="play-outline"></ion-icon><span>{{ $item }}</span></li>
                    @endforeach
                </ul>   
            </div>
            <div class="col-md-12" id="description">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>
        </div>
    </div>
@endsection
