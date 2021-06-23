var timer;
var ccards = document.getElementById("collection-cards");
var last_ID = 0;
var chet = false;

function Init() {
    document.getElementById('FormNewComment').reset();
    ccards = document.getElementById("collection-cards");
    TactTimer();
    timer = setInterval(TactTimer, 1000);
}

function UnInit() {
  if(timer!=null)
      clearInterval(timer);
}


$(document).ready(function() {
    $('#FormNewComment').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'api/setComment.php?id='+last_ID,
            data: $(this).serialize(),
            success: function(response)
            {
                if( typeof response == "number")
                {
                    alert("Присутсвуют пропущенные поля.")
                }
                else
                {
                    if(timer!=null)
                        {clearInterval(timer);timer = null;}
                    var arr = response;
                    AddCard(arr);
                    document.getElementById('FormNewComment').reset();
                    if(timer==null)
                        timer = setInterval(TactTimer, 1000);
                }
            }
           
       });
     });
});

function AddCard(arr)
{
    var len = arr.length;
    var text_cards = "";
    var css_bg="";
    if(len > 0)
    {
      last_ID = arr[len-1][0];
      for (var i = 0; i < len; i++) {
          if(chet)
          {css_bg = "green";}
          else
          {css_bg="grey";}
          chet = !chet;
        text_cards+=
        '<div class="col-4 object-card '+css_bg+' ">'+
        '<div class="card mcard">'+
        '<div class="card-headername name">'+arr[i][2]+'</div>'+
        '<div class="card-body">'+
        '<h5 class="card-title  email">'+arr[i][3]+'</h5>'+
        '<p class="card-text c_text">'+arr[i][4]+'</p>'+
        '</div></div></div>';
      }
      ccards.innerHTML+=text_cards;
    }
}

function TactTimer()
{
  $.ajax({
            type: "GET",
            url: '/api/getComments.php?id='+last_ID,
            success: function(response)
            { 
              
              var arr = response;
              AddCard(arr);
              /*var len = arr.length;
              var text_cards = "";
              if(len > 0)
              {
                  last_ID = arr[len-1][0];
                  for (var i = 0; i < len; i++) {
                    text_cards+=
                    '<div class="col-4 object-card">'+
                    '<div class="card mcard">'+
                    '<div class="card-header name">'+arr[i][2]+'</div>'+
                    '<div class="card-body">'+
                    '<h5 class="card-title email">'+arr[i][3]+'</h5>'+
                    '<p class="card-text c_text">'+arr[i][4]+'</p>'+
                    '</div></div></div>';
                  }
                  ccards.innerHTML+=text_cards;
              }
              else
              {
                //alert("Связь с сервером потереяна: "+response)
              }*/
              //var length = mess[]
              
            },
          error: function (request)
            {
                alert(request.responseText);
            }
});
    
}
