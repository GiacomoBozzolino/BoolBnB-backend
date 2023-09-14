@extends('layouts.admin')

@section('content')
<div class="container">

    @if (isset($message))
    <div class="col-12 mt-5">
        <div class="alert alert-success">
            <span>{{ $message }}</span>
        </div>
    </div>
    @endif  
  
    <table class="table table-striped ">    
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Rooms</th>
            <th scope="col">Bedrooms</th>
            <th scope="col">Bathrooms</th>
            <th scope="col">Strumenti</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
              <tr>
                <td>{{$apartment->title}}</td>
                <td>{{$apartment->slug}}</td> 
                <td>{{$apartment->n_rooms}}</td> 
                <td>{{$apartment->n_beds}}</td> 
                <td>{{$apartment->n_bathrooms}}</td> 
                <td class="d-flex">
                  <div>
                    <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn btn-primary mx-1">
                    <i class="fas fa-eye"></i>
                    </a>
                  </div>
                 
                  <div>
                    <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    </a>
                  </div>
                   
                  <div>
                    <form class="apartment-delete-button d-inline-block mx-1" data-apartment-title="{{ $apartment->title }}" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
        @endforeach 
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <a href="{{route('admin.apartments.create')}}" class="btn btn-sm btn-primary">Crea un nuovo tag</a>
    </div>
</div>

    
    
          
@include('admin.partials.modal_apartment_delete'); 
{{-- @include('admin.partials.modal_delete') --}}
@endsection