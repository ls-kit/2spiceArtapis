@extends('backend.layout.app')

@push('custom-css')
@endpush

@section('main_section')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Site Settings </h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form method="POST" action="{{ route('site.settings.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="app_name">App Name</label>
                                                <input type="text" name="app_name" class="form-control"
                                                    placeholder="App Name" value="{{ $setting ? $setting->app_name : '' }}">
                                                @if ($errors->has('app_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('app_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-12 form-group">
                                                <label id="gallery2" for="form_gallery-upload">Description</label>
                                                <textarea id="text" name="description" rows="5"
                                                    class="form-control" placeholder="Description"
                                                    value="{{ $setting ? $setting->description : '' }}" ></textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-12 form-group">
                                                <label id="gallery2" for="form_gallery-upload">Contact Mail</label>
                                                <input id="text" name="contact_mail" rows="5"
                                                    class="form-control"
                                                    placeholder="info@domain.com">{{ $setting ? $setting->contact_mail : '' }}
                                                @if ($errors->has('contact_mail'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('contact_mail') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="footer_text">Footer Text</label>
                                        <input type="text" name="footer_text" class="form-control"
                                            placeholder="@copyright | {year} {Text}"
                                            value="{{ $setting ? $setting->footer_text : '' }}">
                                        @if ($errors->has('footer_text'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('footer_text') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="banner_title">Banner Title</label>
                                        <input type="text" name="banner_title" class="form-control"
                                            placeholder="Banner Title" value="{{ $setting ? $setting->banner_title : '' }}">
                                        @if ($errors->has('banner_title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('banner_title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-12 form-group">
                                        <label id="gallery2" for="banner_description">Banner Description</label>
                                        <textarea id="text" name="banner_description" rows="5"
                                            class="form-control" placeholder="Banner Description"
                                            value="{{ $setting ? $setting->banner_description : '' }}" ></textarea>
                                        @if ($errors->has('banner_description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('banner_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-12 form_gallery form-group">
                                        <label id="gallery2" for="banner_image">Upload Banner Image</label>
                                        <input data-name="#gallery2" id="banner_image" name="banner_image"
                                            class="form_gallery-upload" type="file" accept="image/*">
                                        @if ($errors->has('banner_image'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('banner_image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-6 form_gallery form-group">
                                        <label id="gallery2" for="form_gallery-upload">Upload Logo</label>
                                        <input data-name="#gallery2" id="form_gallery-upload" name="logo"
                                            class="form_gallery-upload" type="file" accept="image/*">
                                        @if ($errors->has('logo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-6 form_gallery form-group">
                                        <label id="gallery2" for="form_gallery-upload2">Upload Favicon</label>
                                        <input data-name="#gallery2" id="form_gallery-upload2" name="favicon"
                                            class="form_gallery-upload" type="file" accept="image/*">
                                        @if ($errors->has('favicon'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('favicon') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" name="old_banner_image"
                                        value="{{ $setting ? $setting->banner_image : '' }}">
                                    <input type="hidden" name="old_logo" value="{{ $setting ? $setting->logo : '' }}">
                                    <input type="hidden" name="old_fevicon"
                                        value="{{ $setting ? $setting->favicon : '' }}">

                                    <div class="col-12 form-group ">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
