$(document).ready(function() {

      $('table.sales th').click(function() {

            if ($(this).attr('colspan')!==undefined) {
                  return false;
            }

            let JQTable = $(this).closest('table');
            let field = $(this).attr('id');            
            let sorting = 'asc';
            if ($(this).hasClass('asc')) {
                  sorting = 'desc';                  
            }
            JQTable.find('th').removeClass('asc').removeClass('desc');

            $(this).addClass(sorting);

            let sortedLines = JQTable.find('tr:gt(1)');
           
            sortedLines.sort(function(a, b) {

                  let result = 0;

                  let valueA = $(a).find('.'+field).html();
                  if (!isNaN(valueA)) { valueA = parseInt(valueA); }
                  let valueB = $(b).find('.'+field).html();
                  if (!isNaN(valueB)) { valueB = parseInt(valueB); }

                  if (valueA > valueB) {
                        result = 1;
                  } else if (valueA < valueB) {
                        result = -1;
                  }

                  if (sorting==='desc') {
				result = -result;
                  }

                  //console.log(valueA+' '+valueB+' '+result);
                  
                  return result;

            });

            JQTable.append(sortedLines);

      });

});