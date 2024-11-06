@include('template.admin_header')
<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Reason For Tickets</h4>
            <form class="forms-sample" action="{{ route('updateReason', $reason->id) }}" method="post">
              @csrf
                <div class="form-group">
                    <label for="searchreason">Reason</label>
                    <input type="text" class="form-control form-input" id="searchreasonInput" placeholder="Enter reason" name="reason" list="reason-suggestions" value="{{ $reason->reason }}">
                    <input type="hidden" id="selectedReasonId" name="selectedReasonId">
                    <div id="reasonSelect" class="list-group" style="display:none;"></div>
                    @error('reason')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                </div>

                <div class="form-group">
                   <label for="instruction">Instruction</label>
                   <textarea class="form-control form-input" id="instruction" placeholder="Instruction" name="instruction">{{ $reason->instruction }}</textarea>
                   @error('instruction')
                    <p class="text-danger">{{ $message }}</p>
                   @enderror
                </div>

                <div class="form-group">
                    <label for="parent_Id">Category</label>
                    <select class="form-control" id="parent_Id" name="parent_id">                   
                     <option value="0" {{ $reason->category == 0 ? 'selected' : '' }}>New</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $reason->category == $category->id ? 'selected' : '' }}>{{ $category->reason }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') 
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>




                <div class="form-group">
                  <button type="submit" class="btn btn-primary mr-2" id="saveButton">Update</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
 

@include('template.footer')
