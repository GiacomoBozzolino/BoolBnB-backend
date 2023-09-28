@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sponsors as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
