@extends('layouts.admin')

@section('content')
    <div class="mx-5 py-5">
        <div class="row">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">Modifica il tuo appartamento</h2>
                </div>
            </div>
            
            <div class="col-12 mb-5">
                <form action=" {{ Route('admin.apartments.update', $apartment->id) }} " method="POST"
                    enctype="multipart/form-data">
                    {{-- TOKEN --}}
                    @csrf
                    {{-- METHOD PUT --}}
                    @method('PUT')
                    <div class="form-group p-4">
                        <ul class="list-unstyled">

                            <!-- Titolo -->
                            <li>
                                <label class="control-label my-2">Titolo</label>
                                <input type="text" name="title" id="title" placeholder="Inserisci il titolo"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $apartment->title }}" required>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </li>

                            <!-- Numero stanze -->
                            <li>
                                <label class="control-label my-2">Numero delle stanze</label>
                                <select class="form-control " name="n_rooms" id="n_rooms" required>
                                    
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option {{ $i == old('n_rooms', $apartment->n_rooms) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero tanze da letto -->
                            <li>
                                <label class="control-label my-2">Numero delle stanze da letto</label>
                                <select class="form-control" name="n_beds" id="n_beds" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                    <option {{ $i == old('n_beds', $apartment->n_beds) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero bagni -->
                            <li>
                                <label class="control-label my-2">Numero bagni</label>
                                <select class="form-control" name="n_bathrooms" id="n_bathrooms" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                    <option {{ $i == old('n_bathrooms', $apartment->n_bathrooms) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Servizi -->
                            <li>
                                <label class="control-label my-2">Seleziona i servizi</label>
                                <ul class="list-group d-flex flex-row flex-wrap justify-content-evenly my-3">

                                    @foreach ($services as $item)
                                        <li class="list-group-item col-5 d-flex align-items-center">
                                            @if($errors->any())
                                                <input type="checkbox" name="services[]" value="{{ $item->id }}"
                                                class="form-check-input me-4" {{in_array($item->id, old ('services', []))? 'checked': ''}}>
                                            @else
                                            <input type="checkbox" name="services[]" value="{{ $item->id }}"
                                                class="form-check-input me-4" {{$apartment->services->contains($item)? 'checked': ''}}>
                                            @endif

                                            <label class="control-label my-2"><?php echo $item->icon; ?>
                                                {{ $item->type }}</label>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>

                            <!-- Cover Image -->
                            <li>
                                <label for="" class="control-label mb-3">Immagine</label>
                                <div class="my-2">
                                    <img width="50%" src="{{ asset('storage/' . $apartment->cover_img) }}"
                                        alt="">
                                </div>
                                <input class="ps-3 form-control @error('cover_img') is-invalid @enderror" type="file" id="cover_img" name="cover_img"
                                    value="{{old('cover_img')?? $apartment->cover_img}}">
                                   
                                @error('cover_img')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                
                            </li>

                            <!-- Metratura appartamento -->
                            <li>
                                <label class="control-label my-2">Inserisci la metratura</label>
                                <input type="number" name="square_meters" id="square_meters"
                                    placeholder="Inserisci la metratura del tuo locale" class="form-control @error('square_meters') is-invalid @enderror" min="1"
                                    max="249" value="{{ old('square_meters') ?? $apartment->square_meters }}"
                                    required>
                                    @error('square_meters')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </li>

                            <!-- Indrizzo -->
                            <li>
                                <label class="control-label my-2">Inserisci il tuo indirizzo</label>
                                <input type="text" name="address" id="address" placeholder="Inserisci il tuo indirizzo"
                                    class="form-control @error('address') is-invalid @enderror" value="{{ old('address') ?? $apartment->address }}" required>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>

                            <!-- Visibili -->
                            <li>
                                <label class="control-label my-2">Rendi visibile il tuo annuncio</label>
                                <div class="radio-container d-flex">
                                    {{-- parte del si  --}}
                                    <div class="yes-container">
                                        <input type="radio" id="yes" name="visibility" value="1" {{  old('visibility', '1') == '1' ? 'checked' : ''}} >
                                        {{-- <input type="radio" id="yes" name="visibility" value="1"
                                            {{ $apartment->visibility == 1 ? 'checked' : '' }}> --}}
                                        <label for="yes">Si rendi l'annuncio visibile</label>
                                    </div>
                                    {{-- parte del no --}}
                                    <div class="no-container ms-5">
                                        <input type="radio" id="no" name="visibility" value="0" {{old('visibility') == '0' ? 'checked' : ''}}>
                                        {{-- <input type="radio" id="no" name="visibility" value="0"
                                            {{ $apartment->visibility == 0 ? 'checked' : '' }}> --}}
                                        <label for="no">Non rendere l'annuncio visibile</label>
                                    </div>
                                </div>
                            </li>

                            <!-- Descrizione -->
                            <li>
                                <div class="form-group">
                                    <label class="control-label my-2">Descrizione</label>
                                    <textarea name="description" id="description" class="text-start form-control @error('address') is-invalid @enderror"
                                        required>{{ old('description') ?? $apartment->description }}
                                    </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </li>


                            <!-- Submit Button -->
                            <li class="text-center my-5">
                                <button type="submit" class="btn btn-success">Salva</button>
                                <a href="{{ Route('admin.apartments.index') }}" class="btn btn-danger">Anulla</a>
                            </li>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
