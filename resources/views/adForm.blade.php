@extends('layouts.app')

@section('content')

<div class="container">

    <h1>お問い合わせフォーム</h1>

    {{-- エラーメッセージ --}}
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        広告入稿フォームです。(メッセージは適当になってます)<br>
        掲載は無料で行われます。有料プランはありません。

    <br><br>

    <ul>
        <li>返答には最大2週間程度のお時間を頂いております。</li>
        <li>内容によっては返答を差し控えさせて頂くことがありますことをご了承ください。</li>
        <li>内容に不備がある場合は、返答並びに対応出来ません。</li>
    </ul>
    </div>

    <hr>

    <div>
        <h3>広告掲載の条件</h3>
        <p>以下の条件を全てクリアしていない場合、広告を掲載することができません。</p>

        <ul>
            <li>・公序良俗に反しない内容であること</li>
            <li>・整地鯖に関する内容であること</li>
            <li>・画像広告であること(文字のみの広告は×)</li>
            <li>・著作権等に違反していないこと</li>
            <li>・その他、運営チームが不適切と判断した場合は、掲載できません。</li>
        </ul>
    </div>

    <hr>

    <div>
        <h3>上の文章をよく読んだ上で、以下にご記入ください。</h3>

        <p class="text-danger">※：必須項目</p>

        <form method="post" action="/inquiryForm/submit" id="form" class="form-horizontal">

            <div class="form-group">
                {{ csrf_field() }}
                <label for="inputEmail3" class="col-sm-2 control-label">連絡先 <span class="text-danger">※</span></label>

                <div class="radio col-sm-10">
                    <label><input type="radio" name="reply_type" value="discord" checked>Discord　</label>
                    <label><input type="radio" name="reply_type" value="twitter">Twitter　</label>
                </div>
            </div>

            <div class="form-group" id="contact_id_form">
                <label for="contact_id" class="col-sm-2 control-label">
                    <span id="contact_id_label">Discord ID</span>
                    <span class="text-danger">※</span>
                </label>
                <div class="col-sm-10">
                    <input type="text" name="contact_id" class="form-control" id="contact_id" value="{!! Input::old('contact_id') !!}" placeholder="Discord ID(#の数字もつけてください)">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">お問い合わせ内容 <span class="text-danger">※</span></label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inquiry_text" rows="3" name="inquiry_text" placeholder="お問い合わせ内容">{!! Input::old('inquiry_text') !!}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
                </div>
            </div>
        </form>


    </div>


</div>

@include('footer')

@endsection

