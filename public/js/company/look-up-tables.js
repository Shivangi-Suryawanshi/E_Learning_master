function get_positions(whose,whose_id,where_id){
  $.ajax({
           type: "POST",
           url: COMPANY_URL+'get-positions-with-selected',
           data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
           success: function(response){
             $('#'+where_id).empty();
             response.optn_values&&response.optn_values.map((item, idx) =>{
               var text = response.optn_text[idx];
               var selected = response.optn_selects[idx];
               var $newOption = $("<option "+selected+"></option>").val(item).text(text);
               $("#"+where_id).append($newOption).trigger('change');
             })
           }
  });
}

function get_departments(whose,whose_id,where_id){
  $.ajax({
           type: "POST",
           url: COMPANY_URL+'get-departments-with-selected',
           data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
           success: function(response){
             $('#'+where_id).empty();
             response.optn_values&&response.optn_values.map((item, idx) =>{
               var text = response.optn_text[idx];
               var selected = response.optn_selects[idx];
               var $newOption = $("<option "+selected+"></option>").val(item).text(text);
               $("#"+where_id).append($newOption).trigger('change');
             })
           }
  });
}
