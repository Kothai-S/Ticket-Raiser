@include('template.admin_header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Instructions</h4>
            <form class="forms-sample" action="{{ route('showreason') }}" method="post">
              @csrf
              
              <div class="form-group">
                <label for="parent_Id">Category</label>
                <select class="form-control" id="parent_Id" name="parent_id">
                  <option value="0">New</option>
                  @foreach($reasons as $reason)
                    <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                  @endforeach
                </select>
                @error('parent_id')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>        
              
              <div class="form-group">
                <label for="searchreason">Reason</label>
                <input type="text" class="form-control form-input" id="searchreasonInput" placeholder="Enter reason" name="reason" list="reason-suggestions" value="{{ old('reason') }}">
             
                @error('reason')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="instruction">Preliminary Instruction</label>
                <textarea class="form-control" id="editor" name="instruction">{{ old('instruction') }}</textarea>
                @error('instruction')
                 <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              

              <div class="form-group">
                <button type="submit" class="btn btn-primary mr-2" id="saveButton">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
 
  CKEDITOR.replace('editor', {
    enterMode: CKEDITOR.ENTER_BR,    
    shiftEnterMode: CKEDITOR.ENTER_P, 
    removePlugins: 'elementspath',  
    toolbar: [
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
      { name: 'links', items: [ 'Link', 'Unlink' ] },
      { name: 'tools', items: [ 'Maximize' ] }
    ]
  });
</script>

@include('template.footer')
