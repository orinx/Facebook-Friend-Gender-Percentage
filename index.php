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
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
    <div class="col-md-4 col-md-offset-4" style="margin-top:100px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="text-center">看看你的好友性別比例！</h4>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p>這是一個可以分析你好友男女比例的小玩具</p>
                    <p>加了很多好友，卻不知道究竟是男生多還是女生多麻？</p>
                    <p>按下登入就對了！</p>    
                </div>
                
                
                <?php
                    if($facebook->getUser() === 0){
                        echo '<a class="btn btn-success col-md-4 col-md-offset-4" href="' . $facebook->getLoginUrl(array('scope'=>'friends_about_me,user_friends,user_about_me','redirect_uri'=>'http://local.host/sitcon_example/example.php')) . '">登入</a>';
                    }else{
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
                        echo '<a class="btn btn-primary col-md-5 btn-lg">男生' . round($male_c / ($male_c + $female_c)*100) . '%</a>';
                        echo '<a class="btn btn-danger col-md-5 pull-right btn-lg">女生' . round($female_c / ($male_c + $female_c)*100) . '%</a>';

                    }
                ?>
            </div>
            <div class="panel-footer">
                <div class="text-center">
                    台科大程式設計研究社。林熙哲
                </div>
            </div>
        </div>
    </div>
</body>
</html>