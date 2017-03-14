// Convert a data URI to blob
function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(',')[1]);
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], {
        type: 'image/png'
    });
}

// POST FB
function postFacebook(filename,caption,description,link,picture){
  FB.api('https://graph.facebook.com/', 'post', {
      id: link,
      scrape: true
  }, function(response) {
    FB.ui({
      method: 'share',
      display: 'popup',
      title: filename,
      caption: 'http://ila.edu.vn',
      description: description,
      picture: picture,
      href : link,
    },function(res){
      if(typeof res !== 'undefined'){

        var linkfb = 'https://www.facebook.com/'+res.post_id;
        $.ajax({
          'url': '{!!route("frontend.AjaxOrder")!!}',
          'type':'POST',
          data: {link:linkfb, _token:$("meta[name='csrf-token']").attr("content")},
          success:function(data){

            if(data.rs == "Đã tham dự"){
                window.location = "{!!route('frontend.Done')!!}";
            }
          }
        })

      }else{
        alert('Để hoàn tất cuộc thi, bạn phải share bài viết của bạn trên status ở chế độ public!');
        $('.overlay-bg').fadeOut();
      }
    })
  });
}



  $(document).ready(function(){

    $('.form-letter').validate({
      elementError: 'span',
      errorPlacement: function(error, element) {
          //Custom position: first name
          if (element.attr("name") == "content" ) {
              $("#validate-content").text($(error).html());
          }else if(element.attr("name") == "quote"){
              $("#validate-quote").text($(error).html());
          }else{
            element.after(error);
          }
      },
      rules: {
        content: "required",
        quote: "required",
      },
      messages:{
        content: 'Vui lòng nhập nội dung bức thư',
        quote: 'Vui lòng nhập câu trích dẫn'
      },
      submitHandler:function(data){
        var from = $('input[name="from"]').val();
        var message = $('textarea[name="content"]').val();
        var quote = $('textarea[name="quote"]').val();
        $('.overlay-bg').fadeIn();

        // getPictureAjax();
        FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
            FB.api('me/picture?type=large',function(response){
              var img = response.data.url;
              $.ajax({
                url: '{!!route("frontend.AjaxImg")!!}',
                type: 'POST',
                data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
                success:function(data){
                  console.log(data.rs)
                }
              })
            });
            $.ajax({
              url:'{!!route("frontend.ajaxLetter")!!}',
              type:'POST',
              data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
              success:function(data){
                // console.log(data.rs);
                $('#preview').html(data.rs);

                /*RENDER IMAGE*/
                var element = $('#preview');
                element.show();
                html2canvas(element, {
                    onrendered: function (canvas) {
                      var dataimg = canvas.toDataURL("image/png");
                      try {
                          blob = dataURItoBlob(dataimg);
                      } catch (e) {
                          console.log(e);
                      }

                      $.ajax({
                        url: '{!!route("frontend.AjaxGetImg")!!}',
                        type:'POST',
                        data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
                        success:function(data){
                            console.log(data.rs);
                            postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}',data.rs)
                        }
                      });

                    }
                  });
                element.hide();
              }
            });
          } else if (response.status === 'not_authorized') {
            alert('Bạn cần cấp quyền cho ứng dụng Letter From Future!');
            $('.overlay-bg').fadeOut();
            FB.login(function(response){
              FB.api('me/picture?type=large',function(response){
                var img = response.data.url;
                $.ajax({
                  url: '{!!route("frontend.AjaxImg")!!}',
                  type: 'POST',
                  data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
                  success:function(data){
                    if(data.rs = 'ok'){
                      console.log('IMG upload OK');
                    }
                  }
                })
              });
              $.ajax({
                url:'{!!route("frontend.ajaxLetter")!!}',
                type:'POST',
                data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
                success:function(data){
                  // console.log(data.rs);
                  $('#preview').html(data.rs);

                  /*RENDER IMAGE*/
                  var element = $('#preview');
                  element.show();
                  html2canvas(element, {
                        onrendered: function (canvas) {
                          var dataimg = canvas.toDataURL("image/png");
                          try {
                              blob = dataURItoBlob(dataimg);
                          } catch (e) {
                              console.log(e);
                          }
                          $.ajax({
                            url: '{!!route("frontend.AjaxGetImg")!!}',
                            type:'POST',
                            data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
                            success:function(data){
                              postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}',data.rs);
                            }
                          });

                        }
                    });
                    element.hide();
                  }
                });
              },{scope: "email"});
          } else {
            FB.login(function(response){
              FB.api('me/picture?type=large',function(response){
                var img = response.data.url;
                $.ajax({
                  url: '{!!route("frontend.AjaxImg")!!}',
                  type: 'POST',
                  data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
                  success:function(data){
                    console.log(data.rs)
                  }
                })
              });
              $.ajax({
                url:'{!!route("frontend.ajaxLetter")!!}',
                type:'POST',
                data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
                success:function(data){
                  // console.log(data.rs);
                  $('#preview').html(data.rs);

                  /*RENDER IMAGE*/
                  var element = $('#preview');
                  element.show();
                  html2canvas(element, {
                    onrendered: function (canvas) {
                      var dataimg = canvas.toDataURL("image/png");
                      try {
                          blob = dataURItoBlob(dataimg);
                      } catch (e) {
                          console.log(e);
                      }
                        $.ajax({
                          url: '{!!route("frontend.AjaxGetImg")!!}',
                          type:'POST',
                          data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
                          success:function(data){
                            if(data.rs = 'ok'){
                              postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}',data.rs)
                            }
                          }
                        });

                      }
                    });
                    element.hide();
                  },
                });

            },{scope: "email"});
          }
        });
      }
    })
  });
