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
                      <h4 class="card-title">Edit Content</h4>
                   </div>
                </div>
                <div class="iq-card-body">

                  <form method="POST" action="{{ route('public.upload.update',$upload->id) }}" accept-charset="UTF-8" role="form" enctype="multipart/form-data" class="needs-validation" file="true">
                     @csrf
                     @method('PUT')
                      <div class="row">
                         <div class="col-lg-7">
                            <div class="row">
                               <div class="col-12 form-group">
                                  <input type="text" name="name" value="{{ old('name', $upload->name) }}" class="form-control" placeholder="Title">
                               </div>

                               <div class="col-md-9 form-group form_gallery">
                                 <label id="gallery2" for="form_gallery-upload">Upload Image</label>
                                 <input data-name="#gallery2" id="form_gallery-upload" name="thumbnail_image" class="form_gallery-upload"
                                    type="file" accept="image/*">
                                    @if ($errors->has('thumbnail_image'))
                               <span class="help-block">
                                   <strong>{{ $errors->first('thumbnail_image') }}</strong>
                               </span>
                               @endif
                               </div>
                               <div class="col-sm-3 form-group">
                                 <img src="{{ asset($upload->thumbnail_image) }}" class="msg-photo" alt="" style="width: 75px; height:50px;" />
                               </div>
                               <div class="col-md-6 form-group">
                                  <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                                     <option  disabled="">Category</option>
                                     @switch($upload->category_id)
                                     @case($upload->category_id == 1)
                                     <option selected value="1">Music</option>
                                     <option value="2">Comedy</option>
                                     <option value="3">Talent</option>
                                         @break
                                     @case($upload->category_id == 2)
                                     <option value="1">Music</option>
                                     <option selected value="2">Comedy</option>
                                     <option value="3">Talent</option>
                                         @break
                                     @case($upload->category_id == 3)
                                     <option value="1">Music</option>
                                     <option value="2">Comedy</option>
                                     <option selected value="3">Talent</option>
                                         @break

                                     @default
                                     <option value="1">Music</option>
                                     <option value="2">Comedy</option>
                                     <option value="3">Talent</option>
                                 @endswitch
                                     {{-- <option value="{{$upload->category_id}}">Music</option>
                                     <option value="1">Music</option>
                                     <option value="2">Comedy</option>
                                     <option value="3">Talent</option> --}}

                                     {{-- @foreach ($categories as $cate)
                                     <option value="{{$cate->id}}" {{ $cate->id == $upload->category_id ? 'selected':''}}>{{$cate->category_name}}</option>
                                     @endforeach --}}
                                  </select>
                                  @if ($errors->has('category_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                                @endif
                               </div>
                               <div class="col-sm-6 form-group">
                                <select class="form-control" name="region" id="exampleFormControlSelect3">
                                   <option disabled="">Choose Region</option>
                                   @foreach ($countries as $country)
                                   <option value="{{$country}}" {{ $country == $upload->region ? 'selected':''}}>{{$country}}</option>
                           @endforeach
                                </select>
                                @if ($errors->has('region'))
                        <span class="help-block">
                            <strong>{{ $errors->first('region') }}</strong>
                        </span>
                        @endif
                              </div>
                               <div class="col-12 form-group">
                                  <textarea id="text" name="description" rows="5" class="form-control"
                                     placeholder="Description">{{$upload->description}}</textarea>
                               </div>
                            </div>
                         </div>
                         <div class="col-lg-5">
                            <div class="d-block position-relative">
                               <div class="form_video-upload">
                                  <input type="file" name="upload" accept="video/* , audio/*">
                                  <p>Upload Audio/Video</p>
                               </div>
                               @if ($errors->has('upload'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('upload') }}</strong>
                                </span>
                                @endif
                            </div>
                         </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <Label for="contentType">Content Type: </Label>
                            <select name="sell" id="contentType" class="form-control">
                                <option value="0" selected>Free</option>
                                <option value="1" @if($upload->sell == true) selected @endif>Premium</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group" id="inputPrice" @if($upload->sell == true) style="display: block"@else style="display: none" @endif  >
                            <Label for="priceID">Price: </Label>
                            <input type="number" name="price" value="{{$upload->price}}" id="priceID" class="form-control">
                        </div>
                    </div>
                      <div class="row">
                        {{-- <div class="col-sm-12 form-group">
                           <input type="time" class="form-control" value="{{$upload->upload_duration}}" name="upload_duration" placeholder="Movie Duration">
                        </div> --}}
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
@push('custom-script')
<script>
    $(document).ready(function() {
        let contenttype = $('select[name="sell"]');
        $(document).on('change', 'select[name="sell"]', function() {
            let data = $(this).val();
            if (data == 1) {
                $('#inputPrice').css('display', 'block');
            } else if (data == 0) {
                $('#inputPrice').css('display', 'none');
            }
            // console.log(data);
        });
    });
</script>

@endpush
