//////////////////////////////////
//////いいね！用のJavascript
//////////////////////////////////

$(function () {
  //いいね！がクリックされたとき
  $(".js-like").click(function () {
    const this_obj = $(this); //this_objにはクリックされた要素が入る
    const like_id = $(this).data("like-id"); //クリックされた要素のlike_idが代入される
    const like_count_obj = $(this).parent().find(".js-like-count");
    let like_count = Number(like_count_obj.html()); //いいね！数がjs-like-countクラスのhtml内にあるか確認

    if (like_id) {
      //like_idがすでにあるとき（いいね！ずみのとき）
      //クリックされたらいいね！取り消し
      //いいね！カウントを減らす
      like_count--;
      like_count_obj.html(like_count);//htmlの値を減らした値に書き換え
      this_obj.data("like-id", null); //クリック要素のdata属性のlike_idの値をnull(削除)

      //いいね！ボタンの色をグレーに変更
      $(this).find("img").attr("src", "../views/img/icon-heart.svg");
    } else {
      //いいね！を付与
      //いいね！カウントを増やす
      like_count++;
      like_count_obj.html(like_count);
      this_obj.data("like-id", true); //true部分は後にサーバーから取ってきた値を入れる

      //いいね！ボタンの色を青に変更
      $(this).find("img").attr("src", "../views/img/icon-heart-twitterblue.svg");
    }
  });
})
