function updateUserList() {
  if($(".usersmanager").length>0) {
    $.ajax("userslist", {      
      success: function(response){
        $(".usersmanager").html(response);      
        }
      }
    );
  }
}

$(document).ready(function(){
  updateUserList();

  $("div.usersmanager").on('click', '.btn-status', function(event)
  {
    event.preventDefault();
    $.ajax("setstatus", {
      data: {"id":$(this).attr('id')},   
      success: function(feedback) {
          if(feedback=="success")
              updateUserList();
          else alert(feedback);
      }
    });
  });

   $("div.usersmanager").on('click', '.btn-level', function(){
   
    $.ajax("setlevel", {
      data: {"role":$(this).attr('id'),"id":$(this).parent().parent().parent().attr('id')},   
      success: function(feedback) {
        if(feedback=="success") {
          updateUserList();
        }
        else
          alert(feedback);
      }
    });
  });
  
 

});
