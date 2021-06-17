@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Team Profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('team.update', $team) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Team Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $team->name) }}"  autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="coach" class="col-md-4 col-form-label text-md-right">{{ __('Team Manager') }}</label>

                            <div class="col-md-6">
                                <input id="coach" type="text" class="form-control @error('coach') is-invalid @enderror" name="coach" value="{{ old('coach', $team->coach) }}" required>

                                @error('coach')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Team Logo') }}</label>

                            <div class="col-md-6">
                                <input id="logo" type="file" accept=".jpg, .png, .gif, .svg" class="form-control-file mb-2  @error('logo') is-invalid @enderror" name="logo" value="" onchange="preview()">

                                <div id="logo_div" style='height: 100px; width: 100px;' hidden>
                                    <img id="logo_img" src="" style='max-height: 100%; max-width: 100%;'/>
                                </div>

                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location', $team->location) }}" required>

                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function preview() {
            logo_img.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('logo_div').hidden = false;
        }
    </script>
</div>
@endsection
