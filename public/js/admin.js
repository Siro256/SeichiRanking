$(document).ready(function() {

    // 問い合わせ管理の絞り込み条件
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });
});

// 広告管理：承認処理
function ad_approve(id) {

    // CSRFトークンセット
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax('/admin/ad/approve',
        {
            type: 'post',
            data: { id: id }
        }
    )
    // 検索成功時にはページに結果を反映
    .done(function(data) {
        if (data.result === true) {
            location.reload();
        }
        else {
            alert('承認処理に失敗しました。管理者までお問合せください。');
        }
    })
    // 検索失敗時には、その旨をダイアログ表示
    .fail(function() {
        alert('承認処理に失敗しました。お手数ですが再度ログインした後、承認をお試しください。');
    });
}

function ad_delete(id)
{
    if (confirm("No:"+id+"の広告を削除しますか？")) {
        // CSRFトークンセット
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax('/admin/ad/delete',
            {
                type: 'post',
                data: { id: id }
            }
        )
        // 検索成功時にはページに結果を反映
            .done(function(data) {
                if (data.result === true) {
                    location.reload();
                }
                else {
                    alert('承認処理に失敗しました。管理者までお問合せください。');
                }
            })
            // 検索失敗時には、その旨をダイアログ表示
            .fail(function() {
                alert('承認処理に失敗しました。お手数ですが再度ログインした後、承認をお試しください。');
            });
    }
}