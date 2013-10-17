<script>
  $('.selectpicker').selectpicker();
  $('#modal-form-submit').on('click', function(e){
    // We don't want this to act as a link so cancel the link action
    e.preventDefault();

    // Find form and submit it
    $('#modal-form').submit();
  });

  $('#modal-form').on('submit', function(){

  //Serialize the form and post it to the server
  $.post("/yourReceivingPage", $(this).serialize(), function(){

    // When this executes, we know the form was submitted

    // To give some time for the animation, 
    // let's add a delay of 200 ms before the redirect
    var delay = 200;
    setTimeout(function(){
      window.location.href = 'successUrl.html';
    }, delay);

    // Hide the modal
    $("#my-modal").modal('hide');

  });

  // Stop the normal form submission
  return false;
});
$('#dob').datepicker({
    onSelect: function(value, ui) {
        var today = new Date(), 
            dob = new Date(value), 
            age = new Date(today - dob).getFullYear() - 1970;
        
        $('#age').text(age);
    },
    maxDate: '+0d',
    yearRange: '1920:2010',
    changeMonth: true,
    changeYear: true
});
$(function(){
	$("#background-image").fullscreenBackground();
});
</script>