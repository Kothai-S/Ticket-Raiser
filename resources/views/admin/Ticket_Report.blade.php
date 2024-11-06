@include('template.admin_header')

<div class="main-panel">
   <div class="content-wrapper">
       <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card"> 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>                  
                                        <th>Name</th>
                                        <th>total_ticket</th>
                                        <th>completed_ticket</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($adminsWithCount) && is_array($adminsWithCount))
                                    @foreach($adminsWithCount as $adminsAndCounts)
                                        <tr>
                                            <td>{{ $adminsAndCounts['name'] }}</td>
                                            <td>{{ $adminsAndCounts['total_count'] }}</td>
                                            <td>{{ $adminsAndCounts['completed_ticket'] }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">Not attend for  tickets.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  

        </div>




@include('template.footer')
