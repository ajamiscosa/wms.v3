"<html>Please select the date range below:<br/><br/><input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='Start'> to <input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckEnd' name='End'> <script>$('#pckStart').on('ready', function(){var validFrom = $('#pckStart').datepicker({format: 'MM dd, yyyy', autoclose: true, maxDate : new Date() }); }); $('#pckEnd').on('ready', function(){ var validFrom = $('#pckEnd').datepicker({ format: 'MM dd, yyyy', autoclose: true, maxDate : new Date() }); }); </script></html>"