//////////////////////////////////
//////いいね！用のJavascript
//////////////////////////////////

$(function () {
  //いいね！がクリックされたとき
  $(".js-like").click(function () {
    const this_obj = $(this); //this_objにはクリックされた要素が入る
    //tweet-idを取得
    const tweet_id = $(this).data('tweet-id');
    const like_id = $(this).data("like-id"); //クリックされた要素のlike_idが代入される
    const like_count_obj = $(this).parent().find(".js-like-count");
    let like_count = Number(like_count_obj.html()); //いいね！数がjs-like-countクラスのhtml内にあるか確認

    if (like_id) {
      //like_idがすでにあるとき（いいね！ずみのとき）
      //クリックされたらいいね！取り消し
      //非同期通信（画面遷移をせずにデータベースと通信したい場合に用いるもの）
      $.ajax({ //doneとfail両方を書く必要がある
        url:'like.php',
        type:'POST',
        data:{
          'like_id': like_id
        },
        timeout:10000
      })
      //取り消しが成功
      .done(() =>{ //通信に成功したら以下の処理が実行される
          //いいね！カウントを減らす
          like_count--;
          like_count_obj.html(like_count);//htmlの値を減らした値に書き換え
          this_obj.data("like-id", null); //クリック要素のdata属性のlike_idの値をnull(削除)

          //いいね！ボタンの色をグレーに変更
          $(this).find("img").attr("src", "../views/img/icon-heart.svg");
          })
      .fail((data) => { //通信に失敗したら以下の処理が実行される
        alert('処理中にエラーが発生しました。');
        console.log(data);
      });
      }else {
          //いいね！を付与
          //非同期通信
          $.ajax({
            url:'like.php',
            type:'POST',
            data:{
              'tweet_id': tweet_id
            },
            timeout:10000
          })
          //いいね！が成功
          .done((data) =>{
            //いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data("like-id",data['like_id']); //true部分は後にサーバーから取ってきた値を入れる

            //いいね！ボタンの色を青に変更
            $(this).find("img").attr("src", "../views/img/icon-heart-twitterblue.svg");
          })
          .fail((data) => { //通信に失敗したら以下の処理が実行される
            alert('処理中にエラーが発生しました。');
            console.log(data);
          });
      }
  });
})
