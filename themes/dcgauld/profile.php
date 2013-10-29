
    

      <p class="description">Hi, I'm David Gauld. I'm a <strong>Software Engineer</strong> at IBM, a <strong>web designer/developer</strong> and a Computer Science undergraduate from Portsmouth, England. You can follow me on <a href="http://twitter.com/dcgauld">Twitter</a>, view my code on <a href="http://github.com/dcgauld">GitHub</a>, connect with me on <a href="http://uk.linkedin.com/in/dcgauld">LinkedIn</a> or send me a good old fashioned <a href="mailto:dcgauld@gmail.com">email</a>.</p>
      <a href="https://twitter.com/dcgauld" class="twitter-follow-button" data-show-count="false">Follow @dcgauld</a>
<p><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></p>
<div class="divider"></div>
<p><strong>Instagram Photos</strong></p>
<p class="thumbs"><?php
    // Supply a user id and an access token
    $userid = "11777829";
    $accessToken = "11777829.ab103e5.c6c19bce0af34a74861b855f261009d0";

    // Gets our data
    function fetchData($url){
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_TIMEOUT, 20);
         $result = curl_exec($ch);
         curl_close($ch); 
         return $result;
    }

    // Pulls and parses data.
    $result = fetchData("https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}");
    $result = json_decode($result);
  ?>

  <?php $i = 0;
  foreach ($result->data as $post) { if ($i == 6) break; ?>
    <!-- Renders images. @Options (thumbnail,low_resoulution, high_resolution) -->
    <a class="instagram_thumb" href="<?= $post->link ?>"><img src="<?= $post->images->thumbnail->url ?>"></a>
  <?php $i++; } ?></p>
  <div class="divider"></div>
  <p>This blog is powered by <a href="http://github.com/dcgauld/Signpost">Signpost</a>. Any contributions are appreciated.</p>