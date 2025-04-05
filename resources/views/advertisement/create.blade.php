@extends('layouts.app')

@section('title', 'Advertisements')

@section('content')
    <div class="container">
        <div class=" text-center mt-5 ">
            <h1>Create your advertisement</h1>
        </div>

        <div class="row ">
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-4 bg-light">
                    <div class="card-body bg-light">
                        <div class = "container">
                            <form id="advertisement-form" method="POST" action="/advertisement" enctype="multipart/form-data">
                                @csrf
                                <div class="controls">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Title:</label>
                                                <input id="title" type="text" name="title" class="form-control"
                                                    placeholder="Please enter your product title" required="required" value="{{ old('title') }}"
                                                    data-error="Product title is required.">
                                            </div>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description:</label>
                                                <textarea id="description" name="description" class="form-control" placeholder="Write your Description here." value="{{ old('description') }}"
                                                    rows="4" required="required" data-error="Description is required."></textarea>
                                            </div>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-check">

                                                <input type="hidden" name="is_for_rent" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_for_rent" name="is_for_rent" value="1">
                                                <label class="form-check-label" for="is_for_rent">Is this for rent?</label>
                                            </div>
                                            @error('is_for_rent')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price:</label>
                                                <input id="price" type="text" name="price" class="form-control"
                                                    placeholder="Please enter your product price" required="required" value="{{ old('price') }}"
                                                    data-error="Product price is required.">
                                            </div>
                                            @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="photo">Upload Photo:</label>
                                            <input type="file" id="photo" name="photo" class="form-control" value="{{ old('photo') }}">
                                        </div>   
                                        @error('photo')
                                                <div class="text-danger">{{ $message }}</div>
                                        @enderror                                     
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="submit"
                                                class="btn btn-success btn-send  pt-2 btn-block"
                                                value="Create Advertisement">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection