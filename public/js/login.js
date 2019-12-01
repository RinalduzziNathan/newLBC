// Get the button that opens the modal
//var form = document.getElementById("form-connect");

// Get the <span> element that closes the modal
//var btnclose = document.getElementById("closeLogin");


//btnclose.onclick = function() {
  //  if (!error){
    //    $('#loginModal').modal('hide');
    //}
//};

$('#openLogin').click(function(){
    console.log("tese");
    $.ajax({
        url:'/login',
        type:'GET',
        datatType:'json',
        data:{},
        async:true,
        success:function(response){
            $('#something').html(response);
            console.log(response);

        }
    })
});

