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
                      <h4 class="card-title">{{$page_title}}</h4>
                   </div>

                </div>
                <div class="iq-card-body">
                   <div id="table" class="table-editable">
                      <span class="table-add float-right mb-3 mr-2">
                      <a href="{{Route('public.upload')}}" class="btn btn-sm iq-bg-success"><i
                         class="ri-add-fill"><span class="pl-1">Add New</span></i>
                      </a>
                      </span>
                      <table class="table table-bordered table-responsive-md table-striped text-center">

                         <thead>
                            <tr>
                              <th>{!! trans('SL') !!}</th>
                              <th>{!! trans('Name') !!}</th>
                              {{-- <th class="hidden-xs">{!! trans('Category') !!}</th> --}}
                              <th class="hidden-xs">{!! trans('Status') !!}</th>
                              <th class="hidden-xs">{!! trans('Thumbnail') !!}</th>
                              <th class="">{!! trans('Music') !!}</th>
                              <th class="">{!! trans('Price') !!}</th>
                              <th class="">{!! trans('Sort') !!}</th>
                              <th colspan="5">{!! trans('Action') !!}</th>

                            </tr>
                         </thead>
                        <tbody>
                           @forelse($uploads as $video)
                           <tr>
                              <td  contenteditable=" {{$loop->even ? 'true' : ''}}">{{ $loop->iteration }}</td>
                              <td contenteditable="true">{{$video->name}}</td>
                              {{-- <td contenteditable="true">{{$video->categories->category_name}}</td> --}}
                              <td contenteditable="true">
                                @if($video->status == '1')
                                  <span class="badge badge-success">Active</span>
                                  @else
                                  <span class="badge badge-warning">Deactive</span>
                                  @endif
                              </td>
                              <td contenteditable="true"><img src="{{ asset($video->thumbnail_image) }}" class="msg-photo" alt="" style="width: 100px; height:60px;" /></td>
                              <td contenteditable="true">
                                 <video width="320" height="100" controls>
                                  <source src="{{ asset($video->upload) }}" type="video/mp4">
                                 </video>
                              </td>
                              <td contenteditable="true">{{$video->price}}</td>
                              <td>
                                 <span class="table-up"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a></span>
                                 <span class="table-down"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a></span>
                              </td>
                              <td>
                                    <a  href="{{route('public.upload.edit',$video->id)}}"
                                    class="btn btn-light btn-rounded btn-sm px-2 my-0"> Edit  </a>
                                 <span class="table-remove" onclick="return confirm('Want to delete ?')">
                                    <a  href="{{route('public.upload.destroy',$video->id)}}"
                                    class="btn btn-primary btn-rounded btn-sm my-0">Remove</a>
                                 </span>
                              </td>
                            </tr>
                           @empty
                           <tr>
                               <td class="text-muted text-center" colspan="100%">
                                   {{ trans($empty_message) }}</td>
                           </tr>
                       </tbody>

                       @endforelse
                      </table>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection
