<div class="wrap-content-left">
  <h4 class="title-preview">Thư từ tương lai</h4>
  <canvas id="img-avatar" width="80" height="80"></canvas>
  <div class="wrap-top">
    <p class="normal-text"><label for="from">From: </label><input type="text" name="from" class="input-letter from-input" disabled="disabled" value="{!!$from!!} 2030"></p>
    <p class="normal-text"><label for="to">To: </label><input type="text" name="to" class="input-letter to-input" disabled="disabled" value="{!!$from!!}"></p>
  </div>
  <div class="wrap-bottom">
    <textarea name="content" class="content-input">{!!$quote!!}</textarea>
  </div>
  <div class="signature">
    <p class="normal-text">Sincerely</p>
    <p class="normal-text"><b>{!!$from!!}</b></p>
  </div>
</div>
<script>
  var canvas = document.getElementById('img-avatar');
  var ctx = canvas.getContext("2d");
  var img = new Image();
  img.onload = function(){
    ctx.drawImage(img,(canvas.width-img.width)/2,(canvas.height-img.height)/2)
  }
  img.src="{!!$img!!}";
</script>
