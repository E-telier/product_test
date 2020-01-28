$(document).ready(function() {
      $('input[type=number]').each(function() {
          let maxlength = $(this).attr('maxlength');
          if (maxlength!==undefined) {
              $(this).on('keypress', function(e) {                  
                  if ((''+$(this).val()).length>=maxlength) {
                      let newVal = (''+$(this).val()).substring(0, $(this).attr('maxlength'));
                      $(this).val(newVal);
                      e.preventDefault();
                  }
              });
          }
      })
  });