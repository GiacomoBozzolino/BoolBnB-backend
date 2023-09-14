@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">Crea il tuo progetto</h2>
                    <a href="{{ Route('admin.apartments.index') }}" class="btn btn-danger">Back</a>
                </div>
            </div>
            <div class="col-12 mb-5">
                <form action=" {{ Route('admin.apartments.update', $apartment->id) }} " method="POST"
                    enctype="multipart/form-data">
                    {{-- TOKEN --}}
                    @csrf
                    {{-- METHOD PUT --}}
                    @method('PUT')
                    <div class="form-group border p-4">
                        <div class="row">

                            <!-- Titolo -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Titolo</label>
                                <input type="text" name="title" id="title" placeholder="Inserisci il titolo"
                                    class="form-control" value="{{ old('title') ?? $apartment->title }}" required>
                            </div>

                            <!-- Numero stanze -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Numero delle stanze</label>
                                <select class="form-control" name="n_rooms" id="n_rooms" required>
                                    <option
                                        {{ $apartment->n_rooms == old('n_rooms', $apartment->n_rooms) ? 'selected' : '' }}
                                        value="{{ $apartment->n_rooms }}">{{ $apartment->n_rooms }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>

                            <!-- Numero tanze da letto -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Numero delle stanze da letto</label>
                                <select class="form-control" name="n_beds" id="n_beds" required>
                                    <option {{ $apartment->n_beds == old('n_beds', $apartment->n_beds) ? 'selected' : '' }}
                                        value="{{ $apartment->n_beds }}">{{ $apartment->n_beds }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>

                            <!-- Numero bagni -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Numero bagni</label>
                                <select class="form-control" name="n_bathrooms" id="n_bathrooms" required>
                                    <option
                                        {{ $apartment->n_bathrooms == old('n_bathrooms', $apartment->n_bathrooms) ? 'selected' : '' }}
                                        value="{{ $apartment->n_bathrooms }}">{{ $apartment->n_bathrooms }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <!-- Cover Image -->
                            <div class="form-group my-5 d-flex flex-column ">
                                <label for="" class="control-label mb-3">Image</label>
                                <div class="col-12 text-center my-5">
                                    <img width="450px" src="{{ asset('storage/' . $apartment->cover_img) }}"
                                        alt="">
                                </div>
                                <input class="ps-3 form-control" type="file" id="cover_img" name="cover_img"
                                    value="{{ $apartment->cover_img }}">
                            </div>

                            <!-- Metratura appartamento -->
                            <div class="col-12
                                    my-2">
                                <label class="control-label my-2">Inserisci la metratura</label>
                                <input type="number" name="square_meters" id="square_meters"
                                    placeholder="Inserisci la metratura del tuo locale" class="form-control" min="1"
                                    max="249" value="{{ old('square_meters') ?? $apartment->square_meters }}"
                                    required>
                            </div>

                            <!-- Indrizzo -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Inserisci il tuo indirizzo</label>
                                <input type="text" name="address" id="address" placeholder="Inserisci il tuo indirizzo"
                                    class="form-control" value="{{ old('address') ?? $apartment->address }}" required>
                            </div>

                            <!-- Visibili -->
                            <div class="col-12 my-2">
                                <label class="control-label my-2">Rendi visibile il tuo anuncio</label>
                                <div class="radio-container d-flex">
                                    {{-- parte del si  --}}
                                    <div class="yes-container">
                                        <input type="radio" id="yes" name="visibility" value="1"
                                            {{ $apartment->visibility == 1 ? 'checked' : '' }}>
                                        <label for="yes">Si rendi l'anuncio visibile</label>
                                    </div>
                                    {{-- parte del no --}}
                                    <div class="no-container ms-5">
                                        <input type="radio" id="no" name="visibility" value="0"
                                            {{ $apartment->visibility == 0 ? 'checked' : '' }}>
                                        <label for="no">Non rendere l'anuncio visibile</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrizione -->
                            <div class="col-12 my-2">
                                <div class="form-group">
                                    <label class="control-label my-2">Descrizione</label>
                                    <textarea name="description" id="description" placeholder="Inserisci descrzione" class="text-start form-control"
                                        required>
                                        {{ old('description') ?? $apartment->description }}
                                    </textarea>
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <div class="col-12 text-center my-5">
                                <button type="submit" class="btn btn-success">Salva</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
