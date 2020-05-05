<?php
date_default_timezone_set("Asia/Seoul");
$getuser = $_GET['user'];
$getdate = $_GET['date'];
$user = scandir("./user");

function checkuser(){
  if(isset($getuser)){
    return $getuser.'의 ';
  }
}

function getoldtodo(){
  $getold = file_get_contents('./user/'.$getuser.'/'.$getdate);
  echo nl2br($getold);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($getuser)){ echo $getuser.'\'s ';} ?>스터디 플래너</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/main.css">
  </head>
  <body>

    <div class="header">
      <p class="title"><?php if(isset($getuser)){ echo $getuser.'\'s  ';} ?>스터디플래너</p>
    </div>

    <div class="content">
      <div class="top">
        <?php
        if(isset($getuser)){
          $savename = $getuser;
          $savedate = $getdate; ?>
          <a class="datechange_btn" href="index.php?user='.$savename.'&date='.date("Y-m-d", strtotime('-1 days')).'"><</a>
          <span class="showtime"><?=$getdate?></span>
          <a class="datechange_btn" href="index.php?user='.$savename.'&date='.date("Y-m-d", strtotime('+1 days')).'">></a>

        <?php } ?>

      </div>

      <div class="mid">

        <?php
        if(isset($getuser)){ ?>
          <div class="yesuser"> <?php
            $userfile = scandir("./user/".$getuser);
            $k = 0;
            $find = 0;
            while($k<count($userfile)){
              if($userfile[$k]==$getdate){

                $timefile = file_get_contents('./user/'.$getuser.'/'.$getdate);
                $lists = explode("/", $timefile);
                $a = 0;
                $find = 1;
                while($a<sizeof($lists)-1){
                  $todo = explode(":", $lists[$a]);
                  echo '<div class="todo">';
                  if($todo[1]=="yes"){
                      echo '<a class="yes" href="index.php?user='.$getuser.'&date='.$getdate.'&update='.$todo[0].'">'.$todo[0].'</a>';

                      if($_GET['update']==$todo[0]){ ?>
                        <form class="update" action="update" method="post">
                          <input type="hidden" name="oldtodo" value="<?=$todo[0]?>">
                          <input type="text" name="changedtodo" value="<?=$todo[0]?>">
                          <input type="submit" value="바꾸기">
                          <a class="btn" href="#">완료</a>
                        </form>

                      <?php }


                      } else{
                      echo '<a class="no" href="index.php?user='.$getuser.'&date='.$getdate.'&update='.$todo[0].'">'.$todo[0].'</a>';

                      if($_GET['update']==$todo[0]){ ?>
                        <form class="update" action="update" method="post">
                          <input type="hidden" name="oldtodo" value="<?=$todo[0]?>">
                          <input type="text" name="changedtodo" value="<?=$todo[0]?>">
                          <input type="submit" value="바꾸기">
                          <a class="btn" href="#">완료취소</a>
                        </form>

                      <?php }
                  }
                  echo '</div>';
                  $a = $a+1;
                }
              }
              $k = $k+1;
            }
            if($find==0){
              echo '<p class="todo">파일이 존재하지 않습니다.</p>';
            }

            if($_GET['act']=="add")
            { ?>
              <div class="content">
                <form class="add" action="add_act.php" method="post">

                  <input type="hidden" name="username" value=<?=$getuser?>></input>
                  <input type="hidden" name="date" value=<?=$getdate ?>></input>
                  <input type="text" name="newtodo" placeholder="새로운 계획을 입력해주세요" required>

                  <input type="submit" value="추가하기">
                </form>
              </div>
            <?php } ?>
          </div>
        <?php } else { ?>
          <div class="nouser"> <?php
          $i = 0;
          while($i<count($user)){
            $username = $user[$i];

            if($username!='.'){
              if($username!='..'){ ?>
                <li><a class="userlist" href="index.php?user=<?=$username?>&date=<?=date("Y-m-d")?>"><?=$username?></a></li> <?php
              }
            }
            $i = $i +1;
          } ?>
          </div> <?php
        }

        ?>
      </div>

      <div class="bot">

        <?php
        if(isset($getuser)){
          $savename = $getuser;
          $savedate = $getdate;
          if($_GET['act']=="add"){
            echo '<a class="btn" href="index.php?user='.$savename.'&date='.$savedate.'">뒤로가기</a>';
          } else {
            echo '<a class="btn" href="index.php?user='.$savename.'&date='.$savedate.'&act=add">추가하기</a>';
          }
          echo '<a class="btn" href="index.php">홈으로</a>';
        } else{
          echo '<p style="color:#999;">위에 자신의 이름이 없다면 지금 시작해보세요!</p>';
          echo '<a class="btn" href="register.php">시작하기</a>';
        }
        ?>

      </div>

    </div>
  </body>
</html>
