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
                      <h4 class="card-title">Add Menu</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                   <div class="row">
                      <div class="col-lg-12">
                        <form method="POST" action="{{ route('public.menu.store') }}">
                           @csrf
                            <div class="form-group">
                               <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                               @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                               <input id="text" name="link" rows="5" class="form-control"
                               placeholder="Link">
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
                                    <option value="1">Header</option>
                                    <option value="2">Footer</option>
                                    <option value="3">User</option>
                                    <option value="4">Social</option>
                                    </select>
                                    @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="col-md-6 form-group">
                                <input id="text" name="icon" rows="5" class="form-control"
                                placeholder="Icon Class (<i class='demo'></i>)">
                                @if ($errors->has('icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group radio-box">
                               <label>Status</label>
                               <div class="radio-btn">
                                  <div class="custom-control custom-radio custom-control-inline">
                                     <input type="radio" id="customRadio6" name="status" value="1" class="custom-control-input">
                                     <label class="custom-control-label" for="customRadio6">enable</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline">
                                     <input type="radio" id="customRadio7" name="status" value="0" class="custom-control-input">
                                     <label class="custom-control-label" for="customRadio7">disable </label>
                                  </div>
                               </div>
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