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
                            <h4 class="card-title">Ticket List</h4>
                        </div>

                    </div>
                    <div class="iq-card-body">
                        <div id="table" class="table-editable">
                            <span class="table-add float-right mb-3 mr-2">
                                <a href="{{Route('user.ticket.create')}}" class="btn btn-sm iq-bg-success"><i class="ri-add-fill"><span class="pl-1">Submit Ticket</span></i>
                                </a>
                            </span>
                            <form action="" method="GET" class="form-inline">
                                <div class="form-group mb-2">
                                    <label for="exampleFormControlSelect1" class="mr-2">Filter Ticket:  </label>
                                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                                        <option value="">All</option>
                                        <option value="pending" @if (isset($_GET['status']) && $_GET['status'] == 'pending') selected @endif>Pending</option>
                                        <option value="open" @if (isset($_GET['status']) && $_GET['status'] == 'open') selected @endif>Open</option>
                                        <option value="completed" @if (isset($_GET['status']) && $_GET['status'] == 'completed') selected @endif>Completed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary ml-2">Filter</button>
                            </form>
                            <table class="table table-bordered table-responsive-md table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>T.Number</th>
                                        <th>title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{$tickets->firstItem() + $loop->index}}</td>
                                        <td>{{$ticket->ticket_number}}</td>
                                        <td>{{$ticket->title}}</td>
                                        <td>{{$ticket->created_at->format('g:i A | d M Y')}}</td>
                                        <td>
                                            @if ($ticket->status == 'pending')
                                            <span class="badge badge-primary">Pending</span>
                                            @elseif($ticket->status == 'open')
                                            <span class="badge badge-warning">Open</span>
                                                {{-- @if( count($ticket->replies) > 0 )
                                                    <span class="badge badge-primary">{{count($ticket->replies)}}</span>
                                                @endif --}}
                                            @elseif ($ticket->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ticket->status == 'pending')
                                            <button class="btn btn-primary">Pending</button>
                                            @else
                                            <a href="{{route('user.ticket.show', $ticket->id)}}"  class="btn btn-primary">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$tickets->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
