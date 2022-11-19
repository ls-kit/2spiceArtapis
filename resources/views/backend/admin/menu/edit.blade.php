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
                      <h4 class="card-title">Edit Menu</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                   <div class="row">
                      <div class="col-lg-12">
                        <form method="POST" action="{{ route('public.menu.update',$menu->id) }}" accept-charset="UTF-8" role="form" class="needs-validation" file="true">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                               <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name', $menu->name) }}">
                               @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                               <input id="text" name="link" rows="5" class="form-control"
                               placeholder="Link" value="{{ old('link', $menu->link) }}">
                               @if ($errors->has('link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('link') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="type" id="exampleFormControlSelect1">
                                    <option selected disabled="">Menu Type</option>
                                    @switch($menu->type)
                                        @case($menu->type == 1)
                                        <option value="1" selected>Header</option>
                                        <option value="2">Footer</option>
                                        <option value="3">User</option>
                                        <option value="4">Social</option>
                                            @break
                                        @case($menu->type == 2)
                                        <option value="1">Header</option>
                                        <option value="2" selected>Footer</option>
                                        <option value="3">User</option>
                                        <option value="4">Social</option>
                                            @break
                                        @case($menu->type == 3)
                                        <option value="1">Header</option>
                                        <option value="2">Footer</option>
                                        <option value="3" selected>User</option>
                                        <option value="4">Social</option>
                                            @break
                                        @case($menu->type == 4)
                                        <option value="1">Header</option>
                                        <option value="2">Footer</option>
                                        <option value="3">User</option>
                                        <option value="4" selected>Social</option>
                                            @break
                                        @default
                                        <option  disabled="">>No Type Found</option>
                                    @endswitch
                                    </select>
                                    @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="col-md-6 form-group">
                                <input id="text" name="icon" rows="5" class="form-control"
                                placeholder="Icon Class (<i class='demo'></i>)" value="{{ old('icon', $menu->icon) }}">
                                @if ($errors->has('icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group radio-box">
                               <label>Status</label>
                               @switch($menu->status)
                                        @case($menu->status == 1)
                                            <div class="radio-btn">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio6" name="status" value="1" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadio6">enable</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio7" name="status" value="0" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio7">disable </label>
                                            </div>
                                            @break
                                        @case($menu->status == 0)
                                            <div class="radio-btn">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="customRadio6" name="status" value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio6">enable</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="customRadio7" name="status" value="0" class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="customRadio7">disable </label>
                                                </div>
                                            </div>
                                            @break
                                        @default
                                            <label class="custom-control-label" for="customRadio6">Error</label>
                                            @break
                                    @endswitch
                            </div>
                            <div class="form-group ">
                               <button type="submit"  class="btn btn-primary">Submit</button>
                               <button type="reset" class="btn btn-danger">cancel</button>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 @endsection