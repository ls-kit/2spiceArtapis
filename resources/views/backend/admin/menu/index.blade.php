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
                      <h4 class="card-title">Menus</h4>
                   </div>

                </div>
                <div class="iq-card-body">
                   <div id="table" class="table-editable">
                      <span class="table-add float-right mb-3 mr-2">
                      <a href="{{Route('public.menu.create')}}" class="btn btn-sm iq-bg-success"><i
                         class="ri-add-fill"><span class="pl-1">Add New</span></i>
                      </a>
                      </span>
                      <table class="table table-bordered table-responsive-md table-striped text-center">

                         <thead>
                            <tr>
                              <th>{!! trans('SL') !!}</th>
                              <th>{!! trans('Name') !!}</th>
                              <th class="hidden-xs">{!! trans('Status') !!}</th>
                              <th class="hidden-xs">{!! trans('Link') !!}</th>
                              <th class="hidden-xs">{!! trans('Type') !!}</th>
                              <th class="">{!! trans('Icon Class') !!}</th>
                              <th class="">{!! trans('Sort') !!}</th>
                              <th colspan="5">{!! trans('Action') !!}</th>

                            </tr>
                         </thead>
                        <tbody>
                           @forelse($menus as $menu)
                           <tr>
                              <td contenteditable="true">{{ $loop->iteration }}</td>
                              <td contenteditable="true">{{$menu->name}}</td>
                              <td contenteditable="true">
                                @if($menu->status == '1')
                                  <span class="badge badge-success">Active</span>
                                  @else
                                  <span class="badge badge-warning">Deactive</span>
                                  @endif
                              </td>
                              <td contenteditable="true">{{$menu->link}}</td>
                           @if($menu->type == 1)
                              <td contenteditable="true">Header</td>
                           @elseif($menu->type == 2)
                              <td contenteditable="true">Footer</td>
                           @elseif($menu->type == 3)
                              <td contenteditable="true">User</td>
                           @else
                              <td contenteditable="true">Social</td>
                           @endif
                              <td contenteditable="true">{{$menu->icon}}</td>
                              <td>
                                 <span class="table-up"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a></span>
                                 <span class="table-down"><a href="#!" class="indigo-text"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a></span>
                              </td>
                              <td>
                                    <a  href="{{route('public.menu.edit',$menu->id)}}"
                                    class="btn btn-light btn-rounded btn-sm px-2 my-0"> Edit  </a>
                                 <span class="table-remove">
                                    <a  href="{{route('public.menu.destroy',$menu->id)}}"
                                    class="btn btn-primary btn-rounded btn-sm my-0">Remove</a>
                                 </span>
                              </td>
                            </tr>
                           @empty
                           <tr>
                               <td class="text-muted text-center" colspan="100%">
                                   No Menu Available</td>
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
