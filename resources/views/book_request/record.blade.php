@extends('layouts.frame')

@section('title', '样书申请')

@section('content')
    <div class="container">
        <div class="row">
            {{--<p style="font-size: 12px; color:#ccc">Tips:&nbsp;您可在申请详情页上传相关书籍的学校订书单,审核通过后相关申请不扣总的申请次数</p>--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <small style="font-size: 12px; color:grey">亲爱的{{ Auth::user()->username }}，您好。您今年共申请了{{ sizeof(Auth::user()->bookRequests()->where('status',1)->get()) }}本样书，今年的总申请额度还有{{ json_decode(Auth::user()->json_content)->teacher->book_limit }}本。
                        <br>您可<a href="{{ route("bookreq.index") }}">点击此处</a>申请样书</small>
                </div>
            </div>
        </div>
        <div class="row">
            <h4>申请记录</h4>
            </table>
            <table class="table">
                <tr>
                    <td>书名</td>
                    <td>时间</td>
                    <td>状态</td>
                </tr>
                @foreach(Auth::user()->bookRequests as $bookreq)

                    <tr style="font-size: 12px;">
                        <td><a href="{{ route('bookreq.show', $bookreq->id) }}">{{ $bookreq->book->name }}</a></td>
                        <td>{{ date("Y-m-d",strtotime($bookreq->created_at)) }}</td>
                        <td>{{ $bookreq->status==0?"审核中":($bookreq->status==1?"通过":"未通过") }}</td>
                    </tr>
                    {{--<div class="col-xs-6" style="padding:0 5px;">--}}
                    {{--<a href="{{ route('bookreq.show', $bookreq->id) }}" style="color:#666">--}}
                    {{--<div class="panel panel-default">--}}
                    {{--<img src="{{ url_file_exists("http://www.tup.com.cn/upload/bigbookimg/".$bookreq->book->product_number.".jpg")?"http://www.tup.com.cn/upload/bigbookimg/".$bookreq->book->product_number.".jpg":"/test_images/404.jpg" }}" alt="" style="width: 100%; height: 200px;">--}}
                    {{--<p style="padding:0 10px;">--}}
                    {{--<small style="margin-left: 5px;font-size: 11px;line-height: 12px;">{{ $bookreq->book->name }}</small> <br/>--}}
                    {{--<small style="margin-left: 5px;font-size: 9px">isbn号：{{ $bookreq->book->isbn }}</small>--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                @endforeach
            </table>

        </div>
    </div>

@endsection