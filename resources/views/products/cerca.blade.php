@extends("layouts.master")
@section("titolo", "Ricerca prodotti")

@section("contenuto")

    <?php

    $taglie = ["XXS", "XS", "S", "M", "L", "XL", "XXL"];

                                                        ?>
    <div class="container">

        <h1 class="text-center my-5">
            Cerca nei prodotti
        </h1>


        <div class="filtri p-4 w-100 mb-4">
            <div class="card card-custom">
                <form class="card-content" method="POST" action="{{route('products.filterBySearch')}}">
                    @csrf
                    <div class="card-body row">
                        <div class="col-6 py-3 mb-4">
                            <label for="nome" class="form-check-label">Nome:</label>
                            <input type="text" value="{{ isset($fields->nome) ? $fields->nome : "" }}" name="nome" class="form-control" id="nome">
                        </div>
                        <div class="col-6 py-3 mb-4">
                            <label for="categoria" class="form-check-label">Categoria:</label>
                            <select name="categoria" id="categoria" class="form-select">
                                <option {{ isset($fields->categoria) && $fields->categoria == 'all' ? 'selected' : "" }} value="all">Tutte</option>
                                @foreach ($cats as $cat)
                                    <option {{ isset($fields->categoria) && $fields->categoria == $cat->value ? 'selected' : "" }}  value="{{$cat}}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 py-3 mb-4">
                            <label for="prezzoRange" class="form-label">Range di prezzo:</label>
                            <div class="input-group">
                                <div class="input-group-text p-0">
                                    <input type="checkbox" class="btn-check h-100" id="toggleMin" autocomplete="off" name="toggleMin"
                                        onclick="toggle('prezzoMin')" 
                                        {{ isset($fields->prezzoMin) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary dxTondo" for="toggleMin">Min</label>
                                </div>

                                <div class="input-group-text p-0">
                                    <input 
                                    type="number" 
                                    name="prezzoMin" 
                                    id="prezzoMin" 
                                    class="form-control nonTondo" 
                                    value="{{ isset($fields->prezzoMin) ? $fields->prezzoMin : '' }}"  
                                    placeholder="Prezzo minimo" 
                                        {{isset($fields->prezzoMin) ? '' : 'disabled'}}>
                                </div>
                                <div class="input-group-text p-0">
                                    <input 
                                    type="number" 
                                    name="prezzoMax" 
                                    id="prezzoMax" 
                                    class="form-control nonTondo"
                                        placeholder="Prezzo massimo" 
                                        value="{{ isset($fields->prezzoMax) ? $fields->prezzoMax : '' }}"
                                        {{isset($fields->prezzoMax) ? '' : 'disabled'}}>

                                </div>


                                <div class="input-group-text p-0">
                                    <input type="checkbox" class="btn-check h-100" id="toggleMax" autocomplete="off"
                                    name="toggleMax"
                                         onclick="toggle('prezzoMax')"
                                         {{ isset($fields->prezzoMax) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary sxTondo" for="toggleMax">Max</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 py-3 mb-4 row">
                            @foreach ($taglie as $taglia)
                                <div class="col-3 p-2">
                                    <label class="form-check-label">
                                        <input type="checkbox"
                                        {{ isset($fields->taglie) && (is_array($fields->taglie) && in_array($taglia, $fields->taglie)) ? 'checked' : '' }} class="form-check-input me-2" value="{{ $taglia }}"
                                            name="taglie[]">{{ $taglia }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <div class="form-check form-switch d-flex flex-column align-items-center">
                                <label class="form-check-label" for="scontato">Prodotti scontati</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="scontato" name="scontato" {{ isset($fields->scontato) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-center gap-4">
                            <button class="btn btn-secondary d-flex gap-2 align-items-center" type="submit">Cerca <i
                                    class="bi bi-search fs-6"></i>
                            </button>
                            <a class="btn btn-secondary d-flex gap-2 align-items-center"
                                href="{{ route('products.resetFilters') }}"
                                >Svuota filtri <i
                                    class="bi bi-arrow-counterclockwise fs-6"></i>
                            </a>
                        </div>
                    </div>
            </div>
            </form>
        </div>

        <div class="my-5 text-center">
            @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @elseif(isset($successMessage))
            <div class="alert alert-success">
                {{ $successMessage }}
            </div>
            @endif
        </div>

        @if(isset($successMessage))
        <div class="row mb-5">
            @foreach ($prods as $prod)

                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <x-best-card :prod="$prod">
                        <x-slot:desc>
                            <!-- <p class="card-text">{{$prod->descrizione}}</p> -->
                        </x-slot:desc>
                        <x-slot:add>
                            <!-- <a href="{{ route("user.addToCart", $prod) }}" class="btn">
                                                                                                                                                <i class="bi bi-cart2"></i>
                                                                                                                                            </a> -->
                            <div class="btn btn-primary"><a href="{{ route("products.details", $prod) }}">Dettagli</a></div>
                        </x-slot:add>
                    </x-best-card>
                </div>

            @endforeach
        </div>
        {{ $prods->links('pagination::bootstrap-5') }}
        @endif
    </div>
    </div>


    <script>
        const toggle = (id) => {
            const btn = document.getElementById(id)
            btn.disabled = !btn.disabled
        }
    </script>


@endsection