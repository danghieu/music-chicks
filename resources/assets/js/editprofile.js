$(document).ready(function(){
    $('#btn-avatar').click(function(){
       $('.edit-avatar').slideToggle('slow');
       $('.edit-pass').hide();
       $('.edit-email').hide();
       $('.edit-name').hide();

       });
    $('#btn-pass').click(function(){
       $('.edit-pass').slideToggle('slow');
       $('.edit-email').hide();
       $('.edit-avatar').hide();
       $('.edit-name').hide();
     
    });
    $('#btn-email').click(function(){
       $('.edit-email').slideToggle('slow');
      $('.edit-pass').hide();
      $('.edit-avatar').hide();
      $('.edit-name').hide();
      
    });
     $('#btn-name').click(function(){
      $('.edit-name').slideToggle('slow');
      $('.edit-pass').hide();
      $('.edit-avatar').hide();
      $('.edit-email').hide();
    });
    
});

