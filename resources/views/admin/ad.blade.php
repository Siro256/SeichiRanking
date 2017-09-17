@extends('layouts.admin')

@section('content')
    <h3>広告管理</h3>

    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <div>

        <form action="/admin/ad" method="get">
            <div class="radio">
                <label>
                    <input type="radio" name="approve" value="0"{{app('request')->input('approve') === '0' || empty(app('request')->input('approve')) ? ' checked': null }}>
                    未承認　
                </label>
                <label>
                    <input type="radio" name="approve" value="1"{{app('request')->input('approve') === '1' ? ' checked': null }}>
                    承認済　
                </label>
                <label>
                    <input type="radio" name="approve" value="all"{{app('request')->input('approve') === 'all' ? ' checked': null }}>
                    全て　
                </label>
            </div>

            <div class="input-group">
                <input type="text" class="form-control" name="mcid" placeholder="投稿者のMCIDを検索" value="{{!empty(app('request')->input('mcid')) ?app('request')->input('mcid') : null }}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">検索</button>
                </span>
            </div>
        </form>

        <div style="margin-top:10px">
            @if (count($ad_list) > 0)
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>広告画像</th>
                        <th>遷移先URL</th>
                        <th>掲載開始日</th>
                        <th>掲載終了日</th>
                        <th>掲載状態</th>
                        <th class="text-center">承認</th>
                        <th class="text-center">削除</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($ad_list as $key => $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td><img src="{{$item->img_path}}" class="ad"></td>
                            <td><a target="_blank" href="{{$item->redirect_url}}">{{$item->redirect_url}}</a></td>
                            <td>{{$item->publication_start_date}}</td>
                            <td>{{$item->publication_end_date}}</td>
                            <td>@if ($item->avail_flg === 1) 承認済 @else <span class="text-danger">未承認</span> @endif</td>
                            <td class="text-center">
                                @if ($item->avail_flg === 1)
                                    <button type="button" class="btn btn-warning" onclick="ad_approve({{$item->id}})">承認取消</button>
                                @else
                                    <button type="button" class="btn btn-success" onclick="ad_approve({{$item->id}})">承認する</button>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" onclick="ad_delete({{$item->id}})">削除</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning">
                    表示する広告は0件です
                </div>
            @endif

            {!! $ad_list->links() !!}

        </div>
    </div>
@endsection

