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
                      <h4 class="card-title">Editable Table</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                   <div id="table" class="table-editable">
                      <span class="table-add float-right mb-3 mr-2">
                      <a href="{{ route('categories.create') }}" class="btn btn-sm iq-bg-success"><i
                         class="ri-add-fill"><span class="pl-1">Add New</span></i>
                      </a>
                      </span>
                      <table class="table table-bordered table-responsive-md table-striped text-center">
                         <thead>
                            <tr>
                              <th>{!! trans('SL') !!}</th>
                              <th>{!! trans('Name') !!}</th>
                              <th>{!! trans('Status') !!}</th>
                              <th>{!! trans('Description') !!}</th>
                              <th>{!! trans('Sort') !!}</th>
                              <th>{!! trans('Created') !!}</th>
                              <th>{!! trans('Updated') !!}</th>
                              <th >{!! trans('Action') !!}</th>
                            </tr>
                         </thead>
                         <tbody>
                           @forelse($categories as $item)
                           <tr>
                              <td contenteditable="true">{{ $loop->iteration }}</td>
                              <td contenteditable="true">{{$item->category_name}}</td>
                              <td contenteditable="true">
                                @if($item->status == '1')
                                  <span class="badge badge-success">Active</span>
                                  @else
                                  <span class="badge badge-warning">Deactive</span>
                                  @endif
                              </td>
                              <td contenteditable="true">{{$item->description}}</td>
                            
                              <td>
                                 <span class="table-up"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a></span>
                                 <span class="table-down"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a></span>
                              </td>
                              <td contenteditable="true">{{$item->created_at->diffForHumans()}}</td>
                              <td contenteditable="true">{{$item->updated_at->diffForHumans()}}</td>
                              <td>
                                 <a  href="{{route('categories.edit',$item->id)}}"
                                 class="btn btn-light btn-rounded btn-sm px-2 my-0"> Edit  </a>
                                 <span class="table-remove">
                                    <form action="{{route('categories.destroy',$item->id)}}" method="post">
                                       @csrf
                                       @method('DELETE')
                                   <button class="btn btn-primary btn-rounded btn-sm my-0" type="submit">Delete</button>
                                   </form>
                                 </span>
                              </td>
                        </tbody>
                           @empty
                           <tr>
                               <td class="text-muted text-center" colspan="100%">
                                   {{ trans($empty_message) }}</td>
                           </tr>
                           @endforelse
                       </tbody>
                      </table>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
     $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  })
function getDATA(){
        $.ajax({
            url: "{{url('/api/cat') }}/",
                  type:"GET",
                  dataType:"json",
            success:function(response){

                }
        })

     }
     getDATA();   
</script> 


@endsection