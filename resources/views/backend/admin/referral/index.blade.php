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
                        My Referral Link : <span >{{auth()->user()->getReferralLink()}}</span>
                      </span>
                      <table class="table table-bordered table-responsive-md table-striped text-center">

                         <thead>
                            <tr>
                              <th>S.N</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Date</th>
                              <th>Price</th>
                            </tr>
                         </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>1</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at->diffForHumans()}}</td>
                                <td>${{$user->referral->price}}</td>
                            </tr>
                            @endforeach
                       </tbody>
                      </table>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection
