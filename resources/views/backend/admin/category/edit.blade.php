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
                      <h4 class="card-title">Edit Category</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                   <div class="row">
                     <div class="col-lg-12">
                        <form method="POST" action="{{ route('categories.update',$category->id) }}">
                           @csrf
                           @method('PUT')
                            <div class="form-group">
                               <input type="text" class="form-control" value="{{old('category_name',$category->category_name)}}" name="category_name" id="category_name" placeholder="Name">
                               @if ($errors->has('category_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                               <textarea id="text" name="description" rows="5" class="form-control"
                               placeholder="Description">{{old('description',$category->description)}}</textarea>
                               @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group radio-box">
                               <label>Status</label>
                               <div class="radio-btn">
                                 @if ($category->status == 1)
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio6" name="status" checked value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio6">enable</label>
                                 </div> 
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio7" name="status" value="0" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio7">disable </label>
                                 </div>
                                 @else
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio6" name="status"  value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio6">enable</label>
                                 </div> 
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio7" name="status" checked value="0" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio7">disable </label>
                                 </div> 
                                 @endif
                                 
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