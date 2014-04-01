<?php

include('vendor/autoload.php');

$config = array('appId'=>'762313083780973',
                'secret'=>'00bc8a8cc47df125db97e65948a907ec');

$facebook = new Facebook($config);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>看看你的好友性別比例！</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-4977677-10', 'coder.tw');
      ga('send', 'pageview');

    </script>
</head>
<body>
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 col-lg-6 col-lg-offset-3" style="margin-top:100px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="text-center">看看你的好友性別比例！</h4>
            </div>
            <div class="panel-body">          
                <?php
                    if($facebook->getUser() === 0){
                        
                        ?>
                        <div class="text-center">
                            <p>這是一個可以分析你好友男女比例的小玩具</p>
                            <p>加了很多好友，卻不知道究竟是男生多還是女生多麻？</p>
                            <p>按下登入就對了！</p>    
                        </div>
                        <?php
                        echo '<a class="btn btn-success col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4 col-sm-6 col-sm-offset-3" href="' . $facebook->getLoginUrl(array('scope'=>'friends_about_me,user_friends,user_about_me','redirect_uri'=>'http://gender.coder.tw/index.php')) . '">登入</a>';
                    }else{
                        $profile = $facebook->api('/me');
                        echo '<h3 class="text-center">' . $profile['name'] . '<small> 你的好友性別比例是</small></h3>';
                        $data = $facebook->api(array('method'=>'fql.query','query'=>'SELECT name, sex FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())'));
                        $male_c = 0;
                        $female_c = 0;

                        foreach($data as $row){
                            if($row['sex'] == 'female'){
                                $female_c++;
                            }else{
                                $male_c++;
                            }
                        }
                        echo '<div class="btn-group col-md-12 col-sm-12 col-xs-12 col-lg-12">';
                        echo '<a class="btn btn-primary btn-lg" style="width:' . round($male_c / ($male_c + $female_c)*100) . '%;">男生' . round($male_c / ($male_c + $female_c)*100) . '%</a>';
                        echo '<a class="btn btn-danger btn-lg" style="width:' . round($female_c / ($male_c + $female_c)*100) . '%;">女生' . round($female_c / ($male_c + $female_c)*100) . '%</a>';
                        echo '</div>';
                    }
                ?>

            </div>
            <div class="panel-footer">
                <div class="text-center">
                    <a href="https://www.facebook.com/ntust.coding" target="_blank">台科大程式設計研究社</a>。<a href="http://me.coder.tw" target="_blank">林熙哲</a>。<div class="fb-share-button" data-href="http://gender.coder.tw/" data-type="button_count"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=762313083780973";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>