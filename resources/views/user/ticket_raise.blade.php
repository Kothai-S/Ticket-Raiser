@include('template.header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Tickets</h4>
            <form class="forms-sample" action="{{ route('addticket') }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                <input type="hidden" id="userid" name="userid" class="form-control" value="{{ $userId }}">
              </div>

              <div class="form-group">
                <label for="reason">Reason</label>
                <select class="form-control " id="reasonSelect" name="reason">
                  <option value="Select Reason" disabled selected>Select Reason</option>
                  @foreach($tickets as $reason)
                    <option value="{{ $reason->id}}">{{ $reason->reason }}</option>
                  @endforeach
                  <option value="other">Others</option>
                </select>
              </div>

              <div class="form-group" id="otherReasonInput" style="display: none;">
                <label for="otherReason">Other Reason</label>
                <input type="text" class="form-control form-input" id="otherReason" name="sub_reason">
              </div>
             
              <div class="form-group">
                <select id="subReasonSelect" name="sub_reason" class="form-control" style="display: none;"></select>
                @error('reason')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              
              <div id="instructionContainer" class="form-group">
                <!-- <label for="instruction">Discription :</label> -->
                <div id="instructionList"></div>
              </div>
              
              <div class="form-group">
                <label for="image" class="form-label">ScreenShot </label>
                <div class="input-group">
                  <input type="file" id="image" name="image" class="form-control form-input">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-secondary clear-input" data-target="image">Clear</button> 
                       
                  </div>
                </div>
                @error('image')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="link">Enter Link</label>
                <div class="input-group">
                  <input type="text" id="link" name="link" class="form-control form-input">  
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-secondary clear-input" data-target="link">Clear</button>
                        
                  </div>
                </div>
                @error('link')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary mr-2" id="saveButton">Send</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function(){
$('.clear-input').click(function() {
      $('#subReasonSelect').hide();
      $('#textareaInput').hide();
    });

    $('#reasonSelect').change(function() {
      var reasonId = $(this).val();
      if (reasonId !== "Select Reason") {
        $('#subReasonSelect').show();
        $.ajax({
          url: '/fetch-sub-reasons',
          method: 'GET',
          data: { reason_id: reasonId },
          success: function(data) {
            $('#subReasonSelect').empty();
            $.each(data, function(key, value) {
              $('#subReasonSelect').append('<option value="' + value.reason + '" data-instruction="' + value.instruction + '">' + value.reason + '</option>');
            });
          }
        });
      } else {
        $('#subReasonSelect').hide();
      }
    });

    $('#reasonSelect').change(function() {
        var reasonSelected = $(this).val();
        if (reasonSelected === "Select Reason") {

            $('#subReasonSelect').hide();
        } else if (reasonSelected === "other") {
           
            $('#otherReasonInput').show();
            $('#subReasonSelect').hide();
        } else {
           
            $('#otherReasonInput').hide();
            $('#subReasonSelect').show();
        }
    });

  
    $('#subReasonSelect').change(function(){
        var selectedOption = $(this).children("option:selected");
        var instruction = selectedOption.data('instruction');
        var instructionList = $('#instructionList');
        instructionList.empty();        
        if (instruction) {
            var points = instruction.split("\n");
            var ul = $('<ul></ul>');
            $.each(points, function(index, point) {
                ul.append('<li>' + point + '</li>');
            });
            instructionList.empty().append(ul);
        }
    });

    function toggleOtherReasonInput() {
      var selectedOption = $('#reasonSelect').val();
        if (selectedOption === 'other') {
            $('#otherReasonInput').show();
        } else {
            $('#otherReasonInput').hide();
        }
    }
    toggleOtherReasonInput();
});
$('.clear-input').click(function() {
        var targetId = $(this).data('target');
        if (targetId === 'image') {
            $('#image').val(''); 
        } else if (targetId === 'link') {
            $('#link').val(''); 
        }
        $(this).closest('.form-group').remove();
    });

</script>
<script>
  var formSubmitted = false; 
    $('#saveButton').click(function (e) {
      if (formSubmitted) {
        e.preventDefault(); 
      } else {
        formSubmitted = true; 
    }
  });
</script>

@include('template.footer')

