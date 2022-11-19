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
                      <h4 class="card-title">Add Category</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                   <div class="row">
                      <div class="col-lg-12">
                        <form method="POST" action="{{ route('categories.store') }}">
                           @csrf
                            <div class="form-group">
                               <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Name">
                               @if ($errors->has('category_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                               <textarea id="text" name="description" rows="5" class="form-control"
                               placeholder="Description"></textarea>
                               @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
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

 {{-- <script>
   function addToCart(){
        var category_name = $('#name').text();
        var category_dis = $('#text').text();
      //   var id = $('#product_id').val();
        var status = $('#status option:selected').text();
        $.ajax({
            url: "{{ url('/api/cat') }}",
            type: "POST",
            dataType: 'json',
            data:{
                 status:status, description:category_dis, category_name:category_name
            },
            
            success:function(data){

                console.log(data)

              
            }
        })

    }
  
// End Add To Cart Product 
 </script> --}}
 @endsection