@extends("layouts.master")
@section("titolo", "Chi siamo")
@section("contenuto")
    <div class="container cent">
        <div class="whoCont">
            <div class="row ">
                <div class="col-6">
                    <img src="{{ asset("storage/loading.gif") }}" data-src="{{ asset("storage/storage.avif") }}"
                        alt="storage" width="100%" class="lazy-load">
                </div>
                <div class="col-6 justify-content-center d-flex flex-column h-100"  style="min-height: 360px;">
                    <h2>Chi siamo?</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat labore porro nostrum. Sit maxime
                        amet facilis aperiam, quam voluptatem enim quis blanditiis ipsam deleniti aut nobis necessitatibus
                        excepturi soluta! Provident. Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere ad
                        pariatur nobis natus sit ipsam corrupti repudiandae perferendis consectetur praesentium enim
                        reiciendis, ipsa repellat deleniti iusto perspiciatis doloremque commodi voluptates?
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="row mt-5">
                    @foreach ($revs as $rev)
                        <div class="col-3 justify-content-center d-flex">
                            <div class="revCardWho">
                                <div class="d-flex justify-content-between">
                                    <p class="card-title">
                                        {{ $rev->utente }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <p class="card-title">
                                            {{ $rev->voto }}
                                        </p>
                                        <i class="bi bi-star-fill fs-5" style="color: gold;"></i>
                                        </d>
                                    </div>
                                </div>
                                <p class="card-text">
                                    {{ $rev->testo }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection